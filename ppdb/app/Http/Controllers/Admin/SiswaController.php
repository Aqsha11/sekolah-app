<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

class SiswaController extends Controller
{
    /**
     * Daftar semua siswa
     */
    public function index(): View
    {
        $siswas = Siswa::latest()->paginate(20);
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Form tambah siswa
     */
    public function create(): View
    {
        $kelasList = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];
        $jurusanList = ['IPA', 'IPS', 'Bahasa'];
        return view('admin.siswa.create', compact('kelasList', 'jurusanList'));
    }

    /**
     * Simpan siswa baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas,nis',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'rfid' => 'nullable|string|unique:siswas,rfid',
        ]);

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Form edit siswa
     */
    public function edit(Siswa $siswa): View
    {
        $kelasList = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];
        $jurusanList = ['IPA', 'IPS', 'Bahasa'];
        return view('admin.siswa.edit', compact('siswa', 'kelasList', 'jurusanList'));
    }

    /**
     * Update data siswa
     */
    public function update(Request $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas,nis,' . $siswa->id,
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'rfid' => 'nullable|string|unique:siswas,rfid,' . $siswa->id,
        ]);

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diperbarui');
    }

    /**
     * Hapus siswa
     */
    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }

    /**
     * Export data siswa ke Excel (.xlsx)
     */
    public function exportExcel()
    {
        $siswas = Siswa::orderBy('nama')->get();

        $writer = new Writer();
        $fileName = 'data-siswa-' . date('Y-m-d') . '.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'siswa') . '.xlsx';

        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'Nama', 'NIS', 'Kelas', 'Jurusan', 'RFID']));

        foreach ($siswas as $i => $siswa) {
            $writer->addRow(Row::fromValues([
                $i + 1,
                $siswa->nama,
                $siswa->nis,
                $siswa->kelas,
                $siswa->jurusan,
                $siswa->rfid ?? '-',
            ]));
        }

        $writer->close();

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}
