<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Admin\KalenderAkademikController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Public\JadwalController;

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

        Route::prefix('admin')
            ->middleware(['auth'])
            ->name('admin.')
            ->group(function () {

                Route::get('/tentang', [App\Http\Controllers\Admin\TentangController::class, 'index'])
                    ->name('tentang.index');

                Route::put('/tentang', [App\Http\Controllers\Admin\TentangController::class, 'update'])
                    ->name('tentang.update');
            });

        /*
        |--------------------------
        | CONTENT MANAGEMENT — dibatasi permission masing-masing
        |--------------------------
        */
        Route::middleware('permission:manage berita')->group(function () {
            Route::resource('berita', BeritaController::class);
        });

        Route::middleware('permission:manage guru')->group(function () {
            Route::resource('guru', GuruController::class);
        });

        Route::middleware('permission:manage prestasi')->group(function () {
            Route::resource('prestasi', PrestasiController::class);
        });

        Route::middleware('permission:manage galeri')->group(function () {
            Route::resource('galeri', GaleriController::class);
        });

        Route::middleware('permission:manage fasilitas')->group(function () {
            Route::resource('fasilitas', FasilitasController::class);
        });

        Route::middleware('permission:manage kontak')->group(function () {
            Route::resource('kontak', KontakController::class);
            Route::post('/kontak/{kontak}/reply', [KontakController::class, 'reply'])
                ->name('kontak.reply');
        });

        Route::middleware('permission:manage banner')->group(function () {
            Route::resource('banner', BannerController::class);
        });

        Route::middleware('permission:manage kelas')->group(function () {
            Route::resource('kelas', KelasController::class);
        });

        Route::middleware('permission:manage agenda')->group(function () {
            Route::resource('agenda', AgendaController::class);
        });

        Route::middleware('permission:manage alumni')->group(function () {
            Route::resource('alumni', AlumniController::class);
        });

        /*
        |--------------------------
        | KALENDER AKADEMIK
        |--------------------------
        */
        Route::middleware('permission:manage kalender')->group(function () {
            Route::resource('kalender', KalenderAkademikController::class);
        });

        /*
        |--------------------------
        | JADWAL PELAJARAN
        |--------------------------
        */
        Route::middleware('permission:manage jadwal')->group(function () {
            Route::resource('jadwal', JadwalPelajaranController::class);
        });

        /*
        |--------------------------
        | LAPORAN & REKAP
        |--------------------------
        */
        Route::middleware('permission:manage laporan')->group(function () {
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [LaporanController::class, 'index'])->name('index');
                Route::get('/absensi', [LaporanController::class, 'absensi'])->name('absensi');
                Route::get('/export/absensi/excel', [LaporanController::class, 'exportAbsensiExcel'])->name('export.absensi.excel');
                Route::get('/export/absensi/pdf', [LaporanController::class, 'exportAbsensiPdf'])->name('export.absensi.pdf');
                Route::get('/download/{filename}', [LaporanController::class, 'downloadExport'])->name('download');
            });
        });

        /*
        |--------------------------
        | SISWA & ABSENSI
        |--------------------------
        */
        Route::middleware('permission:manage siswa')->group(function () {
            Route::get('siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export.excel');
            Route::resource('siswa', SiswaController::class);
        });

        Route::middleware('permission:manage absensi')->group(function () {
            Route::prefix('absensi')->name('absensi.')->group(function () {
                Route::get('/', [AbsensiController::class, 'index'])->name('index');
                Route::get('/create', [AbsensiController::class, 'create'])->name('create');
                Route::post('/', [AbsensiController::class, 'store'])->name('store');
                Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('laporan');
                Route::get('/export/excel', [AbsensiController::class, 'exportExcel'])->name('export.excel');
                Route::get('/export/laporan', [AbsensiController::class, 'exportLaporan'])->name('export.laporan');
                Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('edit');
                Route::put('/{absensi}', [AbsensiController::class, 'update'])->name('update');
                Route::delete('/{absensi}', [AbsensiController::class, 'destroy'])->name('destroy');
            });
        });

        /*
        |--------------------------
        | ORANG TUA (Admin) — atur relasi orang tua ↔ anak
        |--------------------------
        */
        Route::middleware('permission:manage siswa')->group(function () {

            Route::prefix('orang-tua')->name('orang_tua.')->group(function () {

                Route::get('/', [AdminOrangTuaController::class, 'index'])
                    ->name('index');

                Route::get('/create', [AdminOrangTuaController::class, 'create'])
                    ->name('create');

                Route::post('/', [AdminOrangTuaController::class, 'store'])
                    ->name('store');

                Route::get('/{orangTua}/edit', [AdminOrangTuaController::class, 'edit'])
                    ->name('edit');

                Route::put('/{orangTua}', [AdminOrangTuaController::class, 'update'])
                    ->name('update');
            });
        });
        /*
        |--------------------------
        | SISTEM (User, Role, Permission, Settings)
        |--------------------------
        */
        Route::middleware('permission:manage users')->group(function () {
            Route::get('users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
            Route::resource('users', UserController::class);
        });

        Route::middleware('permission:manage roles')->group(function () {
            Route::resource('roles', RoleController::class);
        });

        Route::middleware('permission:manage permissions')->group(function () {
            Route::resource('permissions', PermissionController::class);
        });

        Route::middleware('permission:manage website')->group(function () {
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('index');
                Route::get('/edit', [SettingController::class, 'edit'])->name('edit');
                Route::get('/show', [SettingController::class, 'show'])->name('show');
                Route::put('/', [SettingController::class, 'update'])->name('update');
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

        // Guru: lihat jadwal mengajar sendiri
        Route::middleware('role:guru|super_admin|admin')->get('/jadwal-saya', [JadwalController::class, 'guru'])
            ->name('jadwal-saya');

        // Tandai pesan sebagai sudah dibaca (dari notif bell)
        Route::patch('/kontak/{kontak}/read', [KontakController::class, 'markAsRead'])
            ->name('kontak.read');
    });
