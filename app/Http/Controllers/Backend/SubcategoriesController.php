<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
            
        return view('backend.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.subcategories.addedit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'grade_level' => 'required|in:sd,smp,sma,umum',
            'curriculum' => 'nullable|string|max:255',
            'status' => 'required|in:publish,draft,inactive',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('subcategories', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Convert checkbox to boolean
        $validated['is_featured'] = $request->has('is_featured');

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        Subcategory::create($validated);

        return redirect()->route('subcategories.index')
            ->with('success', 'Sub Kategori berhasil ditambahkan!');
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
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('backend.subcategories.addedit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'grade_level' => 'required|in:sd,smp,sma,umum',
            'curriculum' => 'nullable|string|max:255',
            'status' => 'required|in:publish,draft,inactive',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($subcategory->cover_image) {
                Storage::disk('public')->delete($subcategory->cover_image);
            }
            
            $imagePath = $request->file('cover_image')->store('subcategories', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Convert checkbox to boolean
        $validated['is_featured'] = $request->has('is_featured');

        // Update slug if name changed
        if ($subcategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $subcategory->update($validated);

        return redirect()->route('subcategories.index')
            ->with('success', 'Sub Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        try {
            // Check if subcategory has materials
            if ($subcategory->materials()->count() > 0) {
                return redirect()->route('subcategories.index')
                    ->with('error', 'Tidak dapat menghapus sub kategori yang memiliki materi. Hapus materi terlebih dahulu.');
            }

            // Delete cover image if exists
            if ($subcategory->cover_image) {
                Storage::disk('public')->delete($subcategory->cover_image);
            }

            $subcategory->delete();

            return redirect()->route('subcategories.index')
                ->with('success', 'Sub Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('subcategories.index')
                ->with('error', 'Gagal menghapus sub kategori: ' . $e->getMessage());
        }
    }
}
