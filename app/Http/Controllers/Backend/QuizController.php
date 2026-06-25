<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index()
    {
        $quizzes = Quiz::with('material')->orderBy('created_at', 'desc')->get();
        return view('backend.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        return view('backend.quizzes.create');
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'status' => 'required|in:publish,draft,inactive',
        ]);

        $quiz = Quiz::create([
            'id' => Str::uuid(),
            'material_id' => null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'time_limit' => $validated['time_limit'],
            'passing_score' => $validated['passing_score'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil dibuat dengan passing grade ' . $validated['passing_score'] . '%');
    }

    /**
     * Display the specified quiz.
     */
    public function show($id)
    {
        $quiz = Quiz::with(['quizQuestions', 'quizAttempts'])->findOrFail($id);
        return view('backend.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('backend.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'status' => 'required|in:publish,draft,inactive',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update($validated);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil diperbarui dengan passing grade ' . $validated['passing_score'] . '%');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        
        // Delete related quiz questions first
        QuizQuestion::where('quiz_id', $id)->delete();
        
        // Delete the quiz
        $quiz->delete();

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil dihapus');
    }
}
