<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom date ke tabel berita
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->date('date')->nullable()->after('category');
        });
    }

    /**
     * Hapus kolom date dari tabel berita
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
