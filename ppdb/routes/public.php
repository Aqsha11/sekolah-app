<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\TeacherController;
use App\Http\Controllers\Public\GaleryController;
use App\Http\Controllers\Public\FacilityController;
use App\Http\Controllers\Public\ContactsController;
use App\Http\Controllers\Public\PrestasiController as PublicPrestasiController;
use App\Models\Setting;

/*
|==========================================================================
| ROOT (Halaman Depan Website)
|==========================================================================
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|==========================================================================
| PUBLIC PAGES (halaman depan website)
|==========================================================================
*/
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita:slug}', [NewsController::class, 'show'])->name('berita.show');

Route::get('/profil', function () {
    $settings = Setting::pluck('value', 'key');
    return view('public.profil', compact('settings'));
})->name('profil');

Route::get('/prestasi', [PublicPrestasiController::class, 'index'])->name('prestasi');
Route::get('/prestasi/{prestasi}', [PublicPrestasiController::class, 'show'])->name('prestasi.show');

Route::get('/data-guru', [TeacherController::class, 'index'])->name('guru.index');
Route::get('/data-guru/{id}', [TeacherController::class, 'show'])->name('guru.show');

Route::get('/galeri', [GaleryController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{id}', [GaleryController::class, 'show'])->name('galeri.show');

Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas');

Route::get('/kontak', [ContactsController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [ContactsController::class, 'store'])->name('kontak.store')->middleware('throttle:contact');
