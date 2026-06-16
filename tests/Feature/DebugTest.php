<?php

use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

it('checks role exists', function () {
    // Verify role exists
    $role = Role::where('name', 'orang_tua')->first();
    expect($role)->not->toBeNull();

    // Try findByName
    $role = Role::findByName('orang_tua');
    expect($role->name)->toBe('orang_tua');
});

it('checks guest access', function () {
    $response = $this->get(route('login'));
    $response->assertOk();
});
