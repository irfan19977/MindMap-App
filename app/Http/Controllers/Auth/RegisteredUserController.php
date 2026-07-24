<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\UmumUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'categories' => Category::where('status', 'publish')->orderBy('name')->get(['id', 'name']),
            'socialRegistration' => session('social_registration'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $socialRegistration = $request->session()->get('social_registration');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'user_type' => ['required', 'in:student,teacher,umum'],
            'category_interests' => ['nullable', 'array'],
            'category_interests.*' => ['uuid', 'exists:categories,id'],
        ];

        if (! $socialRegistration) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        if ($request->user_type === 'teacher') {
            $rules['specialization'] = ['required', 'string', 'max:255'];
            $rules['education'] = ['required', 'string', 'max:1000'];
            $rules['experience'] = ['nullable', 'string', 'max:1000'];
            $rules['description'] = ['required', 'string', 'max:2000'];
            $rules['linkedin_url'] = ['nullable', 'url', 'max:255'];
            $rules['github_url'] = ['nullable', 'url', 'max:255'];
            $rules['twitter_url'] = ['nullable', 'url', 'max:255'];
        }

        if ($request->user_type === 'student') {
            $rules['school'] = ['nullable', 'string', 'max:255'];
            $rules['major'] = ['nullable', 'string', 'max:255'];
            $rules['learning_interest'] = ['nullable', 'string', 'max:1000'];
        }

        if ($request->user_type === 'umum') {
            $rules['occupation'] = ['nullable', 'string', 'max:255'];
            $rules['learning_interest'] = ['nullable', 'string', 'max:1000'];
        }

        $request->validate($rules);

        $isPendingTeacher = $request->user_type === 'teacher';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $socialRegistration ? Str::random(64) : Hash::make($request->password),
            'social_provider' => $socialRegistration['provider'] ?? null,
            'social_provider_id' => $socialRegistration['provider_id'] ?? null,
            'email_verified_at' => $socialRegistration ? now() : null,
            'user_type' => $request->user_type,
            'is_active' => ! $isPendingTeacher,
            'teacher_verification_status' => $isPendingTeacher ? 'pending' : null,
        ]);

        // Create related profile and assign role based on user_type
        if ($request->user_type === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'specialization' => $request->specialization,
                'education' => $request->education,
                'experience' => $request->experience,
                'description' => $request->description,
                'linkedin_url' => $request->linkedin_url,
                'github_url' => $request->github_url,
                'twitter_url' => $request->twitter_url,
            ]);
            $user->assignRole('teacher');
        }

        if ($request->user_type === 'student') {
            Student::create([
                'user_id' => $user->id,
                'school' => $request->school,
                'major' => $request->major,
                'learning_interest' => $request->learning_interest,
                'category_interests' => $request->input('category_interests', []),
            ]);
            $user->assignRole('student');
        }

        if ($request->user_type === 'umum') {
            UmumUser::create([
                'user_id' => $user->id,
                'occupation' => $request->occupation,
                'learning_interest' => $request->learning_interest,
                'category_interests' => $request->input('category_interests', []),
            ]);
            $user->assignRole('umum');
        }

        $request->session()->forget('social_registration');

        event(new Registered($user));

        Auth::login($user);

        if ($isPendingTeacher) {
            return redirect()->route('teacher.pending');
        }

        return redirect('/');
    }
}
