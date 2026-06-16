<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

class AbsensiController extends Controller
{
    /**
     * Daftar absensi harian (filter: tanggal, kelas, status)
     */
    public function index(Request $request): View
    {
        $query = Absensi::with('siswa');

        // Filter tanggal (default: hari ini)
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', Carbon::today());
        }

        // Filter kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('check_in')->paginate(20);
        $kelasList = Siswa::distinct('kelas')->pluck('kelas');
        $tanggal = $request->tanggal ?? Carbon::today()->format('Y-m-d');

        return view('admin.absensi.index', compact('absensis', 'kelasList', 'tanggal'));
    }

    /**
     * Form catat absensi manual
     */
    public function create(): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        return view('admin.absensi.create', compact('siswas'));
    }

    /**
     * Simpan absensi manual
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'status' => 'required|in:hadir,izin,sakit,alpha,terlambat',
            'tanggal' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        $siswa = Siswa::findOrFail($validated['siswa_id']);
        $tanggal = $validated['tanggal'];

        $checkIn = $validated['check_in']
            ? Carbon::parse($tanggal . ' ' . $validated['check_in'])
            : null;

        $checkOut = $validated['check_out']
            ? Carbon::parse($tanggal . ' ' . $validated['check_out'])
            : null;

        Absensi::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tanggal' => $tanggal],
            [
                'rfid' => $siswa->rfid ?? '-',
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $validated['status'],
            ]
        );

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dicatat');
    }

    /**
     * Form edit absensi
     */
    public function edit(Absensi $absensi): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        return view('admin.absensi.edit', compact('absensi', 'siswas'));
    }

    /**
     * Update absensi
     */
    public function update(Request $request, Absensi $absensi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha,terlambat',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        $tanggal = $absensi->tanggal->format('Y-m-d');

        $absensi->update([
            'check_in' => $validated['check_in']
                ? Carbon::parse($tanggal . ' ' . $validated['check_in'])
                : null,
            'check_out' => $validated['check_out']
                ? Carbon::parse($tanggal . ' ' . $validated['check_out'])
                : null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    /**
     * Hapus absensi
     */
    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();
        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    /**
     * Halaman laporan absensi (rentang tanggal, filter kelas & status)
     */
    public function laporan(Request $request): View
    {
        $query = Absensi::with('siswa');

        if ($request->filled('dari')) {
            $query->where('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('tanggal')->paginate(50);
        $kelasList = Siswa::distinct('kelas')->pluck('kelas');

        return view('admin.absensi.laporan', compact('absensis', 'kelasList'));
    }

    /**
     * Export absensi harian ke Excel (.xlsx)
     */
    public function exportExcel(Request $request)
    {
        $query = Absensi::with('siswa');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', Carbon::today());
        }
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $request->kelas));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('check_in')->get();

        $writer = new Writer();
        $fileName = 'absensi-' . date('Y-m-d') . '.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'absensi') . '.xlsx';

        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'Nama', 'Kelas', 'Tanggal', 'Check In', 'Check Out', 'Status']));

        foreach ($absensis as $i => $a) {
            $writer->addRow(Row::fromValues([
                $i + 1,
                $a->siswa->nama,
                $a->siswa->kelas,
                $a->tanggal->format('d/m/Y'),
                $a->check_in?->format('H:i:s') ?? '-',
                $a->check_out?->format('H:i:s') ?? '-',
                ucfirst($a->status),
            ]));
        }

        $writer->close();

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Export laporan absensi (rentang tanggal) ke Excel (.xlsx)
     */
    public function exportLaporan(Request $request)
    {
        $query = Absensi::with('siswa');

        if ($request->filled('dari')) {
            $query->where('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $request->kelas));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->latest('tanggal')->get();

        $writer = new Writer();
        $fileName = 'laporan-absensi-' . date('Y-m-d') . '.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'laporan') . '.xlsx';

        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'Tanggal', 'Nama', 'Kelas', 'Check In', 'Check Out', 'Status']));

        foreach ($absensis as $i => $a) {
            $writer->addRow(Row::fromValues([
                $i + 1,
                $a->tanggal->format('d/m/Y'),
                $a->siswa->nama,
                $a->siswa->kelas,
                $a->check_in?->format('H:i:s') ?? '-',
                $a->check_out?->format('H:i:s') ?? '-',
                ucfirst($a->status),
            ]));
        }

        $writer->close();

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}
