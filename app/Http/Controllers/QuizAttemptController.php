<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuizAttemptController extends Controller
{
    /**
     * Get quiz questions for exam mode
     */
    public function getQuestions($quizId)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized - Silakan login terlebih dahulu'], 401);
            }

            $quiz = Quiz::with('quizQuestions')->findOrFail($quizId);
            
            if ($quiz->quizQuestions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quiz ini belum memiliki soal'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'questions' => $quiz->quizQuestions->map(function($question, $index) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => is_array($question->options) ? $question->options : json_decode($question->options, true) ?? [],
                        'correct_answer' => $question->correct_answer,
                        'points' => $question->points ?? 1
                    ];
                })->values()->toArray(),
                'time_limit' => $quiz->time_limit ?? 30, // Default 30 minutes
                'quiz_title' => $quiz->title
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat soal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start a new quiz attempt.
     */
    public function start(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized - Silakan login terlebih dahulu'], 401);
        }

        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $quiz = Quiz::findOrFail($validated['quiz_id']);

        // Check if user already has an in-progress attempt
        $existingAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return response()->json([
                'success' => true,
                'message' => 'You already have an in-progress attempt',
                'attempt' => $existingAttempt,
                'started_at' => $existingAttempt->started_at->toIso8601String(),
                'time_limit' => $quiz->time_limit,
            ]);
        }

        // Create new attempt
        $attempt = QuizAttempt::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'status' => 'in_progress',
            'score' => 0,
            'started_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz attempt started',
            'attempt' => $attempt,
            'quiz' => $quiz->load('quizQuestions'),
            'started_at' => $attempt->started_at->toIso8601String(),
            'time_limit' => $quiz->time_limit,
        ]);
    }

    /**
     * Submit quiz answers.
     */
    public function submitAnswer(Request $request)
    {
        $validated = $request->validate([
            'quiz_attempt_id' => 'required|exists:quiz_attempts,id',
            'quiz_question_id' => 'required|exists:quiz_questions,id',
            'user_answer' => 'nullable',
        ]);

        $attempt = QuizAttempt::where('id', $validated['quiz_attempt_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->firstOrFail();

        $question = QuizQuestion::findOrFail($validated['quiz_question_id']);

        // Convert null to empty string
        $userAnswer = ($validated['user_answer'] === null || $validated['user_answer'] === '') ? '' : (string)$validated['user_answer'];

        $existingAnswer = QuizAnswer::where('quiz_attempt_id', $attempt->id)
            ->where('quiz_question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            $existingAnswer->update([
                'user_answer' => $userAnswer,
                'is_correct' => $this->checkAnswer($question, $userAnswer),
            ]);
        } else {
            QuizAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $question->id,
                'user_answer' => $userAnswer,
                'is_correct' => $this->checkAnswer($question, $userAnswer),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Answer saved',
        ]);
    }

    /**
     * Submit complete quiz attempt.
     */
    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
        ]);

        $quiz = Quiz::with('quizQuestions')->findOrFail($validated['quiz_id']);

        // Get or create in-progress attempt
        $attempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$attempt) {
            // Create new attempt if none exists
            $attempt = QuizAttempt::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'status' => 'in_progress',
                'score' => 0,
                'started_at' => now(),
            ]);
        }

        // Clear existing answers for this attempt
        QuizAnswer::where('quiz_attempt_id', $attempt->id)->delete();

        // Save answers from JS payload
        $submittedAnswers = $validated['answers'];
        Log::info('Quiz submission received', [
            'quiz_id' => $quiz->id,
            'submitted_answers' => $submittedAnswers,
            'total_questions' => $quiz->quizQuestions->count()
        ]);

        foreach ($submittedAnswers as $questionIndex => $optionIndex) {
            // Convert string index to integer for array access
            $questionIndex = (int)$questionIndex;
            $question = $quiz->quizQuestions[$questionIndex] ?? null;
            if (!$question) {
                Log::warning('Question not found for index', ['question_index' => $questionIndex]);
                continue;
            }

            // Convert null/empty values to empty string to avoid database constraint violation
            $userAnswer = ($optionIndex === null || $optionIndex === '') ? '' : (string)$optionIndex;
            // Compare as lowercase strings to match database format (a, b, c, d)
            $isCorrect = strtolower($userAnswer) === strtolower($question->correct_answer);

            Log::info('Processing answer', [
                'question_index' => $questionIndex,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ]);

            QuizAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $question->id,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        $answers = QuizAnswer::where('quiz_attempt_id', $attempt->id)->get();

        // Calculate score
        $correctCount = $answers->where('is_correct', true)->count();
        $totalQuestions = $quiz->quizQuestions->count();
        $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        // Determine pass/fail
        $status = $score >= ($quiz->passing_score ?? 60) ? 'passed' : 'failed';

        // Update attempt
        $attempt->update([
            'status' => $status,
            'score' => $score,
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully',
            'attempt' => $attempt->load('quizAnswers.question'),
            'score' => $score,
            'score_percentage' => round($score),
            'status' => $status,
            'passed' => $status === 'passed',
            'passing_score' => $quiz->passing_score,
            'saved' => true,
        ]);
    }

    /**
     * Show quiz attempt details.
     */
    public function show($attemptId)
    {
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->with(['quiz', 'quizAnswers.quizQuestion'])
            ->firstOrFail();

        // Reorder quiz answers to match question order
        $attempt->quizAnswers = $attempt->quizAnswers->sortBy(function($answer) {
            return $answer->quizQuestion->order_number ?? 0;
        })->values();

        return response()->json($attempt);
    }

    /**
     * Get attempts by quiz.
     */
    public function getAttemptsByQuiz($quizId)
    {
        $attempts = QuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', Auth::id())
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($attempts);
    }

    /**
     * Get quiz statistics.
     */
    public function getStatistics(Request $request)
    {
        $userId = Auth::id();
        
        $totalAttempts = QuizAttempt::where('user_id', $userId)->count();
        $passedAttempts = QuizAttempt::where('user_id', $userId)->where('status', 'passed')->count();
        $averageScore = QuizAttempt::where('user_id', $userId)
            ->where('status', '!=', 'in_progress')
            ->avg('score') ?? 0;
        
        return response()->json([
            'total_attempts' => $totalAttempts,
            'passed_attempts' => $passedAttempts,
            'average_score' => $averageScore,
            'pass_rate' => $totalAttempts > 0 ? ($passedAttempts / $totalAttempts) * 100 : 0,
        ]);
    }

    /**
     * Get quiz leaderboard.
     */
    public function getLeaderboard($quizId)
    {
        $leaderboard = QuizAttempt::where('quiz_id', $quizId)
            ->where('status', '!=', 'in_progress')
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('completed_at', 'asc')
            ->limit(10)
            ->get();

        return response()->json($leaderboard);
    }

    /**
     * Helper method to check if answer is correct.
     */
    private function checkAnswer($question, $answer)
    {
        if ($answer === null || $answer === '' || $answer === '0') {
            return false;
        }

        // Case-insensitive comparison to match database format (a, b, c, d)
        return strtolower((string)$answer) === strtolower((string)$question->correct_answer);
    }
}
