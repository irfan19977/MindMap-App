<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class KelasController extends Controller
{
    public function index()
    {
        // Get main categories (parent categories) with active children
        $mainCategories = Category::with(['children' => function($query) {
                $query->active()->ordered();
            }])
            ->whereNull('parent_id')
            ->active()
            ->ordered()
            ->get();
            
        return view('frontend.kelas', ['categories' => $mainCategories]);
    }
    
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['children', 'parent'])
            ->firstOrFail();
            
        // Get related categories (same level or similar categories)
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->where(function($query) use ($category) {
                // First try: same parent (siblings)
                if ($category->parent_id) {
                    $query->where('parent_id', $category->parent_id);
                } else {
                    $query->whereNull('parent_id');
                }
            })
            ->orWhere(function($query) use ($category) {
                // Second try: same grade level
                $query->where('grade_level', $category->grade_level)
                      ->where('id', '!=', $category->id);
            })
            ->active()
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
            ->with(['children', 'parent'])
            ->firstOrFail();
            
        // Get related categories (same parent)
        $relatedCategories = Category::where('parent_id', $category->parent_id)
            ->where('id', '!=', $category->id)
            ->active()
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
            ->with(['children', 'parent'])
            ->firstOrFail();
            
        // Get related categories (same parent)
        $relatedCategories = Category::where('parent_id', $subCategory->parent_id)
            ->where('id', '!=', $subCategory->id)
            ->active()
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
        $category = Category::where('slug', $slug)
            ->with(['parent', 'children'])
            ->firstOrFail();
            
        return view('frontend.mindmap', compact('category'));
    }
}
