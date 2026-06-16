@extends('admin.layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl md:text-2xl font-bold">Monitoring Kehadiran</h1>
                <p class="text-gray-500 text-sm">{{ $today->format('d F Y') }}</p>
            </div>
        </div>

        @if (count($data) === 0)
            <div class="bg-white p-8 rounded-xl shadow text-center">
                <div class="text-5xl mb-4">👶</div>
                <h2 class="text-lg font-semibold text-gray-600">Belum ada data anak</h2>
                <p class="text-gray-400 text-sm">Hubungi sekolah untuk menautkan data anak Anda</p>
            </div>
        @endif

        {{-- Total Siswa Card --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-users text-primary-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ count($data) }}</p>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                </div>
            </div>
            @php
                $totalHadirSemua = collect($data)->sum('total_hadir');
                $totalAlphaSemua = collect($data)->sum('total_alpha');
            @endphp
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalHadirSemua }}</p>
                    <p class="text-sm text-gray-500">Total Hadir</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-clock text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ collect($data)->sum('total_terlambat') }}</p>
                    <p class="text-sm text-gray-500">Total Terlambat</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-xmark text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAlphaSemua }}</p>
                    <p class="text-sm text-gray-500">Total Alpha</p>
                </div>
            </div>
        </div>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($data as $item)
                @php
                    $siswa = $item['siswa'];
                    $absensi = $item['absensi_hari_ini'];
                    $hadir = $item['total_hadir'];
                    $terlambat = $item['total_terlambat'];
                    $izin = $item['total_izin'];
                    $alpha = $item['total_alpha'];
                    $total = $hadir + $izin + $alpha;
                    $persenHadir = $total > 0 ? round(($hadir / $total) * 100) : 0;
                @endphp

                <div class="bg-white rounded-xl shadow overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-primary-900 px-4 py-3" data-siswa-header="{{ $siswa->nama }}">
                        <h3 class="text-white font-bold text-lg">{{ $siswa->nama }}</h3>
                        <p class="text-white/90 text-sm">{{ $siswa->kelas }} - {{ $siswa->jurusan }}</p>
                    </div>

                    {{-- Status Hari Ini --}}
                    <div class="px-4 py-3 border-b">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Hari Ini</p>
                        @if ($absensi)
                            <div class="flex items-center gap-3">
                                @if ($absensi->status === 'hadir')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">✅
                                        Hadir</span>
                                @elseif ($absensi->status === 'terlambat')
                                    <span
                                        class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">⚠️
                                        Terlambat</span>
                                @elseif ($absensi->status === 'izin')
                                    <span
                                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">📝
                                        Izin</span>
                                @elseif ($absensi->status === 'sakit')
                                    <span
                                        class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">🤒
                                        Sakit</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">❌
                                        Alpha</span>
                                @endif
                            </div>
                            <div class="flex gap-4 mt-2 text-sm text-gray-500">
                                <div>
                                    <span class="text-gray-400">Check In:</span>
                                    <span class="font-medium">{{ $absensi->check_in?->format('H:i') ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">Check Out:</span>
                                    <span class="font-medium">{{ $absensi->check_out?->format('H:i') ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                <span class="text-gray-500 text-sm">Belum absen hari ini</span>
                            </div>
                        @endif
                    </div>

                    {{-- Stats --}}
                    <div class="px-4 py-3 border-b">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rekap Kehadiran</p>
                        <div class="grid grid-cols-4 gap-2 text-center">
                            <div class="bg-green-50 rounded-lg p-2">
                                <p class="text-lg font-bold text-green-600">{{ $hadir }}</p>
                                <p class="text-[10px] text-green-500">Hadir</p>
                            </div>
                            <div class="bg-orange-50 rounded-lg p-2">
                                <p class="text-lg font-bold text-orange-600">{{ $terlambat }}</p>
                                <p class="text-[10px] text-orange-500">Terlambat</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-2">
                                <p class="text-lg font-bold text-blue-600">{{ $izin }}</p>
                                <p class="text-[10px] text-blue-500">Izin/Sakit</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-2">
                                <p class="text-lg font-bold text-red-600">{{ $alpha }}</p>
                                <p class="text-[10px] text-red-500">Alpha</p>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        @if ($total > 0)
                            <div class="mt-3">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>Kehadiran</span>
                                    <span>{{ $persenHadir }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500"
                                        style="width: {{ $persenHadir }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Riwayat Terbaru --}}
                    <div class="px-4 py-3 border-b">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Riwayat Terbaru</p>
                        <div class="space-y-1.5">
                            @forelse($item['riwayat'] as $r)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ $r->tanggal->format('d/m/Y') }}</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-gray-500 text-xs">{{ $r->check_in?->format('H:i') ?? '-' }} - {{ $r->check_out?->format('H:i') ?? '-' }}</span>
                                        @php
                                            $rc = match($r->status) {
                                                'hadir' => 'bg-green-100 text-green-700',
                                                'izin' => 'bg-blue-100 text-blue-700',
                                                'sakit' => 'bg-orange-100 text-orange-700',
                                                'alpha' => 'bg-red-100 text-red-700',
                                                'terlambat' => 'bg-orange-100 text-orange-800',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="{{ $rc }} px-2 py-0.5 rounded text-[10px] font-medium uppercase">{{ $r->status }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-sm">Belum ada riwayat</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="px-4 py-3">
                        <a href="{{ route('orangtua.riwayat', $siswa->id) }}"
                            class="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                            <i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat Lengkap
                        </a>
                    </div>
                </div>
            @endforeach
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

        // Live clock WITA
        function updateClock() {
            const now = waktuWITA();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            const el = document.querySelector('p.text-gray-500.text-sm');
            if (el) el.innerHTML = `${jam}:${menit}:${detik} WITA &middot; {{ $today->format('d F Y') }}`;
        }
        setInterval(updateClock, 1000);

        // Real-time polling update UI every 15s
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
                            // Find the card for this student and update status
                            const cards = document.querySelectorAll('[data-siswa-header]');
                            for (const card of cards) {
                                if (card.dataset.siswaHeader === data.siswa) {
                                    const statusEl = card.parentElement.querySelector(
                                        '.rounded-full');
                                    if (statusEl) {
                                        if (data.status === 'hadir') {
                                            statusEl.className =
                                                'bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium';
                                            statusEl.textContent = '✅ Hadir';
                                        } else if (data.status === 'terlambat') {
                                            statusEl.className =
                                                'bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium';
                                            statusEl.textContent = '⚠️ Terlambat';
                                        } else if (data.status === 'belum_absen') {
                                            statusEl.className =
                                                'bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-sm font-medium';
                                            statusEl.textContent = '⏳ Belum Absen';
                                        }
                                    }
                                    const timeEls = card.parentElement.querySelectorAll(
                                        '.font-medium');
                                    if (timeEls.length >= 2) {
                                        timeEls[0].textContent = data.check_in || '-';
                                    }
                                    break;
                                }
                            }
                        });
                }, 15000);
            });
        });
    </script>
@endsection
