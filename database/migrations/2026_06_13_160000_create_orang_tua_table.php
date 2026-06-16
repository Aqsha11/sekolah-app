<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')
                ->unique()
                ->nullable();
            $table->string('phone')
                ->nullable();
            $table->timestamps();
        });
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropPrimary();
        });
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->renameColumn(
                'user_id',
                'orang_tua_id'
            );
        });
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->foreign('orang_tua_id')
                ->references('id')
                ->on('orang_tua')
                ->cascadeOnDelete();
            $table->primary([
                'orang_tua_id',
                'siswa_id'
            ]);
        });
    }
    public function down(): void
    {
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropForeign([
                'orang_tua_id'
            ]);
            $table->dropPrimary();
        });
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->renameColumn(
                'orang_tua_id',
                'user_id'
            );
        });
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->primary([
                'user_id',
                'siswa_id'
            ]);
        });
        Schema::dropIfExists('orang_tua');
    }
};