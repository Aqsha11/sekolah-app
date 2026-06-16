<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PrestasiController extends Controller
{
    /**
     * Daftar prestasi (dengan filter pencarian, kategori, tahun)
     */
    public function index(Request $request): View
    {
        $query = Prestasi::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->year) {
            $query->where('year', $request->year);
        }

        $prestasi = $query->latest()->paginate(15);
        $categories = Prestasi::distinct()->pluck('category')->filter();
        $years = Prestasi::distinct()->orderByDesc('year')->pluck('year')->filter();

        return view('admin.prestasi.index', compact('prestasi', 'categories', 'years'));
    }

    /**
     * Form tambah prestasi
     */
    public function create(): View
    {
        return view('admin.prestasi.create');
    }

    /**
     * Simpan prestasi baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:prestasis',
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('prestasi', $filename, 'public');
            $validated['image'] = $filename;
        }

        Prestasi::create($validated);
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan');
    }

    /**
     * Form edit prestasi
     */
    public function edit(Prestasi $prestasi): View
    {
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    /**
     * Update data prestasi
     */
    public function update(Request $request, Prestasi $prestasi): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:prestasis,title,' . $prestasi->id,
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:50',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('prestasi', $filename, 'public');
            $validated['image'] = $filename;
        }

        $prestasi->update($validated);
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui');
    }

    /**
     * Hapus prestasi
     */
    public function destroy(Prestasi $prestasi): RedirectResponse
    {
        $prestasi->delete();
        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus');
    }

    /**
     * Detail prestasi
     */
    public function show(Prestasi $prestasi): View
    {
        return view('admin.prestasi.show', compact('prestasi'));
    }
}
