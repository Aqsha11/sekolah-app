<?php

use Database\Seeders\DummyDataSeeder;

beforeEach(function () {
    $this->seed(DummyDataSeeder::class);
});

it('homepage returns 200', function () {
    $response = $this->get('/');
    $response->assertOk();
});

it('berita index returns 200', function () {
    $response = $this->get(route('berita.index'));
    $response->assertOk();
});

it('berita detail returns 200', function () {
    $berita = \App\Models\Berita::first();
    $response = $this->get(route('berita.show', $berita->slug));
    $response->assertOk();
});

it('guru index returns 200', function () {
    $response = $this->get(route('guru.index'));
    $response->assertOk();
});

it('prestasi index returns 200', function () {
    $response = $this->get(route('prestasi'));
    $response->assertOk();
});

it('galeri index returns 200', function () {
    $response = $this->get(route('galeri.index'));
    $response->assertOk();
});

it('fasilitas index returns 200', function () {
    $response = $this->get(route('fasilitas'));
    $response->assertOk();
});

it('kontak index returns 200', function () {
    $response = $this->get(route('kontak.index'));
    $response->assertOk();
});

it('profil returns 200', function () {
    $response = $this->get(route('profil'));
    $response->assertOk();
});

it('rfid page returns 200', function () {
    $response = $this->get(route('rfid.index'));
    $response->assertOk();
});

it('can submit contact form', function () {
    $response = $this->post(route('kontak.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '081234567890',
        'subject' => 'Test Subject',
        'message' => 'Test message content here.',
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('kontak', ['email' => 'test@example.com']);
});
