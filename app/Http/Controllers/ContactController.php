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
        // Check if request is AJAX
        $isAjax = $request->ajax() || $request->wantsJson();
        
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal. Mohon periksa input Anda.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $contact = Contact::create([
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
                    "Nama: {$request->name} | Email: {$request->email}",
                    route('contact.show', $contact->id)
                );
            }

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim.'
                ]);
            }

            return back()->with('success', 'Pesan berhasil dikirim.');
        } catch (\Exception $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan pesan.'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat mengirim pesan.');
        }
    }
}