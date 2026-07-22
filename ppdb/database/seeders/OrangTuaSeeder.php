<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        if (OrangTua::count() > 0) {
            $this->command->warn('Orang tua sudah ada, skip seeder.');
            return;
        }

        $orangTuaData = [
            ['nama' => 'Budi Santoso', 'email' => 'budi.ortu@sekolah.test', 'phone' => '082116052300'],
            ['nama' => 'Siti Rahmawati', 'email' => 'siti.ortu@sekolah.test', 'phone' => '082116052301'],
            ['nama' => 'Ahmad Hidayat', 'email' => 'ahmad.ortu@sekolah.test', 'phone' => '082116052302'],
            ['nama' => 'Dewi Sartika', 'email' => 'dewi.ortu@sekolah.test', 'phone' => '082116052303'],
            ['nama' => 'Hendra Gunawan', 'email' => 'hendra.ortu@sekolah.test', 'phone' => '082116052304'],
        ];

        $siswas = Siswa::all();

        if ($siswas->isEmpty()) {
            $this->command->error('Belum ada data siswa. Jalankan SiswaSeeder terlebih dahulu.');
            return;
        }

        foreach ($orangTuaData as $index => $data) {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => $data['phone'],
                'is_active' => true,
            ]);
            $user->syncRoles(['orang_tua']);

            $orangTua = OrangTua::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);

            $start = $index * 14;
            $children = $siswas->slice($start, 14);
            foreach ($children as $siswa) {
                $orangTua->anakSiswa()->syncWithoutDetaching([$siswa->id]);
            }
        }

        $this->command->info('Orang tua berhasil dibuat (' . count($orangTuaData) . ' orang tua, terhubung ke siswa).');
    }
}
