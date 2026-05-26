<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Materi;
use Illuminate\Http\Request;

class MindmapController extends Controller
{
    /**
     * Display the mind map creation page.
     */
    public function index()
    {
        $categories = Category::root()
            ->active()
            ->ordered()
            ->with(['children' => function($query) {
                $query->active()->ordered();
            }])
            ->get();

        return view('backend.mindmap.index', compact('categories'));
    }

    /**
     * Get materials for a specific category.
     */
    public function getMaterials(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json(['materials' => []]);
        }

        $materials = Materi::published()
            ->inCategoryOrChildren($categoryId)
            ->ordered()
            ->get(['id', 'title', 'description', 'difficulty_level', 'duration_minutes']);

        return response()->json([
            'materials' => $materials->map(function($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'description' => $material->description,
                    'difficulty_level' => $material->formatted_difficulty_level,
                    'duration' => $material->duration_minutes ? $material->duration_minutes . ' menit' : 'Tidak tersedia'
                ];
            })
        ]);
    }

    /**
     * Save mind map structure.
     */
    public function saveMindmap(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'mindmap_data' => 'required|array',
            'title' => 'required|string|max:255'
        ]);

        // Here you would save the mind map data to your database
        // For now, we'll just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Mind map berhasil disimpan!'
        ]);
    }
}