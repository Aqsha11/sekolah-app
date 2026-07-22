<?php

namespace Database\Seeders;

use App\Models\KalenderAkademik;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KalenderAkademikSeeder extends Seeder
{
    public function run(): void
    {
        if (KalenderAkademik::count() > 0) {
            $this->command->warn('Kalender akademik sudah ada, skip seeder.');
            return;
        }

        $year = (int) Carbon::now()->format('Y');
        $events = [
            [
                'judul'          => 'Tahun Ajaran Baru ' . $year . '/' . ($year + 1),
                'deskripsi'      => 'Masa orientasi siswa baru dan pengenalan lingkungan sekolah.',
                'tanggal_mulai'  => "{$year}-07-14",
                'tanggal_selesai'=> "{$year}-07-16",
                'tipe'           => 'kegiatan',
            ],
            [
                'judul'          => 'Libur Hari Raya',
                'deskripsi'      => 'Libur nasional dalam rangka Hari Raya.',
                'tanggal_mulai'  => "{$year}-07-01",
                'tanggal_selesai'=> "{$year}-07-02",
                'tipe'           => 'libur',
            ],
            [
                'judul'          => 'Ujian Tengah Semester (UTS)',
                'deskripsi'      => 'Pelaksanaan ujian tengah semester ganjil.',
                'tanggal_mulai'  => "{$year}-09-15",
                'tanggal_selesai'=> "{$year}-09-20",
                'tipe'           => 'ujian',
            ],
            [
                'judul'          => 'Hari Sumpah Pemuda',
                'deskripsi'      => 'Peringatan Hari Sumpah Pemuda — upacara bendera.',
                'tanggal_mulai'  => "{$year}-10-28",
                'tanggal_selesai'=> "{$year}-10-28",
                'tipe'           => 'penting',
            ],
            [
                'judul'          => 'Hari Pahlawan',
                'deskripsi'      => 'Peringatan Hari Pahlawan 10 November — upacara dan lomba.',
                'tanggal_mulai'  => "{$year}-11-10",
                'tanggal_selesai'=> "{$year}-11-10",
                'tipe'           => 'penting',
            ],
            [
                'judul'          => 'Ujian Akhir Semester (UAS)',
                'deskripsi'      => 'Pelaksanaan ujian akhir semester ganjil.',
                'tanggal_mulai'  => "{$year}-12-01",
                'tanggal_selesai'=> "{$year}-12-06",
                'tipe'           => 'ujian',
            ],
            [
                'judul'          => 'Libur Natal & Tahun Baru',
                'deskripsi'      => 'Libur nasional dalam rangka Hari Natal dan Tahun Baru.',
                'tanggal_mulai'  => "{$year}-12-24",
                'tanggal_selesai'=> ($year + 1) . "-01-02",
                'tipe'           => 'libur',
            ],
            [
                'judul'          => 'Tahun Ajaran ' . $year . '/' . ($year + 1) . ' Semester Genap Dimulai',
                'deskripsi'      => 'Awal semester genap — masuk sekolah normal.',
                'tanggal_mulai'  => ($year + 1) . "-01-06",
                'tanggal_selesai'=> ($year + 1) . "-01-06",
                'tipe'           => 'kegiatan',
            ],
            [
                'judul'          => 'Ujian Tengah Semester Genap',
                'deskripsi'      => 'Pelaksanaan ujian tengah semester genap.',
                'tanggal_mulai'  => ($year + 1) . "-03-09",
                'tanggal_selesai'=> ($year + 1) . "-03-14",
                'tipe'           => 'ujian',
            ],
            [
                'judul'          => 'Hari Pendidikan Nasional',
                'deskripsi'      => 'Upacara peringatan Hardiknas dan lomba antar kelas.',
                'tanggal_mulai'  => ($year + 1) . "-04-02",
                'tanggal_selesai'=> ($year + 1) . "-04-02",
                'tipe'           => 'penting',
            ],
            [
                'judul'          => 'Ujian Akhir Semester Genap',
                'deskripsi'      => 'Pelaksanaan ujian akhir semester genap.',
                'tanggal_mulai'  => ($year + 1) . "-05-18",
                'tanggal_selesai'=> ($year + 1) . "-05-23",
                'tipe'           => 'ujian',
            ],
            [
                'judul'          => 'Libur Hari Raya Waisak',
                'deskripsi'      => 'Libur nasional dalam rangka Hari Raya Waisak.',
                'tanggal_mulai'  => ($year + 1) . "-05-12",
                'tanggal_selesai'=> ($year + 1) . "-05-12",
                'tipe'           => 'libur',
            ],
            [
                'judul'          => 'Libur Hari Raya Idul Fitri',
                'deskripsi'      => 'Libur nasional dalam rangka Hari Raya Idul Fitri.',
                'tanggal_mulai'  => ($year + 1) . "-03-20",
                'tanggal_selesai'=> ($year + 1) . "-04-01",
                'tipe'           => 'libur',
            ],
            [
                'judul'          => 'Penerimaan Raport',
                'deskripsi'      => 'Pembagian raport akhir semester genap.',
                'tanggal_mulai'  => ($year + 1) . "-06-20",
                'tanggal_selesai'=> ($year + 1) . "-06-20",
                'tipe'           => 'kegiatan',
            ],
            [
                'judul'          => 'Libur Akhir Tahun Ajaran',
                'deskripsi'      => 'Libur siswa menjelang tahun ajaran baru.',
                'tanggal_mulai'  => ($year + 1) . "-06-22",
                'tanggal_selesai'=> ($year + 1) . "-07-13",
                'tipe'           => 'libur',
            ],
        ];

        foreach ($events as $event) {
            KalenderAkademik::create([
                ...$event,
                'is_active' => true,
            ]);
        }

        $this->command->info('Kalender akademik berhasil dibuat (' . count($events) . ' event).');
    }
}
