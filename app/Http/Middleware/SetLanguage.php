<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from URL parameter, session, or browser accept header
        $language = $request->get('lang', Session::get('locale'));
        
        // If no language is set, detect from browser
        if (!$language) {
            $browserLanguage = $request->getPreferredLanguage(['id', 'en', 'es', 'ar']);
            $language = $browserLanguage ?: config('app.locale');
        }
        
        // Validate language is supported
        $supportedLanguages = ['id', 'en', 'es', 'ar'];
        
        if (in_array($language, $supportedLanguages)) {
            App::setLocale($language);
            Session::put('locale', $language);
            
            // Set RTL direction for Arabic
            if ($language === 'ar') {
                Session::put('direction', 'rtl');
            } else {
                Session::put('direction', 'ltr');
            }
        }
        
        return $next($request);
    }
}
