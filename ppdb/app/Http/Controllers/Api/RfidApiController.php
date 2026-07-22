<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RfidApiController extends Controller
{
    /**
     * POST /api/v1/rfid/scan
     * Header: X-API-Key (opsional)
     * Body: { rfid: "RFID001" }
     */
    public function scan(Request $request): JsonResponse
    {
        // Verifikasi API key wajib untuk semua request scan
        $apiKey = $request->header('X-API-Key') ?: $request->input('api_key');
        $validKey = config('rfid.api_key');
        if (! $validKey || $apiKey !== $validKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $request->validate([
            'rfid' => 'required|string',
        ]);

        $rfid = $request->rfid;
        $siswa = Siswa::where('rfid', $rfid)->first();

        if (! $siswa) {
            return response()->json([
                'success' => false,
                'message' => 'RFID tidak terdaftar',
            ], 404);
        }

        $today = Carbon::today('Asia/Makassar');
        $now = Carbon::now('Asia/Makassar');

        $jamMulai = Carbon::createFromTime(6, 0, 0, 'Asia/Makassar');
        $jamSelesai = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');

        if ($now->lt($jamMulai) || $now->gte($jamSelesai)) {
            return response()->json([
                'success' => false,
                'message' => 'Di luar jam operasional (06:00 - 16:00 WITA)',
            ], 400);
        }

        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->first();

        if (! $absensi) {
            $batasJam = Carbon::createFromTime(7, 15, 0, 'Asia/Makassar');
            $status = $now->greaterThan($batasJam) ? 'terlambat' : 'hadir';

            $absensi = Absensi::create([
                'siswa_id' => $siswa->id,
                'rfid' => $rfid,
                'check_in' => $now,
                'check_out' => null,
                'status' => $status,
                'tanggal' => $today,
            ]);

            return response()->json([
                'success' => true,
                'action' => 'check_in',
                'message' => $status === 'terlambat'
                    ? "{$siswa->nama} - Terlambat! (" . $now->format('H:i') . ")"
                    : "{$siswa->nama} - Check-in berhasil",
                'siswa' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'waktu' => $now->format('H:i:s'),
                'status' => $status,
            ]);
        }

        if (! $absensi->check_out) {
            $absensi->update(['check_out' => $now]);

            $durasi = $now->diffInMinutes($absensi->check_in);
            $jam = intdiv($durasi, 60);
            $menit = $durasi % 60;

            return response()->json([
                'success' => true,
                'action' => 'check_out',
                'message' => "{$siswa->nama} - Check-out berhasil",
                'siswa' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'waktu' => $now->format('H:i:s'),
                'durasi' => "{$jam} jam {$menit} menit",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "{$siswa->nama} sudah check-in dan check-out hari ini",
        ], 400);
    }
}
