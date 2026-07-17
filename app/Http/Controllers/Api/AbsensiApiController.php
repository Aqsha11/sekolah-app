<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\OrangTua;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbsensiApiController extends Controller
{
    protected function getAnakSiswa(Request $request)
    {
        $orangTua = OrangTua::where('email', $request->user()->email)->first();
        return $orangTua ? $orangTua->anakSiswa()->get() : collect();
    }

    /**
     * GET /api/v1/absensi?dari=&sampai=&status=
     */
    public function index(Request $request): JsonResponse
    {
        $siswas = $this->getAnakSiswa($request);

        if ($siswas->isEmpty()) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $dari = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->get('status');

        $data = $siswas->map(function ($siswa) use ($dari, $sampai, $status) {
            $query = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$dari, $sampai]);

            if ($status) {
                $query->where('status', $status);
            }

            $absensis = $query->orderBy('tanggal', 'desc')->get();

            return [
                'siswa' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas,
                ],
                'absensi' => $absensis->map(fn ($a) => [
                    'id' => $a->id,
                    'tanggal' => $a->tanggal->format('Y-m-d'),
                    'status' => $a->status,
                    'check_in' => $a->check_in?->format('H:i:s'),
                    'check_out' => $a->check_out?->format('H:i:s'),
                ]),
                'rekap' => [
                    'hadir' => $absensis->where('status', 'hadir')->count(),
                    'izin' => $absensis->where('status', 'izin')->count(),
                    'sakit' => $absensis->where('status', 'sakit')->count(),
                    'alpha' => $absensis->where('status', 'alpha')->count(),
                    'terlambat' => $absensis->where('status', 'terlambat')->count(),
                ],
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * GET /api/v1/absensi/{siswaId}?dari=&sampai=
     */
    public function bySiswa(Request $request, int $siswaId): JsonResponse
    {
        $siswaIds = $this->getAnakSiswa($request)->pluck('id');

        if (! $siswaIds->contains($siswaId)) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        $dari = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $absensis = Absensi::where('siswa_id', $siswaId)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'tanggal' => $a->tanggal->format('Y-m-d'),
                'status' => $a->status,
                'check_in' => $a->check_in?->format('H:i:s'),
                'check_out' => $a->check_out?->format('H:i:s'),
            ]);

        return response()->json(['success' => true, 'data' => $absensis]);
    }
}
