<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Buat tabel orang_tua, migrasi data user role orang_tua, dan ubah foreign key di orang_tua_siswa
     */
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Role::firstOrCreate(['name' => 'orang_tua', 'guard_name' => 'web']);
        $orangTuaUsers = User::role('orang_tua')->get();
        foreach ($orangTuaUsers as $user) {
            DB::table('orang_tua')->insert([
                'id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropPrimary();
            $table->foreignId('orang_tua_id')->nullable()->after('siswa_id');
        });

        DB::statement('UPDATE orang_tua_siswa SET orang_tua_id = user_id');

        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->foreign('orang_tua_id')->references('id')->on('orang_tua')->onDelete('cascade');
            $table->primary(['orang_tua_id', 'siswa_id']);
        });
    }

    /**
     * Kembalikan foreign key orang_tua_siswa ke user_id dan hapus tabel orang_tua
     */
    public function down(): void
    {
        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropForeign(['orang_tua_id']);
            $table->dropPrimary();
            $table->foreignId('user_id')->nullable()->after('siswa_id');
        });

        DB::statement('UPDATE orang_tua_siswa SET user_id = orang_tua_id');

        Schema::table('orang_tua_siswa', function (Blueprint $table) {
            $table->dropColumn('orang_tua_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['user_id', 'siswa_id']);
        });

        Schema::dropIfExists('orang_tua');
    }
};
