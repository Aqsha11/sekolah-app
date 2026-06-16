<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    /**
     * Daftar prestasi publik
     */
    public function index(): View
    {
        $prestasi = Prestasi::latest()->paginate(9);

        return view('public.prestasi', compact('prestasi'));
    }

    /**
     * Detail prestasi
     */
    public function show(Prestasi $prestasi): View
    {
        return view('public.prestasi-show', compact('prestasi'));
    }
}
