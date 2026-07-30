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
use App\Models\Quiz;
use App\Models\SiteVisit;
use App\Models\CourseClass;
use App\Models\ClassEnrollment;
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

        $user = auth()->user();
        $isTeacher = $user->hasRole('teacher');

        if ($isTeacher) {
            // Teacher-specific data
            $teacher = $user->teacher;
            $teacherUserId = $user->id;

            // Total classes owned by teacher
            $totalClasses = CourseClass::where('teacher_id', $teacher->id)->count();

            // Total materials created by teacher
            $totalMaterials = Material::where('created_by', $teacherUserId)->count();

            // Total mindmaps created by teacher
            $totalMindmaps = Mindmap::where('created_by', $teacherUserId)->count();

            // Student learning activities on teacher's materials
            $teacherMaterialIds = Material::where('created_by', $teacherUserId)->pluck('id');
            $totalProgress = UserProgress::whereIn('material_id', $teacherMaterialIds)->count();
            $completedMaterials = UserProgress::whereIn('material_id', $teacherMaterialIds)
                ->whereNotNull('completed_at')->count();

            // Quiz statistics for teacher's quizzes
            $teacherQuizIds = Quiz::whereIn('material_id', $teacherMaterialIds)->pluck('id');
            $totalQuizAttempts = QuizAttempt::whereIn('quiz_id', $teacherQuizIds)->count();
            $quizPassedCount = QuizAttempt::whereIn('quiz_id', $teacherQuizIds)
                ->where('status', 'passed')->count();
            $averageScore = QuizAttempt::whereIn('quiz_id', $teacherQuizIds)->avg('score') ?? 0;

            // Recent quiz attempts for teacher's quizzes
            $recentQuizAttempts = QuizAttempt::with(['user', 'quiz'])
                ->whereIn('quiz_id', $teacherQuizIds)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            // Top students based on interactions with teacher's content
            $topStudents = User::role('student')
                ->whereHas('userProgress', function ($q) use ($teacherMaterialIds) {
                    $q->whereIn('material_id', $teacherMaterialIds);
                })
                ->withCount(['userProgress as completed_count' => function ($q) use ($teacherMaterialIds) {
                    $q->whereIn('material_id', $teacherMaterialIds)->whereNotNull('completed_at');
                }])
                ->orderBy('completed_count', 'desc')
                ->take(5)
                ->get();

            // Class views chart - how often teacher's classes are viewed
            $platformChart = collect();
            for ($i = $period - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $teacherClassIds = CourseClass::where('teacher_id', $teacher->id)->pluck('id');
                
                // Count class enrollments/views for this date
                $classViews = ClassEnrollment::whereIn('class_id', $teacherClassIds)
                    ->whereDate('enrolled_at', $date)
                    ->count();
                
                $platformChart->push([
                    'date' => now()->subDays($i)->format('d M'),
                    'visits' => $classViews,
                    'registrations' => 0, // Not used for teachers
                ]);
            }
            $todayVisits = ClassEnrollment::whereIn('class_id', 
                CourseClass::where('teacher_id', $teacher->id)->pluck('id'))
                ->whereDate('enrolled_at', now()->toDateString())
                ->count();

            // Set variables for view compatibility
            $totalUsers = $totalClasses;
            $totalStudents = $totalMaterials;
            $totalTeachers = $totalMindmaps;
            $totalCategories = 0;
            $totalSubcategories = 0;
            $recentProgress = collect();
            $categoryStats = collect();
        } else {
            // Admin/General dashboard data (original logic)
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
        }

        return view('backend.dashboard.index', compact(
            'totalUsers', 'totalStudents', 'totalTeachers',
            'totalCategories', 'totalSubcategories', 'totalMaterials', 'totalMindmaps',
            'totalProgress', 'completedMaterials', 'totalQuizAttempts', 'quizPassedCount', 'averageScore',
            'recentProgress', 'recentQuizAttempts', 'topStudents', 'categoryStats',
            'platformChart', 'todayVisits', 'period', 'isTeacher'
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
