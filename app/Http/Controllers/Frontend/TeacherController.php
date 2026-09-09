<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\CourseClass;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->whereHas('user', function($query) {
            $query->where('is_active', true);
        })->paginate(1);
        return view('frontend.teacher', compact('teachers'));
    }

    public function pending()
    {
        if (auth()->user()->is_active) {
            return redirect()->route('dashboard.index');
        }

        return view('frontend.teacher-pending', [
            'verificationStatus' => auth()->user()->teacher_verification_status,
        ]);
    }

    public function show($slug)
    {
        $teacher = Teacher::with('user')->where('slug', $slug)->firstOrFail();

        $publishedCourses = CourseClass::where('teacher_id', $teacher->id)
            ->where('status', 'publish')
            ->with(['category', 'subcategory', 'materials'])
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        return view('frontend.teacher-detail', compact('teacher', 'publishedCourses'));
    }

    public function reviews($slug)
    {
        $teacher = Teacher::with('user')->where('slug', $slug)->firstOrFail();
        return view('frontend.teacher-reviews', compact('teacher'));
    }

    public function courses($slug)
    {
        $teacher = Teacher::with('user')->where('slug', $slug)->firstOrFail();
        return view('frontend.teacher-courses', compact('teacher'));
    }
}
