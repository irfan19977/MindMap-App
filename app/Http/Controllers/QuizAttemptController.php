<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    /**
     * Start a new quiz attempt
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|uuid|exists:quizzes,id',
        ]);

        $quiz = Quiz::findOrFail($validated['quiz_id']);

        // Check if user has an in-progress attempt
        $existingAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $validated['quiz_id'])
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return response()->json([
                'success' => true,
                'message' => 'Melanjutkan quiz yang sedang berjalan',
                'attempt' => $existingAttempt,
                'questions' => $quiz->quizQuestions()->ordered()->get(),
            ]);
        }

        // Create new attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $validated['quiz_id'],
            'status' => 'in_progress',
            'started_at' => now(),
            'score' => 0,
            'total_points' => 0,
            'earned_points' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz dimulai',
            'attempt' => $attempt,
            'questions' => $quiz->quizQuestions()->ordered()->get(),
        ]);
    }

    /**
     * Submit quiz answers with auto-scoring
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'quiz_attempt_id' => 'required|uuid|exists:quiz_attempts,id',
            'answers' => 'required|array',
            'answers.*.quiz_question_id' => 'required|uuid|exists:quiz_questions,id',
            'answers.*.user_answer' => 'required|string',
        ]);

        $attempt = QuizAttempt::findOrFail($validated['quiz_attempt_id']);

        // Verify this attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Verify attempt is still in progress
        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Quiz sudah selesai',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $totalPoints = 0;
            $earnedPoints = 0;

            foreach ($validated['answers'] as $answerData) {
                $question = QuizQuestion::findOrFail($answerData['quiz_question_id']);
                
                // Auto-scoring logic
                $isCorrect = $this->checkAnswer($question, $answerData['user_answer']);
                $pointsEarned = $isCorrect ? $question->points : 0;

                $totalPoints += $question->points;
                $earnedPoints += $pointsEarned;

                // Check if answer already exists for this question
                $existingAnswer = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                    ->where('quiz_question_id', $answerData['quiz_question_id'])
                    ->first();

                if ($existingAnswer) {
                    // Update existing answer
                    $existingAnswer->update([
                        'user_answer' => $answerData['user_answer'],
                        'is_correct' => $isCorrect,
                        'points_earned' => $pointsEarned,
                    ]);
                } else {
                    // Create new answer
                    QuizAnswer::create([
                        'quiz_attempt_id' => $attempt->id,
                        'quiz_question_id' => $answerData['quiz_question_id'],
                        'user_answer' => $answerData['user_answer'],
                        'is_correct' => $isCorrect,
                        'points_earned' => $pointsEarned,
                    ]);
                }
            }

            // Calculate final score
            $scorePercentage = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;
            $quiz = Quiz::findOrFail($attempt->quiz_id);
            $status = $scorePercentage >= $quiz->passing_score ? 'passed' : 'failed';

            // Update attempt
            $attempt->update([
                'score' => $scorePercentage,
                'total_points' => $totalPoints,
                'earned_points' => $earnedPoints,
                'status' => $status,
                'completed_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz berhasil disubmit',
                'attempt' => $attempt->fresh(),
                'score_percentage' => $scorePercentage,
                'status' => $status,
                'passed' => $status === 'passed',
                'passing_score' => $quiz->passing_score,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal submit quiz: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check if quiz answer is correct
     */
    private function checkAnswer(QuizQuestion $question, string $userAnswer): bool
    {
        $correctAnswer = trim(strtolower($question->correct_answer));
        $userAnswer = trim(strtolower($userAnswer));

        // Quiz questions are typically multiple choice
        // For multiple choice, exact match required
        return $userAnswer === $correctAnswer;
    }

    /**
     * Get quiz attempt details with answers
     */
    public function show($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'quizAnswers.quizQuestion'])
            ->where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'attempt' => $attempt,
            'quiz' => $attempt->quiz,
            'answers' => $attempt->quizAnswers,
        ]);
    }

    /**
     * Get user's quiz attempts for a specific quiz
     */
    public function getAttemptsByQuiz($quizId)
    {
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'attempts' => $attempts,
            'total_attempts' => $attempts->count(),
            'best_score' => $attempts->max('score'),
            'passed_attempts' => $attempts->where('status', 'passed')->count(),
        ]);
    }

    /**
     * Get user's quiz statistics
     */
    public function getStatistics()
    {
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'in_progress')
            ->get();

        $totalAttempts = $attempts->count();
        $passedAttempts = $attempts->where('status', 'passed')->count();
        $failedAttempts = $attempts->where('status', 'failed')->count();
        $averageScore = $totalAttempts > 0 ? $attempts->avg('score') : 0;
        $bestScore = $attempts->max('score') ?? 0;
        $totalPointsEarned = $attempts->sum('earned_points');
        $totalPointsPossible = $attempts->sum('total_points');

        return response()->json([
            'total_attempts' => $totalAttempts,
            'passed_attempts' => $passedAttempts,
            'failed_attempts' => $failedAttempts,
            'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
            'average_score' => round($averageScore, 2),
            'best_score' => round($bestScore, 2),
            'total_points_earned' => $totalPointsEarned,
            'total_points_possible' => $totalPointsPossible,
            'overall_accuracy' => $totalPointsPossible > 0 ? round(($totalPointsEarned / $totalPointsPossible) * 100, 2) : 0,
        ]);
    }

    /**
     * Get leaderboard for a specific quiz
     */
    public function getLeaderboard($quizId)
    {
        $leaderboard = QuizAttempt::with('user')
            ->where('quiz_id', $quizId)
            ->where('status', '!=', 'in_progress')
            ->orderBy('score', 'desc')
            ->orderBy('completed_at', 'asc')
            ->limit(10)
            ->get();

        return response()->json([
            'leaderboard' => $leaderboard,
        ]);
    }

    /**
     * Submit single answer during quiz (for real-time feedback)
     */
    public function submitAnswer(Request $request)
    {
        $validated = $request->validate([
            'quiz_attempt_id' => 'required|uuid|exists:quiz_attempts,id',
            'quiz_question_id' => 'required|uuid|exists:quiz_questions,id',
            'user_answer' => 'required|string',
        ]);

        $attempt = QuizAttempt::findOrFail($validated['quiz_attempt_id']);

        // Verify this attempt belongs to the authenticated user
        if ($attempt->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Verify attempt is still in progress
        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Quiz sudah selesai',
            ], 400);
        }

        $question = QuizQuestion::findOrFail($validated['quiz_question_id']);
        
        // Auto-scoring logic
        $isCorrect = $this->checkAnswer($question, $validated['user_answer']);
        $pointsEarned = $isCorrect ? $question->points : 0;

        // Check if answer already exists
        $existingAnswer = QuizAnswer::where('quiz_attempt_id', $attempt->id)
            ->where('quiz_question_id', $validated['quiz_question_id'])
            ->first();

        if ($existingAnswer) {
            // Update existing answer
            $existingAnswer->update([
                'user_answer' => $validated['user_answer'],
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
            ]);
        } else {
            // Create new answer
            QuizAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $validated['quiz_question_id'],
                'user_answer' => $validated['user_answer'],
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'explanation' => $question->explanation,
        ]);
    }
}
