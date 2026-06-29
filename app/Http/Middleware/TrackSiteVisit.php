<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests to frontend pages (skip API, assets, backend)
        if ($request->isMethod('get') && !$request->is('api/*', 'dashboard*', 'categories*', 'subcategories*', 'materis*', 'quizzes*', 'roles*', 'permissions*', 'users*', 'mindmap-creator*', 'learning-results*', 'theme*')) {
            SiteVisit::create([
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'url' => $request->path(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                'visited_date' => now()->toDateString(),
            ]);
        }

        return $next($request);
    }
}
