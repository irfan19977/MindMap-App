<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\UserProgress;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;

class LearningResultsController extends Controller
{
    /**
     * Tracking Siswa - overview of student learning progress.
     */
    public function index()
    {
        // Get all students with their progress
        $students = User::role('student')
            ->withCount([
                'userProgress as total_materials' => function ($q) {
                    // all materials accessed
                },
                'userProgress as completed_materials' => function ($q) {
                    $q->whereNotNull('completed_at');
                },
            ])
            ->get();

        // Add quiz stats to each student
        $students->each(function ($student) {
            $student->quiz_attempts_count = QuizAttempt::where('user_id', $student->id)->count();
            $student->quiz_passed_count = QuizAttempt::where('user_id', $student->id)->where('status', 'passed')->count();
            $student->average_score = QuizAttempt::where('user_id', $student->id)->avg('score') ?? 0;
        });

        // Summary stats
        $totalStudents = $students->count();
        $totalAttempts = QuizAttempt::count();
        $totalPassed = QuizAttempt::where('status', 'passed')->count();
        $averageScore = QuizAttempt::avg('score') ?? 0;

        return view('backend.learning-results.index', compact(
            'students', 'totalStudents', 'totalAttempts', 'totalPassed', 'averageScore'
        ));
    }

    /**
     * Hasil Quiz - detailed quiz results.
     */
    public function quizzes()
    {
        $attempts = QuizAttempt::with(['user', 'quiz'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Quiz summary
        $quizzes = Quiz::withCount('quizAttempts')
            ->get()
            ->map(function ($quiz) {
                $quiz->passed_count = QuizAttempt::where('quiz_id', $quiz->id)->where('status', 'passed')->count();
                $quiz->failed_count = QuizAttempt::where('quiz_id', $quiz->id)->where('status', 'failed')->count();
                $quiz->avg_score = QuizAttempt::where('quiz_id', $quiz->id)->avg('score') ?? 0;
                return $quiz;
            });

        return view('backend.learning-results.quizzes', compact('attempts', 'quizzes'));
    }
}
