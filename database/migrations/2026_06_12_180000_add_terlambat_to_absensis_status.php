<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah opsi 'terlambat' ke kolom status di tabel absensis
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('hadir','izin','sakit','alpha','terlambat') DEFAULT 'hadir'");
    }

    /**
     * Hapus opsi 'terlambat' dari kolom status di tabel absensis
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('hadir','izin','sakit','alpha') DEFAULT 'hadir'");
    }
};
