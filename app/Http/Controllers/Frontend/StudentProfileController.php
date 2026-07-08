<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user || !$user->student) {
            abort(403, 'Hanya siswa yang dapat mengakses halaman ini.');
        }

        $student = $user->student;
        $student->load('user');

        return view('frontend.student-profile', compact('student'));
    }
}
