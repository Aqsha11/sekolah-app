<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AbsensiApiController;
use App\Http\Controllers\Api\SiswaApiController;
use App\Http\Controllers\Api\JadwalApiController;
use App\Http\Controllers\Api\KalenderApiController;
use App\Http\Controllers\Api\ProfilApiController;

/*
|==========================================================================
| API Routes — Mobile App / Third-Party Integration
|==========================================================================
|
| Prefix: /api/v1
| Auth: Bearer token (Sanctum)
|
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------
    | PUBLIC (tanpa auth)
    |--------------------------
    */
    Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    /*
    |--------------------------
    | AUTHenticated routes
    |--------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // Profil
        Route::get('/profil', [ProfilApiController::class, 'index']);
        Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

        // Absensi anak (orang tua)
        Route::get('/absensi', [AbsensiApiController::class, 'index']);
        Route::get('/absensi/{siswa}', [AbsensiApiController::class, 'bySiswa']);

        // Jadwal pelajaran
        Route::get('/jadwal', [JadwalApiController::class, 'index']);

        // Kalender akademik
        Route::get('/kalender', [KalenderApiController::class, 'index']);

        // Data siswa (orang tua melihat anaknya)
        Route::get('/siswa', [SiswaApiController::class, 'index']);
    });

    /*
    |--------------------------
    | RFID (tanpa auth — pakai API key)
    |--------------------------
    */
    Route::post('/rfid/scan', [\App\Http\Controllers\Api\RfidApiController::class, 'scan'])->middleware('throttle:rfid-api');
});
