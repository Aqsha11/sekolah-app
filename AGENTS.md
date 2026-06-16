# AGENTS.md — School Management System

## Quick start

```bash
composer setup              # full install + .env + key + migrate + npm build
composer dev                # concurrent: serve + queue + logs + Vite
composer test               # config:clear then php artisan test (Pest)
npm run build               # Vite production build
```

## Testing

- **Pest PHP 3** with `RefreshDatabase` trait for feature tests
- SQLite in-memory (configured in `phpunit.xml`)
- Test seeders manually in tests via `$this->seed(DatabaseSeeder::class)`

## Auth & authorization

- **Spatie Laravel Permission** v6 — roles & permissions middleware aliased in `bootstrap/app.php`:
  - `'role' => \Spatie\Permission\Middleware\RoleMiddleware::class`
  - `'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class`
- 6 roles: `super_admin`, `admin`, `operator`, `guru`, `editor`, `orang_tua`
- Custom middleware classes exist at `app/Http/Middleware/` (`CheckPermission`, `CheckRole`) but are **not registered** — Spatie's built-in middleware is used instead
- No public registration — users created only via admin panel
- `routes/auth.php` exists but is **not loaded** in `bootstrap/app.php` (only `web.php` + `console.php` are). Auth routes (login/logout) are defined directly in `web.php`

## Architecture

| Area | Routes prefix | Controllers |
|------|--------------|-------------|
| Public website | `/` | `App\Http\Controllers\Public\*` |
| Admin panel | `/admin` | `App\Http\Controllers\Admin\*` |
| Parent dashboard | `/orang-tua` | `App\Http\Controllers\Public\OrangTuaController` (middleware: `role:orang_tua|super_admin|admin`) |
| RFID scanner | `/rfid` | `App\Http\Controllers\Public\RfidController` |

Models in `App\Models`: `Absensi`, `Agenda`, `Alumni`, `Banner`, `Berita`, `Fasilitas`, `Galeri`, `Guru`, `Kelas`, `Kontak`, `OrangTua`, `Prestasi`, `Setting`, `Siswa`, `User`

## Notable config

- `DB_CONNECTION=mysql` default (tests use SQLite in-memory)
- Session, cache, queue all use `database` driver in `.env`
- CSRF disabled for `rfid/scan` endpoint (in `bootstrap/app.php`)
- RFID scanner auth via `RFID_API_KEY` env var
- Image handling via Intervention Image v3, Excel export via OpenSpout v4
- Frontend: Blade + Alpine.js + Tailwind CSS v3 + Chart.js, built with Vite

## Seeders (ordered)

```bash
php artisan db:seed
```
1. `RolePermissionSeeder` — creates all permissions + roles
2. `CreateAdminUserSeeder` — creates admin & operator users
3. `RoleSeeder` — optional extra roles
4. `DummyDataSeeder` — development dummy data
