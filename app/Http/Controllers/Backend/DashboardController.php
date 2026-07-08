<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Material;
use App\Models\Mindmap;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\QuizAttempt;
use App\Models\SiteVisit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $period = (int) $request->get('period', 30);
        if (!in_array($period, [7, 30, 90])) {
            $period = 30;
        }

        // Summary stats
        $totalUsers = User::count();
        $totalStudents = User::role('student')->count();
        $totalTeachers = User::role('teacher')->count();
        $totalCategories = Category::count();
        $totalSubcategories = Subcategory::count();
        $totalMaterials = Material::count();
        $totalMindmaps = Mindmap::count();

        // Learning activity stats
        $totalProgress = UserProgress::count();
        $completedMaterials = UserProgress::whereNotNull('completed_at')->count();
        $totalQuizAttempts = QuizAttempt::count();
        $quizPassedCount = QuizAttempt::where('status', 'passed')->count();
        $averageScore = QuizAttempt::avg('score') ?? 0;

        // Recent activity - latest user progress
        $recentProgress = UserProgress::with(['user', 'material'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Recent quiz attempts
        $recentQuizAttempts = QuizAttempt::with(['user', 'quiz'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Top students by completed materials
        $topStudents = User::role('student')
            ->withCount(['userProgress as completed_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }])
            ->orderBy('completed_count', 'desc')
            ->take(5)
            ->get();

        // Content stats per category
        $categoryStats = Category::withCount(['subcategories'])->get();

        // Platform chart: visits & registrations per day (based on selected period)
        $platformChart = collect();
        for ($i = $period - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $platformChart->push([
                'date' => now()->subDays($i)->format('d M'),
                'visits' => SiteVisit::where('visited_date', $date)->count(),
                'registrations' => User::whereDate('created_at', $date)->count(),
            ]);
        }
        $todayVisits = SiteVisit::where('visited_date', now()->toDateString())->count();

        return view('backend.dashboard.index', compact(
            'totalUsers', 'totalStudents', 'totalTeachers',
            'totalCategories', 'totalSubcategories', 'totalMaterials', 'totalMindmaps',
            'totalProgress', 'completedMaterials', 'totalQuizAttempts', 'quizPassedCount', 'averageScore',
            'recentProgress', 'recentQuizAttempts', 'topStudents', 'categoryStats',
            'platformChart', 'todayVisits', 'period'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
