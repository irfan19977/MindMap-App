<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CourseClass;
use App\Models\Material;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $classes = CourseClass::where('created_by', $request->user()->id)->get();
        $materials = Material::where('created_by', $request->user()->id)->get();

        return view('backend.profile.show', [
            'user' => $request->user(),
            'classes' => $classes,
            'materials' => $materials,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        \Log::info('Profile update called', ['user_id' => $user->id, 'email' => $user->email]);
        \Log::info('Request data before validation', ['all' => $request->all()]);

        // Conditional validation based on what fields are present
        $rules = [
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
        ];

        // Only validate name and email if they are present
        if ($request->has('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }
        if ($request->has('email')) {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)];
        }

        $validated = $request->validate($rules);

        \Log::info('Validation passed', ['validated' => $validated]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->fill($validated);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile-photos', $filename, 'public');
            $user->profile_photo = $path;
        }

        $user->save();
        \Log::info('User saved successfully');

        // Handle professional fields based on user role
        \Log::info('User roles', ['roles' => $user->roles->pluck('name')]);
        \Log::info('Request data', ['all' => $request->all()]);

        if ($user->hasRole('teacher')) {
            \Log::info('User has teacher role, calling updateTeacherProfile');
            $this->updateTeacherProfile($request, $user);
        } elseif ($user->hasRole('admin')) {
            \Log::info('User has admin role, calling updateAdminProfile');
            $this->updateAdminProfile($request, $user);
        } else {
            \Log::info('User does not have teacher or admin role');
        }

        \Log::info('Redirecting to profile show');
        return redirect()->route('backend.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    private function updateTeacherProfile(Request $request, $user): void
    {
        $teacher = $user->teacher ?? new Teacher();
        $teacher->user_id = $user->id;

        if (!$teacher->slug) {
            $teacher->slug = Str::slug($user->name) . '-' . Str::random(6);
        }

        // Update phone from professional modal
        if ($request->has('phone')) {
            $teacher->phone = $request->phone;
        }

        // Update country and city from basic profile modal
        if ($request->has('country')) {
            $teacher->country = $request->country;
        }
        if ($request->has('city')) {
            $teacher->city = $request->city;
        }

        $teacher->fill($request->only([
            'description',
            'specialization',
            'category',
            'education',
            'experience',
            'company',
            'date_of_birth',
            'facebook',
            'github_url',
            'linkedin_url',
            'youtube_url',
            'instagram',
        ]));

        \Log::info('Saving teacher profile', ['teacher' => $teacher->toArray()]);
        $teacher->save();
    }

    private function updateAdminProfile(Request $request, $user): void
    {
        $admin = $user->admin ?? new Admin();
        $admin->user_id = $user->id;

        if (!$admin->slug) {
            $admin->slug = Str::slug($user->name) . '-' . Str::random(6);
        }

        // Update phone from professional modal
        if ($request->has('phone')) {
            $admin->phone = $request->phone;
        }

        // Update country and city from basic profile modal
        if ($request->has('country')) {
            $admin->country = $request->country;
        }
        if ($request->has('city')) {
            $admin->city = $request->city;
        }

        $admin->fill($request->only([
            'description',
            'specialization',
            'category',
            'education',
            'experience',
            'company',
            'date_of_birth',
            'facebook',
            'github_url',
            'linkedin_url',
            'youtube_url',
            'instagram',
        ]));

        \Log::info('Saving admin profile', ['admin' => $admin->toArray()]);
        $admin->save();
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('backend.profile.show')->with('success', 'Password berhasil diperbarui.');
    }
}
