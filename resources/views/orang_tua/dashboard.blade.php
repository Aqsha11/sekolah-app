@extends('admin.layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
<style>
    .m3-card {
        background: #ffffff;
        border: 1px solid #c4c5d5;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .m3-chip {
        background: #e8e7f1;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

<div class="max-w-3xl mx-auto space-y-5 pb-8" x-data="dashboard()">
    {{-- Empty State --}}
    @if (count($data) === 0)
        <div class="m3-card p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-slate-400 text-3xl">family_history</span>
            </div>
            <h2 class="text-lg font-semibold text-slate-600">Belum ada data anak</h2>
            <p class="text-sm text-slate-400 mt-1">Hubungi sekolah untuk menautkan data anak Anda</p>
        </div>
    @endif

    @php
        $totalHadirSemua = collect($data)->sum('total_hadir');
        $totalAlphaSemua = collect($data)->sum('total_alpha');
        $totalTerlambatSemua = collect($data)->sum('total_terlambat');
        $totalAnak = count($data);
    @endphp

    {{-- Aggregate Summary (Bento) --}}
    <section class="grid grid-cols-3 gap-3">
        <div class="m3-card p-4 flex flex-col items-center text-center">
            <span class="text-xs font-medium text-slate-500 mb-1">Hadir</span>
            <span class="text-2xl font-bold" style="color:#006c49">{{ $totalHadirSemua }}</span>
            <span class="text-[10px] text-slate-400">Total</span>
        </div>
        <div class="m3-card p-4 flex flex-col items-center text-center">
            <span class="text-xs font-medium text-slate-500 mb-1">Terlambat</span>
            <span class="text-2xl font-bold" style="color:#6b4200">{{ $totalTerlambatSemua }}</span>
            <span class="text-[10px] text-slate-400">Total</span>
        </div>
        <div class="m3-card p-4 flex flex-col items-center text-center">
            <span class="text-xs font-medium text-slate-500 mb-1">Alpha</span>
            <span class="text-2xl font-bold" style="color:#ba1a1a">{{ $totalAlphaSemua }}</span>
            <span class="text-[10px] text-slate-400">Total</span>
        </div>
    </section>

    {{-- Per-Student Cards --}}
    @foreach ($data as $item)
        @php
            $siswa = $item['siswa'];
            $absensi = $item['absensi_hari_ini'];
            $hadir = $item['total_hadir'];
            $terlambat = $item['total_terlambat'];
            $izin = $item['total_izin'];
            $alpha = $item['total_alpha'];
            $totalStats = $hadir + $izin + $alpha + $terlambat;
            $persenHadir = $totalStats > 0 ? round(($hadir / $totalStats) * 100) : 0;

            $statusLabel = match($absensi?->status) {
                'hadir' => 'HADIR',
                'terlambat' => 'TERLAMBAT',
                'izin' => 'IZIN',
                'sakit' => 'SAKIT',
                'alpha' => 'ALPHA',
                default => 'BELUM ABSEN',
            };
            $statusColor = match($absensi?->status) {
                'hadir' => '#006c49',
                'terlambat' => '#6b4200',
                'izin', 'sakit' => '#005caa',
                'alpha' => '#ba1a1a',
                default => '#757684',
            };
            $statusBg = match($absensi?->status) {
                'hadir' => '#e6f7f0',
                'terlambat' => '#fff0e0',
                'izin', 'sakit' => '#e0f0ff',
                'alpha' => '#ffe0de',
                default => '#f0f0f4',
            };
        @endphp

        <article class="m3-card overflow-hidden" data-siswa-id="{{ $siswa->id }}">
            {{-- Gradient Header with Avatar --}}
            <div class="relative h-20" style="background: linear-gradient(135deg, #00288e, #1e40af)">
                <div class="absolute -bottom-8 left-5 ring-4 ring-white rounded-xl overflow-hidden w-16 h-16 bg-slate-200 flex items-center justify-center">
                    <span class="text-xl font-bold text-slate-500">{{ substr($siswa->nama, 0, 1) }}</span>
                </div>
            </div>

            <div class="pt-10 px-5 pb-5 space-y-4">
                {{-- Student Identity --}}
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $siswa->nama }}</h2>
                        <p class="text-sm text-slate-500">{{ $siswa->kelas }} • NIS: {{ $siswa->nis }}</p>
                    </div>
                </div>

                {{-- Today's Status --}}
                <div class="rounded-lg p-4 flex items-center justify-between" style="background:{{ $statusBg }}" data-status-bg>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:{{ $statusColor }}20">
                            <span class="material-symbols-outlined text-sm" style="color:{{ $statusColor }}">
                                {{ $absensi ? 'how_to_reg' : 'hourglass_empty' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold uppercase" style="color:{{ $statusColor }}">Status Hari Ini</span>
                            @if ($absensi)
                                <span class="text-base font-bold" style="color:{{ $statusColor }}" data-status-badge>{{ $statusLabel }}</span>
                            @else
                                <span class="text-base font-bold text-slate-400">Belum Absen</span>
                            @endif
                        </div>
                    </div>
                    @if ($absensi?->check_in)
                        <span class="text-xs font-medium text-slate-500">{{ $absensi->check_in->format('H:i') }} WITA</span>
                    @endif
                </div>

                {{-- Check-in/out times --}}
                @if ($absensi)
                    <div class="flex gap-4 text-xs text-slate-500">
                        <span>Check In: <strong class="text-slate-700" data-check-in>{{ $absensi->check_in?->format('H:i') ?? '-' }}</strong></span>
                        <span>Check Out: <strong class="text-slate-700">{{ $absensi->check_out?->format('H:i') ?? '-' }}</strong></span>
                    </div>
                @endif

                {{-- Stat Recaps --}}
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="rounded-lg p-2" style="background:#e6f7f0">
                        <p class="text-lg font-bold" style="color:#006c49">{{ $hadir }}</p>
                        <p class="text-[10px]" style="color:#006c49">Hadir</p>
                    </div>
                    <div class="rounded-lg p-2" style="background:#fff0e0">
                        <p class="text-lg font-bold" style="color:#6b4200">{{ $terlambat }}</p>
                        <p class="text-[10px]" style="color:#6b4200">Terlambat</p>
                    </div>
                    <div class="rounded-lg p-2" style="background:#e0f0ff">
                        <p class="text-lg font-bold" style="color:#005caa">{{ $izin }}</p>
                        <p class="text-[10px]" style="color:#005caa">Izin</p>
                    </div>
                    <div class="rounded-lg p-2" style="background:#ffe0de">
                        <p class="text-lg font-bold" style="color:#ba1a1a">{{ $alpha }}</p>
                        <p class="text-[10px]" style="color:#ba1a1a">Alpha</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                @if ($totalStats > 0)
                    <div class="rounded-xl p-4 text-white" style="background:#1a1b22">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium">Persentase Kehadiran</span>
                            <span class="text-xl font-bold" style="color:#6cf8bb">{{ $persenHadir }}%</span>
                        </div>
                        <div class="w-full rounded-full h-2.5 overflow-hidden" style="background:rgba(255,255,255,0.12)">
                            <div class="h-full rounded-full transition-all duration-700" style="width:{{ $persenHadir }}%; background:#6cf8bb; box-shadow: 0 0 8px rgba(108,248,187,0.5)"></div>
                        </div>
                        <p class="text-xs mt-2 opacity-70">Kehadiran {{ $persenHadir >= 90 ? 'sangat baik' : ($persenHadir >= 75 ? 'cukup baik' : 'perlu ditingkatkan') }}. {{ $persenHadir >= 90 ? 'Pertahankan!' : '' }}</p>
                    </div>
                @endif

                {{-- Recent Logs --}}
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-sm font-semibold text-slate-700">Log Kehadiran Terbaru</h3>
                        <a href="{{ route('orangtua.riwayat', $siswa->id) }}" class="text-xs font-bold uppercase tracking-wide" style="color:#00288e">Lihat Semua</a>
                    </div>
                    <div class="space-y-2">
                        @forelse($item['riwayat'] as $r)
                            @php
                                $isLate = $r->status === 'terlambat';
                                $isPresent = $r->status === 'hadir';
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:shadow-sm transition-shadow">
                                <div class="flex gap-3 items-center">
                                    <div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center shrink-0" style="background:{{ $isLate ? '#fff0e0' : '#e8e7f1' }}">
                                        <span class="text-[9px] font-bold uppercase" style="color:{{ $isLate ? '#6b4200' : '#444653' }}">{{ $r->tanggal->format('M') }}</span>
                                        <span class="text-sm font-bold leading-none" style="color:{{ $isLate ? '#6b4200' : '#1a1b22' }}">{{ $r->tanggal->format('d') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">{{ $r->check_out ? 'Pulang Sekolah' : 'Masuk Sekolah' }}</p>
                                        <p class="text-xs text-slate-400">{{ $r->check_out ? 'Checkout selesai' : ($isLate ? 'Terlambat ' . $r->check_in?->diffInMinutes(\Carbon\Carbon::parse($r->tanggal->format('Y-m-d') . ' 07:15')) . ' menit' : 'Tepat waktu') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-sm font-bold text-slate-700">{{ $r->check_in?->format('H:i') ?? '-' }}{{ $r->check_out ? ' - ' . $r->check_out->format('H:i') : '' }}</span>
                                    <span class="text-[10px] uppercase font-medium" style="color:{{ $isLate ? '#6b4200' : ($isPresent ? '#006c49' : '#757684') }}">{{ $r->status }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 text-center py-4">Belum ada riwayat absensi</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </article>
    @endforeach

    {{-- Info Card --}}
    <div class="m3-card p-5 flex gap-4" style="background:#eef0ff; border-color:#a8b8ff">
        <span class="material-symbols-outlined shrink-0" style="color:#00288e">info</span>
        <div>
            <p class="text-sm font-bold" style="color:#00288e">Informasi Sekolah</p>
            <p class="text-xs mt-1" style="color:#444653">Pastikan putra/putri Anda membawa kartu akses setiap hari untuk memperlancar proses pencatatan kehadiran otomatis.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function waktuWITA() {
        const now = new Date();
        return new Date(now.getTime() + now.getTimezoneOffset() * 60000 + 8 * 3600000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const siswaIds = [
            @foreach ($data as $item)
                {{ $item['siswa']->id }},
            @endforeach
        ];

        siswaIds.forEach(function(id) {
            setInterval(function() {
                fetch('/orang-tua/realtime/' + id)
                    .then(r => r.json())
                    .then(data => {
                        document.querySelectorAll('[data-siswa-id="' + id + '"]').forEach(card => {
                            const statusBadge = card.querySelector('[data-status-badge]');
                            const statusBg = card.querySelector('[data-status-bg]');
                            const checkInEl = card.querySelector('[data-check-in]');

                            if (data.status === 'hadir') {
                                statusBadge.textContent = 'HADIR';
                                statusBadge.style.color = '#006c49';
                                statusBg.style.background = '#e6f7f0';
                                checkInEl.textContent = data.check_in || '-';
                            } else if (data.status === 'terlambat') {
                                statusBadge.textContent = 'TERLAMBAT';
                                statusBadge.style.color = '#6b4200';
                                statusBg.style.background = '#fff0e0';
                                checkInEl.textContent = data.check_in || '-';
                            } else if (data.status === 'belum_absen') {
                                statusBadge.textContent = 'BELUM ABSEN';
                                statusBadge.style.color = '#757684';
                                statusBg.style.background = '#f0f0f4';
                                checkInEl.textContent = '-';
                            }
                        });
                    });
            }, 15000);
        });
    });
</script>
@endsection
