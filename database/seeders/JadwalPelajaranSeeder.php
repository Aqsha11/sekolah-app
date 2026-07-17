<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JadwalPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        if (JadwalPelajaran::count() > 0) {
            $this->command->warn('Jadwal pelajaran sudah ada, skip seeder.');
            return;
        }

        $kelasList = Kelas::pluck('id', 'nama_kelas');

        if ($kelasList->isEmpty()) {
            $this->command->error('Belum ada data kelas. Jalankan KelasSeeder terlebih dahulu.');
            return;
        }

        $guruBySubject = Guru::where('is_active', true)
            ->pluck('id', 'subject')
            ->toArray();

        if (empty($guruBySubject)) {
            $this->command->error('Belum ada data guru. Jalankan DummyImageSeeder terlebih dahulu.');
            return;
        }

        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        $mapelPerHari = [
            'senin'  => ['Matematika', 'Bahasa Indonesia', 'Fisika', 'Bahasa Inggris', 'Penjaskes', 'Informatika/TIK'],
            'selasa' => ['Bahasa Indonesia', 'Kimia', 'Matematika', 'Sejarah', 'Bahasa Inggris', 'Seni Budaya'],
            'rabu'   => ['Fisika', 'Matematika', 'Bahasa Inggris', 'Biologi', 'Bahasa Indonesia', 'BK'],
            'kamis'  => ['Kimia', 'Bahasa Indonesia', 'Sejarah', 'Matematika', 'Fisika', 'Penjaskes'],
            'jumat'  => ['Bahasa Inggris', 'Biologi', 'Matematika', 'Informatika/TIK', 'Seni Budaya', 'BK'],
            'sabtu'  => ['Penjaskes', 'Sejarah', 'Bahasa Inggris', 'Kimia', 'Biologi', 'Informatika/TIK'],
        ];

        $ruanganMap = [
            'Matematika'      => 'R.101',
            'Bahasa Indonesia' => 'R.102',
            'Bahasa Inggris'  => 'R.103',
            'Fisika'          => 'Lab Fisika',
            'Kimia'           => 'Lab Kimia',
            'Biologi'         => 'Lab Biologi',
            'Sejarah'         => 'R.104',
            'Penjaskes'       => 'Lapangan',
            'BK'              => 'R. BK',
            'Informatika/TIK' => 'Lab Komputer',
            'Seni Budaya'     => 'R. Seni',
        ];

        $total = 0;

        foreach ($kelasList as $namaKelas => $kelasId) {
            foreach ($hariList as $hari) {
                $mapels = $mapelPerHari[$hari];

                $jam = Carbon::parse('07:00');

                foreach ($mapels as $mataPelajaran) {
                    $guruId = $guruBySubject[$mataPelajaran] ?? null;
                    if (!$guruId) continue;

                    $durasi = rand(35, 90);
                    $jamSelesai = $jam->copy()->addMinutes($durasi);

                    JadwalPelajaran::create([
                        'kelas_id'       => $kelasId,
                        'guru_id'        => $guruId,
                        'mata_pelajaran' => $mataPelajaran,
                        'hari'           => $hari,
                        'jam_mulai'      => $jam->format('H:i'),
                        'jam_selesai'    => $jamSelesai->format('H:i'),
                        'ruangan'        => $ruanganMap[$mataPelajaran] ?? null,
                    ]);

                    $jam = $jamSelesai->addMinutes(rand(5, 15));
                    $total++;
                }
            }
        }

        $this->command->info("Jadwal pelajaran berhasil dibuat ({$total} jadwal, " . $kelasList->count() . " kelas).");
    }
}
