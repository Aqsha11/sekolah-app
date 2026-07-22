<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\CreateAdminUserSeeder;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
    $this->seed(CreateAdminUserSeeder::class);

    $this->admin = User::where('email', 'admin@sekolah.test')->first();
    $this->admin->givePermissionTo(Permission::all());
});

it('can access admin dashboard', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $response->assertOk();
});

it('can access berita index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.berita.index'));
    $response->assertOk();
});

it('can access guru index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.guru.index'));
    $response->assertOk();
});

it('can access prestasi index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.prestasi.index'));
    $response->assertOk();
});

it('can access galeri index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.galeri.index'));
    $response->assertOk();
});

it('can access fasilitas index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.fasilitas.index'));
    $response->assertOk();
});

it('can access kontak index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.kontak.index'));
    $response->assertOk();
});

it('can access banner index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.banner.index'));
    $response->assertOk();
});

it('can access siswa index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.siswa.index'));
    $response->assertOk();
});

it('can access users index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
    $response->assertOk();
});

it('can access roles index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.roles.index'));
    $response->assertOk();
});

it('can access permissions index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.permissions.index'));
    $response->assertOk();
});

it('can access settings index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));
    $response->assertOk();
});

it('can access kelas index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.kelas.index'));
    $response->assertOk();
});

it('can access agenda index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.agenda.index'));
    $response->assertOk();
});

it('can access alumni index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.alumni.index'));
    $response->assertOk();
});

it('can create kelas', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.kelas.store'), [
        'nama_kelas' => 'X-Test',
    ]);
    $response->assertRedirect(route('admin.kelas.index'));
    $this->assertDatabaseHas('kelas', ['nama_kelas' => 'X-Test']);
});

it('can create agenda', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.agenda.store'), [
        'judul' => 'Test Agenda',
        'tanggal' => '2026-12-01',
    ]);
    $response->assertRedirect(route('admin.agenda.index'));
    $this->assertDatabaseHas('agendas', ['judul' => 'Test Agenda']);
});

it('can create alumni', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.alumni.store'), [
        'nama' => 'Test Alumni',
        'tahun_lulus' => '2025',
    ]);
    $response->assertRedirect(route('admin.alumni.index'));
    $this->assertDatabaseHas('alumnis', ['nama' => 'Test Alumni']);
});

it('redirects to login when not authenticated', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('login'));
});

it('returns 403 for unauthorized user', function () {
    $user = User::factory()->create();
    $user->assignRole('orang_tua');

    $response = $this->actingAs($user)->get(route('admin.berita.index'));
    $response->assertStatus(403);
});
