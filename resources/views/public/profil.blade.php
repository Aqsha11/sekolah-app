@extends('public.layouts')

@section('title', 'Profil Sekolah')

@section('content')

@php
    $schoolName = $settings['site_name'] ?? 'SMPN 1 Lambandia';

    $heroImg = !empty($settings['hero_image'])
        ? asset('storage/settings/' . $settings['hero_image'])
        : asset('images/sekolah.jpg');

    $sambutan = $settings['sambutan_kepsek'] ?? 'Sambutan kepala sekolah belum tersedia.';
    $kepsek = $settings['nama_kepsek'] ?? 'Kepala Sekolah';

    $sejarah = $settings['sejarah'] ?? 'Sejarah sekolah belum tersedia.';
    $visi = $settings['visi'] ?? 'Visi belum tersedia.';
    $misi = $settings['misi'] ?? 'Misi belum tersedia.';
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6">

        <div class="max-w-3xl">

            <span
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
                <i class="fa-solid fa-school"></i>
                Profil Sekolah
            </span>

            <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
                {{ $schoolName }}
            </h1>

            <p class="mt-5 text-slate-600 text-lg leading-relaxed">
                Mengenal lebih dekat sejarah, visi misi, dan sambutan resmi dari sekolah kami.
            </p>

        </div>

    </div>

</section>

{{-- HERO SECTION --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-12 grid md:grid-cols-3 gap-8">

    <div class="md:col-span-2" data-aos="fade-right">
        <img src="{{ $heroImg }}" class="w-full h-80 md:h-96 object-cover rounded-xl shadow-lg">
    </div>

    <div data-aos="fade-left" class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 border border-white/50">
        <h2 class="text-xl font-bold text-slate-900 mb-3">
            Sambutan Kepala Sekolah
        </h2>

        <p class="text-slate-600 text-sm leading-relaxed">
            "{{ $sambutan }}"
        </p>

        <div class="mt-6 border-t pt-4">
            <p class="font-semibold text-slate-900">{{ $kepsek }}</p>
            <p class="text-sm text-slate-500">Kepala Sekolah</p>
        </div>
    </div>

</section>

{{-- DETAIL SECTION --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-white/50" data-aos="fade-up">

        <div class="flex border-b border-slate-200">
            <button onclick="openTab('sejarah')"
                class="tab-btn px-6 py-4 font-semibold text-blue-500 border-b-2 border-blue-500">
                Sejarah
            </button>

            <button onclick="openTab('visi')" class="tab-btn px-6 py-4 text-slate-600 hover:text-blue-500">
                Visi & Misi
            </button>
        </div>

        <div class="p-6 md:p-8">

            <div id="sejarah" class="tab-content">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Sejarah Sekolah</h2>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $sejarah }}
                </p>
            </div>

            <div id="visi" class="tab-content hidden space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Visi</h2>
                    <p class="text-slate-600 italic">"{{ $visi }}"</p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Misi</h2>
                    <ul class="space-y-2 text-slate-600">
                        @foreach (explode("\n", $misi) as $item)
                            @if ($item)
                                <li class="flex gap-2">
                                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
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

<script>
    function openTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(tab).classList.remove('hidden');

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            btn.classList.add('text-slate-600');
        });

        event.target.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
    }
</script>

@endsection
