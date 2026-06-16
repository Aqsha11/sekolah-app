<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Setting;

class GaleryController extends Controller
{
    /**
     * Daftar galeri publik
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $galeris = Galeri::latest()->paginate(12);

        return view('public.galeri', compact('settings', 'galeris'));
    }

    /**
     * Detail galeri
     */
    public function show($id)
    {
        $settings = Setting::pluck('value', 'key');
        $galeri = Galeri::findOrFail($id);

        return view('public.galeri', compact('settings', 'galeri'));
    }
}
