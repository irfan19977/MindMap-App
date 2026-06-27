<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('frontend.teacher', compact('teachers'));
    }

    public function show($slug)
    {
        $teacher = Teacher::where('slug', $slug)->with('publishedCourses')->firstOrFail();
        return view('frontend.teacher-detail', compact('teacher'));
    }
}
