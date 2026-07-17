@extends('admin.layouts.app')

@section('title', 'Kalender Akademik')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Kalender Akademik</h1>
            <p class="text-gray-500 text-sm">Jadwal libur, ujian, kegiatan, dan hari penting sekolah</p>
        </div>
        <a href="{{ route('admin.kalender.create') }}"
            class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Event
        </a>
    </div>

    {{-- NAVIGASI BULAN --}}
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('admin.kalender.index', ['bulan' => $bulan->copy()->subMonth()->format('Y-m') ]) }}"
                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium transition">
                <i class="fa-solid fa-chevron-left mr-1"></i> {{ $bulan->copy()->subMonth()->translatedFormat('M Y') }}
            </a>

            <div class="text-center">
                <h2 class="text-lg font-bold text-gray-800">{{ $bulan->translatedFormat('F Y') }}</h2>
                <p class="text-xs text-gray-500">{{ $events->count() }} event aktif</p>
            </div>

            <a href="{{ route('admin.kalender.index', ['bulan' => $bulan->copy()->addMonth()->format('Y-m') ]) }}"
                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium transition">
                {{ $bulan->copy()->addMonth()->translatedFormat('M Y') }} <i class="fa-solid fa-chevron-right ml-1"></i>
            </a>
        </div>

        {{-- LEGEND --}}
        <div class="flex flex-wrap gap-3 mb-4 text-xs">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Libur</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Ujian</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-primary-500"></span> Kegiatan</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-purple-500"></span> Penting</span>
        </div>

        {{-- GRID KALENDER --}}
        @php
            $startOfMonth = $bulan->copy()->startOfMonth();
            $endOfMonth = $bulan->copy()->endOfMonth();
            $startDay = (int) $startOfMonth->dayOfWeek;
            $daysInMonth = $endOfMonth->day;
        @endphp

        <div class="grid grid-cols-7 gap-px bg-gray-200 rounded-lg overflow-hidden border border-gray-200">
            {{-- Header hari --}}
            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
                <div class="bg-gray-50 px-2 py-2 text-center text-xs font-bold text-gray-600 uppercase">
                    {{ $dayName }}
                </div>
            @endforeach

            {{-- Kosong sebelum tanggal 1 --}}
            @for($i = 0; $i < $startDay; $i++)
                <div class="bg-white min-h-[80px] md:min-h-[100px] p-1.5 opacity-30"></div>
            @endfor

            {{-- Tanggal --}}
            @for($d = 1; $d <= $daysInMonth; $d++)
                @php
                    $date = $bulan->copy()->day($d);
                    $dayEvents = $events->filter(fn($e) => $e->isActiveOn($date));
                    $isToday = $date->isToday();
                @endphp
                <div class="bg-white min-h-[80px] md:min-h-[100px] p-1.5 transition-colors hover:bg-gray-50 relative">
                    {{-- Nomor tanggal --}}
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold
                        {{ $isToday ? 'bg-primary-500 text-white' : 'text-gray-700' }}">
                        {{ $d }}
                    </span>

                    {{-- Event dots & labels --}}
                    @if($dayEvents->count() > 0)
                        <div class="mt-1 space-y-0.5">
                            @foreach($dayEvents->take(3) as $event)
                                <div class="text-[10px] leading-tight px-1 py-0.5 rounded border truncate
                                    {{ $event->warna }}">
                                    <span class="hidden md:inline">{{ Str::limit($event->judul, 15) }}</span>
                                    <span class="md:hidden">●</span>
                                </div>
                            @endforeach
                            @if($dayEvents->count() > 3)
                                <span class="text-[9px] text-gray-500">+{{ $dayEvents->count() - 3 }} lagi</span>
                            @endif
                        </div>
                    @endif
                </div>
            @endfor

            {{-- Sisa kotak kosong --}}
            @php $remaining = 7 - (($startDay + $daysInMonth) % 7); @endphp
            @if($remaining < 7)
                @for($i = 0; $i < $remaining; $i++)
                    <div class="bg-white min-h-[80px] md:min-h-[100px] p-1.5 opacity-30"></div>
                @endfor
            @endif
        </div>
    </div>

    {{-- DAFTAR EVENT --}}
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">
        <h2 class="text-lg font-bold mb-4">Semua Event</h2>

        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs">No</th>
                        <th class="px-4 py-2 text-left text-xs">Judul</th>
                        <th class="px-4 py-2 text-left text-xs">Tipe</th>
                        <th class="px-4 py-2 text-left text-xs">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-left text-xs">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-left text-xs">Status</th>
                        <th class="px-4 py-2 text-center text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($allEvents as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration + ($allEvents->currentPage() - 1) * $allEvents->perPage() }}</td>
                            <td class="px-4 py-2 font-medium">{{ $item->judul }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold border {{ $item->warna }}">
                                    <i class="{{ $item->icon }} text-[10px]"></i>
                                    {{ ucfirst($item->tipe) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $item->tanggal_mulai->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $item->tanggal_selesai?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if($item->is_active)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.kalender.edit', $item->id) }}"
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg text-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.kalender.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus event ini?')">
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
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada event</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD --}}
        <div class="md:hidden space-y-3">
            @forelse($allEvents as $item)
                <div class="border rounded-lg p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold">{{ $item->judul }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $item->tanggal_mulai->format('d M Y') }}
                                @if($item->tanggal_selesai)
                                    s/d {{ $item->tanggal_selesai->format('d M Y') }}
                                @endif
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold border {{ $item->warna }}">
                            {{ ucfirst($item->tipe) }}
                        </span>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('admin.kalender.edit', $item->id) }}"
                            class="flex-1 bg-primary-500 text-white text-center py-1 rounded-lg text-sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.kalender.destroy', $item->id) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-6">Belum ada event</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $allEvents->links() }}</div>
    </div>

</div>
@endsection
