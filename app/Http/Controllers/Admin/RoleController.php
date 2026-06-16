<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Middleware permission (dikomen sementara)
     */
    public function __construct()
    {
        // $this->middleware('permission:manage roles');
    }

    /**
     * Daftar semua role berikut permission-nya
     */
    public function index(): View
    {
        $roles = Role::with('permissions')->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Form tambah role baru
     */
    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Simpan role baru beserta permission-nya
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil dibuat');
    }

    /**
     * Form edit role
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update role dan sinkronisasi permission
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    /**
     * Detail role
     */
    public function show(Role $role): View
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Hapus role (kecuali role sistem)
     */
    public function destroy(Role $role): RedirectResponse
    {
        if (in_array($role->name, ['super_admin', 'admin'])) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Tidak dapat menghapus role sistem');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
