<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    /**
     * Daftar semua fasilitas
     */
    public function index(): View
    {
        $fasilitas = Fasilitas::latest()->paginate(12);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Form tambah fasilitas
     */
    public function create(): View
    {
        return view('admin.fasilitas.create');
    }

    /**
     * Simpan fasilitas baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:fasilitas',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fasilitas', 'public');
            $validated['image'] = $path;
        }

        Fasilitas::create($validated);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    /**
     * Form edit fasilitas
     */
    public function edit(Fasilitas $fasilita): View
    {
        return view('admin.fasilitas.edit', ['fasilitas' => $fasilita]);
    }

    /**
     * Update data fasilitas
     */
    public function update(Request $request, Fasilitas $fasilita): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:fasilitas,name,' . $fasilita->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {

            if ($fasilita->image && Storage::disk('public')->exists($fasilita->image)) {
                Storage::disk('public')->delete($fasilita->image);
            }

            $path = $request->file('image')->store('fasilitas', 'public');
            $validated['image'] = $path;
        }

        $fasilita->update($validated);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui');
    }

    /**
     * Hapus fasilitas (beserta file gambar)
     */
    public function destroy(Fasilitas $fasilita): RedirectResponse
    {
        if ($fasilita->image && Storage::disk('public')->exists($fasilita->image)) {
            Storage::disk('public')->delete($fasilita->image);
        }

        $fasilita->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus');
    }

    /**
     * Detail fasilitas
     */
    public function show(Fasilitas $fasilita): View
    {
        return view('admin.fasilitas.show', ['fasilitas' => $fasilita]);
    }
}
