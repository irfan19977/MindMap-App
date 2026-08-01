<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if there's an intended URL from the form
        $intendedUrl = $request->input('intended');
        
        if ($intendedUrl && !str_contains($intendedUrl, '/login') && !str_contains($intendedUrl, '/register')) {
            return redirect()->to($intendedUrl);
        }

        $user = $request->user();
        $user->update(['last_login_at' => now()]);

        // Track daily login history for students
        if ($user->student) {
            $today = now()->toDateString();
            $loginHistory = \App\Models\UserLoginHistory::where('user_id', $user->id)
                ->where('login_date', $today)
                ->first();

            if (!$loginHistory) {
                // Check yesterday's login to calculate streak
                $yesterday = now()->subDay()->toDateString();
                $yesterdayLogin = \App\Models\UserLoginHistory::where('user_id', $user->id)
                    ->where('login_date', $yesterday)
                    ->first();

                $streakCount = $yesterdayLogin ? $yesterdayLogin->streak_count + 1 : 1;

                // Calculate XP based on streak
                $xpEarned = match (true) {
                    $streakCount >= 30 => 500,
                    $streakCount >= 14 => 300,
                    $streakCount >= 7 => 150,
                    $streakCount >= 3 => 75,
                    default => 25,
                };

                \App\Models\UserLoginHistory::create([
                    'user_id' => $user->id,
                    'login_date' => $today,
                    'logged_in_at' => now(),
                    'streak_count' => $streakCount,
                    'xp_earned' => $xpEarned,
                ]);
            }
        }

        if ($user->hasRole('admin') || ($user->hasRole('teacher') && $user->is_active)) {
            return redirect()->route('dashboard.index');
        }

        if ($user->hasRole('teacher') && ! $user->is_active) {
            return redirect()->route('teacher.pending');
        }

        $intended = $request->input('intended', $request->session()->pull('url.intended', '/'));

        $intendedHost = parse_url($intended, PHP_URL_HOST);
        if ($intendedHost !== null && $intendedHost !== $request->getHost()) {
            $intended = '/';
        }

        return redirect()->to($intended);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
