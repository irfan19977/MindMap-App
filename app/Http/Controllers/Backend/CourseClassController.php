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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseClassController extends Controller
{
    public function index()
    {
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:publish,draft,inactive',
            'capacity' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('classes', 'public');
        }

        $courseClass = CourseClass::create($validated);
        $this->syncMaterialsFromMindmap($courseClass);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function show(CourseClass $courseClass)
    {
        $courseClass->load(['category', 'subcategory', 'teacher.user', 'materials', 'enrollments.student.user', 'acceptedCollaborations.teacher.user']);

        return view('backend.classes.show', ['class' => $courseClass]);
    }

    public function syncMaterials(CourseClass $courseClass)
    {
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:publish,draft,inactive',
            'capacity' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($courseClass->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_featured'] = $request->has('is_featured');

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
    }

    public function destroy(CourseClass $courseClass)
    {
        if (! $this->canManage($courseClass)) {
            return redirect()->route('classes.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus kelas ini.');
        }

        if ($courseClass->cover_image) {
            Storage::disk('public')->delete($courseClass->cover_image);
        }

        $courseClass->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
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
