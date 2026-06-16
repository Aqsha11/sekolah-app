@extends('admin.layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-xl md:text-2xl font-bold">Absensi Siswa</h1>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.absensi.export.excel', request()->query()) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.absensi.create') }}"
                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fa-solid fa-plus"></i> Catat Manual
            </a>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
            <label class="block text-xs font-medium mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}"
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
        <div class="flex items-end">
            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-1.5 rounded-lg text-sm">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </div>
    </form>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="data-table min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">No.</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Kelas</th>
                    <th class="px-4 py-2 text-left">Check In</th>
                    <th class="px-4 py-2 text-left">Check Out</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-`">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($absensis as $absensi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage() }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $absensi->siswa->nama }}</td>
                        <td class="px-4 py-2">{{ $absensi->siswa->kelas }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_in?->format('H:i:s') ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $absensi->check_out?->format('H:i:s') ?? '-' }}</td>
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
                        <td class="px-4 py-2 text-`">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.absensi.edit', $absensi->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.absensi.destroy', $absensi->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus absensi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            Belum ada data absensi untuk tanggal ini
                        </td>
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
                <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                    <div><span class="text-gray-500">Check In:</span> <span class="font-medium">{{ $absensi->check_in?->format('H:i:s') ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Check Out:</span> <span class="font-medium">{{ $absensi->check_out?->format('H:i:s') ?? '-' }}</span></div>
                </div>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('admin.absensi.edit', $absensi->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1.5 rounded-lg text-sm">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('admin.absensi.destroy', $absensi->id) }}" method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus absensi ini?')">
                        @csrf @method('DELETE')
                        <button class="w-full bg-red-600 text-white py-1.5 rounded-lg text-sm">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">Belum ada data absensi untuk tanggal ini</div>
        @endforelse
    </div>

    <div class="mt-4 flex items-center justify-between">
        <div>{{ $absensis->links() }}</div>
        <div class="text-xs text-gray-400 flex items-center gap-2">
            <span id="live-time-admin"></span>
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span>Live</span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function waktuWITA() {
        const now = new Date();
        const utc = now.getTime() + now.getTimezoneOffset() * 60000;
        return new Date(utc + 8 * 3600000);
    }

    function updateAdminClock() {
        const now = waktuWITA();
        const jam = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('live-time-admin');
        if (el) el.textContent = `${jam}:${menit}:${detik} WITA`;
    }
    updateAdminClock();
    setInterval(updateAdminClock, 1000);

    // Auto-refresh every 30s
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection
