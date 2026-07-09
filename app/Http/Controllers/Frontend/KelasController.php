<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    public function index()
    {
        // Get all published categories
        $categories = Category::published()
            ->ordered()
            ->get();
            
        return view('frontend.kelas', ['categories' => $categories]);
    }
    
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();
            
        // Get related categories (excluding current category)
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->published()
            ->limit(6)
            ->get();
            
        return view('frontend.kelas-detail', compact('category', 'relatedCategories'));
    }
    
    public function showByLevel($slug, $level)
    {
        // Find parent category
        $parentCategory = Category::where('slug', $slug)->firstOrFail();
        
        // Find specific sub-category by level (create slug for sub-category)
        $subSlug = $slug . '-' . $level;
        $category = Category::where('slug', $subSlug)
            ->firstOrFail();
            
        // Get related categories (excluding current category)
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->published()
            ->limit(6)
            ->get();
            
        return view('frontend.kelas-detail', compact('category', 'relatedCategories', 'parentCategory'));
    }
    
    public function showBySubCategory($category, $slug)
    {
        // Find parent category
        $parentCategory = Category::where('slug', $category)->firstOrFail();
        
        // Find specific sub-category
        $subCategory = Category::where('slug', $slug)
            ->firstOrFail();
            
        // Get related categories (excluding current category)
        $relatedCategories = Category::where('id', '!=', $subCategory->id)
            ->published()
            ->limit(6)
            ->get();
            
        return view('frontend.kelas-detail', [
            'category' => $subCategory,
            'relatedCategories' => $relatedCategories,
            'parentCategory' => $parentCategory
        ]);
    }
    
    public function showMindmap($slug)
    {
        // Cek apakah slug ada di subcategories
        $subcategory = \App\Models\Subcategory::where('slug', $slug)
            ->with('category')
            ->first();

        if ($subcategory) {
            // Jika subcategory, ambil materials
            $subcategory->load('materials');
            // Cek apakah ada mindmap untuk subcategory ini
            $mindmap = \App\Models\Mindmap::with('creator.teacher')
                ->where('reference_id', $subcategory->id)
                ->published()
                ->first();

            // Enrich mindmap structure with material slugs
            if ($mindmap && $mindmap->structure) {
                $mindmap->structure = $this->enrichMindmapWithSlugs($mindmap->structure);
            }

            // Debug log
            Log::info('Subcategory found for mindmap', [
                'slug' => $slug,
                'subcategory_id' => $subcategory->id,
                'subcategory_name' => $subcategory->name,
                'mindmap_found' => $mindmap ? true : false,
                'mindmap_id' => $mindmap ? $mindmap->id : null
            ]);

            return view('frontend.mindmap', compact('subcategory', 'mindmap'));
        }

        // Jika tidak ada di subcategories, cek di categories
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        // Load materials from all subcategories of this category
        $category->load('children.materials');

        // Cek apakah ada mindmap untuk category ini
        $mindmap = \App\Models\Mindmap::with('creator.teacher')
            ->where('reference_id', $category->id)
            ->published()
            ->first();

        // Enrich mindmap structure with material slugs
        if ($mindmap && $mindmap->structure) {
            $mindmap->structure = $this->enrichMindmapWithSlugs($mindmap->structure);
        }

        // Debug log
        Log::info('Category found for mindmap', [
            'slug' => $slug,
            'category_id' => $category->id,
            'category_name' => $category->name,
            'mindmap_found' => $mindmap ? true : false,
            'mindmap_id' => $mindmap ? $mindmap->id : null
        ]);

        return view('frontend.mindmap', compact('category', 'mindmap'));
    }

    /**
     * Enrich mindmap structure with material slugs
     */
    private function enrichMindmapWithSlugs($structure)
    {
        if (!isset($structure['nodes'])) {
            return $structure;
        }

        foreach ($structure['nodes'] as &$node) {
            if (isset($node['materialId'])) {
                $material = Material::find($node['materialId']);
                if ($material) {
                    $node['materialSlug'] = $material->slug;
                }
            }
        }

        return $structure;
    }

    public function showMateri($slug)
    {
        $material = Material::where('slug', $slug)
            ->with(['subcategory', 'subcategory.category', 'practiceQuestions' => fn($q) => $q->ordered()])
            ->firstOrFail();

        // Decode konten materi dari JSON (strip HTML tags if editor wrapped it)
        $rawContent = strip_tags($material->content ?? '');
        $kontenMateri = json_decode($rawContent, true);
        // If not valid JSON array, treat as plain HTML content
        if (!is_array($kontenMateri)) {
            $kontenMateri = [];
        }

        // Get related materials from same subcategory
        $relatedMaterials = Material::where('subcategory_id', $material->subcategory_id)
            ->where('id', '!=', $material->id)
            ->published()
            ->limit(4)
            ->get();

        // Check if user has passed this quiz
        $passedQuizAttempt = null;
        if (Auth::check()) {
            $quiz = $material->quizzes()->where('status', 'publish')->first();
            if ($quiz) {
                $passedQuizAttempt = \App\Models\QuizAttempt::where('user_id', Auth::id())
                    ->where('quiz_id', $quiz->id)
                    ->where('status', 'passed')
                    ->with('quizAnswers.quizQuestion')
                    ->latest()
                    ->first();
            }
        }

        return view('frontend.materi-detail', compact('material', 'kontenMateri', 'relatedMaterials', 'passedQuizAttempt'));
    }

    /**
     * Get user progress for materials
     */
    public function getUserProgress()
    {
        if (!Auth::check()) {
            return response()->json(['completed_materials' => []]);
        }

        $user = Auth::user();

        // Materi dianggap selesai/unlock jika quiz-nya lulus (status = passed)
        $passedMaterialIds = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->where('status', 'passed')
            ->with('quiz:id,material_id')
            ->get()
            ->pluck('quiz.material_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Juga sertakan materi yang tidak punya quiz (langsung dianggap selesai jika pernah dibuka)
        $progressedMaterials = UserProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->pluck('material_id')
            ->toArray();

        // Material tanpa quiz yang sudah dibuka dianggap selesai
        $materialsWithoutQuiz = \App\Models\Material::whereIn('id', $progressedMaterials)
            ->whereDoesntHave('quizzes', function($q) {
                $q->where('status', 'publish');
            })
            ->pluck('id')
            ->toArray();

        $completedMaterials = array_unique(array_merge($passedMaterialIds, $materialsWithoutQuiz));

        return response()->json(['completed_materials' => $completedMaterials]);
    }
}
