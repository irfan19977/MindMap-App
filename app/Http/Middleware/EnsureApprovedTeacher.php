<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApprovedTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('teacher') && ! $user->is_active) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akun pengajar Anda masih menunggu verifikasi admin.',
                ], Response::HTTP_FORBIDDEN);
            }

            return redirect('/')
                ->with('error', 'Akun pengajar Anda masih menunggu verifikasi admin.');
        }

        return $next($request);
    }
}
