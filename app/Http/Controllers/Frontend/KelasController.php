<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;

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
            return view('frontend.mindmap', compact('subcategory'));
        }

        // Jika tidak ada di subcategories, cek di categories
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        return view('frontend.mindmap', compact('category'));
    }

    public function showMateri($slug)
    {
        $material = Material::where('slug', $slug)
            ->with(['subcategory', 'subcategory.category'])
            ->firstOrFail();

        // Decode konten materi dari JSON
        $kontenMateri = json_decode($material->content, true) ?? [];

        // Get related materials from same subcategory
        $relatedMaterials = Material::where('subcategory_id', $material->subcategory_id)
            ->where('id', '!=', $material->id)
            ->published()
            ->limit(4)
            ->get();

        return view('frontend.materi-detail', compact('material', 'kontenMateri', 'relatedMaterials'));
    }
}
