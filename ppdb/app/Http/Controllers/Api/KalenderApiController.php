<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KalenderApiController extends Controller
{
    /**
     * Ambil event kalender akademik
     * GET /api/v1/kalender?bulan=&tahun=
     */
    public function index(Request $request): JsonResponse
    {
        $bulan = (int) $request->get('bulan', Carbon::now('Asia/Makassar')->month);
        $tahun = (int) $request->get('tahun', Carbon::now('Asia/Makassar')->year);

        $events = KalenderAkademik::whereYear('tanggal_mulai', '<=', $tahun)
            ->whereYear('tanggal_selesai', '>=', $tahun)
            ->orderBy('tanggal_mulai')
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'judul' => $e->judul,
                'deskripsi' => $e->deskripsi,
                'tipe' => $e->tipe,
                'tanggal_mulai' => $e->tanggal_mulai->format('Y-m-d'),
                'tanggal_selesai' => $e->tanggal_selesai->format('Y-m-d'),
                'is_active' => $e->isActiveOn(Carbon::now('Asia/Makassar')),
            ]);

        return response()->json([
            'success' => true,
            'data' => $events,
        ]);
    }
}
