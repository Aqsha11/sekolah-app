<?php

namespace App\Http\Controllers\Public;

use App\Events\AbsensiUpdated;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RfidController extends Controller
{
    /**
     * Halaman utama RFID (untuk scanner/web)
     */
    public function index(): View
    {
        $settings = \App\Models\Setting::pluck('value', 'key');
        return view('rfid.index', compact('settings'));
    }

    /**
     * API endpoint: menerima scan RFID dari scanner
     * Method: POST
     * Body: { rfid: "RFID001" }
     * Optional header: X-API-Key (untuk hardware)
     */
    public function scan(Request $request): JsonResponse
    {
        // Verifikasi API key wajib untuk semua request scan
        $apiKey = $request->header('X-API-Key') ?: $request->input('api_key');
        $validKey = config('rfid.api_key');
        if (!$validKey || $apiKey !== $validKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Validasi input rfid
        $request->validate([
            'rfid' => 'required|string',
        ]);

        $rfid = $request->rfid;
        // Cari siswa berdasarkan RFID
        $siswa = Siswa::where('rfid', $rfid)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'RFID tidak terdaftar',
            ], 404);
        }

        // Waktu sekarang (WITA)
        $today = Carbon::today('Asia/Makassar');
        $now = Carbon::now('Asia/Makassar');

        // Jam operasional: 06:00 - 16:00 WITA
        $jamMulai = Carbon::createFromTime(6, 0, 0, 'Asia/Makassar');
        $jamSelesai = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');

        if ($now->lt($jamMulai) || $now->gte($jamSelesai)) {
            return response()->json([
                'success' => false,
                'message' => 'Di luar jam operasional (06:00 - 16:00 WITA)',
            ], 400);
        }

        // Cek absensi hari ini
        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->first();

        // BELUM absen hari ini → CHECK IN
        if (!$absensi) {
            // Batas jam masuk: 07:15, setelah itu dianggap terlambat
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

            AbsensiUpdated::dispatch($siswa, $absensi, 'check_in');

            $pesan = $status === 'terlambat'
                ? "{$siswa->nama} - Terlambat! (" . $now->format('H:i') . ")"
                : "{$siswa->nama} - Check-in berhasil";

            return response()->json([
                'success' => true,
                'action' => 'check_in',
                'message' => $pesan,
                'siswa' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'waktu' => $now->format('H:i:s'),
                'status' => $status,
                'terlambat' => $status === 'terlambat',
            ]);
        }

        // SUDAH check-in tapi belum check-out → CHECK OUT
        if (!$absensi->check_out) {
            $absensi->update([
                'check_out' => $now,
            ]);

            AbsensiUpdated::dispatch($siswa, $absensi, 'check_out');

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

        // SUDAH check-in dan check-out semua
        return response()->json([
            'success' => false,
            'message' => "{$siswa->nama} sudah check-in dan check-out hari ini",
        ], 400);
    }
}
