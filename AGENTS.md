# AGENTS.md — sekolah-app

## What is this

Laravel 12 school management system (CMS + Admin Panel + RFID Attendance + Parent Dashboard).
Bahasa Indonesia throughout the codebase. Timezone: `Asia/Makassar` (WITA).

## Commands

| Action | Command |
|--------|---------|
| Full setup (install + migrate + seed + build) | `composer setup` |
| Dev (serve + queue + logs + Vite concurrently) | `composer dev` |
| Run all tests | `composer test` |
| Run single test file | `php artisan test --filter=tests/Feature/Auth/AuthenticationTest.php` |
| Build frontend only | `npm run build` |
| Link storage for file uploads | `php artisan storage:link` |
| Clear all dummy data (keep super admin) | `php artisan data:clear` |

**No linter or typecheck configured.** There is no PHPStan, Pint script, or ESLint in this repo.

## Testing

- **Framework:** Pest PHP 3
- **Database:** SQLite in-memory (configured in `phpunit.xml`)
- **Always runs `RolePermissionSeeder`** before each test (see `tests/Pest.php:21`)
- Tests use `RefreshDatabase` trait automatically
- Run with `composer test` (clears config cache first)

## Architecture

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

| Area | URL prefix | Middleware | Controllers |
|------|-----------|------------|-------------|
| Public website | `/` | `web` | `App\Http\Controllers\Public\*` |
| Admin panel | `/admin` | `auth` + `permission` | `App\Http\Controllers\Admin\*` |
| Parent dashboard | `/orang-tua` | `auth` + `role:orang_tua\|super_admin\|admin` | `App\Http\Controllers\Public\OrangTuaController` |
| RFID scanner | `/rfid` | `web` (CSRF excluded) | `App\Http\Controllers\Public\RfidController` |
| API v1 | `/api/v1` | `auth:sanctum` | `App\Http\Controllers\Api\*` |

## Auth & Permissions

- **Spatie Laravel Permission v6** — 6 roles, 18 permissions
- Middleware aliases: `role`, `permission`, `role_or_permission` (registered in `bootstrap/app.php`)
- **No public registration.** Users created via admin panel only.
- Default seed users: `admin@sekolah.test` / `password` (super_admin), `operator@sekolah.test` / `password` (operator)

## Key Gotchas

- **RFID endpoint** (`/rfid/scan`): CSRF is excluded, throttle 30 req/min, **API key wajib** via `X-API-Key` header. Config via `config('rfid.api_key')` — NOT `env()` at runtime
- **File uploads** go to `storage/app/public/{berita,guru,settings,banners,galeri,fasilitas,prestasi,avatars}/`. Must run `php artisan storage:link`
- **Session/cache/queue** drivers are all `database` in production (but `phpunit.xml` overrides to `array`/`sync` for tests)
- **Seeder order matters:** `RolePermissionSeeder` → `CreateAdminUserSeeder` → `RoleSeeder` → `KelasSeeder` → `SiswaSeeder` → `OrangTuaSeeder` → `AbsensiSeeder` → `DummyImageSeeder` → `JadwalPelajaranSeeder` → `KalenderAkademikSeeder`
- **View composer** in `AppServiceProvider::boot()` shares `$unreadMessages` count to all `admin.*` views
- Models using soft deletes: `User`, `Guru`, `Berita`, `Fasilitas`, `Galeri`, `Prestasi`
- **`clean_html()`** helper in `app/Helpers/helpers.php` sanitizes berita content (XSS prevention)
- **SecurityHeaders** middleware adds X-Content-Type-Options, X-Frame-Options, HSTS, etc.
- **Rate limiters:** `contact` (5/min per email+IP), `rfid-api` (60/min per IP)
- **`profil_sekolah`** is the settings key used by `/profil` page (not `sejarah`)
- **`hasSection()`** is NOT a global PHP function — must use `$__env->hasSection('hideSidebar')` in a `@php` block at top of layout

## Frontend

- Blade + Alpine.js + Tailwind CSS 3 + Vite 5
- Vite entry points: `resources/css/app.css`, `resources/js/app.js`
- Custom Tailwind `primary` color palette defined in `tailwind.config.js` (CSS variables)
- `<x-theme-colors />` component injects dynamic CSS vars from database settings
- Chart.js included for dashboard charts
- Package manager: **yarn** (`yarn.lock` present), not npm
- Error pages (403, 404, 419, 500) and RFID kiosk page keep CDN Tailwind (not Vite)
- All form inputs have Indonesian placeholders

## Database

- MySQL in production, SQLite in-memory for tests
- 20+ tables. Key unique constraints: `siswas.nis`, `siswas.rfid`, `berita.slug`, `absensis(siswa_id, tanggal)`, `settings.key`
- Index on `absensis.tanggal` for query performance
- Important foreign keys cascade on delete (`config/permission.php` sets `onDelete => cascade`)

## Project Docs

`DOKUMENTASI.md` contains full route map, database schema, controller list, and feature docs. Trust executable code over it if they conflict.
