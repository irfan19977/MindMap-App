<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\PracticeQuestion;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materis = Material::with('subcategory.category')
            ->orderBy('title', 'asc')
            ->get();
            
        return view('backend.materis.index', compact('materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'publish')
            ->orderBy('name', 'asc')
            ->get();
        $subcategories = Subcategory::where('status', 'publish')
            ->with('category')
            ->orderBy('name', 'asc')
            ->get();
            
        return view('backend.materis.addedit', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log all incoming data
        \Log::info('Materi Store Request:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'content' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'status' => 'required|in:publish,draft,inactive',
            'is_free' => 'nullable|boolean',
            'quiz_title' => 'nullable|string',
            'quiz_description' => 'nullable|string',
            'quiz_time_limit' => 'nullable|integer',
            'quiz_passing_score' => 'nullable|integer',
            'quiz_status' => 'nullable|in:publish,draft,inactive',
        ]);

        // Convert checkboxes to boolean
        $validated['is_free'] = $request->has('is_free');

        // Create material
        $material = Material::create($validated);

        // Save latihan (practice questions)
        if ($request->filled('latihan_data')) {
            $latihanData = json_decode($request->latihan_data, true);
            foreach ($latihanData as $index => $latihan) {
                PracticeQuestion::create([
                    'material_id' => $material->id,
                    'question' => $latihan['question'],
                    'question_type' => 'essay',
                    'correct_answer' => $latihan['answer'],
                    'explanation' => $latihan['explanation'] ?? null,
                    'order_number' => $index + 1,
                ]);
            }
        }

        // Save quiz
        if ($request->filled('quiz_data')) {
            $quizData = json_decode($request->quiz_data, true);
            if (!empty($quizData)) {
                $quiz = Quiz::create([
                    'material_id' => $material->id,
                    'title' => $request->quiz_title ?? $material->title . ' Quiz',
                    'description' => $request->quiz_description,
                    'time_limit' => $request->quiz_time_limit,
                    'passing_score' => $request->quiz_passing_score ?? 60,
                    'status' => $request->quiz_status ?? 'draft',
                ]);

                foreach ($quizData as $index => $quizItem) {
                    QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question' => $quizItem['question'],
                        'options' => $quizItem['options'],
                        'correct_answer' => $quizItem['correct_answer'],
                        'order_number' => $index + 1,
                    ]);
                }
            }
        }

        // Debug: Log created material
        \Log::info('Created Material:', $material->toArray());

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
    public function edit(Material $materi)
    {
        $categories = Category::where('status', 'publish')
            ->orderBy('name', 'asc')
            ->get();
        $subcategories = Subcategory::where('status', 'publish')
            ->with('category')
            ->orderBy('name', 'asc')
            ->get();

        // Eager load relationships
        $materi->load(['practiceQuestions', 'quizzes.quizQuestions']);

        return view('backend.materis.addedit', compact('materi', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $materi)
    {
        // Debug: Log all incoming data
        \Log::info('Materi Update Request:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'content' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'status' => 'required|in:publish,draft,inactive',
            'is_free' => 'nullable|boolean',
            'quiz_title' => 'nullable|string',
            'quiz_description' => 'nullable|string',
            'quiz_time_limit' => 'nullable|integer',
            'quiz_passing_score' => 'nullable|integer',
            'quiz_status' => 'nullable|in:publish,draft,inactive',
        ]);

        // Convert checkboxes to boolean
        $validated['is_free'] = $request->has('is_free');

        // Update material
        $materi->update($validated);

        // Update latihan (practice questions) - delete old and create new
        $materi->practiceQuestions()->delete();
        if ($request->filled('latihan_data')) {
            $latihanData = json_decode($request->latihan_data, true);
            foreach ($latihanData as $index => $latihan) {
                PracticeQuestion::create([
                    'material_id' => $materi->id,
                    'question' => $latihan['question'],
                    'question_type' => 'essay',
                    'correct_answer' => $latihan['answer'],
                    'explanation' => $latihan['explanation'] ?? null,
                    'order_number' => $index + 1,
                ]);
            }
        }

        // Update quiz - delete old and create new
        $materi->quizzes()->delete();
        if ($request->filled('quiz_data')) {
            $quizData = json_decode($request->quiz_data, true);
            if (!empty($quizData)) {
                $quiz = Quiz::create([
                    'material_id' => $materi->id,
                    'title' => $request->quiz_title ?? $materi->title . ' Quiz',
                    'description' => $request->quiz_description,
                    'time_limit' => $request->quiz_time_limit,
                    'passing_score' => $request->quiz_passing_score ?? 60,
                    'status' => $request->quiz_status ?? 'draft',
                ]);

                foreach ($quizData as $index => $quizItem) {
                    QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question' => $quizItem['question'],
                        'options' => $quizItem['options'],
                        'correct_answer' => $quizItem['correct_answer'],
                        'order_number' => $index + 1,
                    ]);
                }
            }
        }

        // Debug: Log updated material
        \Log::info('Updated Material:', $materi->toArray());

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $materi)
    {
        // Delete cover image if exists
        if ($materi->cover_image) {
            Storage::disk('public')->delete($materi->cover_image);
        }

        $materi->delete();

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Update status via AJAX
     */
    public function updateStatus(Request $request, Material $materi)
    {
        $validated = $request->validate([
            'status' => 'required|in:publish,draft,inactive',
        ]);

        $materi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!'
        ]);
    }
}
