@extends('admin.layouts.app')

@section('title', 'Jadwal Pelajaran')

@php
    $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
@endphp

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Jadwal Pelajaran</h1>
            <p class="text-gray-500 text-sm">Atur jadwal belajar mengajar per kelas</p>
        </div>
        <a href="{{ route('admin.jadwal.create') }}"
            class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    {{-- FILTER KELAS --}}
    <div class="bg-white p-4 rounded-xl shadow">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold mb-1">Filter Kelas</label>
                <select name="kelas_id" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- GRID JADWAL --}}
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">
                @if($selectedKelas)
                    Jadwal: {{ $kelasList->firstWhere('id', $selectedKelas)?->nama_kelas }}
                @else
                    Semua Jadwal
                @endif
            </h2>
            <div class="text-sm text-gray-500">{{ $jadwals->count() }}, jadwal</div>
        </div>

        @if($jadwals->count() > 0)
            {{-- DESKTOP: Grid Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-24">Jam</th>
                            @foreach($hariList as $h)
                                <th class="px-3 py-3 text-center text-xs font-semibold text-gray-600 uppercase">{{ ucfirst($h) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $jamSlots = $jadwals->pluck('jam_mulai')->merge($jadwals->pluck('jam_selesai'))->sort()->unique()->values();
                        @endphp

                        @foreach($jamSlots as $jam)
                            @php
                                $activeJadwal = $jadwals->filter(fn($j) => $j->jam_mulai <= $jam && $j->jam_selesai > $jam);
                            @endphp
                            @if($activeJadwal->isEmpty()) @continue @endif

                            <tr class="border-t border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-2 text-xs font-mono text-gray-600 align-top pt-3">
                                    {{ substr($jam, 0, 5) }}
                                </td>
                                @foreach($hariList as $h)
                                    @php
                                        $jadwalHari = $activeJadwal->firstWhere('hari', $h);
                                    @endphp
                                    <td class="px-2 py-2 align-top">
                                        @if($jadwalHari)
                                            <div class="rounded-lg border p-2.5 {{ $jadwalHari->warna }} transition-all hover:shadow-sm">
                                                <p class="font-bold text-xs text-gray-800 leading-tight">
                                                    {{ $jadwalHari->mata_pelajaran }}
                                                </p>
                                                <p class="text-[10px] text-gray-500 mt-1">
                                                    <i class="fa-solid fa-user-tie mr-0.5"></i>
                                                    {{ Str::limit($jadwalHari->guru->name, 18) }}
                                                </p>
                                                <div class="flex items-center justify-between mt-1.5">
                                                    <span class="text-[10px] text-gray-400 font-mono">
                                                        {{ substr($jadwalHari->jam_mulai, 0, 5) }}-{{ substr($jadwalHari->jam_selesai, 0, 5) }}
                                                    </span>
                                                    @if($jadwalHari->ruangan)
                                                        <span class="text-[10px] text-gray-400">
                                                            <i class="fa-solid fa-door-open mr-0.5"></i>{{ $jadwalHari->ruangan }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if(!$selectedKelas)
                                                    <p class="text-[10px] text-primary-600 font-semibold mt-1">
                                                        {{ $jadwalHari->kelas->nama_kelas }}
                                                    </p>
                                                @endif
                                                <div class="flex gap-1 mt-1.5">
                                                    <a href="{{ route('admin.jadwal.edit', $jadwalHari->id) }}"
                                                        class="text-primary-600 hover:text-primary-800" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                    </a>
                                                    <form action="{{ route('admin.jadwal.destroy', $jadwalHari->id) }}" method="POST"
                                                        onsubmit="return confirm('Hapus?')">
                                                        @csrf @method('DELETE')
                                                        <button class="text-red-600 hover:text-red-800" title="Hapus">
                                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3 block"></i>
                @if($selectedKelas)
                    Belum ada jadwal untuk kelas ini.
                @else
                    Belum ada jadwal pelajaran.
                @endif
                <a href="{{ route('admin.jadwal.create') }}" class="text-primary-500 hover:underline mt-2 inline-block">
                    Tambah jadwal sekarang
                </a>
            </div>
        @endif

        {{-- MOBILE: List by Day --}}
        <div class="md:hidden space-y-4 mt-4">
            @foreach($hariList as $h)
                @php $hariJadwal = $jadwalByHari->get($h, collect()); @endphp
                @if($hariJadwal->isEmpty()) @continue @endif

                <div>
                    <h3 class="font-bold text-sm text-gray-800 mb-2 uppercase">{{ $h }}</h3>
                    <div class="space-y-2">
                        @foreach($hariJadwal->sortBy('jam_mulai') as $jadwal)
                            <div class="border rounded-lg p-3 {{ $jadwal->warna }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-sm">{{ $jadwal->mata_pelajaran }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            <i class="fa-solid fa-user-tie mr-1"></i>{{ $jadwal->guru->name }}
                                        </p>
                                        @if(!$selectedKelas)
                                            <p class="text-xs text-primary-600 font-semibold mt-0.5">
                                                Kelas: {{ $jadwal->kelas->nama_kelas }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="text-xs font-mono text-gray-500">
                                        {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                    </span>
                                </div>
                                @if($jadwal->ruangan)
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fa-solid fa-door-open mr-1"></i>{{ $jadwal->ruangan }}
                                    </p>
                                @endif
                                <div class="flex gap-2 mt-2">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                                        class="text-primary-600 hover:text-primary-800" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
