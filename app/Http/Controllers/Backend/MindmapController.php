<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mindmap;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class MindmapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        $mindmaps = Mindmap::with(['category', 'user'])
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->byCategory($categoryId);
            })
            ->byUser(Auth::id())
            ->latest()
            ->paginate(12);

        $categories = Category::with('recursiveChildren')
            ->root()
            ->active()
            ->ordered()
            ->get();

        return view('backend.mindmaps.index', compact('mindmaps', 'categories'));
    }

    public function create(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = null;
        $materis = collect();

        if ($categoryId) {
            $category = Category::with('recursiveChildren')->find($categoryId);
            if ($category) {
                $materis = $category->allMateris()->published()->ordered();
            }
        }

        $categories = Category::with('recursiveChildren')
            ->root()
            ->active()
            ->ordered()
            ->get();

        return view('backend.mindmaps.create', compact('categories', 'category', 'materis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'mindmap_data' => 'required|array',
            'status' => 'required|in:draft,published',
            'is_public' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_public'] = $request->get('is_public', true);

        $mindmap = Mindmap::create($validated);

        return redirect()
            ->route('mindmaps.index', ['category_id' => $mindmap->category_id])
            ->with('success', 'Mindmap berhasil dibuat!');
    }

    public function show(Mindmap $mindmap)
    {
        $this->authorize('view', $mindmap);
        
        $mindmap->incrementViewCount();
        
        return view('backend.mindmaps.show', compact('mindmap'));
    }

    public function edit(Mindmap $mindmap)
    {
        $this->authorize('update', $mindmap);

        $materis = $mindmap->getMaterisForMindmap();
        $categories = Category::with('recursiveChildren')
            ->root()
            ->active()
            ->ordered()
            ->get();

        return view('backend.mindmaps.edit', compact('mindmap', 'categories', 'materis'));
    }

    public function update(Request $request, Mindmap $mindmap)
    {
        $this->authorize('update', $mindmap);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'mindmap_data' => 'required|array',
            'status' => 'required|in:draft,published',
            'is_public' => 'boolean',
        ]);

        $mindmap->update($validated);

        return redirect()
            ->route('mindmaps.index', ['category_id' => $mindmap->category_id])
            ->with('success', 'Mindmap berhasil diperbarui!');
    }

    public function destroy(Mindmap $mindmap)
    {
        $this->authorize('delete', $mindmap);

        $categoryId = $mindmap->category_id;
        $mindmap->delete();

        return redirect()
            ->route('mindmaps.index', ['category_id' => $categoryId])
            ->with('success', 'Mindmap berhasil dihapus!');
    }

    public function getByCategory($categoryId)
    {
        $category = Category::with('recursiveChildren')->find($categoryId);
        
        if (!$category) {
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }

        $mindmaps = Mindmap::with(['category', 'user'])
            ->byCategory($categoryId)
            ->published()
            ->public()
            ->latest()
            ->get();

        return response()->json([
            'category' => $category,
            'mindmaps' => $mindmaps
        ]);
    }
}
