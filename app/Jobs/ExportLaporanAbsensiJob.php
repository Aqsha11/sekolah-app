<?php

namespace App\Jobs;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportLaporanAbsensiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public string $format,
        public string $dari,
        public string $sampai,
        public ?string $kelasFilter,
        public int $userId,
    ) {
        $this->onQueue('exports');
    }

    public function handle(): string
    {
        $query = Siswa::query();
        if ($this->kelasFilter) {
            $query->where('kelas', $this->kelasFilter);
        }

        $siswas = $query->orderBy('nama')->get();

        $fileName = 'rekap-absensi-' . $this->dari . '-sd-' . $this->sampai;

        if ($this->format === 'excel') {
            return $this->exportExcel($siswas, $fileName);
        }

        return $this->exportPdf($siswas, $fileName);
    }

    protected function exportExcel($siswas, string $fileName): string
    {
        $writer = new Writer();
        $tempPath = tempnam(sys_get_temp_dir(), 'rekap') . '.xlsx';

        $writer->openToFile($tempPath);
        $writer->addRow(Row::fromValues(['No', 'NIS', 'Nama', 'Kelas', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Terlambat', 'Total']));

        foreach ($siswas as $i => $siswa) {
            $absensis = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$this->dari, $this->sampai])->get();

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

        $path = 'exports/' . $fileName . '.xlsx';
        Storage::disk('local')->put($path, file_get_contents($tempPath));
        @unlink($tempPath);

        return $path;
    }

    protected function exportPdf($siswas, string $fileName): string
    {
        $data = $siswas->map(function ($siswa) {
            $absensis = Absensi::where('siswa_id', $siswa->id)
                ->whereBetween('tanggal', [$this->dari, $this->sampai])->get();

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

        $settings = Setting::pluck('value', 'key')->toArray();

        $pdf = Pdf::loadView('admin.laporan.absensi-pdf', [
            'siswas' => $data,
            'dari' => $this->dari,
            'sampai' => $this->sampai,
            'kelasFilter' => $this->kelasFilter,
            'settings' => $settings,
        ])->setPaper('a4', 'landscape');

        $path = 'exports/' . $fileName . '.pdf';
        Storage::disk('local')->put($path, $pdf->output());

        return $path;
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('Export laporan gagal: ' . $exception->getMessage());
    }
}
