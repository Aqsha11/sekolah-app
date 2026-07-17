<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearDummyData extends Command
{
    protected $signature = 'data:clear {--force : Skip confirmation prompt}';

    protected $description = 'Hapus semua data dummy kecuali user super admin, settings, roles & permissions';

    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('Semua data dummy akan dihapus. Lanjutkan?')) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        $superAdminEmail = 'admin@sekolah.test';
        $superAdmin = User::where('email', $superAdminEmail)->first();

        if (!$superAdmin) {
            $this->error("User super admin ({$superAdminEmail}) tidak ditemukan.");
            return self::FAILURE;
        }

        $superAdminId = $superAdmin->id;

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            'absensis',
            'jadwal_pelajarans',
            'kalender_akademiks',
            'orang_tua_siswa',
            'agendas',
            'alumnis',
            'kontak',
            'banners',
            'galeris',
            'berita',
            'prestasis',
            'fasilitas',
            'gurus',
            'siswas',
            'orang_tua',
            'kelas',
        ];

        foreach ($tables as $table) {
            $count = DB::table($table)->count();
            DB::table($table)->truncate();
            if ($count > 0) {
                $this->info("  Truncated: {$table} ({$count} records)");
            }
        }

        // Hapus semua user KECUALI super admin
        $deletedUsers = User::where('id', '!=', $superAdminId)->delete();
        if ($deletedUsers > 0) {
            $this->info("  Deleted users: {$deletedUsers}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Clear cache
        \Cache::flush();

        $this->newLine();
        $this->info('Semua data dummy berhasil dihapus.');
        $this->info("Super admin yang tersisa: {$superAdminEmail}");
        $this->info('Settings, roles, dan permissions tetap tersimpan.');

        return self::SUCCESS;
    }
}
