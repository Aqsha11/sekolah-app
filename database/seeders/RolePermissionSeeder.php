<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder {
    /**
     * Buat semua permission dan role, lalu assign permission ke role
     */
    public function run() {
        // ===== BUAT PERMISSIONS =====
        $permissions = [
            'create berita', 'edit berita', 'delete berita', 'view berita',
            'manage users', 'manage roles', 'manage permissions',
            'manage galeri', 'manage fasilitas', 'manage website',
            'manage guru', 'manage prestasi', 'manage kontak',
            'manage banner',
            'manage berita', 'manage absensi', 'manage siswa',
            'manage kelas', 'manage agenda', 'manage alumni',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ===== BUAT ROLES =====
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $operator = Role::firstOrCreate(['name' => 'operator']);
        $guru = Role::firstOrCreate(['name' => 'guru']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $orangTua = Role::firstOrCreate(['name' => 'orang_tua']);

        // ===== ASSIGN PERMISSION KE ROLE =====
        // Super Admin: semua permission
        $superAdmin->syncPermissions($permissions);

        // Admin: semua permission (sama dengan super admin)
        $admin->syncPermissions($permissions);

        // Operator: hanya berita & galeri
        $operator->givePermissionTo(['manage berita', 'manage galeri']);

        // Guru: hanya berita
        $guru->givePermissionTo(['manage berita']);

        // Editor: hanya berita
        $editor->givePermissionTo(['manage berita']);

        // Orang Tua: tidak ada permission admin (hanya akses dashboard parent)
        $orangTua->givePermissionTo([]);
    }
}
