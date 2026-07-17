<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ExportLaporanAbsensiJob;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan — tab Absensi
     */
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route('admin.laporan.absensi', $request->query());
    }

    /* ==================================================================
     |  ABSENSI — Rekap per siswa dalam rentang tanggal
     |================================================================== */

    public function absensi(Request $request): View
    {
        $dari = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kelasFilter = $request->get('kelas');

        $query = Siswa::query();

        if ($kelasFilter) {
            $query->where('kelas', $kelasFilter);
        }

        $siswas = $query->orderBy('nama')->get()->map(function ($siswa) use ($dari, $sampai) {
            $absensis = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$dari, $sampai])
                ->get();

            return (object) [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas,
                'hadir' => $absensis->where('status', 'hadir')->count(),
                'izin' => $absensis->where('status', 'izin')->count(),
                'sakit' => $absensis->where('status', 'sakit')->count(),
                'alpha' => $absensis->where('status', 'alpha')->count(),
                'terlambat' => $absensis->where('status', 'terlambat')->count(),
                'total' => $absensis->count(),
            ];
        });

        $kelasList = Siswa::distinct('kelas')->pluck('kelas')->filter()->sort()->values();

        $summary = [
            'total_siswa' => $siswas->count(),
            'total_hadir' => $siswas->sum('hadir'),
            'total_alpha' => $siswas->sum('alpha'),
            'total_terlambat' => $siswas->sum('terlambat'),
        ];

        $tab = 'absensi';
        return view('admin.laporan.index', compact('siswas', 'kelasList', 'dari', 'sampai', 'kelasFilter', 'summary', 'tab'));
    }

    /**
     * Export rekap absensi ke Excel (via queue untuk data besar)
     */
    public function exportAbsensiExcel(Request $request)
    {
        $dari = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kelasFilter = $request->get('kelas');

        $siswaCount = Siswa::when($kelasFilter, fn ($q) => $q->where('kelas', $kelasFilter))->count();

        // Jika data > 500 siswa, proses via queue
        if ($siswaCount > 500) {
            ExportLaporanAbsensiJob::dispatch('excel', $dari, $sampai, $kelasFilter, auth()->id());

            return back()->with('info', 'Export sedang diproses di background. File akan tersedia di halaman unduhan dalam beberapa menit.');
        }

        // Data kecil — proses langsung
        return $this->syncExcel($dari, $sampai, $kelasFilter);
    }

    /**
     * Export rekap absensi ke PDF (via queue untuk data besar)
     */
    public function exportAbsensiPdf(Request $request)
    {
        $dari = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kelasFilter = $request->get('kelas');

        $siswaCount = Siswa::when($kelasFilter, fn ($q) => $q->where('kelas', $kelasFilter))->count();

        if ($siswaCount > 500) {
            ExportLaporanAbsensiJob::dispatch('pdf', $dari, $sampai, $kelasFilter, auth()->id());

            return back()->with('info', 'Export PDF sedang diproses di background. File akan tersedia di halaman unduhan dalam beberapa menit.');
        }

        return $this->syncPdf($dari, $sampai, $kelasFilter);
    }

    /**
     * Download file export dari queue
     */
    public function downloadExport(string $filename)
    {
        $path = 'exports/' . $filename;

        if (! \Storage::disk('local')->exists($path)) {
            abort(404, 'File tidak ditemukan atau masih diproses.');
        }

        return \Storage::disk('local')->download($path, $filename, [
            'Content-Type' => str_ends_with($filename, '.xlsx')
                ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                : 'application/pdf',
        ])->deleteFileAfterSend(true);
    }

    /* ==================================================================
     |  SYNC EXPORT (untuk data < 500 siswa)
     |================================================================== */

    protected function syncExcel(string $dari, string $sampai, ?string $kelasFilter)
    {
        $query = Siswa::query();
        if ($kelasFilter) {
            $query->where('kelas', $kelasFilter);
        }

        $siswas = $query->orderBy('nama')->get();

        $writer = new Writer();
        $fileName = 'rekap-absensi-' . $dari . '-sd-' . $sampai . '.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), 'rekap') . '.xlsx';

        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'NIS', 'Nama', 'Kelas', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Terlambat', 'Total']));

        foreach ($siswas as $i => $siswa) {
            $absensis = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$dari, $sampai])->get();

            $writer->addRow(Row::fromValues([
                $i + 1,
                $siswa->nis,
                $siswa->nama,
                $siswa->kelas ?? '-',
                $absensis->where('status', 'hadir')->count(),
                $absensis->where('status', 'izin')->count(),
                $absensis->where('status', 'sakit')->count(),
                $absensis->where('status', 'alpha')->count(),
                $absensis->where('status', 'terlambat')->count(),
                $absensis->count(),
            ]));
        }

        $writer->close();
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    protected function syncPdf(string $dari, string $sampai, ?string $kelasFilter)
    {
        $query = Siswa::query();
        if ($kelasFilter) {
            $query->where('kelas', $kelasFilter);
        }

        $siswas = $query->orderBy('nama')->get()->map(function ($siswa) use ($dari, $sampai) {
            $absensis = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$dari, $sampai])->get();

            return (object) [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas ?? '-',
                'hadir' => $absensis->where('status', 'hadir')->count(),
                'izin' => $absensis->where('status', 'izin')->count(),
                'sakit' => $absensis->where('status', 'sakit')->count(),
                'alpha' => $absensis->where('status', 'alpha')->count(),
                'terlambat' => $absensis->where('status', 'terlambat')->count(),
                'total' => $absensis->count(),
            ];
        });

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        $pdf = Pdf::loadView('admin.laporan.absensi-pdf', compact('siswas', 'dari', 'sampai', 'kelasFilter', 'settings'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekap-absensi-' . $dari . '-sd-' . $sampai . '.pdf');
    }
}
