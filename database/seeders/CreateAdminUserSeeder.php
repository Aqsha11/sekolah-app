<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Buat user admin dan operator default untuk development
     */
    public function run()
    {
        // 🔥 RESET CACHE SPATIE PERMISSION (wajib!)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔥 BUAT ROLE JIKA BELUM ADA
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $operatorRole = Role::firstOrCreate([
            'name' => 'operator',
            'guard_name' => 'web'
        ]);

        // 🔥 ADMIN USER (email: admin@sekolah.test / password: password)
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.test'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['super_admin']);

        // 🔥 OPERATOR USER (email: operator@sekolah.test / password: password)
        $operator = User::firstOrCreate(
            ['email' => 'operator@sekolah.test'],
            [
                'name' => 'Operator',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $operator->syncRoles(['operator']);
    }
}
