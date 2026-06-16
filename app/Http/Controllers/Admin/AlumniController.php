<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AlumniController extends Controller
{
    public function index(): View
    {
        $alumni = Alumni::latest()->paginate(20);
        return view('admin.alumni.index', compact('alumni'));
    }

    public function create(): View
    {
        return view('admin.alumni.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:4',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni berhasil ditambahkan');
    }

    public function edit(Alumni $alumnus): View
    {
        return view('admin.alumni.edit', compact('alumnus'));
    }

    public function update(Request $request, Alumni $alumnus): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:4',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        $alumnus->update($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni berhasil diperbarui');
    }

    public function destroy(Alumni $alumnus): RedirectResponse
    {
        $alumnus->delete();

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni berhasil dihapus');
    }
}
