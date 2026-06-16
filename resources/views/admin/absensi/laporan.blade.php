@extends('admin.layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-xl md:text-2xl font-bold">Laporan Absensi</h1>
        <a href="{{ route('admin.absensi.export.laporan', request()->query()) }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
            <label class="block text-xs font-medium mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}"
                class="border rounded-lg px-3 py-1.5 text-sm focus:ring focus:ring-primary-200">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                class="border rounded-lg px-3 py-1.5 text-sm focus:ring focus:ring-primary-200">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Kelas</label>
            <select name="kelas" class="border rounded-lg px-3 py-1.5 text-sm focus:ring focus:ring-primary-200">
                <option value="">Semua Kelas</option>
                @foreach ($kelasList as $k)
                    <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Status</label>
            <select name="status" class="border rounded-lg px-3 py-1.5 text-sm focus:ring focus:ring-primary-200">
                <option value="">Semua</option>
                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fa-solid fa-search"></i> Cari
            </button>
            <a href="{{ route('admin.absensi.laporan') }}"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-1.5 rounded-lg text-sm">
                Reset
            </a>
        </div>
    </form>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="data-table min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">No.</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Kelas</th>
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
                        <td class="px-4 py-2 font-semibold">{{ $absensi->siswa->nama }}</td>
                        <td class="px-4 py-2">{{ $absensi->siswa->kelas }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_in?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_out?->format('H:i') ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @php
                                $statusClass = match($absensi->status) {
                                    'hadir' => 'bg-green-100 text-green-700',
                                    'izin' => 'bg-blue-100 text-blue-700',
                                    'sakit' => 'bg-orange-100 text-orange-700',
                                    'alpha' => 'bg-red-100 text-red-700',
                                    'terlambat' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="{{ $statusClass }} px-2 py-0.5 rounded text-xs font-medium uppercase">
                                {{ $absensi->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($absensis as $absensi)
            @php
                $statusClass = match($absensi->status) {
                    'hadir' => 'bg-green-100 text-green-700',
                    'izin' => 'bg-blue-100 text-blue-700',
                    'sakit' => 'bg-orange-100 text-orange-700',
                    'alpha' => 'bg-red-100 text-red-700',
                    'terlambat' => 'bg-orange-100 text-orange-800',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-gray-800">{{ $absensi->siswa->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $absensi->siswa->kelas }}</p>
                    </div>
                    <span class="{{ $statusClass }} px-2 py-0.5 rounded text-xs font-medium uppercase">
                        {{ $absensi->status }}
                    </span>
                </div>
                <div class="text-xs text-gray-500 mt-1">{{ $absensi->tanggal->format('d/m/Y') }}</div>
                <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                    <div><span class="text-gray-500">Check In:</span> <span class="font-medium">{{ $absensi->check_in?->format('H:i') ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Check Out:</span> <span class="font-medium">{{ $absensi->check_out?->format('H:i') ?? '-' }}</span></div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">Tidak ada data absensi</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $absensis->links() }}</div>
</div>
@endsection
