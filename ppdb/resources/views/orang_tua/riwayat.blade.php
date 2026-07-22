@extends('admin.layouts.app')

@section('title', 'Riwayat Absensi - ' . $siswa->nama)
@section('hideSidebar', true)

@section('content')

<div class="max-w-4xl mx-auto space-y-6 pb-10">

    {{-- Back Navigation --}}
    <a href="{{ route('orangtua.dashboard') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-primary-700 transition-colors">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Kembali ke Dashboard
    </a>

    {{-- Student Info Card --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="h-2 bg-gradient-to-r from-primary-600 to-primary-400"></div>
        <div class="p-6 flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                <span class="text-2xl font-bold">{{ substr($siswa->nama, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-xl font-bold text-slate-900 truncate">{{ $siswa->nama }}</h1>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1.5">
                    <span class="inline-flex items-center gap-1 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">class</span>
                        {{ $siswa->kelas }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-sm">badge</span>
                        NIS: {{ $siswa->nis }}
                    </span>
                </div>
            </div>
            @php
                $total = $absensis->total();
                $totalItems = $absensis->count();
            @endphp
            <div class="text-right shrink-0">
                <p class="text-2xl font-black text-primary-700">{{ $total }}</p>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Total Data</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-white border border-slate-200 rounded-xl p-4 flex flex-wrap items-end gap-3 shadow-sm">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Filter Bulan</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                    <span class="material-symbols-outlined text-base">calendar_today</span>
                </span>
                <input type="month" name="bulan" value="{{ $bulan }}" placeholder="Pilih bulan"
                       class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:outline-none transition">
            </div>
        </div>
        <button type="submit"
                class="px-5 py-2 rounded-lg text-sm font-semibold text-white bg-primary-700 hover:bg-primary-800 transition-colors flex items-center gap-1.5">
            <span class="material-symbols-outlined text-base">filter_list</span>
            Tampilkan
        </button>
    </form>

    {{-- Stat Cards --}}
    @php
        $totalHadir = $absensis->getCollection()->whereIn('status', ['hadir', 'terlambat'])->count();
        $totalTerlambat = $absensis->getCollection()->where('status', 'terlambat')->count();
        $totalIzin = $absensis->getCollection()->whereIn('status', ['izin', 'sakit'])->count();
        $totalAlpha = $absensis->getCollection()->where('status', 'alpha')->count();
        $totalAll = $totalHadir + $totalIzin + $totalAlpha;
        $persenHadir = $totalAll > 0 ? round(($totalHadir / $totalAll) * 100) : 0;
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white border border-emerald-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-50 rounded-bl-[2rem]"></div>
            <div class="relative">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center mb-2.5">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                </div>
                <p class="text-2xl font-black text-emerald-700">{{ $totalHadir }}</p>
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mt-0.5">Hadir</p>
            </div>
        </div>
        <div class="bg-white border border-amber-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-amber-50 rounded-bl-[2rem]"></div>
            <div class="relative">
                <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center mb-2.5">
                    <span class="material-symbols-outlined text-amber-600 text-lg">schedule</span>
                </div>
                <p class="text-2xl font-black text-amber-700">{{ $totalTerlambat }}</p>
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mt-0.5">Terlambat</p>
            </div>
        </div>
        <div class="bg-white border border-primary-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-primary-50 rounded-bl-[2rem]"></div>
            <div class="relative">
                <div class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center mb-2.5">
                    <span class="material-symbols-outlined text-primary-600 text-lg">info</span>
                </div>
                <p class="text-2xl font-black text-primary-700">{{ $totalIzin }}</p>
                <p class="text-[10px] font-bold text-primary-600 uppercase tracking-wider mt-0.5">Izin / Sakit</p>
            </div>
        </div>
        <div class="bg-white border border-red-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-red-50 rounded-bl-[2rem]"></div>
            <div class="relative">
                <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center mb-2.5">
                    <span class="material-symbols-outlined text-red-600 text-lg">cancel</span>
                </div>
                <p class="text-2xl font-black text-red-600">{{ $totalAlpha }}</p>
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider mt-0.5">Alpha</p>
            </div>
        </div>
    </div>

    {{-- Attendance Percentage --}}
    @if($totalAll > 0)
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-600 text-lg">insights</span>
                <h3 class="text-sm font-bold text-slate-700">Tingkat Kehadiran</h3>
            </div>
            <span class="text-lg font-black {{ $persenHadir >= 90 ? 'text-emerald-600' : ($persenHadir >= 75 ? 'text-amber-600' : 'text-red-600') }}">
                {{ $persenHadir }}%
            </span>
        </div>
        <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-700 {{ $persenHadir >= 90 ? 'bg-emerald-500' : ($persenHadir >= 75 ? 'bg-amber-500' : 'bg-red-500') }}"
                 style="width: {{ $persenHadir }}%"></div>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            @if($persenHadir >= 90)
                Kehadiran sangat baik. Pertahankan!
            @elseif($persenHadir >= 75)
                Kehadiran cukup baik. Masih bisa ditingkatkan.
            @else
                Kehadiran perlu ditingkatkan. Pantau terus.
            @endif
        </p>
    </div>
    @endif

    {{-- Desktop Table --}}
    <div class="hidden md:block bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-slate-400">history</span>
                Detail Kehadiran
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Hari</th>
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Check In</th>
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Check Out</th>
                        <th class="text-left px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($absensis as $absensi)
                        @php
                            $sc = match($absensi->status) {
                                'hadir' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/50',
                                'izin' => 'bg-primary-50 text-primary-700 ring-1 ring-primary-200/50',
                                'sakit' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/50',
                                'alpha' => 'bg-red-50 text-red-700 ring-1 ring-red-200/50',
                                'terlambat' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/50',
                                default => 'bg-slate-100 text-slate-600',
                            };
                            $dotColor = match($absensi->status) {
                                'hadir' => 'bg-emerald-500',
                                'izin', 'sakit' => 'bg-primary-500',
                                'alpha' => 'bg-red-500',
                                'terlambat' => 'bg-amber-500',
                                default => 'bg-slate-400',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage() }}</td>
                            <td class="px-5 py-3.5">
                                <span class="font-semibold text-slate-800">{{ $absensi->tanggal->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $absensi->tanggal->locale('id')->isoFormat('dddd') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1 text-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $absensi->check_in?->format('H:i') ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($absensi->check_out)
                                    <span class="inline-flex items-center gap-1 text-slate-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        {{ $absensi->check_out->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $sc }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $absensi->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <span class="material-symbols-outlined text-4xl text-slate-200 block mb-2">event_busy</span>
                                <p class="text-sm text-slate-400">Tidak ada data absensi untuk bulan ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="md:hidden space-y-2">
        <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2 px-1">
            <span class="material-symbols-outlined text-base text-slate-400">history</span>
            Detail Kehadiran
        </h3>
        @forelse($absensis as $absensi)
            @php
                $sc = match($absensi->status) {
                    'hadir' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                    'izin' => ['bg' => 'bg-primary-50', 'text' => 'text-primary-700', 'dot' => 'bg-primary-500'],
                    'sakit' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                    'alpha' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                    'terlambat' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                    default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400'],
                };
            @endphp
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex gap-3">
                        <div class="w-12 h-12 rounded-xl {{ $sc['bg'] }} flex flex-col items-center justify-center shrink-0">
                            <span class="text-[9px] font-bold uppercase {{ $sc['text'] }}">{{ $absensi->tanggal->format('M') }}</span>
                            <span class="text-base font-black leading-none {{ $sc['text'] }}">{{ $absensi->tanggal->format('d') }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $absensi->tanggal->locale('id')->isoFormat('dddd') }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                @if($absensi->check_in)
                                    <span class="text-xs text-slate-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        In: {{ $absensi->check_in->format('H:i') }}
                                    </span>
                                @endif
                                @if($absensi->check_out)
                                    <span class="text-xs text-slate-500 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Out: {{ $absensi->check_out->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sc['bg'] }} {{ $sc['text'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                        {{ $absensi->status }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-xl p-10 text-center shadow-sm">
                <span class="material-symbols-outlined text-4xl text-slate-200 block mb-2">event_busy</span>
                <p class="text-sm text-slate-400">Tidak ada data absensi untuk bulan ini</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($absensis->hasPages())
    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm">
        {{ $absensis->links() }}
    </div>
    @endif
</div>
@endsection
