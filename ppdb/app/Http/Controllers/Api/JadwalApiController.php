<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\OrangTua;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalApiController extends Controller
{
    /**
     * GET /api/v1/jadwal?hari=
     */
    public function index(Request $request): JsonResponse
    {
        $orangTua = OrangTua::where('email', $request->user()->email)->first();
        $siswas = $orangTua ? $orangTua->anakSiswa()->get() : collect();

        $kelasIds = Kelas::whereIn('nama_kelas', $siswas->pluck('kelas'))->pluck('id');

        $query = JadwalPelajaran::with('guru')
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $jadwals = $query->orderBy('jam_mulai')
            ->get()
            ->map(fn ($j) => [
                'id' => $j->id,
                'hari' => $j->hari,
                'mata_pelajaran' => $j->mata_pelajaran,
                'jam_mulai' => $j->jam_mulai,
                'jam_selesai' => $j->jam_selesai,
                'ruangan' => $j->ruangan,
                'guru' => $j->guru?->nama,
                'kelas' => $j->kelas->nama_kelas ?? null,
            ]);

        return response()->json(['success' => true, 'data' => $jadwals]);
    }
}
