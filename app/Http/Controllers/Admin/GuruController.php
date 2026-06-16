<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GuruController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('permission:manage guru', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Daftar semua guru
     */
    public function index(): View
    {
        $gurus = Guru::latest()->paginate(12);
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Form tambah guru
     */
    public function create(): View
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan guru baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:gurus,nip',
            'subject' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'email' => 'nullable|email|unique:gurus,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('guru', $filename, 'public');
            $validated['photo'] = $filename;
        }

        Guru::create($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    /**
     * Form edit guru
     */
    public function edit(Guru $guru): View
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update data guru
     */
    public function update(Request $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|unique:gurus,nip,' . $guru->id,
            'mapel' => 'required|string|max:100',
            'email' => 'nullable|email|unique:gurus,email,' . $guru->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload ulang foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('guru', $filename, 'public');
            $validated['photo'] = $filename;
        }

        $validated['is_active'] = $request->has('is_active');
        $guru->update($validated);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui');
    }

    /**
     * Hapus guru (soft delete)
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }

    /**
     * Detail guru
     */
    public function show(Guru $guru): View
    {
        return view('admin.guru.show', compact('guru'));
    }
}
