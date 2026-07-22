<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel prestasis
     */
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('level')->nullable();
            $table->year('year')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('category');
            $table->index('year');
        });
    }

    /**
     * Hapus tabel prestasis
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};