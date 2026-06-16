<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Prestasi;
use App\Models\Fasilitas;
use App\Models\Kontak;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Alumni;
use App\Models\Agenda;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Halaman dashboard admin
     * Menampilkan statistik dan data terbaru
     */
    public function index(): View
    {
        $data = [
            // TOTAL DATA (untuk kartu statistik)
            'totalGuru'      => Guru::count(),
            'totalSiswa'     => Siswa::count(),
            'totalKelas'     => Kelas::count(),
            'totalAlumni'    => Alumni::count(),
            'totalBerita'    => Berita::count(),
            'totalPrestasi'  => Prestasi::count(),
            'totalGaleri'    => Galeri::count(),
            'totalFasilitas' => Fasilitas::count(),
            'totalUsers'     => User::count(),
            'unreadMessages' => \App\Models\Kontak::where('status', 'unread')->count(),

            // DATA TERBARU (untuk tabel/list di dashboard)
            'recentMessages' => \App\Models\Kontak::latest()->take(5)->get(),
            'recentNews'     => Berita::latest()->take(5)->get(),
            'recentTeachers' => Guru::latest()->take(5)->get(),
            'recentPrestasi' => Prestasi::latest()->take(5)->get(),
            'recentAgenda'   => Agenda::latest()->take(5)->get(),
            'recentGaleri'   => Galeri::latest()->take(5)->get(),

            // DATA TERBARU (alternatif)
            'latestBerita'   => Berita::latest()->limit(5)->get(),
            'latestGuru'     => Guru::latest()->limit(5)->get(),
            'latestPrestasi' => Prestasi::latest()->limit(5)->get(),
        ];

        return view('admin.dashboard.index', $data);
    }
}
