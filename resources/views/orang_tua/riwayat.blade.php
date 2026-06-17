@extends('admin.layouts.app')

@section('title', 'Riwayat Absensi - ' . $siswa->nama)

@section('content')
<style>
    .m3-card {
        background: #ffffff;
        border: 1px solid #c4c5d5;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
</style>

<div class="max-w-3xl mx-auto space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Riwayat Absensi</h1>
            <p class="text-sm text-slate-500">{{ $siswa->nama }} — {{ $siswa->kelas }} ({{ $siswa->nis }})</p>
        </div>
        <a href="{{ route('orangtua.dashboard') }}"
           class="inline-flex items-center gap-1 text-sm font-medium" style="color:#00288e">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="m3-card p-4 flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Filter Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                   class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:outline-none"
                   style="focus:ring-color:#00288e">
        </div>
        <button type="submit"
                class="px-4 py-1.5 rounded-lg text-sm text-white font-medium transition-colors"
                style="background:#00288e">
            Tampilkan
        </button>
    </form>

    {{-- Stat Cards --}}
    @php
        $totalHadir = $absensis->whereIn('status', ['hadir', 'terlambat'])->count();
        $totalTerlambat = $absensis->where('status', 'terlambat')->count();
        $totalIzin = $absensis->whereIn('status', ['izin', 'sakit'])->count();
        $totalAlpha = $absensis->where('status', 'alpha')->count();
    @endphp
    <div class="grid grid-cols-4 gap-3">
        <div class="m3-card p-3 text-center" style="border-color:#d0e8d8">
            <p class="text-xl font-bold" style="color:#006c49">{{ $totalHadir }}</p>
            <p class="text-[10px] font-medium" style="color:#006c49">Hadir</p>
        </div>
        <div class="m3-card p-3 text-center" style="border-color:#f0d8c0">
            <p class="text-xl font-bold" style="color:#6b4200">{{ $totalTerlambat }}</p>
            <p class="text-[10px] font-medium" style="color:#6b4200">Terlambat</p>
        </div>
        <div class="m3-card p-3 text-center" style="border-color:#c0d8f0">
            <p class="text-xl font-bold" style="color:#005caa">{{ $totalIzin }}</p>
            <p class="text-[10px] font-medium" style="color:#005caa">Izin/Sakit</p>
        </div>
        <div class="m3-card p-3 text-center" style="border-color:#f0d0d0">
            <p class="text-xl font-bold" style="color:#ba1a1a">{{ $totalAlpha }}</p>
            <p class="text-[10px] font-medium" style="color:#ba1a1a">Alpha</p>
        </div>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden md:block m3-card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100" style="background:#f4f2fc">
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">No.</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Check In</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Check Out</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($absensis as $absensi)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage() }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $absensi->check_in?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $absensi->check_out?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $sc = match($absensi->status) {
                                    'hadir' => ['bg' => '#e6f7f0', 'text' => '#006c49'],
                                    'izin' => ['bg' => '#e0f0ff', 'text' => '#005caa'],
                                    'sakit' => ['bg' => '#fff0e0', 'text' => '#6b4200'],
                                    'alpha' => ['bg' => '#ffe0de', 'text' => '#ba1a1a'],
                                    'terlambat' => ['bg' => '#fff0e0', 'text' => '#6b4200'],
                                    default => ['bg' => '#f0f0f4', 'text' => '#444653'],
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase"
                                  style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}">
                                {{ $absensi->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards --}}
    <div class="md:hidden space-y-2">
        @forelse($absensis as $absensi)
            @php
                $sc = match($absensi->status) {
                    'hadir' => ['bg' => '#e6f7f0', 'text' => '#006c49'],
                    'izin' => ['bg' => '#e0f0ff', 'text' => '#005caa'],
                    'sakit' => ['bg' => '#fff0e0', 'text' => '#6b4200'],
                    'alpha' => ['bg' => '#ffe0de', 'text' => '#ba1a1a'],
                    'terlambat' => ['bg' => '#fff0e0', 'text' => '#6b4200'],
                    default => ['bg' => '#f0f0f4', 'text' => '#444653'],
                };
            @endphp
            <div class="m3-card p-4 flex items-center justify-between">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 rounded-lg flex flex-col items-center justify-center shrink-0"
                         style="background:{{ $sc['bg'] }}">
                        <span class="text-[9px] font-bold uppercase" style="color:{{ $sc['text'] }}">{{ $absensi->tanggal->format('M') }}</span>
                        <span class="text-sm font-bold leading-none" style="color:{{ $sc['text'] }}">{{ $absensi->tanggal->format('d') }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $absensi->check_out ? 'Pulang' : 'Masuk' }}</p>
                        <p class="text-xs text-slate-400">{{ $absensi->check_in?->format('H:i') ?? '-' }}{{ $absensi->check_out ? ' - ' . $absensi->check_out->format('H:i') : '' }}</p>
                    </div>
                </div>
                <span class="text-[11px] font-semibold uppercase px-2.5 py-1 rounded-full"
                      style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}">
                    {{ $absensi->status }}
                </span>
            </div>
        @empty
            <div class="m3-card p-8 text-center">
                <p class="text-slate-400">Tidak ada data absensi</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-2">{{ $absensis->links() }}</div>
</div>
@endsection
