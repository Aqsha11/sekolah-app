<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GaleriController extends Controller
{
    /**
     * Daftar galeri (dengan filter pencarian & kategori)
     */
    public function index(Request $request): View
    {
        $query = Galeri::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $galeri = $query->latest()->paginate(12);
        $categories = Galeri::distinct()->pluck('category')->filter();

        return view('admin.galeri.index', compact('galeri', 'categories'));
    }

    /**
     * Form tambah gambar galeri
     */
    public function create(): View
    {
        return view('admin.galeri.create');
    }

    /**
     * Simpan gambar galeri baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('galeri', $filename, 'public');

            Galeri::create([
                'title' => $request->title,
                'image' => $filename,
                'category' => $request->category,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Gambar berhasil diunggah');
    }

    /**
     * Form edit galeri
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update data galeri
     */
    public function update(Request $request, Galeri $galeri): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('galeri', $filename, 'public');
            $data['image'] = $filename;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Gambar berhasil diperbarui');
    }

    /**
     * Hapus gambar dari galeri
     */
    public function destroy(Galeri $galeri): RedirectResponse
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Gambar berhasil dihapus');
    }

    /**
     * Detail galeri
     */
    public function show(Galeri $galeri): View
    {
        return view('admin.galeri.show', compact('galeri'));
    }
}
