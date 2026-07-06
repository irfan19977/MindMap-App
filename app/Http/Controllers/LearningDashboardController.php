<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Material;
use App\Models\Mindmap;
use App\Models\UserProgress;
use App\Models\QuizAttempt;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningDashboardController extends Controller
{
    /**
     * Display the learning dashboard for the authenticated student.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Personal Learning Statistics
        $totalMindmaps = Mindmap::where('created_by', $user->id)->count();
        $inProgressMaterials = UserProgress::where('user_id', $user->id)
            ->whereNull('completed_at')
            ->count();
        $completedMaterials = UserProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
        $totalQuizAttempts = QuizAttempt::where('user_id', $user->id)->count();
        $passedQuizzes = QuizAttempt::where('user_id', $user->id)
            ->where('status', 'passed')
            ->count();
        
        // Calculate average score
        $averageScore = QuizAttempt::where('user_id', $user->id)->avg('score') ?? 0;
        
        // Overall progress percentage
        $totalProgress = UserProgress::where('user_id', $user->id)->count();
        $overallProgress = $totalProgress > 0 
            ? round(($completedMaterials / $totalProgress) * 100) 
            : 0;
        
        // Learning streak (consecutive days with activity)
        $learningStreak = $this->calculateLearningStreak($user);
        
        // Study time calculation (estimated based on progress)
        $totalStudyHours = $this->calculateStudyHours($user);
        
        // Continue Learning - Last accessed material
        $continueLearning = UserProgress::with('material')
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->orderBy('updated_at', 'desc')
            ->first();

        // Ensure material relationship is loaded
        if ($continueLearning && !$continueLearning->material) {
            $continueLearning->load('material');
        }
        
        // Recent learning activity
        $recentActivity = UserProgress::with(['material'])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Mind maps breakdown by category
        $mindmapStats = $this->getMindmapStats($user);
        
        // Recommended materials (not started yet)
        $recommendedMaterials = Material::published()
            ->whereDoesntHave('userProgresses', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['subcategory.category'])
            ->take(4)
            ->get();
        
        // Quiz performance trend
        $quizPerformance = $this->getQuizPerformance($user);
        
        // Learning achievements
        $achievements = $this->getAchievements($user);
        
        return view('learning-dashboard', compact(
            'user',
            'totalMindmaps',
            'inProgressMaterials',
            'completedMaterials',
            'totalQuizAttempts',
            'passedQuizzes',
            'averageScore',
            'overallProgress',
            'learningStreak',
            'totalStudyHours',
            'continueLearning',
            'recentActivity',
            'mindmapStats',
            'recommendedMaterials',
            'quizPerformance',
            'achievements'
        ));
    }
    
    /**
     * Calculate learning streak (consecutive days with activity)
     */
    private function calculateLearningStreak($user): int
    {
        try {
            $streak = 0;
            $currentDate = now();
            
            // Check for activity in consecutive days
            for ($i = 0; $i < 365; $i++) {
                $checkDate = $currentDate->copy()->subDays($i);
                $hasActivity = UserProgress::where('user_id', $user->id)
                    ->whereDate('updated_at', $checkDate->format('Y-m-d'))
                    ->exists();
                
                if ($hasActivity) {
                    $streak++;
                } elseif ($i > 0) {
                    // Break the streak if no activity and not checking today
                    break;
                }
            }
            
            return $streak;
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Calculate estimated study hours based on progress
     */
    private function calculateStudyHours($user): float
    {
        // Estimate: 30 minutes per material progress entry
        $progressCount = UserProgress::where('user_id', $user->id)->count();
        return round(($progressCount * 0.5), 1);
    }
    
    /**
     * Get mind map statistics by category
     */
    private function getMindmapStats($user): array
    {
        $mindmaps = Mindmap::where('created_by', $user->id)->get();
        $stats = [];
        
        foreach ($mindmaps as $mindmap) {
            // Try to get category from material if reference exists
            try {
                $material = Material::find($mindmap->reference_id);
                if ($material && $material->subcategory && $material->subcategory->category) {
                    $categoryName = $material->subcategory->category->name;
                    $stats[$categoryName] = ($stats[$categoryName] ?? 0) + 1;
                } else {
                    $stats['Uncategorized'] = ($stats['Uncategorized'] ?? 0) + 1;
                }
            } catch (\Exception $e) {
                $stats['Uncategorized'] = ($stats['Uncategorized'] ?? 0) + 1;
            }
        }
        
        return $stats;
    }
    
    /**
     * Get quiz performance trend (last 7 attempts)
     */
    private function getQuizPerformance($user): array
    {
        return QuizAttempt::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get()
            ->reverse()
            ->map(function ($attempt) {
                return [
                    'date' => $attempt->created_at->format('d M'),
                    'score' => round($attempt->score, 0),
                    'status' => $attempt->status
                ];
            })
            ->toArray();
    }
    
    /**
     * Get user achievements based on progress
     */
    private function getAchievements($user): array
    {
        $achievements = [];
        $completedCount = UserProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
        $mindmapCount = Mindmap::where('created_by', $user->id)->count();
        $quizPassedCount = QuizAttempt::where('user_id', $user->id)
            ->where('status', 'passed')
            ->count();
        
        // First steps achievement
        if ($completedCount >= 1) {
            $achievements[] = [
                'title' => 'First Steps',
                'description' => 'Completed your first material',
                'icon' => '🎯',
                'unlocked' => true
            ];
        }
        
        // Mind map creator achievement
        if ($mindmapCount >= 1) {
            $achievements[] = [
                'title' => 'Mind Map Creator',
                'description' => 'Created your first mind map',
                'icon' => '🧠',
                'unlocked' => true
            ];
        }
        
        // Quiz master achievement
        if ($quizPassedCount >= 5) {
            $achievements[] = [
                'title' => 'Quiz Master',
                'description' => 'Passed 5 quizzes',
                'icon' => '🏆',
                'unlocked' => true
            ];
        }
        
        // Learning streak achievement
        $streak = $this->calculateLearningStreak($user);
        if ($streak >= 7) {
            $achievements[] = [
                'title' => 'Week Warrior',
                'description' => '7-day learning streak',
                'icon' => '🔥',
                'unlocked' => true
            ];
        }
        
        // Knowledge explorer achievement
        if ($completedCount >= 10) {
            $achievements[] = [
                'title' => 'Knowledge Explorer',
                'description' => 'Completed 10 materials',
                'icon' => '📚',
                'unlocked' => true
            ];
        }
        
        return $achievements;
    }
}
