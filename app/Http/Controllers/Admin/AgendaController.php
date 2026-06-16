<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AgendaController extends Controller
{
    public function index(): View
    {
        $agenda = Agenda::latest()->paginate(20);
        return view('admin.agenda.index', compact('agenda'));
    }

    public function create(): View
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan');
    }

    public function edit(Agenda $agendum): View
    {
        return view('admin.agenda.edit', compact('agendum'));
    }

    public function update(Request $request, Agenda $agendum): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $agendum->update($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui');
    }

    public function destroy(Agenda $agendum): RedirectResponse
    {
        $agendum->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus');
    }
}
