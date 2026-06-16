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


        // Ubah pivot lama user_id menjadi orang_tua_id
        Schema::table('orang_tua_siswa', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropPrimary();

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

        Schema::dropIfExists('orang_tua');


    }
};