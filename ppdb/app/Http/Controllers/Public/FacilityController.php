<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Setting;

class FacilityController extends Controller
{
    /**
     * Daftar fasilitas publik (hanya yang aktif)
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $fasilitas = Fasilitas::where('status', 'active')->latest()->paginate(12);

        return view('public.fasilitas', compact('fasilitas', 'settings'));
    }
}
