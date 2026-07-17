@extends('public.layouts')

@section('title', 'Profil Sekolah')

@section('content')

@php
    $schoolName = $settings['nama_website'] ?? '';

    $heroImg = !empty($settings['hero_image'])
        ? asset('storage/settings/' . $settings['hero_image'])
        : null;

    $sambutan = $settings['sambutan_kepsek'] ?? 'Sambutan kepala sekolah belum tersedia.';
    $kepsek = $settings['nama_kepsek'] ?? 'Kepala Sekolah';

    $sejarah = $settings['profil_sekolah'] ?? $settings['sejarah'] ?? 'Profil sekolah belum tersedia.';
    $visi = $settings['visi'] ?? 'Visi belum tersedia.';
    $misi = $settings['misi'] ?? 'Misi belum tersedia.';
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 md:px-6">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
                <span class="material-symbols-outlined text-sm">school</span>
                Profil Sekolah
            </span>
            <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">{{ $schoolName }}</h1>
            <p class="mt-5 text-slate-600 text-lg leading-relaxed">
                Mengenal lebih dekat sejarah, visi misi, dan sambutan resmi dari sekolah kami.
            </p>
        </div>
    </div>
</section>

{{-- HERO SECTION --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-12 grid md:grid-cols-3 gap-8">

    <div class="md:col-span-2" data-aos="fade-right">
        @if ($heroImg)
            <img src="{{ $heroImg }}" alt="Profil {{ $schoolName }}" class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-lg border border-slate-100">
        @else
            <div class="w-full h-80 md:h-96 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 border border-slate-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-primary-300">school</span>
            </div>
        @endif
    </div>

    <div data-aos="fade-left" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-slate-100">
        <h2 class="text-xl font-bold text-slate-900 mb-3">Sambutan Kepala Sekolah</h2>
        <p class="text-slate-600 text-sm leading-relaxed italic">"{{ $sambutan }}"</p>
        <div class="mt-6 border-t border-slate-200 pt-4">
            <p class="font-semibold text-slate-900">{{ $kepsek }}</p>
            <p class="text-sm text-slate-500">Kepala Sekolah</p>
        </div>
    </div>

</section>

{{-- DETAIL SECTION --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20" x-data="{ activeTab: 'profil' }">

    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden border border-slate-100" data-aos="fade-up">

        <div class="flex border-b border-slate-200">
            <button @click="activeTab = 'profil'"
                class="px-6 py-4 font-semibold text-sm transition-all border-b-2 cursor-pointer"
                :class="activeTab === 'profil' ? 'text-primary-600 border-primary-600' : 'text-slate-600 border-transparent hover:text-primary-600'">
                <span class="material-symbols-outlined text-sm align-middle mr-2">history_edu</span>
                Profil Sekolah
            </button>
            <button @click="activeTab = 'visi'"
                class="px-6 py-4 font-semibold text-sm transition-all border-b-2 cursor-pointer"
                :class="activeTab === 'visi' ? 'text-primary-600 border-primary-600' : 'text-slate-600 border-transparent hover:text-primary-600'">
                <span class="material-symbols-outlined text-sm align-middle mr-2">visibility</span>
                Visi & Misi
            </button>
        </div>

        <div class="p-6 md:p-8">

            <div x-show="activeTab === 'profil'" x-transition.opacity>
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Profil Sekolah</h2>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $sejarah }}</p>
            </div>

            <div x-show="activeTab === 'visi'" x-transition.opacity class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Visi</h2>
                    <p class="text-slate-600 italic bg-primary-50 border border-primary-100 rounded-xl p-4">"{{ $visi }}"</p>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Misi</h2>
                    <ul class="space-y-3 text-slate-600">
                        @foreach (explode("\n", $misi) as $item)
                            @if (trim($item) !== '')
                                <li class="flex items-start gap-3 bg-slate-50 rounded-xl p-3">
                                    <span class="w-6 h-6 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined text-sm">check</span>
                                    </span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>

</section>

@endsection
