<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materis = Materi::with('category')
            ->ordered()
            ->get();
            
        return view('backend.materis.index', compact('materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()
            ->ordered()
            ->get();
            
        return view('backend.materis.addedit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,archived',
            'order_number' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'konten_materi_data' => 'nullable|string',
            'latihan_data' => 'nullable|string',
            'quiz_data' => 'nullable|string',
            'quiz_title' => 'nullable|string|max:255',
            'quiz_duration' => 'nullable|integer|min:1',
            'quiz_passing_score' => 'nullable|integer|min:0|max:100',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('materis/files', 'public');
            $validated['file_path'] = $filePath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('materis/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Convert checkboxes to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_free'] = $request->has('is_free');

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Process tags
        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter($validated['tags']);
        }

        // Process tab data
        $tabData = [];
        
        // Process konten materi data
        if ($request->has('konten_materi_data')) {
            $kontenData = json_decode($request->input('konten_materi_data'), true);
            if ($kontenData && !empty($kontenData)) {
                $validated['konten_materi'] = $kontenData;
            }
        }
        
        // Process latihan data
        if ($request->has('latihan_data')) {
            $latihanData = json_decode($request->input('latihan_data'), true);
            if ($latihanData && !empty($latihanData)) {
                $validated['latihan_data'] = $latihanData;
            }
        }
        
        // Process quiz data
        if ($request->has('quiz_data')) {
            $quizData = json_decode($request->input('quiz_data'), true);
            if ($quizData && !empty($quizData)) {
                $validated['quiz_data'] = $quizData;
            }
        }

        Materi::create($validated);

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil ditambahkan!');
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
    public function edit(Materi $materi)
    {
        $categories = Category::active()
            ->ordered()
            ->get();

        return view('backend.materis.addedit', compact('materi', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,archived',
            'order_number' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_free' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'konten_materi_data' => 'nullable|string',
            'latihan_data' => 'nullable|string',
            'quiz_data' => 'nullable|string',
            'quiz_title' => 'nullable|string|max:255',
            'quiz_duration' => 'nullable|integer|min:1',
            'quiz_passing_score' => 'nullable|integer|min:0|max:100',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            
            $filePath = $request->file('file_path')->store('materis/files', 'public');
            $validated['file_path'] = $filePath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('materis/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Convert checkboxes to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_free'] = $request->has('is_free');

        // Update slug if title changed
        if ($materi->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Process tags
        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter($validated['tags']);
        }

        // Process tab data
        // Process konten materi data
        if ($request->has('konten_materi_data')) {
            $kontenData = json_decode($request->input('konten_materi_data'), true);
            if ($kontenData && !empty($kontenData)) {
                $validated['konten_materi'] = $kontenData;
            } else {
                $validated['konten_materi'] = null;
            }
        }
        
        // Process latihan data
        if ($request->has('latihan_data')) {
            $latihanData = json_decode($request->input('latihan_data'), true);
            if ($latihanData && !empty($latihanData)) {
                $validated['latihan_data'] = $latihanData;
            } else {
                $validated['latihan_data'] = null;
            }
        }
        
        // Process quiz data
        if ($request->has('quiz_data')) {
            $quizData = json_decode($request->input('quiz_data'), true);
            if ($quizData && !empty($quizData)) {
                $validated['quiz_data'] = $quizData;
            } else {
                $validated['quiz_data'] = null;
            }
        }

        $materi->update($validated);

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        // Delete files
        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }
        
        if ($materi->thumbnail) {
            Storage::disk('public')->delete($materi->thumbnail);
        }

        $materi->delete();

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Update status via AJAX
     */
    public function updateStatus(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,archived',
        ]);

        $materi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!'
        ]);
    }
}
