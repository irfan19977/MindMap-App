<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('frontend.teacher', compact('teachers'));
    }

    public function show($slug)
    {
        $teacher = Teacher::with('user')->where('slug', $slug)->firstOrFail();
        return view('frontend.teacher-detail', compact('teacher'));
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
