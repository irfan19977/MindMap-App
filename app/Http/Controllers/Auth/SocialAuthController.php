<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    private const PROVIDERS = ['google', 'github', 'facebook'];

    public function redirect(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        if (! config("services.{$provider}.client_id") || ! config("services.{$provider}.client_secret") || ! config("services.{$provider}.redirect")) {
            return redirect()->route('login')
                ->with('error', 'Login ' . ucfirst($provider) . ' belum dikonfigurasi.');
        }

        return Socialite::driver($provider)
            ->scopes($provider === 'github' ? ['user:email'] : ['email'])
            ->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable) {
            return redirect()->route('login')
                ->with('error', 'Autentikasi ' . ucfirst($provider) . ' gagal. Silakan coba lagi.');
        }

        $email = $socialUser->getEmail();

        if (! $email) {
            return redirect()->route('login')
                ->with('error', 'Akun ' . ucfirst($provider) . ' Anda tidak memberikan alamat email.');
        }

        $user = User::where('social_provider', $provider)
            ->where('social_provider_id', (string) $socialUser->getId())
            ->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
        }

        if (! $user) {
            request()->session()->put('social_registration', [
                'provider' => $provider,
                'provider_id' => (string) $socialUser->getId(),
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'Pengguna ' . ucfirst($provider),
                'email' => $email,
            ]);

            return redirect()->route('register');
        }

        if (! $user->social_provider) {
            $user->update([
                'social_provider' => $provider,
                'social_provider_id' => (string) $socialUser->getId(),
                'email_verified_at' => $user->email_verified_at ?: now(),
            ]);
        }

        Auth::login($user, true);
        request()->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        if ($user->hasRole('admin') || ($user->hasRole('teacher') && $user->is_active)) {
            return redirect()->route('dashboard.index');
        }

        if ($user->hasRole('teacher') && ! $user->is_active) {
            return redirect()->route('teacher.pending');
        }

        return redirect()->intended('/');
    }
}
