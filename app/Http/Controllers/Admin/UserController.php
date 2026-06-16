<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user (dengan filter)
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filter pencarian (nama/email)
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($role = $request->role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        // Filter status aktif/nonaktif
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $users = $query->with('roles')->latest()->paginate(20)->withQueryString();
        $roles = Role::all();

        // Hitung jumlah anak untuk user role orang_tua
        $anakCounts = [];
        foreach ($users as $user) {
            if ($user->hasRole('orang_tua')) {
                $orangTua = OrangTua::where('email', $user->email)->first();
                $anakCounts[$user->id] = $orangTua?->anakSiswa()->count() ?? 0;
            }
        }

        return view('admin.users.index', compact('users', 'roles', 'anakCounts'));
    }

    /**
     * Form tambah user baru
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Simpan user baru ke database
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'is_active' => 'nullable',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'is_active' => $request->has('is_active'),
        ]);

        // Simpan Role (Spatie Permission)
        $user->assignRole($request->role);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Form edit user
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
            'is_active' => 'nullable',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $request->has('is_active'),
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // Update Role
        $user->syncRoles([$request->role]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Detail user
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Hapus user (soft delete)
     */
    public function destroy(User $user): RedirectResponse
    {
        // Cegah hapus akun sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus');
    }

    /**
     * Export data user ke Excel (.xlsx)
     * Menggunakan OpenSpout (library spreadsheet)
     */
    public function exportExcel(Request $request)
    {
        $query = User::query()->with('roles');

        // Filter sama seperti index
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $users = $query->orderBy('name')->get();

        // Buat file XLSX
        $writer = new Writer();
        $fileName = 'data-users-' . date('Y-m-d') . '.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'users') . '.xlsx';

        $writer->openToFile($tempPath);
        // Header kolom
        $writer->addRow(Row::fromValues(['No', 'Nama', 'Email', 'No. WA', 'Role', 'Jumlah Anak', 'Status']));

        foreach ($users as $i => $user) {
            $role = $user->getRoleNames()->first() ?? '-';
            $anakCount = $user->hasRole('orang_tua')
                ? (OrangTua::where('email', $user->email)->first()?->anakSiswa()->count() ?? 0)
                : '-';

            $writer->addRow(Row::fromValues([
                $i + 1,
                $user->name,
                $user->email,
                $user->phone ?? '-',
                $role,
                $anakCount,
                $user->is_active ? 'Aktif' : 'Nonaktif',
            ]));
        }

        $writer->close();

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}
