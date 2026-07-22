<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - {{ $dari }} s/d {{ $sampai }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 11px; color: #1a1a1a; padding: 30px; }
        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #1e293b; padding-bottom: 16px; }
        .header h1 { font-size: 18px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        .header p { font-size: 11px; color: #64748b; margin-top: 4px; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 10px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #f1f5f9; padding: 8px 6px; text-align: left; font-weight: 700; font-size: 9px;
             text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #cbd5e1; }
        td { padding: 6px; border: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background: #f8fafc; }
        .center { text-align: center; }
        .summary { display: flex; gap: 16px; margin-bottom: 20px; }
        .summary-card { flex: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; text-align: center; }
        .summary-card .value { font-size: 20px; font-weight: 800; }
        .summary-card .label { font-size: 9px; color: #64748b; text-transform: uppercase; }
        .footer { text-align: center; font-size: 9px; color: #94a3b8; margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $settings['nama_website'] ?? 'Sekolah' }}</h1>
        <p>Rekap Absensi Siswa</p>
        <p style="font-size:10px; margin-top:2px;">Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
        @if($kelasFilter)
            <p style="font-size:10px;">Kelas: {{ $kelasFilter }}</p>
        @endif
    </div>

    <div class="meta">
        <span>Dicetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</span>
        <span>Total: {{ $siswas->count() }} siswa</span>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center" style="width:30px;">No</th>
                <th style="width:70px;">NIS</th>
                <th>Nama</th>
                <th style="width:50px;">Kelas</th>
                <th class="center" style="width:35px;">Hadir</th>
                <th class="center" style="width:35px;">Izin</th>
                <th class="center" style="width:35px;">Sakit</th>
                <th class="center" style="width:35px;">Alpha</th>
                <th class="center" style="width:35px;">Telat</th>
                <th class="center" style="width:35px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $i => $s)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td style="font-family:monospace;">{{ $s->nis }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kelas ?? '-' }}</td>
                    <td class="center">{{ $s->hadir }}</td>
                    <td class="center">{{ $s->izin }}</td>
                    <td class="center">{{ $s->sakit }}</td>
                    <td class="center">{{ $s->alpha }}</td>
                    <td class="center">{{ $s->terlambat }}</td>
                    <td class="center"><strong>{{ $s->total }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="center" style="padding:20px;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatisch oleh {{ $settings['nama_website'] ?? 'Sistem Sekolah' }}
    </div>
</body>
</html>
