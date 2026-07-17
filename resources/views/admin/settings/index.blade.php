@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')

@php
    $logo = $settings['logo'] ?? null;
    $favicon = $settings['favicon'] ?? null;
    $profilImage = $settings['profil_image'] ?? null;
    $heroImage = $settings['hero_image'] ?? null;
    $socials = json_decode($settings['social_media'] ?? '[]', true);
    $primaryColor = $settings['primary_color'] ?? '#2563eb';
@endphp


{{-- HEADER --}}
<div class="bg-white p-4 md:p-6 rounded-xl shadow mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-gear text-primary-600"></i>
                Pengaturan Website
            </h1>
            <p class="text-gray-500 text-sm mt-1">Kelola identitas, kontak, media, dan tema website sekolah</p>
        </div>
        <a href="{{ route('admin.settings.edit') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg flex items-center justify-center gap-2 text-sm font-medium transition-colors">
            <i class="fa-solid fa-pen text-xs"></i>
            Edit Pengaturan
        </a>
    </div>
</div>


@if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-500"></i>
        {{ session('success') }}
    </div>
@endif


{{-- QUICK STATS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-globe text-primary-600 text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-gray-400 font-medium">Nama Website</p>
                <p class="text-sm font-bold text-gray-800 truncate">{{ $settings['nama_website'] ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-phone text-emerald-600 text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-gray-400 font-medium">Telepon</p>
                <p class="text-sm font-bold text-gray-800 truncate">{{ $settings['telepon'] ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-user-tie text-purple-600 text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-gray-400 font-medium">Kepala Sekolah</p>
                <p class="text-sm font-bold text-gray-800 truncate">{{ $settings['nama_kepsek'] ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-share-nodes text-orange-600 text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-gray-400 font-medium">Sosial Media</p>
                <p class="text-sm font-bold text-gray-800">{{ count($socials) }} akun</p>
            </div>
        </div>
    </div>
</div>


{{-- MAIN GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- IDENTITAS WEBSITE --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                        <i class="fa-solid fa-globe text-primary-600 text-xs"></i>
                    </div>
                    Identitas Website
                </h2>
            </div>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nama Website</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $settings['nama_website'] ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nama Sekolah</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $settings['nama_sekolah'] ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Tagline</p>
                <p class="text-sm text-gray-600 mt-1">{{ $settings['tagline'] ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Akreditasi</p>
                <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-bold rounded bg-primary-100 text-primary-700">
                    {{ $settings['akreditasi'] ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    {{-- KONTAK SEKOLAH --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <i class="fa-solid fa-phone text-emerald-600 text-xs"></i>
                </div>
                Kontak Sekolah
            </h2>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-envelope text-gray-400 text-xs"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Email</p>
                    <p class="text-sm font-semibold text-gray-800 mt-1 break-all">{{ $settings['email'] ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Telepon</p>
                    <p class="text-sm font-semibold text-gray-800 mt-1">{{ $settings['telepon'] ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-location-dot text-gray-400 text-xs"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Alamat</p>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $settings['alamat'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- KEPALA SEKOLAH --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-user-tie text-purple-600 text-xs"></i>
                </div>
                Kepala Sekolah
            </h2>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nama</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $settings['nama_kepsek'] ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Sambutan</p>
                <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                    {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 180) }}
                </p>
            </div>
        </div>
    </div>
</div>


{{-- WARNA TEMA & SOSIAL MEDIA --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- WARNA TEMA --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center">
                    <i class="fa-solid fa-palette text-pink-600 text-xs"></i>
                </div>
                Warna Tema
            </h2>
        </div>
        <div class="px-6 py-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-xl border-2 border-gray-200 shadow-inner shrink-0"
                    style="background-color: {{ $primaryColor }}"></div>
                <div>
                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Warna Utama</p>
                    <p class="text-sm font-bold text-gray-800 mt-1 font-mono uppercase">{{ $primaryColor }}</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        @php
                            $palette = \App\Models\Setting::generateColorPalette($primaryColor);
                        @endphp
                        @foreach ([50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950] as $shade)
                            <div class="w-5 h-5 rounded-full border border-white shadow-sm"
                                style="background-color: {{ $palette[$shade] }}"
                                title="{{ $shade }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SOSIAL MEDIA --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                    <i class="fa-solid fa-share-nodes text-primary-600 text-xs"></i>
                </div>
                Sosial Media
            </h2>
        </div>
        <div class="px-6 py-5">
            @if (count($socials))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($socials as $social)
                        <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="{{ $social['icon'] ?? 'fa-solid fa-link' }} text-gray-500 text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $social['name'] }}</p>
                                <a href="{{ $social['url'] }}" target="_blank"
                                    class="text-xs text-primary-600 hover:text-primary-700 truncate block">
                                    {{ $social['url'] }}
                                </a>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-gray-300 text-xs"></i>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-share-nodes text-gray-300"></i>
                    </div>
                    <p class="text-sm text-gray-400">Belum ada sosial media</p>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- MEDIA WEBSITE --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                    <i class="fa-solid fa-image text-orange-600 text-xs"></i>
                </div>
                Media Website
            </h2>
            <span class="text-[11px] text-gray-400 font-medium">
                {{ collect([$logo, $favicon, $profilImage, $heroImage])->filter()->count() }} / 4 gambar
            </span>
        </div>
    </div>
    <div class="px-6 py-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Logo', 'icon' => 'fa-solid fa-image', 'value' => $logo, 'color' => 'primary'],
                ['label' => 'Favicon', 'icon' => 'fa-solid fa-star', 'value' => $favicon, 'color' => 'amber'],
                ['label' => 'Foto Profil', 'icon' => 'fa-solid fa-id-card', 'value' => $profilImage, 'color' => 'emerald'],
                ['label' => 'Foto Kepsek', 'icon' => 'fa-solid fa-user', 'value' => $heroImage, 'color' => 'purple'],
            ] as $item)
                <div class="group relative rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="aspect-[4/3] bg-gray-50 flex items-center justify-center">
                        @if ($item['value'])
                            <img src="{{ asset('storage/settings/' . $item['value']) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="text-center">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-2">
                                    <i class="{{ $item['icon'] }} text-gray-300"></i>
                                </div>
                                <p class="text-[10px] text-gray-400 font-medium">Belum ada</p>
                            </div>
                        @endif
                    </div>
                    <div class="px-3 py-2.5 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-700">{{ $item['label'] }}</p>
                        @if ($item['value'])
                            <p class="text-[10px] text-gray-400 mt-0.5 truncate">{{ $item['value'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


{{-- PROFIL, VISI, MISI, SEJARAH --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="px-6 pt-5 pb-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                <i class="fa-solid fa-school text-primary-600 text-xs"></i>
            </div>
            Profil & Identitas Sekolah
        </h2>
    </div>
    <div class="px-6 py-5 space-y-6">

        {{-- Profil --}}
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                Profil Sekolah
            </h3>
            <p class="text-sm text-gray-600 leading-relaxed pl-3 border-l-2 border-gray-100">
                {{ $settings['profil_sekolah'] ?? '-' }}
            </p>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Visi --}}
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Visi
            </h3>
            <p class="text-sm text-gray-600 leading-relaxed pl-3 border-l-2 border-emerald-200">
                {{ $settings['visi'] ?? '-' }}
            </p>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Misi --}}
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                Misi
            </h3>
            <div class="text-sm text-gray-600 leading-relaxed pl-3 border-l-2 border-purple-200">
                {!! nl2br(e($settings['misi'] ?? '-')) !!}
            </div>
        </div>

        <div class="border-t border-gray-100"></div>

        {{-- Sejarah --}}
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                Sejarah
            </h3>
            <p class="text-sm text-gray-600 leading-relaxed pl-3 border-l-2 border-amber-200">
                {{ $settings['sejarah'] ?? '-' }}
            </p>
        </div>

    </div>
</div>


@endsection
