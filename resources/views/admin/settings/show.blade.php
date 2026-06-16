@extends('admin.layouts.app')

@section('title', 'Detail Pengaturan Website')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-eye text-primary-600"></i>
        Detail Pengaturan Website
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PROFIL --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Profil Sekolah</h2>
            <p class="text-gray-700">{{ $settings['profil_sekolah'] ?? '-' }}</p>
        </div>

        {{-- SAMBUTAN (BARU) --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Sambutan Kepala Sekolah</h2>
            <p class="text-gray-700 whitespace-pre-line">
                {{ $settings['sambutan_kepsek'] ?? '-' }}
            </p>
        </div>

        {{-- NAMA KEPSEK --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Nama Kepala Sekolah</h2>
            <p class="text-gray-700">
                {{ $settings['nama_kepsek'] ?? '-' }}
            </p>
        </div>

        {{-- VISI --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Visi</h2>
            <p class="text-gray-700">{{ $settings['visi'] ?? '-' }}</p>
        </div>

        {{-- MISI --}}
        <div class="p-4 border rounded-lg md:col-span-2">
            <h2 class="font-semibold mb-1">Misi</h2>
            <p class="text-gray-700 whitespace-pre-line">
                {{ $settings['misi'] ?? '-' }}
            </p>
        </div>

        {{-- SEJARAH --}}
        <div class="p-4 border rounded-lg md:col-span-2 bg-gray-50">
            <h2 class="font-semibold mb-1">Sejarah Sekolah</h2>
            <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                {{ $settings['sejarah'] ?? '-' }}
            </p>
        </div>

        {{-- EMAIL --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Email</h2>
            <p class="text-gray-700">{{ $settings['email'] ?? '-' }}</p>
        </div>

        {{-- TELEPON --}}
        <div class="p-4 border rounded-lg">
            <h2 class="font-semibold mb-1">Telepon</h2>
            <p class="text-gray-700">{{ $settings['telepon'] ?? '-' }}</p>
        </div>

        {{-- ALAMAT --}}
        <div class="p-4 border rounded-lg md:col-span-2">
            <h2 class="font-semibold mb-1">Alamat</h2>
            <p class="text-gray-700">{{ $settings['alamat'] ?? '-' }}</p>
        </div>

    </div>

    {{-- BUTTON --}}
    <div class="mt-6 flex gap-3">

        <a href="{{ route('admin.settings.edit') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-pen"></i> Edit
        </a>

        <a href="{{ route('admin.settings.index') }}"
            class="bg-primary-600 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

    </div>

</div>
@endsection