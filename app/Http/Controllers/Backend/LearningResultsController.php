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
        $ownedMaterialIds = \App\Models\Material::where('created_by', auth()->id())->pluck('id');
        $ownedQuizIds = Quiz::whereIn('material_id', $ownedMaterialIds)->pluck('id');

        $students = User::role('student')
            ->withCount([
                'userProgress as total_materials' => function ($q) use ($ownedMaterialIds) {
                    $q->whereIn('material_id', $ownedMaterialIds);
                },
                'userProgress as completed_materials' => function ($q) use ($ownedMaterialIds) {
                    $q->whereNotNull('completed_at')->whereIn('material_id', $ownedMaterialIds);
                },
            ])
            ->whereHas('userProgress', function ($q) use ($ownedMaterialIds) {
                $q->whereIn('material_id', $ownedMaterialIds);
            })
            ->get();

        // Add quiz stats to each student
        $students->each(function ($student) use ($ownedQuizIds) {
            $quizQuery = QuizAttempt::where('user_id', $student->id)->whereIn('quiz_id', $ownedQuizIds);
            $student->quiz_attempts_count = (clone $quizQuery)->count();
            $student->quiz_passed_count = (clone $quizQuery)->where('status', 'passed')->count();
            $student->average_score = (clone $quizQuery)->avg('score') ?? 0;
        });

        // Summary stats
        $totalStudents = $students->count();
        $attemptsQuery = QuizAttempt::whereIn('quiz_id', $ownedQuizIds);
        $totalAttempts = (clone $attemptsQuery)->count();
        $totalPassed = (clone $attemptsQuery)->where('status', 'passed')->count();
        $averageScore = (clone $attemptsQuery)->avg('score') ?? 0;

        return view('backend.learning-results.index', compact(
            'students', 'totalStudents', 'totalAttempts', 'totalPassed', 'averageScore'
        ));
    }

    /**
     * Hasil Quiz - detailed quiz results.
     */
    public function quizzes()
    {
        $ownedMaterialIds = \App\Models\Material::where('created_by', auth()->id())->pluck('id');
        $ownedQuizIds = Quiz::whereIn('material_id', $ownedMaterialIds)->pluck('id');

        $quizzesQuery = Quiz::withCount('quizAttempts')->whereIn('id', $ownedQuizIds);
        $attemptsQuery = QuizAttempt::with(['user', 'quiz'])
            ->whereIn('quiz_id', $ownedQuizIds)
            ->orderBy('created_at', 'desc');

        $attempts = $attemptsQuery->get();

        $quizzes = $quizzesQuery->get()->map(function ($quiz) {
            $quiz->passed_count = QuizAttempt::where('quiz_id', $quiz->id)->where('status', 'passed')->count();
            $quiz->failed_count = QuizAttempt::where('quiz_id', $quiz->id)->where('status', 'failed')->count();
            $quiz->avg_score = QuizAttempt::where('quiz_id', $quiz->id)->avg('score') ?? 0;
            return $quiz;
        });

        return view('backend.learning-results.quizzes', compact('attempts', 'quizzes'));
    }
}
