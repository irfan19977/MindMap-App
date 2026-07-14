<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return redirect()->route('backend.profile.show');
    }

    public function update(Request $request)
    {
        return redirect()->route('backend.profile.show');
    }

    public function destroy(Request $request)
    {
        return redirect()->route('backend.profile.show');
    }
}
