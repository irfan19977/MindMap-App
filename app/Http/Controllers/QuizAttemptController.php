<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizAttemptController extends Controller
{
    /**
     * Start a new quiz attempt.
     */
    public function start(Request $request)
    {
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
                'message' => 'You already have an in-progress attempt',
                'attempt' => $existingAttempt,
            ], 400);
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
            'message' => 'Quiz attempt started',
            'attempt' => $attempt,
            'quiz' => $quiz->load('quizQuestions'),
        ]);
    }

    /**
     * Submit quiz answers.
     */
    public function submitAnswer(Request $request)
    {
        $validated = $request->validate([
            'attempt_id' => 'required|exists:quiz_attempts,id',
            'question_id' => 'required|exists:quiz_questions,id',
            'answer' => 'required',
        ]);

        $attempt = QuizAttempt::where('id', $validated['attempt_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->firstOrFail();

        $question = QuizQuestion::findOrFail($validated['question_id']);

        // Check if answer already exists
        $existingAnswer = QuizAnswer::where('attempt_id', $attempt->id)
            ->where('question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            $existingAnswer->update([
                'answer' => $validated['answer'],
                'is_correct' => $this->checkAnswer($question, $validated['answer']),
            ]);
        } else {
            QuizAnswer::create([
                'id' => Str::uuid(),
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer' => $validated['answer'],
                'is_correct' => $this->checkAnswer($question, $validated['answer']),
            ]);
        }

        return response()->json([
            'message' => 'Answer saved',
        ]);
    }

    /**
     * Submit complete quiz attempt.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'attempt_id' => 'required|exists:quiz_attempts,id',
        ]);

        $attempt = QuizAttempt::where('id', $validated['attempt_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->firstOrFail();

        $quiz = Quiz::with('quizQuestions')->findOrFail($attempt->quiz_id);
        $answers = QuizAnswer::where('attempt_id', $attempt->id)->get();

        // Calculate score
        $correctCount = $answers->where('is_correct', true)->count();
        $totalQuestions = $quiz->quizQuestions->count();
        $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        // Determine pass/fail
        $status = $score >= $quiz->passing_score ? 'passed' : 'failed';

        // Update attempt
        $attempt->update([
            'status' => $status,
            'score' => $score,
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'attempt' => $attempt->load('quizAnswers'),
            'score' => $score,
            'status' => $status,
        ]);
    }

    /**
     * Show quiz attempt details.
     */
    public function show($attemptId)
    {
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->with(['quiz', 'quizAnswers.question'])
            ->firstOrFail();

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
        if ($question->type === 'multiple_choice') {
            return $answer === $question->correct_answer;
        } elseif ($question->type === 'essay') {
            // Essay questions need manual grading
            return null;
        }
        
        return false;
    }
}
