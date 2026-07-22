<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah kolom image di tabel galeris menjadi nullable
     */
    public function up(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Kembalikan kolom image di tabel galeris menjadi not null
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
        });
    }
};
