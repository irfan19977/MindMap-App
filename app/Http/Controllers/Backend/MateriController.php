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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class MateriController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('materi.index');
        $query = Material::with('subcategory.category')->orderBy('title', 'asc');
        if (auth()->user()->hasRole('teacher')) {
            $query->where('created_by', auth()->id());
        }
        $materis = $query->get();
            
        return view('backend.materis.index', compact('materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('materi.create');
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
        $validated['created_by'] = auth()->id();
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
        $this->authorize('materi.edit');
        if (auth()->user()->hasRole('teacher') && $materi->created_by !== auth()->id()) {
            return redirect()->route('materis.index')->with('error', 'Anda tidak memiliki akses untuk mengedit materi ini.');
        }
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

        return redirect()->route('materis.index')
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $materi)
    {
        $this->authorize('materi.delete');
        if (auth()->user()->hasRole('teacher') && $materi->created_by !== auth()->id()) {
            return redirect()->route('materis.index')->with('error', 'Anda tidak memiliki akses untuk menghapus materi ini.');
        }
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

    /**
     * Convert PDF to text with formatting detection
     */
    public function convertPdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $file = $request->file('pdf_file');
            $parser = new PdfParser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            // Normalize line endings but preserve structure
            $text = preg_replace('/\r\n|\r/', "\n", $text);
            $text = trim($text);

            // Split by newlines and preserve empty lines for paragraph detection
            $lines = preg_split('/\n/', $text);

            // Detect formatting patterns with better paragraph detection
            $htmlContent = $this->convertTextWithFormatting($lines);

            return response()->json([
                'success' => true,
                'text' => $htmlContent,
                'message' => 'PDF berhasil diconvert ke teks!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengconvert PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Convert text lines to HTML with formatting detection
     */
    private function convertTextWithFormatting($lines)
    {
        $htmlContent = '';
        $lines = array_values($lines); // Re-index array

        if (empty($lines)) {
            return '<p>No content found in PDF</p>';
        }

        // Detect base indentation (minimum leading spaces across all lines)
        $minIndent = PHP_INT_MAX;
        foreach ($lines as $line) {
            $leadingSpaces = strlen($line) - strlen(ltrim($line));
            if ($leadingSpaces < $minIndent && trim($line) !== '') {
                $minIndent = $leadingSpaces;
            }
        }
        $minIndent = max(0, $minIndent);

        // Group lines into paragraphs
        $paragraphs = [];
        $currentParagraph = [];
        $previousIndent = 0;
        $previousLineEndsWithPunctuation = false;

        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            
            // Empty line indicates paragraph break
            if (empty($trimmedLine)) {
                if (!empty($currentParagraph)) {
                    $paragraphs[] = [
                        'lines' => $currentParagraph,
                        'indent' => $previousIndent
                    ];
                    $currentParagraph = [];
                }
                $previousLineEndsWithPunctuation = false;
                continue;
            }

            // Detect indentation
            $leadingSpaces = strlen($line) - strlen(ltrim($line));
            $indent = max(0, $leadingSpaces - $minIndent);

            // Check if current line starts with uppercase (potential new sentence/paragraph)
            $startsWithUppercase = preg_match('/^[A-Z]/', $trimmedLine);
            
            // Check if line is all uppercase (likely heading)
            $isAllUppercase = $trimmedLine === strtoupper($trimmedLine) && strlen($trimmedLine) > 3;
            
            // Check if line is numbered (e.g., "1.1", "2.", etc.)
            $isNumbered = preg_match('/^\d+\./', $trimmedLine);
            
            // Check if previous line ends with sentence-ending punctuation
            $lastChar = !empty($currentParagraph) ? substr(end($currentParagraph), -1) : '';
            $endsWithPunctuation = in_array($lastChar, ['.', '!', '?']);

            // Detect paragraph break:
            // 1. Empty line (already handled above)
            // 2. Significant indentation change (> 2 spaces)
            // 3. Previous line ends with punctuation AND current line starts with uppercase
            // 4. Current line is all uppercase (heading)
            // 5. Current line is numbered (list item)
            $isParagraphBreak = false;
            
            if (!empty($currentParagraph)) {
                if (abs($indent - $previousIndent) > 2) {
                    $isParagraphBreak = true;
                } elseif ($endsWithPunctuation && $startsWithUppercase) {
                    $isParagraphBreak = true;
                } elseif ($isAllUppercase) {
                    $isParagraphBreak = true;
                } elseif ($isNumbered) {
                    $isParagraphBreak = true;
                }
            }

            if ($isParagraphBreak) {
                $paragraphs[] = [
                    'lines' => $currentParagraph,
                    'indent' => $previousIndent
                ];
                $currentParagraph = [];
            }

            $currentParagraph[] = $trimmedLine;
            $previousIndent = $indent;
        }

        // Don't forget the last paragraph
        if (!empty($currentParagraph)) {
            $paragraphs[] = [
                'lines' => $currentParagraph,
                'indent' => $previousIndent
            ];
        }

        // Convert paragraphs to HTML
        foreach ($paragraphs as $index => $paragraph) {
            $indentEm = $paragraph['indent'] / 4; // Convert spaces to em (4 spaces = 1em)
            
            // Merge lines within paragraph with single space
            $mergedText = implode(' ', $paragraph['lines']);
            
            // Preserve multiple spaces within text
            $displayLine = htmlspecialchars($mergedText);
            $displayLine = str_replace('  ', '&nbsp;&nbsp;', $displayLine);
            
            // Build HTML with formatting
            $style = "margin-bottom: 0.5em; line-height: 1.6; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;";
            
            if ($indentEm > 0.5) {
                $style .= " margin-left: " . number_format($indentEm, 2) . "em;";
            }

            $htmlContent .= '<p style="' . $style . '">' . $displayLine . '</p>';
            
            // Add empty paragraph for spacing (except for last paragraph)
            if ($index < count($paragraphs) - 1) {
                $htmlContent .= '<p style="margin-bottom: 1em;">&nbsp;</p>';
            }
        }

        return $htmlContent;
    }
}
