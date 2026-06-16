# 📘 School Management System — Dokumentasi Project

> **Sistem Manajemen Sekolah** — CMS website sekolah + Panel Admin + Absensi RFID + Dashboard Orang Tua
> Framework: **Laravel 12** | PHP ^8.2 | MySQL | Tailwind CSS 3 | Alpine.js | Vite

---

## 📋 Daftar Isi

1. [Arsitektur Aplikasi](#1-arsitektur-aplikasi)
2. [Role & Permission](#2-role--permission)
3. [Route Map](#3-route-map)
4. [Database Schema](#4-database-schema)
5. [Struktur Controller](#5-struktur-controller)
6. [Struktur Views](#6-struktur-views)
7. [Fitur Unggulan](#7-fitur-unggulan)
8. [Cara Install & Setup](#8-cara-install--setup)
9. [Testing](#9-testing)
10. [Catatan Teknis](#10-catatan-teknis)

---

## 1. Arsitektur Aplikasi

### Pembagian Area

| Area | Prefix | Middleware | Controller |
|------|--------|-----------|------------|
| **Public Website** | `/` | `web` | `App\Http\Controllers\Public\*` |
| **Admin Panel** | `/admin` | `auth` + `permission` | `App\Http\Controllers\Admin\*` |
| **Dashboard Orang Tua** | `/orang-tua` | `auth` + role check | `App\Http\Controllers\Public\OrangTuaController` |
| **RFID Scanner** | `/rfid` | `web` (CSRF excluded) | `App\Http\Controllers\Public\RfidController` |

### Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Database | MySQL (prod), SQLite (testing) |
| ORM | Eloquent ORM |
| Auth & Role | Spatie Laravel Permission v6 |
| Frontend | Blade, Alpine.js, Tailwind CSS 3, Chart.js |
| Asset Bundler | Vite 5 |
| Image | Intervention Image 3 |
| Export Excel | OpenSpout 4 |
| Testing | Pest PHP 3 |

---

## 2. Role & Permission

### 6 Roles

| Role | Deskripsi | Permissions |
|------|-----------|-------------|
| **super_admin** | Akses penuh ke semua fitur | Semua 18 permission |
| **admin** | Sama seperti super_admin | Semua 18 permission |
| **operator** | Operasional harian | `manage berita`, `manage galeri` |
| **guru** | Guru | `manage berita` |
| **editor** | Kontributor konten | `manage berita` |
| **orang_tua** | Orang tua/wali siswa | Tidak ada permission — akses via role middleware ke parent dashboard |

### 18 Permissions

```
view berita, create berita, edit berita, delete berita, manage berita,
manage users, manage roles, manage permissions,
manage galeri, manage fasilitas, manage website,
manage guru, manage prestasi, manage kontak,
manage banner, manage absensi, manage siswa
```

### Middleware Aliases (registered di `bootstrap/app.php`)

```php
'role'           => \Spatie\Permission\Middleware\RoleMiddleware::class
'permission'     => \Spatie\Permission\Middleware\PermissionMiddleware::class
'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
```

### Default Users (Seeder)

| Email | Password | Role |
|-------|----------|------|
| `admin@sekolah.test` | `password` | super_admin |
| `operator@sekolah.test` | `password` | operator |

> **Tidak ada registrasi publik** — user hanya bisa dibuat melalui panel admin.

---

## 3. Route Map

### Public Website

| Method | URI | Nama Route | Controller |
|--------|-----|------------|------------|
| GET | `/` | `home` | `HomeController@index` |
| GET | `/berita` | `berita.index` | `NewsController@index` |
| GET | `/berita/{slug}` | `berita.show` | `NewsController@show` |
| GET | `/profil` | `profil` | Closure |
| GET | `/prestasi` | `prestasi` | `PrestasiController@index` |
| GET | `/prestasi/{prestasi}` | `prestasi.show` | `PrestasiController@show` |
| GET | `/data-guru` | `guru.index` | `TeacherController@index` |
| GET | `/data-guru/{id}` | `guru.show` | `TeacherController@show` |
| GET | `/galeri` | `galeri.index` | `GaleryController@index` |
| GET | `/galeri/{id}` | `galeri.show` | `GaleryController@show` |
| GET | `/fasilitas` | `fasilitas` | `FacilityController@index` |
| GET | `/kontak` | `kontak.index` | `ContactsController@index` |
| POST | `/kontak` | `kontak.store` | `ContactsController@store` |

### Auth

| Method | URI | Controller |
|--------|-----|------------|
| GET | `/login` | `AuthenticatedSessionController@create` |
| POST | `/login` | `AuthenticatedSessionController@store` |
| POST | `/logout` | `AuthenticatedSessionController@destroy` |
| POST | `/force-logout` | Closure |

### RFID

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/rfid` | Halaman scanner |
| POST | `/rfid/scan` | Endpoint scan (CSRF excluded, throttle 30/menit) |

### Orang Tua Dashboard

| Method | URI | Nama Route |
|--------|-----|------------|
| GET | `/orang-tua/dashboard` | `orangtua.dashboard` |
| GET | `/orang-tua/riwayat/{siswa}` | `orangtua.riwayat` |
| GET | `/orang-tua/realtime/{siswa}` | `orangtua.realtime` |

### Admin Panel

| Area | URI | Permission |
|------|-----|------------|
| Dashboard | `/admin/dashboard` | Semua auth |
| Berita (CRUD) | `/admin/berita` | `manage berita` |
| Guru (CRUD) | `/admin/guru` | `manage guru` |
| Prestasi (CRUD) | `/admin/prestasi` | `manage prestasi` |
| Galeri (CRUD) | `/admin/galeri` | `manage galeri` |
| Fasilitas (CRUD) | `/admin/fasilitas` | `manage fasilitas` |
| Kontak (CRUD) | `/admin/kontak` | `manage kontak` |
| Banner (CRUD) | `/admin/banner` | `manage banner` |
| Siswa (CRUD) | `/admin/siswa` | `manage siswa` |
| Absensi (CRUD) | `/admin/absensi` | `manage absensi` |
| Users (CRUD) | `/admin/users` | `manage users` |
| Roles | `/admin/roles` | `manage roles` |
| Permissions | `/admin/permissions` | `manage permissions` |
| Settings | `/admin/settings` | `manage website` |
| Orang Tua | `/admin/orang-tua` | `manage siswa` |
| Profile | `/admin/profile` | Semua auth |

---

## 4. Database Schema

### 15 Tables

| Tabel | Key Columns | Relasi |
|-------|-------------|--------|
| **users** | id, name, email, password, phone, avatar, is_active | — |
| **siswas** | id, nama, nis (unique), kelas, jurusan, rfid (unique) | → absensis, ↔ orang_tua |
| **gurus** | id, name, nip (unique), subject, position, email, phone, photo, bio, is_active | — |
| **berita** | id, title, slug (unique), content, category, date, image, user_id, is_published, views | → users |
| **prestasis** | id, title, category, level, year, description, image | — |
| **galeris** | id, title, description, image, category | — |
| **fasilitas** | id, name, description, image, status (active/inactive) | — |
| **kelas** | id, nama_kelas | — |
| **alumnis** | id, nama, tahun_lulus, pekerjaan | — |
| **agendas** | id, judul, tanggal, deskripsi | — |
| **kontak** | id, name, email, phone, subject, message, status, reply_message, replied_by | → users |
| **settings** | id, key (unique), value | — |
| **banners** | id, title, subtitle, image, link, order, is_active | — |
| **absensis** | id, siswa_id, rfid, check_in, check_out, status, tanggal | → siswas |
| **orang_tua** | id, nama, email (unique), phone | ↔ siswas (pivot) |
| **orang_tua_siswa** | orang_tua_id, siswa_id | Pivot table |

### Constraints Penting

- **absensis**: unique(siswa_id, tanggal) — 1 record per siswa per hari
- **siswas**: unique(nis), unique(rfid)
- **berita**: unique(slug)
- **settings**: unique(key)

### Soft Deletes

Model yang menggunakan `SoftDeletes`: `users`, `gurus`, `berita`, `fasilitas`, `galeris`, `prestasis`

---

## 5. Struktur Controller

### Admin Controllers (16)

| Controller | Fungsi Utama |
|-----------|-------------|
| `DashboardController` | Statistik dashboard (chart) |
| `AbsensiController` | CRUD absensi, rekap, export Excel, laporan per periode |
| `BannerController` | CRUD banner hero |
| `BeritaController` | CRUD berita dengan upload gambar |
| `FasilitasController` | CRUD fasilitas |
| `GaleriController` | CRUD galeri |
| `GuruController` | CRUD guru dengan upload photo |
| `KontakController` | Kelola pesan masuk, reply, mark read |
| `OrangTuaController` | Kelola relasi orang tua-siswa |
| `PermissionController` | CRUD permissions |
| `PrestasiController` | CRUD prestasi |
| `ProfileController` | Edit profile, avatar, ganti password |
| `RoleController` | CRUD roles |
| `SettingController` | CRUD settings website |
| `SiswaController` | CRUD siswa, export Excel |
| `UserController` | CRUD users, filter, export Excel |

### Public Controllers (9)

| Controller | Fungsi |
|-----------|--------|
| `HomeController` | Halaman depan website |
| `NewsController` | Daftar & detail berita |
| `TeacherController` | Daftar & detail guru |
| `GaleryController` | Galeri foto |
| `FacilityController` | Fasilitas sekolah |
| `ContactsController` | Form kontak |
| `PrestasiController` | Prestasi sekolah |
| `OrangTuaController` | Dashboard & riwayat absensi anak |
| `RfidController` | Halaman & endpoint scan RFID |

---

## 6. Struktur Views

```
resources/views/
├── public/                     # Halaman publik website sekolah
│   ├── layouts.blade.php
│   ├── home.blade.php
│   ├── profil.blade.php
│   ├── news.blade.php
│   ├── news_detail.blade.php
│   ├── prestasi.blade.php
│   ├── prestasi-show.blade.php
│   ├── guru/index.blade.php
│   ├── guru/show.blade.php
│   ├── galeri.blade.php
│   ├── fasilitas.blade.php
│   └── kontak.blade.php
├── admin/                      # Panel admin
│   ├── layouts/               # app, guest, navigation, sidebar
│   ├── components/            # 15 blade components
│   ├── auth/                  # Login, register, forgot/reset password
│   ├── dashboard/index.blade.php
│   ├── berita/                # create, edit, index, show
│   ├── guru/                  # create, edit, index, show
│   ├── prestasi/              # create, edit, index, show
│   ├── galeri/                # create, edit, index, show
│   ├── fasilitas/             # create, edit, index, show
│   ├── kontak/                # index, show
│   ├── banner/                # create, edit, index
│   ├── siswa/                 # create, edit, index
│   ├── absensi/               # create, edit, index, laporan
│   ├── users/                 # create, edit, index, show
│   ├── roles/                 # create, edit, index, show
│   ├── permissions/           # create, edit, index, show
│   ├── settings/              # create, edit, index, show
│   ├── orang_tua/             # edit, index
│   └── profile/               # edit, partials
├── orang_tua/                  # Dashboard orang tua
│   ├── dashboard.blade.php
│   └── riwayat.blade.php
├── rfid/                       # Halaman scanner RFID
│   └── index.blade.php
└── errors/                     # Custom error pages
    └── 403.blade.php
```

---

## 7. Fitur Unggulan

### 7.1 Sistem Absensi RFID

- **Scan RFID**: Siswa scan kartu RFID untuk check-in/check-out
- **Jam Operasional**: 06:00 - 16:00 WITA
- **Batas Terlambat**: > 07:15 WITA = status `terlambat`
- **Flow**: Scan pertama → check-in, Scan kedua (hari sama) → check-out
- **Status**: hadir, terlambat, izin, sakit, alpha
- **Duplicate Prevention**: Unique constraint siswa_id + tanggal
- **Auth**: API Key via header `X-API-Key` atau parameter `api_key`

### 7.2 Dashboard Orang Tua

- Orang tua bisa memantau absensi anak secara real-time
- Riwayat absensi per bulan
- Endpoint JSON realtime
- Relasi many-to-many (1 orang tua bisa punya banyak anak)

### 7.3 Export Excel

Menggunakan OpenSpout v4, tersedia export:
- Daftar Siswa → `/admin/siswa/export/excel`
- Absensi Harian → `/admin/absensi/export/excel`
- Laporan Absensi (per periode) → `/admin/absensi/export/laporan`
- Data Users → `/admin/users/export/excel`

### 7.4 CMS Website

Halaman publik lengkap: berita (dengan slug), profil sekolah, guru, prestasi, galeri foto, fasilitas, kontak form.

---

## 8. Cara Install & Setup

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & npm/yarn
- MySQL

### Langkah

```bash
# 1. Clone project
git clone <repo-url> sekolah-app
cd sekolah-app

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
# - Edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD
# - Atur RFID_API_KEY

# 4. Generate key & migrate
php artisan key:generate
php artisan migrate --seed

# 5. Build frontend
npm run build

# 6. Jalankan
php artisan serve
```

### Atau via Composer Script

```bash
composer setup       # full install + .env + key + migrate + seed + npm build
composer dev         # serve + queue + logs + Vite (concurrent)
```

---

## 9. Testing

```bash
composer test
# atau: php artisan config:clear && php artisan test
```

| Detail | Value |
|--------|-------|
| Framework | Pest PHP 3 |
| Database | SQLite in-memory (via phpunit.xml) |
| Trait | `RefreshDatabase` |
| Tests | 6 Feature test files, 1 Unit test |

### Test Files

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── PasswordUpdateTest.php
│   │   └── RegistrationTest.php
│   ├── ExampleTest.php
│   └── ProfileTest.php
├── Unit/
│   └── ExampleTest.php
├── Pest.php
└── TestCase.php
```

---

## 10. Catatan Teknis

### Konfigurasi Kunci

| Config | Value |
|--------|-------|
| Timezone | `Asia/Makassar` (WITA) |
| Session Driver | `database` (60 menit, expire on close, encrypt, same_site=strict) |
| Cache Driver | `database` |
| Queue Driver | `database` |
| DB Default | MySQL (SQLite fallback) |

### Alur Boot App (`bootstrap/app.php`)

```php
// Middleware
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
    // CSRF excluded for RFID
    $middleware->validateCsrfTokens(except: ['rfid/scan']);
})

// Exceptions
->withExceptions(function (Exceptions $exceptions) {
    // UnauthorizedException -> 403 view or JSON
})
```

### Sharing Data ke Semua View Admin

Di `AppServiceProvider::boot()`:

```php
View::composer('admin.*', function ($view) {
    $view->with('unreadMessages', Kontak::where('status', 'unread')->count());
});
```

### Keamanan

- Session: encrypt + same_site strict + expire on close
- RFID endpoint: throttle 30 requests/menit, API Key auth
- No public registration
- CSRF disabled only for `rfid/scan`
- Soft deletes pada model penting

### Seeder Order

```
1. RolePermissionSeeder   — 18 permissions + 6 roles
2. CreateAdminUserSeeder  — admin & operator users
3. RoleSeeder             — re-create roles
4. DummyDataSeeder        — dummy data development (72 siswa, 12 guru, dll)
```

### File Upload

Images disimpan di `storage/app/public/` dengan subdirektori:
- `berita/`
- `guru/`
- `settings/`
- `banners/`

Wajib jalankan: `php artisan storage:link`

---

## Struktur Direktori Lengkap

```
sekolah-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # 16 controller
│   │   │   ├── Auth/           # 9 controller (Breeze)
│   │   │   ├── Public/         # 9 controller
│   │   │   └── Controller.php
│   │   ├── Middleware/         # CheckPermission, CheckRole (unused)
│   │   └── Requests/          # 6 Form Request
│   ├── Models/                 # 15 model
│   ├── Providers/              # AppServiceProvider
│   └── View/Components/       # AppLayout, GuestLayout
├── bootstrap/                  # app.php, providers.php
├── config/                     # 12 file konfigurasi
├── database/
│   ├── factories/              # UserFactory
│   ├── migrations/             # 23 migration
│   └── seeders/                # 5 seeder
├── public/
├── resources/views/            # Lihat section 6
├── routes/
│   ├── web.php                 # Semua routes
│   ├── auth.php                # Tidak dipakai
│   └── console.php
├── tests/                      # Pest tests
├── composer.json
├── package.json
└── vite.config.js
```

---

> **Dibuat:** Juni 2026  
> **Laravel Version:** 12.x  
> **Terakhir diperbarui:** 16 Juni 2026
