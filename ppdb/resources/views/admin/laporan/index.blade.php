@extends('admin.layouts.app')

@section('title', 'Laporan & Rekap')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-xl md:text-2xl font-bold">Laporan & Rekap</h1>
        <p class="text-gray-500 text-sm">Rekap data absensi siswa, export ke Excel / PDF</p>
    </div>

    {{-- TABS --}}
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">
        <div class="flex gap-2 border-b pb-3 mb-6 overflow-x-auto">
            <a href="{{ route('admin.laporan.index', ['tab' => 'absensi']) }}"
                class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition
                    {{ ($tab ?? 'absensi') == 'absensi'
                        ? 'bg-primary-500 text-white'
                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <i class="fa-solid fa-clipboard-check mr-1"></i> Rekap Absensi
            </a>
            <span class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap bg-gray-50 text-gray-400 cursor-not-allowed">
                <i class="fa-solid fa-star mr-1"></i> Rekap Nilai <span class="text-[10px]">(segera)</span>
            </span>
            <span class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap bg-gray-50 text-gray-400 cursor-not-allowed">
                <i class="fa-solid fa-money-bill mr-1"></i> Rekap Pembayaran <span class="text-[10px]">(segera)</span>
            </span>
        </div>

        {{-- CONTENT --}}
        @if(($tab ?? 'absensi') == 'absensi')
            @include('admin.laporan.absensi')
        @endif
    </div>

</div>
@endsection
