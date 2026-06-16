<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kontak;
use App\Models\Setting;

class ContactsController extends Controller
{
    /**
     * Halaman kontak publik
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('public.kontak', compact('settings'));
    }

    /**
     * Kirim pesan dari form kontak publik
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Kontak::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
