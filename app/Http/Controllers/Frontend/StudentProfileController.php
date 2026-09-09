<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $students = Student::with('user')->get()
            ->sortByDesc(fn ($studentItem) => $studentItem->experience_points)
            ->values();

        $studentRank = $students->search(fn ($studentItem) => $studentItem->id === $student->id);
        $studentRank = $studentRank === false ? null : $studentRank + 1;
        $globalStudentCount = $students->count();

        return view('frontend.student-profile', compact('student', 'studentRank', 'globalStudentCount'));
    }

    public function leaderboard()
    {
        $user = Auth::user();

        $page = request()->get('page', 1);
        $perPage = 50;

        $allStudents = Student::with('user')->get()
            ->sortByDesc(fn ($studentItem) => $studentItem->experience_points)
            ->values();

        $currentStudent = null;
        if ($user && $user->student) {
            $currentStudent = $user->student->load('user');
        }

        // For mobile: paginate all students (including top 3)
        $mobilePaginatedList = $allStudents;
        if ($currentStudent) {
            $mobilePaginatedList = $allStudents->reject(fn($s) => $s->id === $currentStudent->id)->values();
        }

        $mobileStudents = new \Illuminate\Pagination\LengthAwarePaginator(
            $mobilePaginatedList->forPage($page, $perPage),
            $mobilePaginatedList->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // For desktop: exclude top 3 students (podium) and current student from paginated list
        $top3Ids = $allStudents->take(3)->pluck('id')->toArray();
        $desktopPaginatedList = $allStudents->reject(fn($s) => in_array($s->id, $top3Ids))->values();

        if ($currentStudent) {
            $desktopPaginatedList = $desktopPaginatedList->reject(fn($s) => $s->id === $currentStudent->id)->values();
        }

        $desktopStudents = new \Illuminate\Pagination\LengthAwarePaginator(
            $desktopPaginatedList->forPage($page, $perPage),
            $desktopPaginatedList->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('frontend.leaderboard', [
            'mobileStudents' => $mobileStudents,
            'desktopStudents' => $desktopStudents,
            'allStudents' => $allStudents,
            'currentStudent' => $currentStudent
        ]);
    }

    public function edit()
    {
        $user = Auth::user();

        if (!$user || !$user->student) {
            abort(403, 'Hanya siswa yang dapat mengakses halaman ini.');
        }

        $student = $user->student;
        $student->load('user');

        return view('frontend.student-profile-edit', compact('student'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->student) {
            abort(403, 'Hanya siswa yang dapat mengakses halaman ini.');
        }

        $student = $user->student;

        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'school'             => ['nullable', 'string', 'max:255'],
            'grade'              => ['nullable', 'string', 'max:50'],
            'major'              => ['nullable', 'string', 'max:255'],
            'learning_interest'  => ['nullable', 'string', 'max:255'],
            'birth_date'         => ['nullable', 'date'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'address'            => ['nullable', 'string', 'max:500'],
            'avatar'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar'      => ['nullable', 'boolean'],
        ]);

        // Nama disimpan di tabel users, sisanya di tabel students
        $user->update([
            'name' => $validated['name'],
        ]);

        $avatarPath = $student->avatar;

        if ($request->hasFile('avatar')) {
            // Hapus foto lama kalau ada, lalu simpan yang baru
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar')) {
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = null;
        }

        $student->update([
            'school'            => $validated['school'] ?? null,
            'grade'             => $validated['grade'] ?? null,
            'major'             => $validated['major'] ?? null,
            'learning_interest' => $validated['learning_interest'] ?? null,
            'birth_date'        => $validated['birth_date'] ?? null,
            'phone'             => $validated['phone'] ?? null,
            'address'           => $validated['address'] ?? null,
            'avatar'            => $avatarPath,
        ]);

        return redirect()
            ->route('student.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}