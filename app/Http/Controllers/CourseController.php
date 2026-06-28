<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with('teacher')->firstOrFail();
        return view('frontend.course-detail', compact('course'));
    }
}
