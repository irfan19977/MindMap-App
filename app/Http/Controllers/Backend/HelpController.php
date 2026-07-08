<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display the help center / knowledge base page.
     */
    public function index()
    {
        return view('backend.help.index');
    }
}
