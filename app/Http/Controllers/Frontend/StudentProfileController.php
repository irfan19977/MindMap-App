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

        return view('frontend.student-profile', compact('student'));
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