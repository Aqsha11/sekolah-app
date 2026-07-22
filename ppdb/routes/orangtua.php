<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\OrangTuaController;
use App\Http\Controllers\Public\JadwalController;

/*
|==========================================================================
| ORANG TUA (Parent Monitoring Dashboard)
|==========================================================================
| Hanya bisa diakses user dengan role: orang_tua, super_admin, atau admin
*/
Route::middleware(['auth', 'role:orang_tua|super_admin|admin'])->prefix('orang-tua')->name('orangtua.')->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat/{siswa}', [OrangTuaController::class, 'riwayat'])->name('riwayat');
    Route::get('/realtime/{siswa}', [OrangTuaController::class, 'realtime'])->name('realtime');
    Route::get('/realtime-all', [OrangTuaController::class, 'realtimeAll'])->name('realtimeAll');
    Route::get('/jadwal', [JadwalController::class, 'orangTua'])->name('jadwal');
});
