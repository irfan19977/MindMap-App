<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClassEnrollment;
use App\Models\CourseClass;
use App\Models\Material;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    public function index()
    {
        $classes = CourseClass::with(['category', 'subcategory', 'teacher.user', 'materials'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.kelas', compact('classes'));
    }

    public function show($slug)
    {
        $class = CourseClass::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        return redirect()->route('mindmap.show', $class->subcategory->slug);
    }

    public function joinClass(Request $request, $slug)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk bergabung ke kelas.');
        }

        $courseClass = CourseClass::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $student = Auth::user()->student;
        if (! $student) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai siswa.');
        }

        $existingEnrollment = ClassEnrollment::where('class_id', $courseClass->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingEnrollment) {
            if ($existingEnrollment->status === 'dropped') {
                $existingEnrollment->update(['status' => 'pending']);
            }
            return redirect()->back()->with('success', 'Anda sudah terdaftar di kelas ini. Status: ' . ucfirst($existingEnrollment->status));
        }

        ClassEnrollment::create([
            'class_id' => $courseClass->id,
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permintaan bergabung telah dikirim. Menunggu persetujuan guru.');
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
            // Cek apakah ada mindmap untuk subcategory ini
            $mindmap = \App\Models\Mindmap::with('creator.teacher')
                ->where('reference_id', $subcategory->id)
                ->published()
                ->first();

            // Enrich mindmap structure with material slugs
            if ($mindmap && $mindmap->structure) {
                $mindmap->structure = $this->enrichMindmapWithSlugs($mindmap->structure);
            }

            // Load related classes for this subcategory
            $relatedClasses = CourseClass::with(['teacher.user', 'materials', 'category'])
                ->where('subcategory_id', $subcategory->id)
                ->where('status', 'publish')
                ->get();

            $enrollments = $this->getEnrollmentStatuses($relatedClasses);

            // Debug log
            Log::info('Subcategory found for mindmap', [
                'slug' => $slug,
                'subcategory_id' => $subcategory->id,
                'subcategory_name' => $subcategory->name,
                'mindmap_found' => $mindmap ? true : false,
                'mindmap_id' => $mindmap ? $mindmap->id : null
            ]);

            return view('frontend.mindmap', compact('subcategory', 'mindmap', 'relatedClasses', 'enrollments'));
        }

        // Jika tidak ada di subcategories, cek di categories
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        // Load materials from all subcategories of this category
        $category->load('children.materials');

        // Cek apakah ada mindmap untuk category ini
        $mindmap = \App\Models\Mindmap::with('creator.teacher')
            ->where('reference_id', $category->id)
            ->published()
            ->first();

        // Enrich mindmap structure with material slugs
        if ($mindmap && $mindmap->structure) {
            $mindmap->structure = $this->enrichMindmapWithSlugs($mindmap->structure);
        }

        // Load related classes for this category
        $relatedClasses = CourseClass::with(['teacher.user', 'materials', 'subcategory'])
            ->where('category_id', $category->id)
            ->where('status', 'publish')
            ->get();

        $enrollments = $this->getEnrollmentStatuses($relatedClasses);

        // Debug log
        Log::info('Category found for mindmap', [
            'slug' => $slug,
            'category_id' => $category->id,
            'category_name' => $category->name,
            'mindmap_found' => $mindmap ? true : false,
            'mindmap_id' => $mindmap ? $mindmap->id : null
        ]);

        return view('frontend.mindmap', compact('category', 'mindmap', 'relatedClasses', 'enrollments'));
    }

    /**
     * Get enrollment statuses for the current student on given classes.
     */
    private function getEnrollmentStatuses($classes): array
    {
        if (! Auth::check()) {
            return [];
        }

        $student = Auth::user()->student;
        if (! $student || $classes->isEmpty()) {
            return [];
        }

        return ClassEnrollment::where('student_id', $student->id)
            ->whereIn('class_id', $classes->pluck('id'))
            ->get()
            ->keyBy('class_id')
            ->map(fn ($enrollment) => $enrollment->status)
            ->toArray();
    }

    /**
     * Enrich mindmap structure with material slugs
     */
    private function enrichMindmapWithSlugs($structure)
    {
        if (!isset($structure['nodes'])) {
            return $structure;
        }

        foreach ($structure['nodes'] as &$node) {
            if (isset($node['materialId'])) {
                $material = Material::find($node['materialId']);
                if ($material) {
                    $node['materialSlug'] = $material->slug;
                }
            }
        }

        return $structure;
    }

    public function showMateri($slug)
    {
        $material = Material::where('slug', $slug)
            ->with(['subcategory', 'subcategory.category', 'practiceQuestions' => fn($q) => $q->ordered()])
            ->firstOrFail();

        // Decode konten materi dari JSON (strip HTML tags if editor wrapped it)
        $rawContent = strip_tags($material->content ?? '');
        $kontenMateri = json_decode($rawContent, true);
        // If not valid JSON array, treat as plain HTML content
        if (!is_array($kontenMateri)) {
            $kontenMateri = [];
        }

        // Get related materials from same subcategory
        $relatedMaterials = Material::where('subcategory_id', $material->subcategory_id)
            ->where('id', '!=', $material->id)
            ->published()
            ->limit(4)
            ->get();

        // Check if user has passed this quiz
        $passedQuizAttempt = null;
        if (Auth::check()) {
            $quiz = $material->quizzes()->where('status', 'publish')->first();
            if ($quiz) {
                $passedQuizAttempt = \App\Models\QuizAttempt::where('user_id', Auth::id())
                    ->where('quiz_id', $quiz->id)
                    ->where('status', 'passed')
                    ->with('quizAnswers.quizQuestion')
                    ->latest()
                    ->first();
            }
        }

        return view('frontend.materi-detail', compact('material', 'kontenMateri', 'relatedMaterials', 'passedQuizAttempt'));
    }

    /**
     * Get user progress for materials
     */
    public function getUserProgress()
    {
        if (!Auth::check()) {
            return response()->json(['completed_materials' => []]);
        }

        $user = Auth::user();

        // Materi dianggap selesai/unlock jika quiz-nya lulus (status = passed)
        $passedMaterialIds = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->where('status', 'passed')
            ->with('quiz:id,material_id')
            ->get()
            ->pluck('quiz.material_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Juga sertakan materi yang tidak punya quiz (langsung dianggap selesai jika pernah dibuka)
        $progressedMaterials = UserProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->pluck('material_id')
            ->toArray();

        // Material tanpa quiz yang sudah dibuka dianggap selesai
        $materialsWithoutQuiz = \App\Models\Material::whereIn('id', $progressedMaterials)
            ->whereDoesntHave('quizzes', function($q) {
                $q->where('status', 'publish');
            })
            ->pluck('id')
            ->toArray();

        $completedMaterials = array_unique(array_merge($passedMaterialIds, $materialsWithoutQuiz));

        return response()->json(['completed_materials' => $completedMaterials]);
    }
}
