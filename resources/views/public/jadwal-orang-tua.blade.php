@extends('admin.layouts.app')

@section('title', 'Jadwal Pelajaran Anak')
@section('hideSidebar', true)

@php
    $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    $hariNameMap = ['senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu', 'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu'];
    $todayHari = strtolower(Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
@endphp

@section('content')

<div class="max-w-5xl mx-auto space-y-6 pb-10">

    {{-- Back Navigation --}}
    <a href="{{ route('orangtua.dashboard') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-primary-700 transition-colors">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Kembali ke Dashboard
    </a>

    {{-- Header Card --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="h-2 bg-gradient-to-r from-primary-600 to-primary-400"></div>
        <div class="p-6 flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">menu_book</span>
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-slate-900">Jadwal Pelajaran Anak</h1>
                <p class="text-sm text-slate-500 mt-1">
                    @foreach($anakSiswa as $anak)
                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                            {{ $anak->nama }} — {{ $anak->kelas }}
                        </span>
                        {{ !$loop->last ? ' ' : '' }}
                    @endforeach
                </p>
            </div>
            @if($jadwals->count() > 0)
                <div class="text-right shrink-0">
                    <p class="text-2xl font-black text-primary-700">{{ $jadwals->count() }}</p>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Mata Pelajaran</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Filter --}}
    @if($kelasList->count() > 1)
    <form method="GET" class="bg-white border border-slate-200 rounded-xl p-4 flex flex-wrap items-end gap-3 shadow-sm">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Filter Kelas Anak</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                    <span class="material-symbols-outlined text-base">class</span>
                </span>
                <select name="kelas_id" class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:outline-none transition appearance-none"
                    onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    @endif

    @if($jadwals->count() > 0)

        {{-- Today's Schedule Quick View --}}
        @php
            $todayJadwals = $jadwals->filter(fn($j) => strtolower($j->hari) === $todayHari)->sortBy('jam_mulai');
        @endphp
        @if($todayJadwals->count() > 0)
        <div class="bg-gradient-to-br from-primary-700 to-primary-500 rounded-2xl p-6 text-white shadow-lg shadow-primary-200/50">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-lg">today</span>
                <h2 class="text-sm font-bold uppercase tracking-wider">Jadwal Hari Ini</h2>
                <span class="ml-auto text-xs font-semibold bg-white/20 px-2.5 py-0.5 rounded-full">{{ $todayName = $hariNameMap[$todayHari] ?? $todayHari }}</span>
            </div>
            <div class="space-y-2">
                @foreach($todayJadwals as $jadwal)
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                    <div class="w-16 shrink-0 text-center rounded-lg py-1.5 bg-white/15">
                        <span class="block text-[10px] font-bold leading-tight">{{ substr($jadwal->jam_mulai, 0, 5) }}</span>
                        <span class="block text-[8px] opacity-60">-</span>
                        <span class="block text-[10px] font-bold leading-tight">{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate">{{ $jadwal->mata_pelajaran }}</p>
                        <p class="text-[11px] opacity-70 truncate">{{ $jadwal->guru->nama ?? '-' }}{{ $jadwal->ruangan ? ' • ' . $jadwal->ruangan : '' }}</p>
                    </div>
                    @if($anakSiswa->count() > 1)
                        <span class="text-[10px] font-semibold bg-white/15 px-2 py-0.5 rounded-full shrink-0">{{ $jadwal->kelas->nama_kelas }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- DESKTOP: Weekly Table --}}
        <div class="hidden lg:block bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-slate-400">date_range</span>
                <h3 class="text-sm font-bold text-slate-700">Jadwal Mingguan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider w-20">Jam</th>
                            @foreach($hariList as $h)
                                @php $isToday = $h === $todayHari; @endphp
                                <th class="px-3 py-3 text-center text-[10px] font-bold uppercase tracking-wider
                                    {{ $isToday ? 'bg-primary-50 text-primary-700' : 'text-slate-500' }}">
                                    {{ $hariNameMap[$h] }}
                                    @if($isToday)
                                        <span class="block text-[8px] font-semibold text-primary-500 normal-case tracking-normal mt-0.5">Hari Ini</span>
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

                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-xs font-mono text-slate-400 align-top pt-4">
                                    {{ substr($jam, 0, 5) }}
                                </td>
                                @foreach($hariList as $h)
                                    @php
                                        $jadwalHari = $activeJadwal->firstWhere('hari', $h);
                                        $isToday = $h === $todayHari;
                                    @endphp
                                    <td class="px-2 py-2 align-top {{ $isToday ? 'bg-primary-50/20' : '' }}">
                                        @if($jadwalHari)
                                            <div class="rounded-xl border p-3 {{ $jadwalHari->warna }} transition-all hover:shadow-md hover:-translate-y-0.5 cursor-default">
                                                <p class="font-bold text-xs text-slate-800 leading-tight">
                                                    {{ $jadwalHari->mata_pelajaran }}
                                                </p>
                                                <p class="text-[10px] text-slate-500 mt-1.5 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">person</span>
                                                    {{ Str::limit($jadwalHari->guru->nama ?? '-', 18) }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 mt-0.5 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">door_front</span>
                                                    {{ $jadwalHari->ruangan ?? '-' }}
                                                </p>
                                                <span class="text-[9px] text-slate-400 font-mono mt-1.5 inline-block">
                                                    {{ substr($jadwalHari->jam_mulai, 0, 5) }}-{{ substr($jadwalHari->jam_selesai, 0, 5) }}
                                                </span>
                                                @if($anakSiswa->count() > 1)
                                                    <p class="text-[9px] text-primary-600 font-bold mt-1">
                                                        {{ $jadwalHari->kelas->nama_kelas }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE: Cards grouped by day --}}
        <div class="lg:hidden space-y-4">
            <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2 px-1">
                <span class="material-symbols-outlined text-base text-slate-400">date_range</span>
                Jadwal Mingguan
            </h3>
            @foreach($hariList as $h)
                @php $hariJadwal = $jadwalByHari->get($h, collect())->sortBy('jam_mulai'); @endphp
                @if($hariJadwal->isEmpty()) @continue @endif

                @php $isToday = $h === $todayHari; @endphp
                <div class="bg-white border rounded-xl overflow-hidden shadow-sm {{ $isToday ? 'border-primary-200 ring-1 ring-primary-100' : 'border-slate-200' }}">
                    <div class="px-4 py-3 flex items-center justify-between {{ $isToday ? 'bg-primary-50' : 'bg-slate-50' }}">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $isToday ? 'bg-primary-500' : 'bg-slate-300' }}"></span>
                            <h3 class="font-bold text-sm uppercase {{ $isToday ? 'text-primary-700' : 'text-slate-700' }}">
                                {{ $hariNameMap[$h] }}
                            </h3>
                        </div>
                        @if($isToday)
                            <span class="text-[10px] font-bold text-primary-600 bg-primary-100 px-2 py-0.5 rounded-full">Hari Ini</span>
                        @endif
                    </div>
                    <div class="p-3 space-y-2">
                        @foreach($hariJadwal as $jadwal)
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:shadow-sm transition-shadow">
                                <div class="w-14 shrink-0 text-center rounded-lg py-1.5 {{ $jadwal->warna }}">
                                    <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ substr($jadwal->jam_mulai, 0, 5) }}</span>
                                    <span class="block text-[8px] text-slate-500">-</span>
                                    <span class="block text-[10px] font-bold text-slate-700 leading-tight">{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ $jadwal->mata_pelajaran }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ $jadwal->guru->nama ?? '-' }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if($jadwal->ruangan)
                                            <span class="text-[10px] text-slate-400 flex items-center gap-0.5">
                                                <span class="material-symbols-outlined text-[10px]">door_front</span>
                                                {{ $jadwal->ruangan }}
                                            </span>
                                        @endif
                                        @if($anakSiswa->count() > 1)
                                            <span class="text-[10px] font-semibold text-primary-600 bg-primary-50 px-1.5 py-0.5 rounded">{{ $jadwal->kelas->nama_kelas }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    @else
        {{-- Empty State --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-slate-300 text-3xl">calendar_month</span>
            </div>
            <h2 class="text-lg font-bold text-slate-600">Belum Ada Jadwal</h2>
            <p class="text-sm text-slate-400 mt-1.5 max-w-sm mx-auto">Jadwal pelajaran belum tersedia untuk kelas anak Anda. Silakan hubungi sekolah untuk informasi lebih lanjut.</p>
        </div>
    @endif
</div>
@endsection
