<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ============ ADMIN CONTROLLERS ============
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\OrangTuaController as AdminOrangTuaController;

// ============ PUBLIC CONTROLLERS ============
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\RfidController;
use App\Http\Controllers\Public\OrangTuaController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\TeacherController;
use App\Http\Controllers\Public\GaleryController;
use App\Http\Controllers\Public\FacilityController;
use App\Http\Controllers\Public\ContactsController;
use App\Http\Controllers\Public\PrestasiController as PublicPrestasiController;

use Illuminate\Support\Facades\Auth;

/*
|==========================================================================
| FORCE LOGOUT (via POST dengan CSRF)
|==========================================================================
| Digunakan untuk logout paksa jika ada masalah session
*/

Route::middleware('auth')->post('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('force-logout');

/*
|==========================================================================
| ROOT (Halaman Depan Website)
|==========================================================================
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|==========================================================================
| AUTH (Login & Logout)
|==========================================================================
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|==========================================================================
| ADMIN AREA (semua route admin dilindungi auth)
|==========================================================================
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        /*
        |--------------------------
        | DASHBOARD — semua role admin bisa akses
        |--------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------
        | CONTENT MANAGEMENT — dibatasi permission masing-masing
        |--------------------------
        */
        Route::middleware('permission:manage berita')->group(function () {
            Route::resource('berita', BeritaController::class);     // CRUD Berita
        });

        Route::middleware('permission:manage guru')->group(function () {
            Route::resource('guru', GuruController::class);         // CRUD Guru
        });

        Route::middleware('permission:manage prestasi')->group(function () {
            Route::resource('prestasi', PrestasiController::class); // CRUD Prestasi
        });

        Route::middleware('permission:manage galeri')->group(function () {
            Route::resource('galeri', GaleriController::class);     // CRUD Galeri
        });

        Route::middleware('permission:manage fasilitas')->group(function () {
            Route::resource('fasilitas', FasilitasController::class); // CRUD Fasilitas
        });

        Route::middleware('permission:manage kontak')->group(function () {
            Route::resource('kontak', KontakController::class);      // CRUD Pesan Masuk
            Route::post('/kontak/{kontak}/reply', [KontakController::class, 'reply'])
                ->name('kontak.reply');                              // Kirim balasan pesan
        });

        Route::middleware('permission:manage banner')->group(function () {
            Route::resource('banner', BannerController::class);      // CRUD Banner Hero
        });

        Route::middleware('permission:manage kelas')->group(function () {
            Route::resource('kelas', KelasController::class);        // CRUD Kelas
        });

        Route::middleware('permission:manage agenda')->group(function () {
            Route::resource('agenda', AgendaController::class);      // CRUD Agenda
        });

        Route::middleware('permission:manage alumni')->group(function () {
            Route::resource('alumni', AlumniController::class);      // CRUD Alumni
        });

        /*
        |--------------------------
        | SISWA & ABSENSI
        |--------------------------
        */
        Route::middleware('permission:manage siswa')->group(function () {
            Route::get('siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export.excel');
            Route::resource('siswa', SiswaController::class);        // CRUD Siswa
        });

        Route::middleware('permission:manage absensi')->group(function () {
            Route::prefix('absensi')->name('absensi.')->group(function () {
                Route::get('/', [AbsensiController::class, 'index'])->name('index');           // Daftar absensi
                Route::get('/create', [AbsensiController::class, 'create'])->name('create');    // Form absen manual
                Route::post('/', [AbsensiController::class, 'store'])->name('store');           // Simpan absen
                Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('laporan'); // Laporan absensi
                Route::get('/export/excel', [AbsensiController::class, 'exportExcel'])->name('export.excel');       // Export Excel
                Route::get('/export/laporan', [AbsensiController::class, 'exportLaporan'])->name('export.laporan'); // Export laporan
                Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('edit');   // Edit absensi
                Route::put('/{absensi}', [AbsensiController::class, 'update'])->name('update');    // Update absensi
                Route::delete('/{absensi}', [AbsensiController::class, 'destroy'])->name('destroy'); // Hapus absensi
            });
        });

        /*
        |--------------------------
        | ORANG TUA (Admin) — atur relasi orang tua ↔ anak
        |--------------------------
        */
        Route::middleware('permission:manage siswa')->group(function () {
            Route::prefix('orang-tua')->name('orang_tua.')->group(function () {
                Route::get('/', [AdminOrangTuaController::class, 'index'])->name('index');   // Daftar orang tua
                Route::get('/{orangTua}/edit', [AdminOrangTuaController::class, 'edit'])->name('edit'); // Form atur anak
                Route::put('/{orangTua}', [AdminOrangTuaController::class, 'update'])->name('update'); // Simpan relasi
            });
        });

        /*
        |--------------------------
        | SISTEM (User, Role, Permission, Settings)
        |--------------------------
        */
        Route::middleware('permission:manage users')->group(function () {
            Route::get('users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
            Route::resource('users', UserController::class);         // CRUD Users
        });

        Route::middleware('permission:manage roles')->group(function () {
            Route::resource('roles', RoleController::class);         // CRUD Roles
        });

        Route::middleware('permission:manage permissions')->group(function () {
            Route::resource('permissions', PermissionController::class); // CRUD Permissions
        });

        Route::middleware('permission:manage website')->group(function () {
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('index');  // Lihat settings
                Route::get('/edit', [SettingController::class, 'edit'])->name('edit'); // Form edit
                Route::get('/show', [SettingController::class, 'show'])->name('show');
                Route::put('/', [SettingController::class, 'update'])->name('update'); // Simpan settings
                Route::delete('/', [SettingController::class, 'destroy'])->name('destroy');
            });
        });

        /*
        |--------------------------
        | PROFILE (semua user yang login)
        |--------------------------
        */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    });

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

/*
|==========================================================================
| ORANG TUA (Parent Monitoring Dashboard)
|==========================================================================
| Hanya bisa diakses user dengan role: orang_tua, super_admin, atau admin
*/
Route::middleware(['auth', 'role:orang_tua|super_admin|admin'])->prefix('orang-tua')->name('orangtua.')->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');  // Dashboard utama
    Route::get('/riwayat/{siswa}', [OrangTuaController::class, 'riwayat'])->name('riwayat'); // Riwayat absensi per anak
    Route::get('/realtime/{siswa}', [OrangTuaController::class, 'realtime'])->name('realtime'); // Data real-time
});

/*
|==========================================================================
| PUBLIC PAGES (halaman depan website)
|==========================================================================
*/
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');       // Daftar berita
Route::get('/berita/{berita:slug}', [NewsController::class, 'show'])->name('berita.show'); // Detail berita

Route::get('/profil', function () {                                     // Halaman profil sekolah
    $settings = \App\Models\Setting::pluck('value', 'key');
    return view('public.profil', compact('settings'));
})->name('profil');

Route::get('/prestasi', [PublicPrestasiController::class, 'index'])->name('prestasi');           // Daftar prestasi
Route::get('/prestasi/{prestasi}', [PublicPrestasiController::class, 'show'])->name('prestasi.show'); // Detail prestasi

Route::get('/data-guru', [TeacherController::class, 'index'])->name('guru.index');  // Daftar guru
Route::get('/data-guru/{id}', [TeacherController::class, 'show'])->name('guru.show'); // Detail guru

Route::get('/galeri', [GaleryController::class, 'index'])->name('galeri.index');  // Galeri foto
Route::get('/galeri/{id}', [GaleryController::class, 'show'])->name('galeri.show'); // Detail galeri

Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas'); // Fasilitas sekolah

Route::get('/kontak', [ContactsController::class, 'index'])->name('kontak.index');   // Form kontak
Route::post('/kontak', [ContactsController::class, 'store'])->name('kontak.store');  // Kirim pesan

// Tandai pesan sebagai sudah dibaca (dari notif bell)
Route::patch('/admin/kontak/{kontak}/read', [KontakController::class, 'markAsRead'])
    ->name('admin.kontak.read');
