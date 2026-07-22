<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        if (Siswa::count() > 0) {
            $this->command->warn('Siswa sudah ada, skip seeder.');
            return;
        }

        if (Kelas::count() === 0) {
            $this->command->error('Belum ada data kelas. Jalankan KelasSeeder terlebih dahulu.');
            return;
        }

        $namaSiswa = [
            'Ahmad Fauzan',
            'Bunga Citra Lestari',
            'Chandra Wijaya',
            'Dian Permata Sari',
            'Eko Prasetyo',
            'Fitri Handayani',
            'Gilang Ramadhan',
            'Hesti Purnamasari',
            'Indra Maulana',
            'Joko Susilo',
            'Kartika Sari Dewi',
            'Lukman Hakim',
            'Mega Wati',
            'Nanda Pratama',
            'Olivia Putri',
            'Panji Kusuma',
            'Rina Melati',
            'Satria Budi',
            'Tika Wulandari',
            'Umar Hadi',
            'Vina Amalia',
            'Wahyu Nugroho',
            'Yuniarti',
            'Zaki Abdullah',
            'Aditya Rahman',
            'Bella Safira',
            'Cipto Gunawan',
            'Dina Mariana',
            'Evan Dimas',
            'Fara Nabila',
            'Guntur Prayoga',
            'Happy Novita',
            'Iqbal Ramadhan',
            'Jessica Angelina',
            'Kevin Sanjaya',
            'Laras Ayu',
            'M. Rizky Pratama',
            'Natasha Kusuma',
            'Oscar Wirawan',
            'Putri Ayunda',
            'Rafi Ahmad',
            'Salsabila Nur',
            'Taufik Hidayat',
            'Utami Dewi',
            'Valentino Febri',
            'Widya Astuti',
            'Xavier Januar',
            'Yoga Saputra',
            'Zahra Aliffia',
            'Adi Saputra',
            'Bima Sakti',
            'Citra Kirana',
            'Dimas Prayoga',
            'Elsa Safitri',
            'Fajar Setiawan',
            'Gita Permata',
            'Hasan Basri',
            'Intan Permata',
            'Jefri Pratama',
            'Kinanti Ayu',
            'Lintang Kusuma',
            'Maya Sari',
            'Novi Andriani',
            'Oni Kurniawan',
            'Puspita Dewi',
            'Rizky Febian',
            'Sherly Anggraini',
            'Teguh Santoso',
            'Ucok Sihombing',
            'Vanesa Gracia',
            'Winda Sari',
            'Yudha Pratama',
        ];

        $kelasList = Kelas::pluck('nama_kelas')->toArray();
        $jurusanList = ['IPA', 'IPA', 'IPA', 'IPA', 'IPS', 'IPS', 'IPA', 'IPS', 'Bahasa'];

        foreach ($namaSiswa as $index => $nama) {
            $kelasIndex = $index % count($kelasList);
            Siswa::create([
                'nama' => $nama,
                'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'kelas' => $kelasList[$kelasIndex],
                'jurusan' => $jurusanList[$kelasIndex] ?? 'IPA',
                'rfid' => 'RFID' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('Siswa berhasil dibuat (' . count($namaSiswa) . ' siswa).');
    }
}
