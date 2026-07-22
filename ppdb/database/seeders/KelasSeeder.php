<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        if (Kelas::count() > 0) {
            $this->command->warn('Kelas sudah ada, skip seeder.');
            return;
        }

        $kelasList = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];

        foreach ($kelasList as $nama) {
            Kelas::create(['nama_kelas' => $nama]);
        }

        $this->command->info('Kelas berhasil dibuat (' . count($kelasList) . ' kelas).');
    }
}
