<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseClass;
use App\Models\Subcategory;
use App\Models\Teacher;
use App\Models\TeacherCollaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaborationController extends Controller
{


    /**
     * Display collaboration page for a specific class.
     */
    public function classCollaboration(CourseClass $courseClass)
    {
        $teachers = Teacher::with('user')->get();
        $collaborations = TeacherCollaboration::with(['admin', 'teacher.user'])
            ->where('collaboration_type', 'class')
            ->where('class_id', $courseClass->id)
            ->latest()
            ->get();

        return view('backend.collaborations.class', compact('courseClass', 'teachers', 'collaborations'));
    }

    /**
     * Display a listing of collaborations.
     */
    public function index()
    {
        $collaborations = TeacherCollaboration::with(['admin', 'teacher.user', 'category', 'subcategory', 'class'])
            ->latest()
            ->get();

        return view('backend.collaborations.index', compact('collaborations'));
    }

    /**
     * Show the form for creating a new collaboration.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        $categories = Category::where('status', 'publish')->get();
        $subcategories = Subcategory::where('status', 'publish')->get();
        $classes = CourseClass::where('status', 'publish')->get();

        return view('backend.collaborations.create', compact('teachers', 'categories', 'subcategories', 'classes'));
    }

    /**
     * Store a newly created collaboration in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'collaboration_type' => 'required|in:category,subcategory,class',
            'category_id' => 'required_if:collaboration_type,category|exists:categories,id',
            'subcategory_id' => 'required_if:collaboration_type,subcategory|exists:subcategories,id',
            'class_id' => 'required_if:collaboration_type,class|exists:classes,id',
            'message' => 'nullable|string|max:1000',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string|in:view,create,edit,delete,mindmap,materials,quiz',
        ]);

        // Check if collaboration already exists
        $existing = TeacherCollaboration::where('teacher_id', $request->teacher_id)
            ->where('collaboration_type', $request->collaboration_type)
            ->where(function ($query) use ($request) {
                switch ($request->collaboration_type) {
                    case 'category':
                        $query->where('category_id', $request->category_id);
                        break;
                    case 'subcategory':
                        $query->where('subcategory_id', $request->subcategory_id);
                        break;
                    case 'class':
                        $query->where('class_id', $request->class_id);
                        break;
                }
            })
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Kolaborasi untuk guru ini sudah ada dengan status ' . $existing->formatted_status);
        }

        $collaboration = TeacherCollaboration::create([
            'admin_id' => Auth::id(),
            'teacher_id' => $request->teacher_id,
            'collaboration_type' => $request->collaboration_type,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'class_id' => $request->class_id,
            'message' => $request->message,
            'permissions' => $request->permissions,
            'invited_at' => now(),
        ]);

        return redirect()->route('collaborations.index')
            ->with('success', 'Undangan kolaborasi berhasil dikirim ke ' . $collaboration->teacher->user->name);
    }

    /**
     * Show the form for editing the specified collaboration.
     */
    public function edit(TeacherCollaboration $collaboration)
    {
        $teachers = Teacher::with('user')->get();
        $categories = Category::where('status', 'publish')->get();
        $subcategories = Subcategory::where('status', 'publish')->get();
        $classes = CourseClass::where('status', 'publish')->get();

        return view('backend.collaborations.edit', compact('collaboration', 'teachers', 'categories', 'subcategories', 'classes'));
    }

    /**
     * Update the specified collaboration in storage.
     */
    public function update(Request $request, TeacherCollaboration $collaboration)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string|in:view,create,edit,delete,mindmap,materials,quiz',
        ]);

        $collaboration->update([
            'message' => $request->message,
            'permissions' => $request->permissions,
        ]);

        return redirect()->route('collaborations.index')
            ->with('success', 'Kolaborasi berhasil diperbarui');
    }

    /**
     * Remove the specified collaboration from storage.
     */
    public function destroy(TeacherCollaboration $collaboration)
    {
        $collaboration->delete();

        return redirect()->route('collaborations.index')
            ->with('success', 'Kolaborasi berhasil dihapus');
    }

    /**
     * Revoke a collaboration.
     */
    public function revoke(TeacherCollaboration $collaboration)
    {
        $collaboration->delete();

        return back()->with('success', 'Kolaborasi berhasil dibatalkan dan dihapus');
    }

    /**
     * Get subcategories for a category (AJAX).
     */
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json(['subcategories' => []]);
        }

        $subcategories = Subcategory::where('category_id', $categoryId)
            ->where('status', 'publish')
            ->get(['id', 'name']);

        return response()->json(['subcategories' => $subcategories]);
    }

    /**
     * Get classes for a subcategory (AJAX).
     */
    public function getClasses(Request $request)
    {
        $subcategoryId = $request->input('subcategory_id');
        
        if (!$subcategoryId) {
            return response()->json(['classes' => []]);
        }

        $classes = CourseClass::where('subcategory_id', $subcategoryId)
            ->where('status', 'publish')
            ->get(['id', 'name']);

        return response()->json(['classes' => $classes]);
    }

    /**
     * Quick invite for class collaboration (AJAX).
     */
    public function quickInvite(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'message' => 'nullable|string|max:1000',
        ]);

        // Check if collaboration already exists
        $existing = TeacherCollaboration::where('teacher_id', $request->teacher_id)
            ->where('collaboration_type', 'class')
            ->where('class_id', $request->class_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existing) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kolaborasi untuk guru ini sudah ada dengan status ' . $existing->formatted_status
                ], 422);
            }
            return back()->with('error', 'Kolaborasi untuk guru ini sudah ada dengan status ' . $existing->formatted_status);
        }

        $collaboration = TeacherCollaboration::create([
            'admin_id' => Auth::id(),
            'teacher_id' => $request->teacher_id,
            'collaboration_type' => 'class',
            'class_id' => $request->class_id,
            'message' => $request->message,
            'permissions' => ['view', 'create', 'edit', 'delete', 'mindmap', 'materials', 'quiz'],
            'invited_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Undangan kolaborasi berhasil dikirim ke ' . $collaboration->teacher->user->name,
                'collaboration' => $collaboration->load(['teacher.user', 'class'])
            ]);
        }

        return back()->with('success', 'Undangan kolaborasi berhasil dikirim ke ' . $collaboration->teacher->user->name);
    }

    /**
     * Display teacher's collaboration invitations (inbox).
     */
    public function myCollaborations()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $collaborations = TeacherCollaboration::where('teacher_id', $teacher->id)
            ->with(['admin', 'category', 'subcategory', 'class'])
            ->latest()
            ->get();

        return view('backend.collaborations.my', compact('collaborations'));
    }

    /**
     * Accept a collaboration invitation.
     */
    public function acceptCollaboration(TeacherCollaboration $collaboration)
    {
        \Log::info('acceptCollaboration called', ['collaboration_id' => $collaboration->id, 'status' => $collaboration->status]);
        
        $user = Auth::user();
        $teacher = $user->teacher;

        \Log::info('User check', ['user_id' => $user->id, 'teacher_id' => $teacher?->id, 'collab_teacher_id' => $collaboration->teacher_id]);

        if (!$teacher || $collaboration->teacher_id !== $teacher->id) {
            \Log::error('Unauthorized access attempt', ['teacher_id' => $teacher?->id, 'collab_teacher_id' => $collaboration->teacher_id]);
            abort(403, 'Unauthorized');
        }

        if ($collaboration->status !== 'pending') {
            \Log::warning('Collaboration not pending', ['status' => $collaboration->status]);
            return redirect()->route('classes.index')->with('error', 'Undangan ini sudah ' . $collaboration->formatted_status);
        }

        \Log::info('Accepting collaboration', ['collaboration_id' => $collaboration->id]);
        $collaboration->accept();

        return redirect()->route('classes.index')->with('success', 'Kolaborasi berhasil diterima! Anda sekarang memiliki akses ke ' . $collaboration->target_name);
    }

    /**
     * Reject a collaboration invitation.
     */
    public function rejectCollaboration(TeacherCollaboration $collaboration)
    {
        \Log::info('rejectCollaboration called', ['collaboration_id' => $collaboration->id, 'status' => $collaboration->status]);
        
        $user = Auth::user();
        $teacher = $user->teacher;

        \Log::info('User check', ['user_id' => $user->id, 'teacher_id' => $teacher?->id, 'collab_teacher_id' => $collaboration->teacher_id]);

        if (!$teacher || $collaboration->teacher_id !== $teacher->id) {
            \Log::error('Unauthorized access attempt', ['teacher_id' => $teacher?->id, 'collab_teacher_id' => $collaboration->teacher_id]);
            abort(403, 'Unauthorized');
        }

        if ($collaboration->status !== 'pending') {
            \Log::warning('Collaboration not pending', ['status' => $collaboration->status]);
            return redirect()->route('classes.index')->with('error', 'Undangan ini sudah ' . $collaboration->formatted_status);
        }

        \Log::info('Rejecting collaboration', ['collaboration_id' => $collaboration->id]);
        $collaboration->reject();

        return redirect()->route('classes.index')->with('success', 'Kolaborasi berhasil ditolak');
    }
}
