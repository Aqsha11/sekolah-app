<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel galeris
     */
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('image');
            $table->string('category')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('category');
        });
    }

    /**
     * Hapus tabel galeris
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};