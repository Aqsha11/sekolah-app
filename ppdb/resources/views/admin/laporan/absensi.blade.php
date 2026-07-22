@php
    $bulanIni = \Carbon\Carbon::now();
@endphp

{{-- FILTER --}}
<div class="bg-gray-50 rounded-xl p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-end gap-3">
        <input type="hidden" name="tab" value="absensi">

        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}"
                class="w-full border rounded-lg p-2 text-sm focus:ring focus:ring-primary-300">
        </div>

        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}"
                class="w-full border rounded-lg p-2 text-sm focus:ring focus:ring-primary-300">
        </div>

        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Kelas</label>
            <select name="kelas" class="w-full border rounded-lg p-2 text-sm focus:ring focus:ring-primary-300">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ $kelasFilter == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-filter"></i> Filter
        </button>

        <div class="flex gap-2">
            <a href="{{ route('admin.laporan.export.absensi.excel', ['dari' => $dari, 'sampai' => $sampai, 'kelas' => $kelasFilter]) }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.export.absensi.pdf', ['dari' => $dari, 'sampai' => $sampai, 'kelas' => $kelasFilter]) }}"
                class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
        </div>
    </form>
</div>

{{-- SUMMARY CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border rounded-xl p-4 text-center shadow-sm">
        <div class="text-2xl font-bold text-gray-800">{{ $summary['total_siswa'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Total Siswa</div>
    </div>
    <div class="bg-white border rounded-xl p-4 text-center shadow-sm border-l-4 border-l-emerald-500">
        <div class="text-2xl font-bold text-emerald-600">{{ $summary['total_hadir'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Total Hadir</div>
    </div>
    <div class="bg-white border rounded-xl p-4 text-center shadow-sm border-l-4 border-l-amber-500">
        <div class="text-2xl font-bold text-amber-600">{{ $summary['total_terlambat'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Total Terlambat</div>
    </div>
    <div class="bg-white border rounded-xl p-4 text-center shadow-sm border-l-4 border-l-red-500">
        <div class="text-2xl font-bold text-red-600">{{ $summary['total_alpha'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Total Alpha</div>
    </div>
</div>

{{-- TABEL --}}
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIS</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kelas</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Hadir</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Izin</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Sakit</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Alpha</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Terlambat</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswas as $i => $s)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $i + 1 }}</td>
                        <td class="px-4 py-2 text-sm font-mono">{{ $s->nis }}</td>
                        <td class="px-4 py-2 text-sm font-medium">{{ $s->nama }}</td>
                        <td class="px-4 py-2 text-sm">{{ $s->kelas ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                {{ $s->hadir }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 text-primary-700 text-xs font-bold">
                                {{ $s->izin }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                {{ $s->sakit }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                {{ $s->alpha }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                {{ $s->terlambat }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="text-sm font-bold text-gray-800">{{ $s->total }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada data absensi untuk periode ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE --}}
    <div class="md:hidden divide-y">
        @forelse($siswas as $i => $s)
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-sm">{{ $s->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $s->nis }} • {{ $s->kelas ?? '-' }}</p>
                    </div>
                    <span class="text-xs font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-full">
                        {{ $s->total }} hari
                    </span>
                </div>
                <div class="grid grid-cols-5 gap-2 text-center">
                    <div>
                        <div class="text-sm font-bold text-emerald-600">{{ $s->hadir }}</div>
                        <div class="text-[10px] text-gray-400">Hadir</div>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-primary-600">{{ $s->izin }}</div>
                        <div class="text-[10px] text-gray-400">Izin</div>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-amber-600">{{ $s->sakit }}</div>
                        <div class="text-[10px] text-gray-400">Sakit</div>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-red-600">{{ $s->alpha }}</div>
                        <div class="text-[10px] text-gray-400">Alpha</div>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-orange-600">{{ $s->terlambat }}</div>
                        <div class="text-[10px] text-gray-400">Telat</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">Tidak ada data</div>
        @endforelse
    </div>
</div>
