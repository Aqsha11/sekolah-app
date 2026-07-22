@extends('admin.layouts.app')

@section('title', 'Jadwal Mengajar Saya')

@php
    $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
@endphp

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                @if($guru->photo)
                    <img src="{{ asset('storage/guru/' . $guru->photo) }}" alt="{{ $guru->name }}"
                        class="w-14 h-14 rounded-full object-cover">
                @else
                    <i class="fa-solid fa-chalkboard-user text-primary-600 text-xl"></i>
                @endif
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold">Jadwal Mengajar Saya</h1>
                <p class="text-gray-500 text-sm">{{ $guru->name }} — {{ $guru->subject ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- GRID JADWAL --}}
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">

        @if($jadwals->count() > 0)
            {{-- DESKTOP: Grid Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-24">Jam</th>
                            @foreach($hariList as $h)
                                @php $isToday = Carbon\Carbon::now()->englishDayOfWeek === ucfirst($h); @endphp
                                <th class="px-3 py-3 text-center text-xs font-semibold uppercase
                                    {{ $isToday ? 'bg-primary-50 text-primary-700' : 'text-gray-600' }}">
                                    {{ ucfirst($h) }}
                                    @if($isToday)
                                        <span class="block text-[9px] text-primary-500 font-normal">Hari Ini</span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $jamSlots = $jadwals->pluck('jam_mulai')->merge($jadwals->pluck('jam_selesai'))->sort()->unique()->values();
                        @endphp

                        @foreach($jamSlots as $jam)
                            @php $activeJadwal = $jadwals->filter(fn($j) => $j->jam_mulai <= $jam && $j->jam_selesai > $jam); @endphp
                            @if($activeJadwal->isEmpty()) @continue @endif

                            <tr class="border-t border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-2 text-xs font-mono text-gray-600 align-top pt-3">
                                    {{ substr($jam, 0, 5) }}
                                </td>
                                @foreach($hariList as $h)
                                    @php
                                        $jadwalHari = $activeJadwal->firstWhere('hari', $h);
                                        $isToday = Carbon\Carbon::now()->englishDayOfWeek === ucfirst($h);
                                    @endphp
                                    <td class="px-2 py-2 align-top {{ $isToday ? 'bg-primary-50/30' : '' }}">
                                        @if($jadwalHari)
                                            <div class="rounded-lg border p-2.5 {{ $jadwalHari->warna }} transition-all hover:shadow-sm">
                                                <p class="font-bold text-xs text-gray-800 leading-tight">
                                                    {{ $jadwalHari->mata_pelajaran }}
                                                </p>
                                                <p class="text-[10px] text-gray-500 mt-1">
                                                    <i class="fa-solid fa-door-open mr-0.5"></i>{{ $jadwalHari->ruangan ?? '-' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">
                                                    Kelas: {{ $jadwalHari->kelas->nama_kelas }}
                                                </p>
                                                <span class="text-[10px] text-gray-400 font-mono">
                                                    {{ substr($jadwalHari->jam_mulai, 0, 5) }}-{{ substr($jadwalHari->jam_selesai, 0, 5) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE: List by Day --}}
            <div class="md:hidden space-y-4">
                @foreach($hariList as $h)
                    @php $hariJadwal = $jadwalByHari->get($h, collect()); @endphp
                    @if($hariJadwal->isEmpty()) @continue @endif

                    @php $isToday = Carbon\Carbon::now()->englishDayOfWeek === ucfirst($h); @endphp
                    <div class="border rounded-lg {{ $isToday ? 'border-primary-300 bg-primary-50/30' : '' }}">
                        <div class="px-4 py-2 {{ $isToday ? 'bg-primary-100' : 'bg-gray-50' }} rounded-t-lg">
                            <h3 class="font-bold text-sm {{ $isToday ? 'text-primary-700' : 'text-gray-800' }} uppercase">
                                {{ $h }}
                                @if($isToday) <span class="text-[10px] font-normal">(Hari Ini)</span> @endif
                            </h3>
                        </div>
                        <div class="p-3 space-y-2">
                            @foreach($hariJadwal->sortBy('jam_mulai') as $jadwal)
                                <div class="border rounded-lg p-3 {{ $jadwal->warna }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-bold text-sm">{{ $jadwal->mata_pelajaran }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                Kelas: {{ $jadwal->kelas->nama_kelas }}
                                            </p>
                                            @if($jadwal->ruangan)
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    <i class="fa-solid fa-door-open mr-1"></i>{{ $jadwal->ruangan }}
                                                </p>
                                            @endif
                                        </div>
                                        <span class="text-xs font-mono text-gray-500">
                                            {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3 block"></i>
                Belum ada jadwal mengajar untuk Anda.
            </div>
        @endif
    </div>

</div>
@endsection
