@extends('admin.layouts.app')

@section('title', 'Riwayat Absensi - ' . $siswa->nama)

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Riwayat Absensi</h1>
            <p class="text-gray-500 text-sm">{{ $siswa->nama }} - {{ $siswa->kelas }} ({{ $siswa->nis }})</p>
        </div>
        <a href="{{ route('orangtua.dashboard') }}"
            class="text-primary-600 hover:text-primary-700 text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Filter Bulan --}}
    <form method="GET" class="flex gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
            <label class="block text-xs font-medium mb-1">Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                class="border rounded-lg px-3 py-1.5 text-sm focus:ring focus:ring-primary-200">
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fa-solid fa-filter"></i> Tampilkan
            </button>
        </div>
    </form>

    {{-- Stats --}}
    @php
        $totalHadir = $absensis->whereIn('status', ['hadir', 'terlambat'])->count();
        $totalTerlambat = $absensis->where('status', 'terlambat')->count();
        $totalIzin = $absensis->whereIn('status', ['izin', 'sakit'])->count();
        $totalAlpha = $absensis->where('status', 'alpha')->count();
    @endphp
    <div class="grid grid-cols-4 gap-3 mb-6">
        <div class="bg-green-50 rounded-lg p-3 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $totalHadir }}</p>
            <p class="text-xs text-green-500">Hadir</p>
        </div>
        <div class="bg-orange-50 rounded-lg p-3 text-center">
            <p class="text-2xl font-bold text-orange-600">{{ $totalTerlambat }}</p>
            <p class="text-xs text-orange-500">Terlambat</p>
        </div>
        <div class="bg-blue-50 rounded-lg p-3 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $totalIzin }}</p>
            <p class="text-xs text-blue-500">Izin/Sakit</p>
        </div>
        <div class="bg-red-50 rounded-lg p-3 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $totalAlpha }}</p>
            <p class="text-xs text-red-500">Alpha</p>
        </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="data-table min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">No.</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Check In</th>
                    <th class="px-4 py-2 text-left">Check Out</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($absensis as $absensi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage() }}</td>
                        <td class="px-4 py-2">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_in?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_out?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @php
                                $sc = match($absensi->status) {
                                    'hadir' => 'bg-green-100 text-green-700',
                                    'izin' => 'bg-blue-100 text-blue-700',
                                    'sakit' => 'bg-orange-100 text-orange-700',
                                    'alpha' => 'bg-red-100 text-red-700',
                                    'terlambat' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="{{ $sc }} px-2 py-0.5 rounded text-xs font-medium uppercase">
                                {{ $absensi->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($absensis as $absensi)
            @php
                $sc = match($absensi->status) {
                    'hadir' => 'bg-green-100 text-green-700',
                    'izin' => 'bg-blue-100 text-blue-700',
                    'sakit' => 'bg-orange-100 text-orange-700',
                    'alpha' => 'bg-red-100 text-red-700',
                    'terlambat' => 'bg-orange-100 text-orange-800',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-800">{{ $absensi->tanggal->format('d/m/Y') }}</span>
                    <span class="{{ $sc }} px-2 py-0.5 rounded text-xs font-medium uppercase">{{ $absensi->status }}</span>
                </div>
                <div class="flex gap-4 mt-2 text-sm text-gray-500">
                    <span><span class="text-gray-400">Check In:</span> {{ $absensi->check_in?->format('H:i') ?? '-' }}</span>
                    <span><span class="text-gray-400">Check Out:</span> {{ $absensi->check_out?->format('H:i') ?? '-' }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">Tidak ada data absensi</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $absensis->links() }}</div>
</div>
@endsection
