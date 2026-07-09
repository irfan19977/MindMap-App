<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Models\Subcategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MindmapController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the mind map creation page.
     */
    public function index()
    {
        $this->authorize('mindmap.index');
        $categories = Category::published()->ordered()
            ->where('created_by', auth()->id())
            ->with(['subcategories' => function($query) {
                $query->where('status', 'publish')->orderBy('name', 'asc');
            }])
            ->get();

        return view('backend.mindmap.index', compact('categories'));
    }

    /**
     * Get materials for a specific category or subcategory.
     */
    public function getMaterials(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json(['materials' => []]);
        }

        // Check if the ID is a subcategory or a category
        $subcategory = Subcategory::find($categoryId);
        
        if ($subcategory) {
            // If it's a subcategory, get materials for this subcategory
            $materials = Material::published()
                ->where('subcategory_id', $categoryId)
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'description']);
        } else {
            // If it's a category, get materials for all its subcategories
            $materials = Material::published()
                ->whereHas('subcategory', function($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'description']);
        }

        return response()->json([
            'materials' => $materials->map(function($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'description' => $material->description,
                    'difficulty_level' => '-',
                    'duration' => '-'
                ];
            })
        ]);
    }

    /**
     * Save mind map structure.
     */
    public function saveMindmap(Request $request)
    {
        try {
            $data = $request->validate([
                'category_id' => 'required',
                'mindmap_data' => 'required|array',
                'title' => 'required|string|max:255'
            ]);

            // Determine if the reference is a subcategory or category
            $referenceType = Subcategory::find($data['category_id']) ? 'subcategory' : 'category';

            // Save the mind map data to the database
            $mindmap = \App\Models\Mindmap::updateOrCreate(
                [
                    'reference_id' => $data['category_id']
                ],
                [
                    'reference_type' => $referenceType,
                    'title' => $data['title'],
                    'structure' => $data['mindmap_data'],
                    'status' => 'publish',
                    'created_by' => auth()->id(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Mind map berhasil disimpan!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Load mind map structure for a category.
     */
    public function loadMindmap(Request $request)
    {
        try {
            $referenceId = $request->input('reference_id');

            if (!$referenceId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reference ID is required'
                ], 400);
            }

            $mindmap = \App\Models\Mindmap::where('reference_id', $referenceId)->first();

            if (!$mindmap) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mind map not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $mindmap->id,
                    'title' => $mindmap->title,
                    'structure' => $mindmap->structure,
                    'status' => $mindmap->status
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}