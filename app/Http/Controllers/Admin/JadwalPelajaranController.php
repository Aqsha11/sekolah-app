<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelajaranController extends Controller
{
    /**
     * Daftar jadwal dengan filter kelas
     */
    public function index(Request $request): View
    {
        $query = JadwalPelajaran::with(['kelas', 'guru']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->get();

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $selectedKelas = $request->kelas_id;

        // Grup by hari untuk tampilan grid
        $jadwalByHari = $jadwals->groupBy('hari');

        return view('admin.jadwal.index', compact('jadwals', 'kelasList', 'selectedKelas', 'jadwalByHari'));
    }

    /**
     * Form tambah jadwal
     */
    public function create(): View
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $guruList = Guru::where('is_active', true)->orderBy('name')->get();

        return view('admin.jadwal.create', compact('kelasList', 'guruList'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran' => 'required|string|max:100',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'ruangan' => 'nullable|string|max:50',
        ]);

        if ($validated['jam_selesai'] <= $validated['jam_mulai']) {
            return back()->withErrors([
                'jam_selesai' => 'Jam selesai harus lebih besar dari jam mulai.',
            ])->withInput();
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan');
    }

    /**
     * Form edit jadwal
     */
    public function edit(JadwalPelajaran $jadwal): View
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $guruList = Guru::where('is_active', true)->orderBy('name')->get();

        return view('admin.jadwal.edit', compact('jadwal', 'kelasList', 'guruList'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, JadwalPelajaran $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran' => 'required|string|max:100',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'ruangan' => 'nullable|string|max:50',
        ]);

        if ($validated['jam_selesai'] <= $validated['jam_mulai']) {
            return back()->withErrors([
                'jam_selesai' => 'Jam selesai harus lebih besar dari jam mulai.',
            ])->withInput();
        }

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil diperbarui');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(JadwalPelajaran $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus');
    }
}
