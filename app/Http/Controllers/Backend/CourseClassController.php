<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClassEnrollment;
use App\Models\CourseClass;
use App\Models\Material;
use App\Models\Mindmap;
use App\Models\Subcategory;
use App\Models\Teacher;
use App\Models\TeacherCollaboration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseClassController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('classes.index');
        $query = CourseClass::with(['category', 'subcategory', 'teacher.user'])
            ->orderBy('created_at', 'desc');

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $collaborationClassIds = [];

        if (! $this->isAdmin()) {
            $teacher = $user->teacher;
            if ($teacher) {
                $collaborationClassIds = TeacherCollaboration::where('teacher_id', $teacher->id)
                    ->where('collaboration_type', 'class')
                    ->where('status', 'accepted')
                    ->pluck('class_id')
                    ->toArray();

                $query->where(function ($q) use ($teacher, $user, $collaborationClassIds) {
                    $q->where('teacher_id', $teacher->id)
                        ->orWhere('created_by', $user->id)
                        ->orWhereIn('id', $collaborationClassIds);
                });
            } else {
                $query->where('created_by', $user->id);
            }
        } else {
            $teacher = $user->teacher;
            if ($teacher) {
                $collaborationClassIds = TeacherCollaboration::where('teacher_id', $teacher->id)
                    ->where('collaboration_type', 'class')
                    ->where('status', 'accepted')
                    ->pluck('class_id')
                    ->toArray();
            }
        }

        $classes = $query->get();

        // Get pending collaborations for teacher
        $pendingCollaborations = collect();
        if ($user->teacher) {
            $pendingCollaborations = TeacherCollaboration::where('teacher_id', $user->teacher->id)
                ->where('status', 'pending')
                ->with(['admin', 'class'])
                ->latest()
                ->get();
        }

        return view('backend.classes.index', compact('classes', 'collaborationClassIds', 'pendingCollaborations'));
    }

    public function create()
    {
        $this->authorize('classes.create');
        $user = auth()->user();

        $categories = Category::where('created_by', $user->id)
            ->orderBy('name', 'asc')
            ->get();
        $subcategories = Subcategory::with('category')
            ->where('created_by', $user->id)
            ->orderBy('name', 'asc')
            ->get();
        $teachersQuery = Teacher::with('user')->orderBy('slug', 'asc');
        if (! $this->isAdmin()) {
            $teachersQuery->where('user_id', $user->id);
        }
        $teachers = $teachersQuery->get();

        return view('backend.classes.addedit', compact('categories', 'subcategories', 'teachers'));
    }

    public function store(Request $request)
    {
        $this->authorize('classes.create');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:500',
            'status' => 'required|in:publish,draft,inactive',
            'capacity' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');

        try {
            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $request->file('cover_image')->store('classes', 'public');
            }

            $courseClass = CourseClass::create($validated);
            $this->syncMaterialsFromMindmap($courseClass);

            return redirect()->route('classes.index')
                ->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kelas dengan nama ini sudah ada.');
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan kelas.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan kelas.');
        }
    }

    public function show(CourseClass $courseClass)
    {
        $this->authorize('classes.index');
        $courseClass->load(['category', 'subcategory', 'teacher.user', 'materials', 'enrollments.student.user', 'acceptedCollaborations.teacher.user']);

        // Get quiz attempts for quizzes in this class's materials
        $materialIds = $courseClass->materials->pluck('id');
        $classQuizAttempts = \App\Models\QuizAttempt::with(['user', 'quiz.material'])
            ->whereHas('quiz', function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            })
            ->latest()
            ->take(10)
            ->get();

        // Get students who completed all materials in this class
        $totalMaterials = $courseClass->materials->count();
        $completedStudents = collect();
        
        if ($totalMaterials > 0) {
            $completedStudents = \App\Models\ClassEnrollment::where('class_id', $courseClass->id)
                ->where('status', 'active')
                ->with('student.user')
                ->get()
                ->filter(function ($enrollment) use ($totalMaterials) {
                    return ($enrollment->completed_materials_count ?? 0) >= $totalMaterials;
                })
                ->map(function ($enrollment) {
                    return [
                        'name' => $enrollment->student->user->name ?? '-',
                        'email' => $enrollment->student->user->email ?? '-',
                        'completed_count' => $enrollment->completed_materials_count ?? 0,
                        'completed_at' => $enrollment->updated_at ? $enrollment->updated_at->format('d M Y H:i') : '-',
                    ];
                });
        }

        return view('backend.classes.show', [
            'class' => $courseClass,
            'classQuizAttempts' => $classQuizAttempts,
            'completedStudents' => $completedStudents,
        ]);
    }

    public function syncMaterials(CourseClass $courseClass)
    {
        $this->authorize('classes.edit');
        if (! $this->canManage($courseClass)) {
            return redirect()->route('classes.show', $courseClass->id)
                ->with('error', 'Anda tidak memiliki akses untuk sync materi kelas ini.');
        }

        $this->syncMaterialsFromMindmap($courseClass);

        return redirect()->route('classes.show', $courseClass->id)
            ->with('success', 'Materi berhasil disync dari mindmap terbaru!');
    }

    public function edit(CourseClass $courseClass)
    {
        $this->authorize('classes.edit');
        if (! $this->canManage($courseClass)) {
            return redirect()->route('classes.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit kelas ini.');
        }

        $user = auth()->user();

        $categories = Category::where('created_by', $user->id)
            ->orderBy('name', 'asc')
            ->get();
        $subcategories = Subcategory::with('category')
            ->where('created_by', $user->id)
            ->orderBy('name', 'asc')
            ->get();
        $teachersQuery = Teacher::with('user')->orderBy('slug', 'asc');
        if (! $this->isAdmin()) {
            $teachersQuery->where('user_id', $user->id);
        }
        $teachers = $teachersQuery->get();

        return view('backend.classes.addedit', ['class' => $courseClass, 'categories' => $categories, 'subcategories' => $subcategories, 'teachers' => $teachers]);
    }

    public function update(Request $request, CourseClass $courseClass)
    {
        $this->authorize('classes.edit');
        if (! $this->canManage($courseClass)) {
            return redirect()->route('classes.index')
                ->with('error', 'Anda tidak memiliki akses untuk memperbarui kelas ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:500',
            'status' => 'required|in:publish,draft,inactive',
            'capacity' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($courseClass->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_featured'] = $request->has('is_featured');

        try {
            if ($request->hasFile('cover_image')) {
                if ($courseClass->cover_image) {
                    Storage::disk('public')->delete($courseClass->cover_image);
                }
                $validated['cover_image'] = $request->file('cover_image')->store('classes', 'public');
            }

            $courseClass->update($validated);
            $this->syncMaterialsFromMindmap($courseClass);

            return redirect()->route('classes.index')
                ->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kelas dengan nama ini sudah ada.');
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kelas.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kelas.');
        }
    }

    public function destroy(CourseClass $courseClass)
    {
        $this->authorize('classes.delete');
        if (! $this->canManage($courseClass)) {
            return redirect()->route('classes.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus kelas ini.');
        }

        try {
            if ($courseClass->cover_image) {
                Storage::disk('public')->delete($courseClass->cover_image);
            }

            $courseClass->delete();

            return redirect()->route('classes.index')
                ->with('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('classes.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kelas.');
        }
    }

    public function getMaterials(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        $materialIds = $this->extractMaterialIdsFromMindmap($request->subcategory_id);

        $materials = Material::whereIn('id', $materialIds)
            ->orderBy('title', 'asc')
            ->get(['id', 'title']);

        return response()->json($materials);
    }

    public function approveEnrollment(Request $request, CourseClass $courseClass, ClassEnrollment $enrollment)
    {
        if (! $this->canManage($courseClass)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        if ($enrollment->class_id !== $courseClass->id) {
            abort(404);
        }

        $enrollment->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'enrolled_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil disetujui.');
    }

    public function rejectEnrollment(Request $request, CourseClass $courseClass, ClassEnrollment $enrollment)
    {
        if (! $this->canManage($courseClass)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        if ($enrollment->class_id !== $courseClass->id) {
            abort(404);
        }

        $enrollment->update([
            'status' => 'dropped',
            'approved_at' => null,
            'approved_by' => null,
        ]);

        return redirect()->back()->with('success', 'Permintaan siswa ditolak.');
    }

    public function studentDetail(CourseClass $courseClass, $studentId)
    {
        $this->authorize('classes.index');
        
        $student = \App\Models\Student::with('user')->findOrFail($studentId);
        $enrollment = ClassEnrollment::where('class_id', $courseClass->id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        // Get mindmap for the class's subcategory
        $mindmap = Mindmap::where('reference_id', $courseClass->subcategory_id)
            ->where(function ($query) {
                $query->where('reference_type', 'subcategory')
                    ->orWhereNull('reference_type');
            })
            ->published()
            ->first();

        // Get completed materials for this student in this class
        $materialIds = $courseClass->materials()->pluck('materials.id');
        $completedMaterialIds = [];
        
        if (!$materialIds->isEmpty()) {
            // Get materials completed through UserProgress
            $progressCompleted = \App\Models\UserProgress::where('user_id', $student->user_id)
                ->whereIn('material_id', $materialIds)
                ->whereNotNull('completed_at')
                ->pluck('material_id')
                ->toArray();

            // Get materials completed through passed quizzes
            $quizCompleted = \App\Models\QuizAttempt::where('user_id', $student->user_id)
                ->where('status', 'passed')
                ->with('quiz:id,material_id')
                ->get()
                ->pluck('quiz.material_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            // Merge both completion methods and ensure uniqueness
            $completedMaterialIds = array_unique(array_merge($progressCompleted, $quizCompleted));
        }

        return view('backend.classes.student-detail', [
            'class' => $courseClass,
            'student' => $student,
            'enrollment' => $enrollment,
            'mindmap' => $mindmap,
            'completedMaterialIds' => $completedMaterialIds,
        ]);
    }

    public function getStudentQuizAnswers(Request $request, CourseClass $courseClass, $studentId, $materialId)
    {
        $this->authorize('classes.index');
        
        $student = \App\Models\Student::with('user')->findOrFail($studentId);
        
        // Get quiz attempts for this student and material
        $quizAttempts = \App\Models\QuizAttempt::with(['quiz', 'quizAnswers.quizQuestion'])
            ->where('user_id', $student->user_id)
            ->whereHas('quiz', function ($query) use ($materialId) {
                $query->where('material_id', $materialId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Group answers by attempt
        $attemptsData = [];
        foreach ($quizAttempts as $index => $attempt) {
            $answers = [];
            foreach ($attempt->quizAnswers as $answer) {
                $answers[] = [
                    'question' => $answer->quizQuestion->question ?? '-',
                    'user_answer' => $answer->user_answer ?? '-',
                    'is_correct' => $answer->is_correct,
                    'points_earned' => $answer->points_earned,
                    'explanation' => $answer->quizQuestion->explanation ?? '-',
                ];
            }
            
            $attemptsData[] = [
                'attempt_number' => $index + 1,
                'attempt_id' => $attempt->id,
                'score' => $attempt->score,
                'status' => $attempt->status,
                'attempt_date' => $attempt->created_at->format('d M Y H:i'),
                'answers' => $answers,
            ];
        }

        return response()->json([
            'success' => true,
            'attempts' => $attemptsData,
            'total_attempts' => $quizAttempts->count(),
        ]);
    }

    protected function syncMaterialsFromMindmap(CourseClass $courseClass)
    {
        $materialIds = $this->extractMaterialIdsFromMindmap($courseClass->subcategory_id);

        $syncData = [];
        foreach (array_unique($materialIds) as $index => $materialId) {
            $syncData[$materialId] = ['order_number' => $index + 1];
        }

        $courseClass->materials()->sync($syncData);
    }

    protected function extractMaterialIdsFromMindmap(string $subcategoryId): array
    {
        $mindmap = Mindmap::where('reference_id', $subcategoryId)
            ->where(function ($query) {
                $query->where('reference_type', 'subcategory')
                    ->orWhereNull('reference_type');
            })
            ->published()
            ->first();

        if (! $mindmap || ! is_array($mindmap->structure)) {
            return [];
        }

        $materialIds = [];
        $nodes = $mindmap->structure['nodes'] ?? [];

        foreach ($nodes as $node) {
            if (! empty($node['materialId'])) {
                $materialIds[] = $node['materialId'];
            }
        }

        return $materialIds;
    }

    protected function canManage(CourseClass $courseClass): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $teacher = $user->teacher;

        if ($courseClass->created_by === $user->id) {
            return true;
        }

        if ($teacher && $courseClass->teacher_id === $teacher->id) {
            return true;
        }

        // Check if teacher has accepted collaboration for this class
        if ($teacher) {
            $hasCollaboration = TeacherCollaboration::where('teacher_id', $teacher->id)
                ->where('class_id', $courseClass->id)
                ->where('status', 'accepted')
                ->exists();

            if ($hasCollaboration) {
                return true;
            }
        }

        return false;
    }

    protected function isAdmin(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->hasRole('admin');
    }
}
