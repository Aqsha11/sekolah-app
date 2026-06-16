<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;

class FacilityController extends Controller
{
    /**
     * Daftar fasilitas publik (hanya yang aktif)
     */
    public function index()
    {
        $fasilitas = Fasilitas::where('status', 'active')->latest()->paginate(12);

        return view('public.fasilitas', compact('fasilitas'));
    }
}
