<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
    NotificationController::createNotification(
        $admin->id,
        'contact',
        'Pesan Contact Baru',
        "Nama: {$request->name} | Email: {$request->email} | Pesan: {$request->message}",
        '/contact'
    );
}
        

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}