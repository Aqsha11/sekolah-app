<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    /**
     * Jadwal untuk Guru — tampilkan jadwal mengajar berdasarkan email guru
     */
    public function guru(): View
    {
        $user = auth()->user();
        $guru = Guru::where('email', $user->email)->first();

        if (!$guru) {
            abort(403, 'Data guru tidak ditemukan untuk akun ini');
        }

        $jadwals = JadwalPelajaran::with(['kelas', 'guru'])
            ->where('guru_id', $guru->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $jadwalByHari = $jadwals->groupBy('hari');

        return view('public.jadwal-guru', compact('jadwals', 'jadwalByHari', 'guru'));
    }

    /**
     * Jadwal untuk Orang Tua — tampilkan jadwal berdasarkan kelas anak
     */
    public function orangTua(Request $request): View
    {
        $user = auth()->user();
        $orangTua = OrangTua::where('email', $user->email)->firstOrFail();
        $anakSiswa = $orangTua->anakSiswa()->get();

        // Ambil kelas unik dari semua anak
        $kelasNames = $anakSiswa->pluck('kelas')->filter()->unique()->values();

        // Cari kelas_id berdasarkan nama kelas anak
        $kelasIds = Kelas::whereIn('nama_kelas', $kelasNames)->pluck('id');

        // Filter kelas tertentu jika dipilih
        $selectedKelasId = $request->get('kelas_id');
        if ($selectedKelasId) {
            $jadwals = JadwalPelajaran::with(['kelas', 'guru'])
                ->where('kelas_id', $selectedKelasId)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        } else {
            $jadwals = JadwalPelajaran::with(['kelas', 'guru'])
                ->whereIn('kelas_id', $kelasIds)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        }

        $jadwalByHari = $jadwals->groupBy('hari');
        $kelasList = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('public.jadwal-orang-tua', compact('jadwals', 'jadwalByHari', 'anakSiswa', 'kelasList', 'selectedKelasId'));
    }
}
