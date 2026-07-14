<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeacherCollaboration;
use Illuminate\Support\Facades\Auth;

class TeacherCollaborationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teacher');
    }

    /**
     * Display teacher's collaboration invitations.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        $collaborations = TeacherCollaboration::where('teacher_id', $teacher->id)
            ->with(['admin', 'category', 'subcategory', 'class'])
            ->latest()
            ->get();

        return view('frontend.teacher-collaborations', compact('collaborations'));
    }

    /**
     * Accept a collaboration invitation.
     */
    public function accept(TeacherCollaboration $collaboration)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher || $collaboration->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized');
        }

        if ($collaboration->status !== 'pending') {
            return back()->with('error', 'Undangan ini sudah ' . $collaboration->formatted_status);
        }

        $collaboration->accept();

        return back()->with('success', 'Kolaborasi berhasil diterima! Anda sekarang memiliki akses ke ' . $collaboration->target_name);
    }

    /**
     * Reject a collaboration invitation.
     */
    public function reject(TeacherCollaboration $collaboration)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher || $collaboration->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized');
        }

        if ($collaboration->status !== 'pending') {
            return back()->with('error', 'Undangan ini sudah ' . $collaboration->formatted_status);
        }

        $collaboration->reject();

        return back()->with('success', 'Kolaborasi berhasil ditolak');
    }
}
