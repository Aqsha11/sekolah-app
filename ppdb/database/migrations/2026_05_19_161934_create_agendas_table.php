<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel agendas
     */
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel agendas
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
