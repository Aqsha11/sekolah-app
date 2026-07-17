<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\RfidController;

/*
|==========================================================================
| RFID ABSENSI (public — untuk scanner)
|==========================================================================
| - GET  /rfid  : halaman scanner
| - POST /rfid/scan : endpoint scan (dibatasi 30 request/menit)
*/
Route::get('/rfid', [RfidController::class, 'index'])->name('rfid.index');
Route::post('/rfid/scan', [RfidController::class, 'scan'])
    ->name('rfid.scan')
    ->middleware('throttle:30,1');
