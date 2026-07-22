<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel pivot orang_tua_siswa
     */
    public function up(): void
    {
        Schema::create('orang_tua_siswa', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'siswa_id']);
        });
    }

    /**
     * Hapus tabel orang_tua_siswa
     */ 
    public function down(): void
    {
        Schema::dropIfExists('orang_tua_siswa');
    }
};
