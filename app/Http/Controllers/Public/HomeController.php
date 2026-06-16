<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Berita;
use App\Models\Alumni;
use App\Models\Prestasi;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Agenda;
use App\Models\Setting;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home', [

            'settings' => Setting::pluck('value', 'key'),

            'statistics' => [
                (object)['label' => 'Fasilitas', 'value' => Fasilitas::count()],
                (object)['label' => 'Guru', 'value' => Guru::count()],
                (object)['label' => 'Berita', 'value' => Berita::count()],
                (object)['label' => 'Prestasi', 'value' => Prestasi::count()],
            ],

            'recentNews' => Berita::latest()->take(6)->get(),
            
            'recentPrestasi' => Prestasi::latest()->take(6)->get(),

            'recentAgenda' => Agenda::latest()->take(6)->get(),

            'recentGaleri' => Galeri::latest()->take(4)->get(),

            'recentFasilitas' => Fasilitas::latest()->take(6)->get(),

            'recentGuru' => Guru::latest()->take(8)->get(),

            'banners' => Banner::where('is_active', true)
                ->orderBy('order')
                ->get(),
        ]);
    }
}