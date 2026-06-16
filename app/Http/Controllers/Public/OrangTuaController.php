<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\OrangTua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrangTuaController extends Controller
{
    /**
     * Ambil data OrangTua berdasarkan user yang login
     * User login (tabel users) dicocokkan via email ke tabel orang_tua
     */
    protected function getOrangTua(): OrangTua
    {
        $user = auth()->user();
        return OrangTua::where('email', $user->email)->firstOrFail();
    }

    /**
     * Dashboard orang tua: lihat absensi anak-anaknya hari ini
     */
    public function dashboard(Request $request): View
    {
        $orangTua = $this->getOrangTua();
        $anakSiswa = $orangTua->anakSiswa()->get();

        $today = Carbon::today();
        $data = [];

        // Loop setiap anak, hitung statistik absensi
        foreach ($anakSiswa as $siswa) {
            $absensiHariIni = Absensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $today)
                ->first();

            $totalHadir = Absensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();

            $totalTerlambat = Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'terlambat')
                ->count();

            $totalIzin = Absensi::where('siswa_id', $siswa->id)
                ->whereIn('status', ['izin', 'sakit'])
                ->count();

            $totalAlpha = Absensi::where('siswa_id', $siswa->id)
                ->where('status', 'alpha')
                ->count();

            $riwayatTerbaru = Absensi::where('siswa_id', $siswa->id)
                ->latest('tanggal')
                ->take(5)
                ->get();

            $data[] = [
                'siswa' => $siswa,
                'absensi_hari_ini' => $absensiHariIni,
                'riwayat' => $riwayatTerbaru,
                'total_hadir' => $totalHadir,
                'total_terlambat' => $totalTerlambat,
                'total_izin' => $totalIzin,
                'total_alpha' => $totalAlpha,
            ];
        }

        return view('orang_tua.dashboard', compact('data', 'today'));
    }

    /**
     * Riwayat absensi detail per anak, bisa filter bulan
     */
    public function riwayat(Request $request, $siswaId): View
    {
        $orangTua = $this->getOrangTua();
        $siswa = $orangTua->anakSiswa()->findOrFail($siswaId);

        $query = Absensi::where('siswa_id', $siswa->id);

        // Filter berdasarkan bulan (format: YYYY-MM)
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        $absensis = $query->latest('tanggal')->paginate(30);
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');

        return view('orang_tua.riwayat', compact('siswa', 'absensis', 'bulan'));
    }

    /**
     * API: ambil data absensi real-time (dipanggil JS setiap beberapa detik)
     */
    public function realtime($siswaId): \Illuminate\Http\JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $siswa = $orangTua->anakSiswa()->findOrFail($siswaId);

        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', Carbon::today())
            ->first();

        return response()->json([
            'check_in' => $absensi?->check_in?->format('H:i:s'),
            'check_out' => $absensi?->check_out?->format('H:i:s'),
            'status' => $absensi?->status ?? 'belum_absen',
            'siswa' => $siswa->nama,
            'kelas' => $siswa->kelas,
        ]);
    }
}
