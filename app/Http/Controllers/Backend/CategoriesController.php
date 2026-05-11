<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')
            ->ordered()
            ->get();
            
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::active()
            ->root()
            ->ordered()
            ->get();
            
        return view('backend.categories.addedit', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|in:sd,smp,sma,umum',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'order_number' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('categories', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Convert checkboxes to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_free'] = $request->has('is_free');

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
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
    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)
            ->where(function($query) use ($category) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '!=', $category->id);
            })
            ->active()
            ->ordered()
            ->get();

        return view('backend.categories.addedit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|in:sd,smp,sma,umum',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'order_number' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }
            
            $imagePath = $request->file('cover_image')->store('categories', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Convert checkboxes to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_free'] = $request->has('is_free');

        // Update slug if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
