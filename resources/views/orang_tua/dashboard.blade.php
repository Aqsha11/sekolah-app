@extends('admin.layouts.app')

@section('title', 'Dashboard Orang Tua')
@section('hideSidebar', true)

@section('content')

<div class="max-w-3xl mx-auto space-y-5 pb-10" x-data="{ tab: '{{ request('tab', 'kehadiran') }}' }">

    {{-- Header --}}
    <div class="space-y-1">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Dashboard Orang Tua</h1>
                <p class="text-sm text-slate-500">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-1.5 text-[10px] font-semibold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                <span id="realtime-dot" class="w-1.5 h-1.5 rounded-full bg-slate-300 transition-colors duration-300"></span>
                Real-time
            </div>
        </div>
    </div>

    @if (count($data) === 0)
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-slate-300 text-3xl">family_history</span>
            </div>
            <h2 class="text-lg font-bold text-slate-600">Belum Ada Data Anak</h2>
            <p class="text-sm text-slate-400 mt-1.5 max-w-sm mx-auto">Hubungi sekolah untuk menautkan data anak Anda ke akun orang tua ini.</p>
        </div>
    @endif

    {{-- Tabs --}}
    <div class="bg-white border border-slate-200 p-1 rounded-xl flex gap-1 shadow-sm">
        <button @click="tab = 'kehadiran'" class="flex-1 flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-xs font-bold transition-all cursor-pointer"
            :class="tab === 'kehadiran' ? 'text-white bg-primary-700 shadow-sm' : 'text-slate-500 hover:bg-slate-100'">
            <span class="material-symbols-outlined text-base">how_to_reg</span>
            Kehadiran
        </button>
        <button @click="tab = 'jadwal'" class="flex-1 flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-xs font-bold transition-all cursor-pointer"
            :class="tab === 'jadwal' ? 'text-white bg-primary-700 shadow-sm' : 'text-slate-500 hover:bg-slate-100'">
            <span class="material-symbols-outlined text-base">schedule</span>
            Jadwal
        </button>
        <button @click="tab = 'kalender'" class="flex-1 flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-xs font-bold transition-all cursor-pointer"
            :class="tab === 'kalender' ? 'text-white bg-primary-700 shadow-sm' : 'text-slate-500 hover:bg-slate-100'">
            <span class="material-symbols-outlined text-base">event</span>
            Kalender
        </button>
    </div>

    {{-- TAB: KEHADIRAN ANAK --}}
    <div x-show="tab === 'kehadiran'" x-cloak>
        @php
            $totalHadirSemua = collect($data)->sum('total_hadir');
            $totalAlphaSemua = collect($data)->sum('total_alpha');
            $totalTerlambatSemua = collect($data)->sum('total_terlambat');
        @endphp

        <section class="grid grid-cols-3 gap-3 mb-5">
            <div class="bg-white border border-emerald-100 rounded-xl p-4 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-12 h-12 bg-emerald-50 rounded-bl-[2rem]"></div>
                <div class="relative">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center mb-2 mx-auto">
                        <span class="material-symbols-outlined text-emerald-600 text-base">check_circle</span>
                    </div>
                    <span id="summary-hadir" class="text-2xl font-black text-emerald-700 block">{{ $totalHadirSemua }}</span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hadir</span>
                </div>
            </div>
            <div class="bg-white border border-amber-100 rounded-xl p-4 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-12 h-12 bg-amber-50 rounded-bl-[2rem]"></div>
                <div class="relative">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center mb-2 mx-auto">
                        <span class="material-symbols-outlined text-amber-600 text-base">schedule</span>
                    </div>
                    <span id="summary-terlambat" class="text-2xl font-black text-amber-700 block">{{ $totalTerlambatSemua }}</span>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Terlambat</span>
                </div>
            </div>
            <div class="bg-white border border-red-100 rounded-xl p-4 flex flex-col items-center text-center shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-12 h-12 bg-red-50 rounded-bl-[2rem]"></div>
                <div class="relative">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center mb-2 mx-auto">
                        <span class="material-symbols-outlined text-red-600 text-base">cancel</span>
                    </div>
                    <span id="summary-alpha" class="text-2xl font-black text-red-600 block">{{ $totalAlphaSemua }}</span>
                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Alpha</span>
                </div>
            </div>
        </section>

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
                $statusClass = match($absensi?->status) {
                    'hadir' => 'text-emerald-700 bg-emerald-50',
                    'terlambat' => 'text-amber-700 bg-amber-50',
                    'izin', 'sakit' => 'text-primary-600 bg-primary-50',
                    'alpha' => 'text-red-600 bg-red-50',
                    default => 'text-slate-400 bg-slate-100',
                };
                $statusIconClass = match($absensi?->status) {
                    'hadir' => 'text-emerald-600 bg-emerald-100',
                    'terlambat' => 'text-amber-600 bg-amber-100',
                    'izin', 'sakit' => 'text-primary-500 bg-primary-100',
                    'alpha' => 'text-red-500 bg-red-100',
                    default => 'text-slate-400 bg-slate-100',
                };
            @endphp

            <article class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-5" data-siswa-id="{{ $siswa->id }}">
                <div class="relative h-20 bg-gradient-to-br from-primary-700 to-primary-500">
                    <div class="absolute -bottom-8 left-5 ring-4 ring-white rounded-xl overflow-hidden w-16 h-16 bg-slate-200 flex items-center justify-center">
                        <span class="text-xl font-bold text-slate-500">{{ substr($siswa->nama, 0, 1) }}</span>
                    </div>
                </div>

                <div class="pt-10 px-5 pb-5 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $siswa->nama }}</h2>
                            <p class="text-sm text-slate-500">{{ $siswa->kelas }} • NIS: {{ $siswa->nis }}</p>
                        </div>
                    </div>

                    <div data-status-row class="rounded-lg p-4 flex items-center justify-between {{ $statusClass }}" data-status-bg>
                        <div class="flex items-center gap-3">
                            <div data-status-icon-bg class="w-10 h-10 rounded-full flex items-center justify-center {{ $statusIconClass }}">
                                <span data-status-icon class="material-symbols-outlined text-sm">
                                    {{ $absensi ? 'how_to_reg' : 'hourglass_empty' }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold uppercase {{ $statusClass }}">Status Hari Ini</span>
                                @if ($absensi)
                                    <span class="text-base font-bold {{ $statusClass }}" data-status-badge>{{ $statusLabel }}</span>
                                @else
                                    <span class="text-base font-bold text-slate-400" data-status-badge>Belum Absen</span>
                                @endif
                            </div>
                        </div>
                        @if ($absensi?->check_in)
                            <span data-time class="text-xs font-medium opacity-70">{{ $absensi->check_in->format('H:i') }} WITA</span>
                        @else
                            <span data-time class="text-xs font-medium opacity-70"></span>
                        @endif
                    </div>

                    @if ($absensi)
                    <div class="flex gap-4 text-xs text-slate-500">
                        <span>Check In: <strong class="text-slate-700" data-check-in>{{ $absensi->check_in?->format('H:i') ?? '-' }}</strong></span>
                        <span>Check Out: <strong class="text-slate-700" data-check-out>{{ $absensi->check_out?->format('H:i') ?? '-' }}</strong></span>
                    </div>
                    @else
                    <div class="flex gap-4 text-xs text-slate-500">
                        <span>Check In: <strong class="text-slate-400" data-check-in>-</strong></span>
                        <span>Check Out: <strong class="text-slate-400" data-check-out>-</strong></span>
                    </div>
                    @endif

                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div class="rounded-lg p-2 bg-emerald-50">
                            <p data-stat-hadir class="text-lg font-bold text-emerald-700">{{ $hadir }}</p>
                            <p class="text-[10px] text-emerald-700">Hadir</p>
                        </div>
                        <div class="rounded-lg p-2 bg-amber-50">
                            <p data-stat-terlambat class="text-lg font-bold text-amber-700">{{ $terlambat }}</p>
                            <p class="text-[10px] text-amber-700">Terlambat</p>
                        </div>
                        <div class="rounded-lg p-2 bg-primary-50">
                            <p data-stat-izin class="text-lg font-bold text-primary-600">{{ $izin }}</p>
                            <p class="text-[10px] text-primary-600">Izin</p>
                        </div>
                        <div class="rounded-lg p-2 bg-red-50">
                            <p data-stat-alpha class="text-lg font-bold text-red-600">{{ $alpha }}</p>
                            <p class="text-[10px] text-red-600">Alpha</p>
                        </div>
                    </div>

                    @if ($totalStats > 0)
                        <div class="rounded-xl p-4 text-white bg-slate-900">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium">Persentase Kehadiran</span>
                                <span data-persen-badge class="text-xl font-bold text-emerald-400">{{ $persenHadir }}%</span>
                            </div>
                            <div class="w-full rounded-full h-2.5 overflow-hidden bg-white/10">
                                <div data-persen-bar class="h-full rounded-full transition-all duration-700 bg-emerald-400" style="width:{{ $persenHadir }}%"></div>
                            </div>
                            <p data-persen-text class="text-xs mt-2 opacity-70">Kehadiran {{ $persenHadir >= 90 ? 'sangat baik' : ($persenHadir >= 75 ? 'cukup baik' : 'perlu ditingkatkan') }}. {{ $persenHadir >= 90 ? 'Pertahankan!' : '' }}</p>
                        </div>
                    @endif

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm font-semibold text-slate-700">Log Kehadiran Terbaru</h3>
                            <a href="{{ route('orangtua.riwayat', $siswa->id) }}" class="text-xs font-bold uppercase tracking-wide text-primary-700 hover:text-primary-800">Lihat Semua</a>
                        </div>
                        <div data-riwayat class="space-y-2">
                            @forelse($item['riwayat'] as $r)
                                @php
                                    $isLate = $r->status === 'terlambat';
                                    $isPresent = $r->status === 'hadir';
                                    $logBg = $isLate ? 'bg-amber-50' : 'bg-slate-100';
                                    $logTextClass = $isLate ? 'text-amber-700' : 'text-slate-600';
                                @endphp
                                <div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:shadow-sm transition-shadow">
                                    <div class="flex gap-3 items-center">
                                        <div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center shrink-0 {{ $logBg }}">
                                            <span class="text-[9px] font-bold uppercase {{ $logTextClass }}">{{ $r->tanggal->format('M') }}</span>
                                            <span class="text-sm font-bold leading-none text-slate-800">{{ $r->tanggal->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-800">{{ $r->check_out ? 'Pulang Sekolah' : 'Masuk Sekolah' }}</p>
                                            <p class="text-xs text-slate-400">{{ $r->check_out ? 'Checkout selesai' : ($isLate ? 'Terlambat ' . $r->check_in?->diffInMinutes(\Carbon\Carbon::parse($r->tanggal->format('Y-m-d') . ' 07:15')) . ' menit' : 'Tepat waktu') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-sm font-bold text-slate-700">{{ $r->check_in?->format('H:i') ?? '-' }}{{ $r->check_out ? ' - ' . $r->check_out->format('H:i') : '' }}</span>
                                        <span class="text-[10px] uppercase font-medium {{ $isLate ? 'text-amber-700' : ($isPresent ? 'text-emerald-700' : 'text-slate-400') }}">{{ $r->status }}</span>
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

        <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 flex gap-3">
            <span class="material-symbols-outlined shrink-0 text-primary-600 mt-0.5">info</span>
            <div>
                <p class="text-xs font-bold text-primary-700">Informasi</p>
                <p class="text-xs mt-1 text-slate-600 leading-relaxed">Pastikan putra/putri Anda membawa kartu RFID setiap hari untuk pencatatan kehadiran otomatis. Status akan terupdate secara real-time.</p>
            </div>
        </div>
    </div>

    {{-- TAB: JADWAL PELAJARAN --}}
    <div x-show="tab === 'jadwal'" x-cloak>
        @if ($jadwalHariIni->count())
            <section class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 mb-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-base text-primary-700">today</span>
                    <h2 class="text-sm font-bold text-slate-800">Jadwal Hari Ini — {{ $hariIni }}</h2>
                </div>
                <div class="space-y-2">
                    @foreach ($jadwalHariIni->groupBy('anak_nama') as $anakNama => $jadwals)
                        @if (count($data) > 1)
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-3 first:mt-0">{{ $anakNama }}</p>
                        @endif
                        @foreach ($jadwals as $jadwal)
                            <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-100 hover:shadow-sm transition-shadow">
                                <div class="w-14 shrink-0 text-center rounded-lg py-1.5 {{ $jadwal->warna }}">
                                    <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ $jadwal->jam_mulai }}</span>
                                    <span class="block text-[9px] font-medium text-slate-500">-</span>
                                    <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ $jadwal->jam_selesai }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $jadwal->mata_pelajaran }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $jadwal->guru->nama ?? '-' }}</p>
                                </div>
                                <span class="text-[10px] font-medium text-slate-400 shrink-0">{{ $jadwal->ruangan ?? '' }}</span>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </section>
        @endif

        @php
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $jadwalPerHari = $jadwalMingguIni->groupBy('hari');
        @endphp

        @if ($jadwalMingguIni->count())
            <section class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-primary-700">date_range</span>
                        <h2 class="text-sm font-bold text-slate-800">Jadwal Mingguan</h2>
                    </div>
                    @if (count($data) > 0)
                        <a href="{{ route('orangtua.jadwal') }}" class="text-xs font-bold uppercase tracking-wide text-primary-700 hover:text-primary-800">Lihat Semua</a>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach ($hariList as $hari)
                        @php $items = $jadwalPerHari->get($hari, collect()); @endphp
                        @if ($items->isEmpty()) @continue @endif

                        @php $isToday = $hari === $hariIni; @endphp
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-2 h-2 rounded-full {{ $isToday ? 'bg-primary-700' : 'bg-slate-300' }}"></span>
                                <p class="text-xs font-bold uppercase tracking-wider {{ $isToday ? 'text-primary-700' : 'text-slate-400' }}">
                                    {{ $hari }}@if($isToday) <span class="font-normal normal-case tracking-normal">(Hari Ini)</span>@endif
                                </p>
                            </div>
                            <div class="space-y-1.5 ml-4 border-l-2 border-slate-100 pl-4">
                                @foreach ($items->sortBy('jam_mulai') as $jadwal)
                                    <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition-colors
                                        {{ $isToday ? 'bg-primary-50/30 border border-primary-100' : '' }}">
                                        <div class="w-12 shrink-0 text-center rounded py-1 {{ $jadwal->warna }}">
                                            <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ substr($jadwal->jam_mulai, 0, 5) }}</span>
                                            <span class="block text-[8px] text-slate-500">-</span>
                                            <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $jadwal->mata_pelajaran }}</p>
                                            <p class="text-[11px] text-slate-400 truncate">{{ $jadwal->guru->nama ?? '-' }}{{ $jadwal->ruangan ? ' • ' . $jadwal->ruangan : '' }}</p>
                                        </div>
                                        @if (count($data) > 1)
                                            <span class="text-[10px] font-medium text-slate-400 shrink-0 bg-slate-100 px-1.5 py-0.5 rounded">{{ $jadwal->anak_nama }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!$jadwalHariIni->count() && !$jadwalMingguIni->count())
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400 text-3xl">schedule</span>
                </div>
                <h2 class="text-lg font-semibold text-slate-600">Belum ada jadwal</h2>
                <p class="text-sm text-slate-400 mt-1">Jadwal pelajaran belum tersedia untuk kelas anak Anda</p>
            </div>
        @endif
    </div>

    {{-- TAB: KALENDER AKADEMIK --}}
    <div x-show="tab === 'kalender'" x-cloak>
        @if ($kalenderEvents->count())
            @php
                $bulanKal = $today->copy()->startOfMonth();
                $startOfMonth = $bulanKal->copy()->startOfMonth();
                $endOfMonth = $bulanKal->copy()->endOfMonth();
                $startDay = (int) $startOfMonth->dayOfWeek;
                $daysInMonth = $endOfMonth->day;
            @endphp

            <section class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 mb-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-slate-800">{{ $bulanKal->translatedFormat('F Y') }}</h2>
                </div>

                <div class="grid grid-cols-7 gap-px bg-slate-200 rounded-lg overflow-hidden">
                    @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dn)
                        <div class="bg-slate-50 px-1 py-1.5 text-center text-[10px] font-bold text-slate-500 uppercase">{{ $dn }}</div>
                    @endforeach

                    @for($i = 0; $i < $startDay; $i++)
                        <div class="bg-white min-h-[40px] p-0.5 opacity-30"></div>
                    @endfor

                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $date = $bulanKal->copy()->day($d);
                            $dayEvents = $kalenderEvents->filter(fn($e) => $e->isActiveOn($date));
                            $isToday = $date->isToday();
                        @endphp
                        <div class="bg-white min-h-[40px] p-0.5 relative group cursor-default
                            {{ $isToday ? 'bg-primary-50' : 'hover:bg-slate-50' }}">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-[10px] font-semibold
                                {{ $isToday ? 'bg-primary-700 text-white' : 'text-slate-700' }}">
                                {{ $d }}
                            </span>
                            @if($dayEvents->count() > 0)
                                <div class="flex justify-center gap-px mt-px">
                                    @foreach($dayEvents->take(3) as $ev)
                                        <span class="w-1 h-1 rounded-full" style="background:{{ $ev->dot_color }}"></span>
                                    @endforeach
                                </div>
                                <div class="absolute z-50 bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block w-48 bg-slate-900 text-white text-[10px] rounded-lg p-2 shadow-lg pointer-events-none">
                                    @foreach($dayEvents as $ev)
                                        <div class="flex items-center gap-1.5 py-0.5">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:{{ $ev->dot_color }}"></span>
                                            <span class="truncate">{{ $ev->judul }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endfor

                    @php $remaining = 7 - (($startDay + $daysInMonth) % 7); @endphp
                    @if($remaining < 7)
                        @for($i = 0; $i < $remaining; $i++)
                            <div class="bg-white min-h-[40px] opacity-30"></div>
                        @endfor
                    @endif
                </div>
            </section>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 mb-5">
                <div class="flex flex-wrap gap-3 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Libur</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Ujian</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-primary-500"></span> Kegiatan</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Penting</span>
                </div>
            </div>

            <section class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-base text-primary-700">event_note</span>
                    <h2 class="text-sm font-bold text-slate-800">Semua Event</h2>
                </div>
                <div class="space-y-2">
                    @foreach ($kalenderEvents as $event)
                        @php
                            $start = $event->tanggal_mulai;
                            $end = $event->tanggal_selesai;
                            $isRange = $start && $end && !$start->isSameDay($end);
                            $dotColor = $event->dot_color;
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-100 hover:shadow-sm transition-shadow">
                            <div class="w-12 shrink-0 text-center rounded-lg py-1.5" style="background:{{ $dotColor }}">
                                <span class="block text-[10px] font-bold text-white leading-tight">{{ $start->format('d') }}</span>
                                <span class="block text-[9px] font-medium text-white opacity-80">{{ $start->format('M') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $event->judul }}</p>
                                <p class="text-xs text-slate-400">
                                    @if ($isRange)
                                        {{ $start->format('d M') }} – {{ $end->format('d M Y') }}
                                    @else
                                        {{ $start->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <span class="text-[10px] font-medium text-slate-400 shrink-0">{{ ucfirst($event->tipe) }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        @else
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400 text-3xl">event_busy</span>
                </div>
                <h2 class="text-lg font-semibold text-slate-600">Belum ada event</h2>
                <p class="text-sm text-slate-400 mt-1">Belum ada kalender akademik yang tersedia</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<style>
    @keyframes pulse-realtime {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .pulse-change {
        animation: pulse-realtime 0.4s ease-in-out;
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up {
        animation: fade-in-up 0.3s ease-out;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusConfig = {
        hadir: { text: 'HADIR', textClass: 'text-emerald-700', bgClass: 'bg-emerald-50', iconClass: 'text-emerald-600 bg-emerald-100', icon: 'how_to_reg' },
        terlambat: { text: 'TERLAMBAT', textClass: 'text-amber-700', bgClass: 'bg-amber-50', iconClass: 'text-amber-600 bg-amber-100', icon: 'how_to_reg' },
        izin: { text: 'IZIN', textClass: 'text-primary-600', bgClass: 'bg-primary-50', iconClass: 'text-primary-500 bg-primary-100', icon: 'how_to_reg' },
        sakit: { text: 'SAKIT', textClass: 'text-primary-600', bgClass: 'bg-primary-50', iconClass: 'text-primary-500 bg-primary-100', icon: 'how_to_reg' },
        alpha: { text: 'ALPHA', textClass: 'text-red-600', bgClass: 'bg-red-50', iconClass: 'text-red-500 bg-red-100', icon: 'how_to_reg' },
        belum_absen: { text: 'BELUM ABSEN', textClass: 'text-slate-400', bgClass: 'bg-slate-100', iconClass: 'text-slate-400 bg-slate-100', icon: 'hourglass_empty' }
    };

    let previousStatus = {};
    @foreach ($data as $item)
        previousStatus[{{ $item['siswa']->id }}] = '{{ $item['absensi_hari_ini']?->status ?? "belum_absen" }}';
    @endforeach

    function updateCard(siswaId, d) {
        const card = document.querySelector('[data-siswa-id="' + siswaId + '"]');
        if (!card) return;

        const cfg = statusConfig[d.status] || statusConfig['belum_absen'];
        const prev = previousStatus[siswaId];

        if (prev !== d.status) {
            const statusRow = card.querySelector('[data-status-row]');
            if (statusRow) {
                statusRow.className = 'rounded-lg p-4 flex items-center justify-between ' + cfg.textClass + ' ' + cfg.bgClass + ' pulse-change';
            }

            const iconEl = card.querySelector('[data-status-icon-bg]');
            if (iconEl) {
                iconEl.className = 'w-10 h-10 rounded-full flex items-center justify-center ' + cfg.iconClass;
            }

            const iconSymbol = card.querySelector('[data-status-icon]');
            if (iconSymbol) {
                iconSymbol.textContent = cfg.icon;
            }

            const badge = card.querySelector('[data-status-badge]');
            if (badge) {
                badge.textContent = cfg.text;
                badge.className = 'text-base font-bold ' + cfg.textClass;
            }

            previousStatus[siswaId] = d.status;
        }

        const checkInEl = card.querySelector('[data-check-in]');
        if (checkInEl && d.check_in) {
            checkInEl.textContent = d.check_in;
        }

        const checkOutEl = card.querySelector('[data-check-out]');
        if (checkOutEl) {
            checkOutEl.textContent = d.check_out || '-';
        }

        const timeEl = card.querySelector('[data-time]');
        if (timeEl && d.check_in) {
            timeEl.textContent = d.check_in + ' WITA';
        }

        const hadirEl = card.querySelector('[data-stat-hadir]');
        if (hadirEl) hadirEl.textContent = d.total_hadir;

        const terlambatEl = card.querySelector('[data-stat-terlambat]');
        if (terlambatEl) terlambatEl.textContent = d.total_terlambat;

        const izinEl = card.querySelector('[data-stat-izin]');
        if (izinEl) izinEl.textContent = d.total_izin;

        const alphaEl = card.querySelector('[data-stat-alpha]');
        if (alphaEl) alphaEl.textContent = d.total_alpha;

        const totalStats = d.total_hadir + d.total_izin + d.total_alpha + d.total_terlambat;
        const persenHadir = totalStats > 0 ? Math.round((d.total_hadir / totalStats) * 100) : 0;

        const persenBadge = card.querySelector('[data-persen-badge]');
        if (persenBadge) persenBadge.textContent = persenHadir + '%';

        const persenBar = card.querySelector('[data-persen-bar]');
        if (persenBar) persenBar.style.width = persenHadir + '%';

        const persenText = card.querySelector('[data-persen-text]');
        if (persenText) {
            const label = persenHadir >= 90 ? 'sangat baik' : (persenHadir >= 75 ? 'cukup baik' : 'perlu ditingkatkan');
            const advice = persenHadir >= 90 ? ' Pertahankan!' : '';
            persenText.textContent = 'Kehadiran ' + label + '. ' + advice;
        }

        const riwayatContainer = card.querySelector('[data-riwayat]');
        if (riwayatContainer && d.riwayat && d.riwayat.length > 0) {
            riwayatContainer.innerHTML = d.riwayat.map(function(r) {
                const isLate = r.status === 'terlambat';
                const isPresent = r.status === 'hadir';
                const logBg = isLate ? 'bg-amber-50' : 'bg-slate-100';
                const logText = isLate ? 'text-amber-700' : 'text-slate-600';
                const statusColor = isPresent ? 'text-emerald-700' : (isLate ? 'text-amber-700' : 'text-slate-400');
                const timeRange = r.check_in + (r.check_out ? ' - ' + r.check_out : '');

                return '<div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:shadow-sm transition-shadow">' +
                    '<div class="flex gap-3 items-center">' +
                        '<div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center shrink-0 ' + logBg + '">' +
                            '<span class="text-[9px] font-bold uppercase ' + logText + '">' + r.tanggal_short.split(' ')[0] + '</span>' +
                            '<span class="text-sm font-bold leading-none text-slate-800">' + r.tanggal_short.split(' ')[1] + '</span>' +
                        '</div>' +
                        '<div>' +
                            '<p class="text-sm font-medium text-slate-800">' + (r.check_out ? 'Pulang Sekolah' : 'Masuk Sekolah') + '</p>' +
                            '<p class="text-xs text-slate-400">' + (r.check_out ? 'Checkout selesai' : (isLate ? 'Terlambat' : 'Tepat waktu')) + '</p>' +
                        '</div>' +
                    '</div>' +
                    '<div class="text-right">' +
                        '<span class="block text-sm font-bold text-slate-700">' + timeRange + '</span>' +
                        '<span class="text-[10px] uppercase font-medium ' + statusColor + '">' + r.status + '</span>' +
                    '</div>' +
                '</div>';
            }).join('');
        }
    }

    function updateSummary(children) {
        const totalHadir = children.reduce(function(s, c) { return s + c.total_hadir; }, 0);
        const totalTerlambat = children.reduce(function(s, c) { return s + c.total_terlambat; }, 0);
        const totalAlpha = children.reduce(function(s, c) { return s + c.total_alpha; }, 0);

        const hadirSum = document.getElementById('summary-hadir');
        const terlambatSum = document.getElementById('summary-terlambat');
        const alphaSum = document.getElementById('summary-alpha');

        if (hadirSum) hadirSum.textContent = totalHadir;
        if (terlambatSum) terlambatSum.textContent = totalTerlambat;
        if (alphaSum) alphaSum.textContent = totalAlpha;
    }

    function poll() {
        fetch('{{ route("orangtua.realtimeAll") }}')
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.children) {
                    data.children.forEach(function(child) {
                        updateCard(child.siswa_id, child);
                    });
                    updateSummary(data.children);
                }

                const indicator = document.getElementById('realtime-dot');
                if (indicator) {
                    indicator.classList.remove('bg-slate-300');
                    indicator.classList.add('bg-emerald-500');
                    setTimeout(function() {
                        indicator.classList.remove('bg-emerald-500');
                        indicator.classList.add('bg-slate-300');
                    }, 500);
                }
            })
            .catch(function() {});
    }

    setInterval(poll, 3000);
    setTimeout(poll, 1000);
});
</script>
@endsection
