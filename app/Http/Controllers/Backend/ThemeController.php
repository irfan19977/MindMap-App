<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    /**
     * Save theme preferences for the authenticated user
     */
    public function savePreferences(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|in:light,dark',
            'navigation' => 'required|string|in:light,dark',
            'header' => 'required|string|in:light,dark',
            'skin' => 'required|string|in:light,dark',
            'font_family' => 'required|string|in:lato,rubik,inter,cinzel,nunito,opensans,roboto',
        ]);

        $user = Auth::user();
        if ($user) {
            $preferences = array_merge($user->theme_preferences ?? [], [
                'theme' => $request->theme,
                'navigation' => $request->navigation,
                'header' => $request->header,
                'skin' => $request->skin,
                'font_family' => $request->font_family,
                'updated_at' => now()->toISOString(),
            ]);

            $user->theme_preferences = $preferences;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Theme preferences saved successfully',
                'preferences' => $preferences
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    /**
     * Get theme preferences for the authenticated user
     */
    public function getPreferences()
    {
        $user = Auth::user();
        if ($user) {
            $defaultPreferences = [
                'theme' => 'light',
                'navigation' => 'light',
                'header' => 'light',
                'skin' => 'light',
                'font_family' => 'inter',
            ];

            $preferences = array_merge($defaultPreferences, $user->theme_preferences ?? []);

            return response()->json([
                'success' => true,
                'preferences' => $preferences
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    /**
     * Apply theme preferences to the session
     */
    public function applyPreferences(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $preferences = $user->theme_preferences ?? [];
            
            // Store in session for immediate use
            session([
                'theme_preferences' => $preferences
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Theme preferences applied to session',
                'preferences' => $preferences
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }
}
