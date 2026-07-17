<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\KalenderAkademik;
use App\Models\Kelas;
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
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $data = [];

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

        $jadwalHariIni = collect();
        $jadwalMingguIni = collect();
        foreach ($anakSiswa as $siswa) {
            $kelas = Kelas::where('nama_kelas', $siswa->kelas)->first();
            if ($kelas) {
                $jadwalHariIni = $jadwalHariIni->concat(
                    JadwalPelajaran::where('kelas_id', $kelas->id)
                        ->where('hari', $hariIni)
                        ->with('guru')
                        ->orderBy('jam_mulai')
                        ->get()
                        ->each(fn($j) => $j->anak_nama = $siswa->nama)
                );

                $jadwalMingguIni = $jadwalMingguIni->concat(
                    JadwalPelajaran::where('kelas_id', $kelas->id)
                        ->with('guru')
                        ->orderBy('jam_mulai')
                        ->get()
                        ->each(fn($j) => $j->anak_nama = $siswa->nama)
                );
            }
        }

        $kalenderEvents = KalenderAkademik::where('tanggal_mulai', '<=', $today->copy()->addDays(30))
            ->where('tanggal_selesai', '>=', $today->copy()->subDays(7))
            ->orderBy('tanggal_mulai')
            ->get();

        return view('orang_tua.dashboard', compact(
            'data', 'today', 'jadwalHariIni', 'jadwalMingguIni', 'kalenderEvents', 'hariIni'
        ));
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

    /**
     * API: ambil data semua anak sekaligus untuk polling real-time
     */
    public function realtimeAll(): \Illuminate\Http\JsonResponse
    {
        $orangTua = $this->getOrangTua();
        $anakSiswa = $orangTua->anakSiswa()->get();
        $today = Carbon::today();

        $results = [];

        foreach ($anakSiswa as $siswa) {
            $absensi = Absensi::where('siswa_id', $siswa->id)
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

            $riwayat = Absensi::where('siswa_id', $siswa->id)
                ->latest('tanggal')
                ->take(5)
                ->get()
                ->map(fn($r) => [
                    'id' => $r->id,
                    'tanggal' => $r->tanggal->format('d M Y'),
                    'tanggal_short' => $r->tanggal->format('M d'),
                    'check_in' => $r->check_in?->format('H:i'),
                    'check_out' => $r->check_out?->format('H:i'),
                    'status' => $r->status,
                ]);

            $results[] = [
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'nis' => $siswa->nis,
                'status' => $absensi?->status ?? 'belum_absen',
                'check_in' => $absensi?->check_in?->format('H:i'),
                'check_out' => $absensi?->check_out?->format('H:i:s'),
                'check_in_time' => $absensi?->check_in?->format('H:i'),
                'total_hadir' => $totalHadir,
                'total_terlambat' => $totalTerlambat,
                'total_izin' => $totalIzin,
                'total_alpha' => $totalAlpha,
                'riwayat' => $riwayat,
            ];
        }

        return response()->json([
            'children' => $results,
            'updated_at' => Carbon::now()->format('H:i:s'),
        ]);
    }
}
