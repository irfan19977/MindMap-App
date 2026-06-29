<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:student,teacher,umum'],
        ];

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
        }

        $request->validate($rules);

        // Create user (only name, email, password)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            ]);
            $user->assignRole('student');
        }

        if ($request->user_type === 'umum') {
            UmumUser::create([
                'user_id' => $user->id,
            ]);
            $user->assignRole('student');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index', absolute: false));
    }
}
