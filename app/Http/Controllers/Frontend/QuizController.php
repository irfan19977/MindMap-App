<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display quiz dashboard with all available quizzes
     */
    public function index()
    {
        $quizzes = Quiz::with(['material', 'quizAttempts' => function($query) {
            $query->where('user_id', Auth::id());
        }])
        ->where('status', 'publish')
        ->orderBy('created_at', 'desc')
        ->get();

        // Get user's quiz statistics
        $userAttempts = QuizAttempt::where('user_id', Auth::id())
            ->where('status', '!=', 'in_progress')
            ->get();

        $totalAttempts = $userAttempts->count();
        $passedAttempts = $userAttempts->where('status', 'passed')->count();
        $averageScore = $totalAttempts > 0 ? $userAttempts->avg('score') : 0;

        return view('frontend.quiz.index', compact('quizzes', 'totalAttempts', 'passedAttempts', 'averageScore'));
    }

    /**
     * Display quiz taking page
     */
    public function take($quizId)
    {
        $quiz = Quiz::with(['quizQuestions' => function($query) {
            $query->orderBy('order_number');
        }, 'material'])
        ->findOrFail($quizId);

        // Check if user has an in-progress attempt
        $currentAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->where('status', 'in_progress')
            ->first();

        return view('frontend.quiz.take', compact('quiz', 'currentAttempt'));
    }

    /**
     * Display quiz results and evaluation
     */
    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'quizAnswers.quizQuestion'])
            ->where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Calculate additional statistics
        $correctAnswers = $attempt->quizAnswers->where('is_correct', true)->count();
        $totalQuestions = $attempt->quizAnswers->count();
        $accuracy = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // Get user's previous attempts for comparison
        $previousAttempts = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $attempt->quiz_id)
            ->where('id', '!=', $attemptId)
            ->where('status', '!=', 'in_progress')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.quiz.result', compact('attempt', 'correctAnswers', 'totalQuestions', 'accuracy', 'previousAttempts'));
    }

    /**
     * Display quiz history for a specific quiz
     */
    public function history($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $attempts = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->where('status', '!=', 'in_progress')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.quiz.history', compact('quiz', 'attempts'));
    }

    /**
     * Display quiz leaderboard
     */
    public function leaderboard($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $leaderboard = QuizAttempt::with('user')
            ->where('quiz_id', $quizId)
            ->where('status', '!=', 'in_progress')
            ->orderBy('score', 'desc')
            ->orderBy('completed_at', 'asc')
            ->limit(20)
            ->get();

        // Get user's best score for this quiz
        $userBestScore = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->where('status', 'passed')
            ->max('score') ?? 0;

        return view('frontend.quiz.leaderboard', compact('quiz', 'leaderboard', 'userBestScore'));
    }

    /**
     * Display user's overall quiz progress
     */
    public function progress()
    {
        $attempts = QuizAttempt::with('quiz.material')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'in_progress')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAttempts = $attempts->count();
        $passedAttempts = $attempts->where('status', 'passed')->count();
        $failedAttempts = $attempts->where('status', 'failed')->count();
        $averageScore = $totalAttempts > 0 ? $attempts->avg('score') : 0;
        $bestScore = $attempts->max('score') ?? 0;
        $totalPointsEarned = $attempts->sum('earned_points');
        $totalPointsPossible = $attempts->sum('total_points');

        // Group by quiz for progress tracking
        $quizProgress = $attempts->groupBy('quiz_id')->map(function($attempts) {
            $quiz = $attempts->first()->quiz;
            return [
                'quiz' => $quiz,
                'attempts' => $attempts->count(),
                'best_score' => $attempts->max('score'),
                'last_attempt' => $attempts->first(),
                'passed' => $attempts->where('status', 'passed')->count() > 0,
            ];
        });

        return view('frontend.quiz.progress', compact(
            'attempts',
            'totalAttempts',
            'passedAttempts',
            'failedAttempts',
            'averageScore',
            'bestScore',
            'totalPointsEarned',
            'totalPointsPossible',
            'quizProgress'
        ));
    }
}
