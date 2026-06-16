<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    /**
     * Daftar semua permission
     */
    public function index(): View
    {
        $permissions = Permission::paginate(20);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Form tambah permission
     */
    public function create(): View
    {
        return view('admin.permissions.create');
    }

    /**
     * Simpan permission baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions',
        ]);

        Permission::create(['name' => $validated['name']]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission berhasil dibuat');
    }

    /**
     * Form edit permission
     */
    public function edit(Permission $permission): View
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update permission
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $validated['name']]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission berhasil diperbarui');
    }

    /**
     * Detail permission
     */
    public function show(Permission $permission): View
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Hapus permission
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission berhasil dihapus');
    }
}
