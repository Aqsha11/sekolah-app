<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrangTuaController extends Controller
{
    /**
     * Daftar semua orang tua (dari tabel orang_tua, bukan users)
     */
    public function index(): View
    {
        $orangTuas = OrangTua::orderBy('nama')->paginate(20);
        return view('admin.orang_tua.index', compact('orangTuas'));
    }

    /**
     * Form atur relasi orang tua ↔ anak (siswa)
     */
    public function edit(OrangTua $orangTua): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        $terpilih = $orangTua->anakSiswa()->pluck('siswa_id')->toArray();
        return view('admin.orang_tua.edit', compact('orangTua', 'siswas', 'terpilih'));
    }

    /**
     * Simpan relasi orang tua ↔ anak (sync pivot table)
     */
    public function update(Request $request, OrangTua $orangTua): RedirectResponse
    {
        $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        // Sync: tambah/hapus relasi di tabel pivot orang_tua_siswa
        $orangTua->anakSiswa()->sync($request->siswa_ids ?? []);

        return redirect()->route('admin.orang_tua.index')
            ->with('success', 'Relasi orang tua dengan siswa berhasil diperbarui');
    }
}
