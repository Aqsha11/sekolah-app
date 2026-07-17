<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        if (Absensi::count() > 0) {
            $this->command->warn('Absensi sudah ada, skip seeder.');
            return;
        }

        $siswas = Siswa::all();

        if ($siswas->isEmpty()) {
            $this->command->error('Belum ada data siswa. Jalankan SiswaSeeder terlebih dahulu.');
            return;
        }

        $statuses = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'];
        $weights = [60, 10, 10, 10, 10];

        $today = Carbon::today();
        $startDate = Carbon::today()->subWeekdays(20);

        $total = 0;
        for ($date = $startDate; $date->lte($today); $date->addDay()) {
            if ($date->isWeekend()) continue;

            foreach ($siswas as $siswa) {
                $status = $this->weightedRandom($statuses, $weights);

                $checkIn = $status === 'hadir'
                    ? Carbon::parse($date->format('Y-m-d') . ' 07:' . rand(0, 15) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                    : ($status === 'terlambat'
                        ? Carbon::parse($date->format('Y-m-d') . ' 07:' . rand(16, 30) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                        : null);

                $checkOut = $checkIn
                    ? Carbon::parse($checkIn->format('Y-m-d') . ' 1' . rand(4, 6) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                    : null;

                Absensi::create([
                    'siswa_id' => $siswa->id,
                    'rfid' => $siswa->rfid ?? '-',
                    'tanggal' => $date->format('Y-m-d'),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                ]);

                $total++;
            }
        }

        $this->command->info("Absensi berhasil dibuat ({$total} records).");
    }

    protected function weightedRandom(array $items, array $weights): string
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);
        foreach ($items as $i => $item) {
            $rand -= $weights[$i];
            if ($rand <= 0) return $item;
        }
        return $items[0];
    }
}
