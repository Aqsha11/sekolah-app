<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Jalankan semua seeder secara berurutan
     */
    public function run(): void {
        $this->call([
            RolePermissionSeeder::class,    // 1. Buat role & permission
            CreateAdminUserSeeder::class,   // 2. Buat user admin & operator
            RoleSeeder::class,              // 3. (opsional) tambahan role
            // DummyDataSeeder::class,         // 4. Data dummy untuk development
            DummyImageSeeder::class,         // 5. Data dummy prestasi/berita/guru/galeri + images
        ]);
    }
}
