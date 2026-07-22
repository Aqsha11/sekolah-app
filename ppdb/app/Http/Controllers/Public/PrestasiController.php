<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Setting;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    /**
     * Daftar prestasi publik
     */
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $prestasi = Prestasi::latest()->paginate(9);

        return view('public.prestasi', compact('prestasi', 'settings'));
    }

    /**
     * Detail prestasi
     */
    public function show(Prestasi $prestasi): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('public.prestasi-show', compact('prestasi', 'settings'));
    }
}
