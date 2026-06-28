<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProgressController extends Controller
{
    /**
     * Display the student's progress dashboard.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Load user's progress with materials and categories
            $progress = $user->userProgress()
                ->with(['material.subcategory.category'])
                ->orderBy('updated_at', 'desc')
                ->get();

            // Load quiz attempts with quiz and material
            $quizAttempts = $user->quizAttempts()
                ->with(['quiz.material.subcategory.category'])
                ->orderBy('completed_at', 'desc')
                ->get();

            // Load practice answers with questions
            $practiceAnswers = $user->practiceAnswers()
                ->with(['practiceQuestion.material'])
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();

            // Calculate statistics
            $stats = [
                'total_materials' => \App\Models\Material::count(),
                'completed_materials' => $progress->whereNotNull('completed_at')->count(),
                'in_progress_materials' => $progress->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count(),
                'total_quizzes' => $quizAttempts->count(),
                'passed_quizzes' => $quizAttempts->where('status', 'passed')->count(),
                'average_score' => $quizAttempts->where('status', 'passed')->avg('score') ?? 0,
                'total_practice_answers' => $user->practiceAnswers()->count(),
                'correct_practice_answers' => $user->practiceAnswers()->where('is_correct', true)->count(),
            ];

            $stats['overall_progress'] = $stats['total_materials'] > 0 
                ? round(($stats['completed_materials'] / $stats['total_materials']) * 100, 2) 
                : 0;

            $stats['practice_accuracy'] = $stats['total_practice_answers'] > 0
                ? round(($stats['correct_practice_answers'] / $stats['total_practice_answers']) * 100, 2)
                : 0;

            return view('frontend.student-progress.index', compact('progress', 'quizAttempts', 'practiceAnswers', 'stats'));
        } catch (\Exception $e) {
            \Log::error('Student Progress Index Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat progress pembelajaran.');
        }
    }

    /**
     * Display detailed progress for a specific material.
     */
    public function showMaterial($materialId)
    {
        try {
            $user = Auth::user();
            
            $progress = $user->userProgress()
                ->with('material')
                ->where('material_id', $materialId)
                ->first();

            if (!$progress) {
                return redirect()->route('layanan.progress-tracking')->with('error', 'Progress materi tidak ditemukan.');
            }

            $material = $progress->material;
            
            // Get related quiz attempts
            $quizAttempts = $user->quizAttempts()
                ->whereHas('quiz', function($query) use ($materialId) {
                    $query->where('material_id', $materialId);
                })
                ->with('quiz')
                ->get();

            // Get related practice answers
            $practiceAnswers = $user->practiceAnswers()
                ->whereHas('practiceQuestion', function($query) use ($materialId) {
                    $query->where('material_id', $materialId);
                })
                ->with('practiceQuestion')
                ->get();

            return view('frontend.student-progress.material', compact('progress', 'material', 'quizAttempts', 'practiceAnswers'));
        } catch (\Exception $e) {
            \Log::error('Student Progress Show Material Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail progress.');
        }
    }

    /**
     * Update progress for a material.
     */
    public function updateProgress(Request $request, $materialId)
    {
        $request->validate([
            'progress_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $user = Auth::user();
        
        $progress = $user->userProgress()
            ->where('material_id', $materialId)
            ->firstOrCreate(['material_id' => $materialId]);

        $progress->progress_percentage = $request->progress_percentage;
        
        if ($request->progress_percentage >= 100) {
            $progress->completed_at = now();
        }
        
        $progress->save();

        return response()->json([
            'success' => true,
            'progress' => $progress,
        ]);
    }

    /**
     * Get progress data as JSON for charts.
     */
    public function getProgressData()
    {
        $user = Auth::user();
        
        $progressByCategory = $user->userProgress()
            ->with('material.subcategory.category')
            ->get()
            ->groupBy(function($item) {
                return $item->material->subcategory->category->name ?? 'Uncategorized';
            })
            ->map(function($group) {
                return [
                    'total' => $group->count(),
                    'completed' => $group->whereNotNull('completed_at')->count(),
                    'in_progress' => $group->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count(),
                ];
            });

        $quizScores = $user->quizAttempts()
            ->where('status', 'passed')
            ->orderBy('completed_at')
            ->get()
            ->map(function($attempt) {
                return [
                    'date' => $attempt->completed_at->format('Y-m-d'),
                    'score' => $attempt->score,
                    'quiz_title' => $attempt->quiz->title,
                ];
            });

        return response()->json([
            'progress_by_category' => $progressByCategory,
            'quiz_scores' => $quizScores,
        ]);
    }
}
