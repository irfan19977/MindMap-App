<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuizAttempt;
use App\Models\Quiz;
use App\Models\Material;
use App\Models\Category;
use App\Models\Mindmap;
use App\Models\SiteVisit;
use App\Models\UserProgress;
use App\Models\PracticeAnswer;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function index()
    {
        // User Statistics
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        
        // Quiz Statistics
        $totalQuizzes = Quiz::count();
        $totalQuizAttempts = QuizAttempt::count();
        $quizAttemptsThisMonth = QuizAttempt::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $averageQuizScore = QuizAttempt::where('status', '!=', 'in_progress')
            ->avg('score') ?? 0;
        $passRate = QuizAttempt::where('status', 'passed')->count() > 0 
            ? (QuizAttempt::where('status', 'passed')->count() / QuizAttempt::where('status', '!=', 'in_progress')->count()) * 100 
            : 0;
        
        // Content Statistics
        $totalMaterials = Material::count();
        $totalCategories = Category::count();
        $totalMindmaps = Mindmap::count();
        
        // Site Visit Statistics
        $totalVisits = SiteVisit::count();
        $visitsToday = SiteVisit::whereDate('visited_date', Carbon::today())->count();
        $visitsThisMonth = SiteVisit::whereMonth('visited_date', Carbon::now()->month)
            ->whereYear('visited_date', Carbon::now()->year)
            ->count();
        
        // User Progress Statistics
        $totalProgress = UserProgress::count();
        $completedMaterials = UserProgress::where('progress_percentage', '>=', 100)->count();
        
        // Practice Statistics
        $totalPracticeAnswers = PracticeAnswer::count();
        $correctAnswers = PracticeAnswer::where('is_correct', true)->count();
        $practiceAccuracy = $totalPracticeAnswers > 0 
            ? ($correctAnswers / $totalPracticeAnswers) * 100 
            : 0;
        
        // Monthly data for charts (last 6 months)
        $monthlyUsers = [];
        $monthlyQuizAttempts = [];
        $monthlyVisits = [];
        $monthLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabels[] = $month->format('M');
            $monthlyUsers[] = User::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $monthlyQuizAttempts[] = QuizAttempt::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $monthlyVisits[] = SiteVisit::whereMonth('visited_date', $month->month)
                ->whereYear('visited_date', $month->year)
                ->count();
        }
        
        // Quiz performance by quiz
        $quizPerformance = Quiz::withCount('quizAttempts')
            ->with(['quizAttempts' => function($query) {
                $query->where('status', '!=', 'in_progress');
            }])
            ->get()
            ->map(function($quiz) {
                $attempts = $quiz->quizAttempts->where('status', '!=', 'in_progress');
                $avgScore = $attempts->avg('score') ?? 0;
                $passCount = $attempts->where('status', 'passed')->count();
                $passRate = $attempts->count() > 0 ? ($passCount / $attempts->count()) * 100 : 0;
                
                return [
                    'title' => $quiz->title,
                    'attempts' => $quiz->quiz_attempts_count,
                    'avg_score' => round($avgScore, 2),
                    'pass_rate' => round($passRate, 2),
                ];
            });
        
        // Recent activity
        $recentQuizAttempts = QuizAttempt::with('user', 'quiz')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('backend.analytics.index', compact(
            'totalUsers',
            'newUsersThisMonth',
            'newUsersToday',
            'totalQuizzes',
            'totalQuizAttempts',
            'quizAttemptsThisMonth',
            'averageQuizScore',
            'passRate',
            'totalMaterials',
            'totalCategories',
            'totalMindmaps',
            'totalVisits',
            'visitsToday',
            'visitsThisMonth',
            'totalProgress',
            'completedMaterials',
            'totalPracticeAnswers',
            'practiceAccuracy',
            'monthlyUsers',
            'monthlyQuizAttempts',
            'monthlyVisits',
            'monthLabels',
            'quizPerformance',
            'recentQuizAttempts'
        ));
    }
    
    /**
     * Get analytics data as JSON for AJAX requests.
     */
    public function getData(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, year
        
        switch($period) {
            case 'week':
                $startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            default:
                $startDate = Carbon::now()->subMonth();
        }
        
        $data = [
            'users' => User::where('created_at', '>=', $startDate)->count(),
            'quiz_attempts' => QuizAttempt::where('created_at', '>=', $startDate)->count(),
            'visits' => SiteVisit::where('visited_date', '>=', $startDate)->count(),
            'avg_score' => QuizAttempt::where('created_at', '>=', $startDate)
                ->where('status', '!=', 'in_progress')
                ->avg('score') ?? 0,
        ];
        
        return response()->json($data);
    }
}
