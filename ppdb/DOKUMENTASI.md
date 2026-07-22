# School Management System — Dokumentasi Project

> **Sistem Manajemen Sekolah** — CMS website sekolah + Panel Admin + Absensi RFID + Dashboard Orang Tua
> Framework: **Laravel 12** | PHP ^8.2 | MySQL | Tailwind CSS 3 | Alpine.js | Vite

---

## Daftar Isi

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
11. [Keamanan](#11-keamanan)
12. [Perintah Penting](#12-perintah-penting)

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
| Package Manager | yarn |

### Route Files

Routes dipecah ke beberapa file, dimuat via `bootstrap/app.php`:

```
routes/
├── web.php          # Auth (login/logout/force-logout)
├── admin.php        # Semua admin routes
├── public.php       # Halaman publik website
├── orangtua.php     # Dashboard orang tua
├── rfid.php         # Scanner RFID
└── api.php          # API v1 (Sanctum auth)
```

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
manage banner, manage absensi, manage siswa,
manage kelas, manage agenda, manage alumni,
manage kalender, manage jadwal, manage laporan
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

| Method | URI | Middleware | Controller |
|--------|-----|------------|------------|
| GET | `/login` | `guest` | `AuthenticatedSessionController@create` |
| POST | `/login` | `guest` | `AuthenticatedSessionController@store` |
| POST | `/logout` | `auth` | `AuthenticatedSessionController@destroy` |
| GET | `/force-logout` | `auth` | Closure |

### RFID

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/rfid` | Halaman scanner |
| POST | `/rfid/scan` | Endpoint scan (CSRF excluded, throttle 30/menit, API key wajib) |

### Orang Tua Dashboard

| Method | URI | Nama Route |
|--------|-----|------------|
| GET | `/orang-tua/dashboard` | `orangtua.dashboard` |
| GET | `/orang-tua/riwayat` | `orangtua.riwayat` |
| GET | `/orang-tua/realtime-all` | `orangtua.realtimeAll` |
| GET | `/orang-tua/jadwal` | `orangtua.jadwal` |
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
| Absensi | `/admin/absensi` | `manage absensi` |
| Kelas (CRUD) | `/admin/kelas` | `manage kelas` |
| Agenda (CRUD) | `/admin/agenda` | `manage agenda` |
| Alumni (CRUD) | `/admin/alumni` | `manage alumni` |
| Kalender (CRUD) | `/admin/kalender` | `manage kalender` |
| Jadwal (CRUD) | `/admin/jadwal` | `manage jadwal` |
| Laporan | `/admin/laporan` | `manage laporan` |
| Users (CRUD) | `/admin/users` | `manage users` |
| Roles | `/admin/roles` | `manage roles` |
| Permissions | `/admin/permissions` | `manage permissions` |
| Settings | `/admin/settings` | `manage website` |
| Orang Tua | `/admin/orang-tua` | `manage siswa` |
| Profile | `/admin/profile` | Semua auth |
| Jadwal Saya | `/admin/jadwal-saya` | `role:guru\|super_admin\|admin` |

### API v1

| Method | URI | Auth | Keterangan |
|--------|-----|------|------------|
| POST | `/api/v1/auth/login` | Public | Login, return Sanctum token |
| POST | `/api/v1/auth/logout` | `auth:sanctum` | Logout |
| GET | `/api/v1/profil` | `auth:sanctum` | Data profil |
| GET | `/api/v1/absensi` | `auth:sanctum` | Data absensi anak |
| GET | `/api/v1/absensi/{siswa}` | `auth:sanctum` | Absensi per siswa |
| GET | `/api/v1/jadwal` | `auth:sanctum` | Jadwal pelajaran |
| GET | `/api/v1/kalender` | `auth:sanctum` | Kalender akademik |
| GET | `/api/v1/siswa` | `auth:sanctum` | Data siswa |
| POST | `/api/v1/rfid/scan` | API Key | Scan RFID |

---

## 4. Database Schema

### 20+ Tables

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
| **jadwal_pelajarans** | id, kelas, hari, jam_mulai, jam_selesai, mata_pelajaran, guru, ruangan, warna | — |
| **kalender_akademiks** | id, judul, deskripsi, tanggal_mulai, tanggal_selesai, tipe, warna, dot_color | — |

### Constraints Penting

- **absensis**: unique(siswa_id, tanggal) — 1 record per siswa per hari + index on tanggal
- **siswas**: unique(nis), unique(rfid)
- **berita**: unique(slug)
- **settings**: unique(key)

### Soft Deletes

Model yang menggunakan `SoftDeletes`: `users`, `gurus`, `berita`, `fasilitas`, `galeris`, `prestasis`

---

## 5. Struktur Controller

### Admin Controllers (20+)

| Controller | Fungsi Utama |
|-----------|-------------|
| `DashboardController` | Statistik dashboard (chart) |
| `AbsensiController` | CRUD absensi, rekap, export Excel, laporan per periode |
| `AgendaController` | CRUD agenda sekolah |
| `AlumniController` | CRUD alumni |
| `BannerController` | CRUD banner hero |
| `BeritaController` | CRUD berita dengan upload gambar |
| `FasilitasController` | CRUD fasilitas |
| `GaleriController` | CRUD galeri |
| `GuruController` | CRUD guru dengan upload photo |
| `JadwalPelajaranController` | CRUD jadwal pelajaran |
| `KalenderAkademikController` | CRUD kalender akademik |
| `KelasController` | CRUD kelas |
| `KontakController` | Kelola pesan masuk, reply, mark read |
| `LaporanController` | Laporan & rekap absensi |
| `OrangTuaController` | Kelola relasi orang tua-siswa |
| `PermissionController` | CRUD permissions |
| `PrestasiController` | CRUD prestasi |
| `ProfileController` | Edit profile, avatar, ganti password |
| `RoleController` | CRUD roles |
| `SettingController` | CRUD settings website |
| `SiswaController` | CRUD siswa, export Excel |
| `UserController` | CRUD users, filter, export Excel |

### Public Controllers (10)

| Controller | Fungsi |
|-----------|--------|
| `HomeController` | Halaman depan website |
| `NewsController` | Daftar & detail berita |
| `TeacherController` | Daftar & detail guru |
| `GaleryController` | Galeri foto |
| `FacilityController` | Fasilitas sekolah |
| `ContactsController` | Form kontak |
| `PrestasiController` | Prestasi sekolah |
| `OrangTuaController` | Dashboard, riwayat, jadwal anak |
| `RfidController` | Halaman & endpoint scan RFID |
| `JadwalController` | Jadwal pelajaran (guru & orang tua) |

### API Controllers (6)

| Controller | Fungsi |
|-----------|--------|
| `AuthController` | Login & logout (Sanctum) |
| `AbsensiApiController` | Data absensi |
| `SiswaApiController` | Data siswa |
| `JadwalApiController` | Jadwal pelajaran |
| `KalenderApiController` | Kalender akademik |
| `RfidApiController` | Scan RFID via API |
| `ProfilApiController` | Data profil |

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
│   ├── kontak.blade.php
│   └── jadwal-orang-tua.blade.php
├── admin/                      # Panel admin
│   ├── layouts/               # app, guest, navigation, sidebar
│   ├── components/            # Blade components
│   ├── auth/                  # Login
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
│   ├── kelas/                 # create, edit, index
│   ├── agenda/                # create, edit, index
│   ├── alumni/                # create, edit, index
│   ├── kalender/              # create, edit, index
│   ├── jadwal/                # create, edit, index
│   ├── laporan/               # index, absensi
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
├── components/                 # Shared components
│   └── theme-colors.blade.php
└── errors/                     # Custom error pages
    ├── 403.blade.php
    ├── 404.blade.php
    ├── 419.blade.php
    └── 500.blade.php
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
- **Auth**: API Key **wajib** via header `X-API-Key` atau parameter `api_key`
- **Realtime**: Event `AbsensiUpdated` di-broadcast via Pusher (log driver)
- **Throttle**: 30 requests/menit (web), 60 requests/menit (API)

### 7.2 Dashboard Orang Tua

- 3 tab: **Kehadiran** (realtime), **Jadwal**, **Kalender**
- Statistik absensi: total, hadir, terlambat, izin, sakit, alpha
- Persentase kehadiran dengan progress bar
- Riwayat absensi per bulan dengan filter
- Jadwal pelajaran hari ini (highlight hari aktif)
- Kalender akademik
- **Polling real-time** setiap 3 detik via `GET /orang-tua/realtime-all`
- Relasi many-to-many (1 orang tua bisa punya banyak anak)

### 7.3 Dynamic Color System

Warna website dikontrol dari admin settings (`primary_color`):

- `tailwind.config.js` → CSS variables via `primary` palette
- `<x-theme-colors />` → inject CSS variables dari database
- Semua komponen otomatis mengikuti warna yang dipilih

### 7.4 Export Excel

Menggunakan OpenSpout v4, tersedia export:
- Daftar Siswa → `/admin/siswa/export/excel`
- Absensi Harian → `/admin/absensi/export/excel`
- Laporan Absensi (per periode) → `/admin/laporan/export/absensi/excel`
- Data Users → `/admin/users/export/excel`

### 7.5 Export PDF

Menggunakan DomPDF:
- Laporan Absensi PDF → `/admin/laporan/export/absensi/pdf`

### 7.6 CMS Website

Halaman publik lengkap dengan desain profesional:
- Berita (dengan slug, kategori, related news)
- Profil sekolah (Alpine.js tabs: Profil Sekolah / Visi & Misi)
- Guru (daftar & detail dengan bio)
- Prestasi (daftar & detail)
- Galeri foto (dengan lightbox)
- Fasilitas
- Kontak form

### 7.7 Settings Website

Admin bisa mengatur:
- Nama sekolah, nama website, tagline
- Profil sekolah, visi, misi
- Sambutan kepala sekolah
- Email, telepon, alamat
- Jam operasional
- Akreditasi (A/B/C/D)
- Hero image, logo
- Warna tema (primary color)
- Banner carousel
- Social media links

---

## 8. Cara Install & Setup

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & yarn
- MySQL

### Langkah

```bash
# 1. Clone project
git clone <repo-url> sekolah-app
cd sekolah-app

# 2. Install dependencies
composer install
yarn install

# 3. Setup environment
cp .env.example .env
# Edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD, RFID_API_KEY, APP_URL

# 4. Generate key & migrate
php artisan key:generate
php artisan migrate --seed

# 5. Link storage
php artisan storage:link

# 6. Build frontend
yarn build

# 7. Jalankan
php artisan serve
```

### Atau via Composer Script

```bash
composer setup       # full install + .env + key + migrate + seed + yarn build
composer dev         # serve + queue + logs + Vite (concurrent)
```

### Deployment Production

```bash
# 1. Set APP_KEY dan RFID_API_KEY di .env
php artisan key:generate

# 2. Jalankan migrasi
php artisan migrate --force

# 3. Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Link storage
php artisan storage:link

# 5. Build frontend
yarn build

# 6. Jalankan queue worker
php artisan queue:work
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
| Tests | 43 tests, 69 assertions |

### Test Files

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── AuthenticationTest.php
│   │   ├── PasswordUpdateTest.php
│   ├── AdminPageTest.php       # 21 tests (CRUD access)
│   ├── ExampleTest.php
│   ├── ProfileTest.php
│   └── PublicPageTest.php      # 11 tests (all public pages)
├── Unit/
│   └── ExampleTest.php
├── Pest.php                    # Global setup (RolePermissionSeeder)
└── TestCase.php
```

---

## 10. Catatan Teknis

### Konfigurasi Kunci

| Config | Value |
|--------|-------|
| Timezone | `Asia/Makassar` (WITA) |
| Session Driver | `database` (120 menit, encrypt, secure cookie, same_site=lax) |
| Cache Driver | `database` |
| Queue Driver | `database` |
| Broadcast Driver | `log` ( Pusher ready) |
| DB Default | MySQL (SQLite fallback) |

### Alur Boot App (`bootstrap/app.php`)

```php
->withRouting(
    web: routes/web.php,
    api: routes/api.php,
    then: function () {
        Route::middleware('web')->group('routes/public.php');
        Route::middleware('web')->group('routes/admin.php');
        Route::middleware('web')->group('routes/orangtua.php');
        Route::middleware('web')->group('routes/rfid.php');
    },
)

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([...]);           // Spatie role/permission
    $middleware->append(SecurityHeaders::class);  // Security headers
    $middleware->validateCsrfTokens(except: ['rfid/scan']);
    $middleware->trustHosts(at: ['localhost', '127.0.0.1', '::1']);
})
```

### Sharing Data ke Semua View Admin

Di `AppServiceProvider::boot()`:

```php
View::composer('admin.*', function ($view) {
    $view->with('unreadMessages', Kontak::where('status', 'unread')->count());
});
```

### RFID Configuration

API key disimpan di `config/rfid.php` (env: `RFID_API_KEY`).
Controller menggunakan `config('rfid.api_key')` — bukan `env()` langsung.

### HTML Sanitization

Konten berita menggunakan `clean_html()` helper untuk mencegah XSS:
- Strips `<script>`, event handlers, `javascript:` URIs
- Memb safe tags: h1-h6, p, br, strong, em, a, img, table, dll

### Seeder Order

```
1. RolePermissionSeeder   — permissions + roles
2. CreateAdminUserSeeder  — admin & operator users
3. RoleSeeder             — re-create roles
4. KelasSeeder            — 9 kelas
5. SiswaSeeder            — 72 siswa
6. OrangTuaSeeder         — 5 orang tua + relasi
7. AbsensiSeeder          — 1440 records absensi
8. DummyImageSeeder       — guru, prestasi, berita, galeri, fasilitas
9. JadwalPelajaranSeeder  — 324 jadwal (9 kelas)
10. KalenderAkademikSeeder — 15 event
```

### File Upload

Images disimpan di `storage/app/public/` dengan subdirektori:
- `berita/`
- `guru/`
- `settings/`
- `banners/`
- `galeri/`
- `fasilitas/`
- `prestasi/`
- `avatars/`

Wajib jalankan: `php artisan storage:link`

---

## 11. Keamanan

### Security Headers (Middleware)

Middleware `SecurityHeaders` ditambahkan ke semua request:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`
- `Strict-Transport-Security` (HTTPS only)

### Rate Limiting

| Endpoint | Limit | Key |
|----------|-------|-----|
| Login | 5/menit | IP + email |
| RFID scan (web) | 30/menit | IP |
| RFID scan (API) | 60/menit | IP |
| Form kontak | 5/menit | email + IP |

### Authentication

- Session-based auth (web) + Sanctum tokens (API)
- `SESSION_ENCRYPT=true`, `SESSION_SECURE_COOKIE=true`
- `SESSION_SAME_SITE=lax`
- No public registration

### RFID Security

- API key **wajib** untuk semua scan request
- Config via `config/rfid.php` (bukan `env()` runtime)
- CSRF excluded untuk `/rfid/scan`

### XSS Prevention

- Blade auto-escaping (`{{ }}`)
- `clean_html()` helper untuk konten berita (`{!! !!}`)
- Strips script tags, event handlers, javascript: URIs

### Production Defaults (`.env.example`)

```
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=warning
SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

---

## 12. Perintah Penting

| Aksi | Perintah |
|------|----------|
| Full setup | `composer setup` |
| Dev server | `composer dev` |
| Run tests | `composer test` |
| Build frontend | `yarn build` |
| Link storage | `php artisan storage:link` |
| Clear dummy data | `php artisan data:clear` |
| Clear dummy data (skip konfirmasi) | `php artisan data:clear --force` |
| Cache config | `php artisan config:cache` |
| Cache routes | `php artisan route:cache` |
| Cache views | `php artisan view:cache` |
| Fresh migrate + seed | `php artisan migrate:fresh --seed` |

---

> **Dibuat:** Juni 2026
> **Laravel Version:** 12.x
> **Terakhir diperbarui:** 18 Juli 2026
