<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Jalankan semua seeder secara berurutan
     */
    public function run(): void {
        $this->call([
            RolePermissionSeeder::class,      // 1. Buat role & permission
            CreateAdminUserSeeder::class,     // 2. Buat user admin & operator
            RoleSeeder::class,                // 3. (opsional) tambahan role
            KelasSeeder::class,               // 4. Data kelas (wajib sebelum siswa)
            SiswaSeeder::class,               // 5. Data siswa (butuh kelas)
            OrangTuaSeeder::class,            // 6. Data orang tua + tautan ke siswa (butuh siswa)
            AbsensiSeeder::class,             // 7. Data absensi 20 hari kerja
            DummyImageSeeder::class,          // 8. Data dummy prestasi/berita/guru/galeri + images
            JadwalPelajaranSeeder::class,     // 9. Jadwal pelajaran (butuh kelas + guru)
            KalenderAkademikSeeder::class,    // 10. Kalender akademik
            // DummyDataSeeder::class,         // (opsional) data dummy lengkap
        ]);
    }
}
