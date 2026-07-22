<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom rfid ke tabel siswas
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('rfid')->nullable()->unique()->after('jurusan');
        });
    }

    /**
     * Hapus kolom rfid dari tabel siswas
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('rfid');
        });
    }
};
