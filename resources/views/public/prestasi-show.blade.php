@extends('public.layouts')

@section('title', $prestasi->title)

@section('content')

    {{-- HERO --}}
    <section data-aos="fade-in" class="relative overflow-hidden py-20">

        <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

        <div class="relative max-w-5xl mx-auto px-4 md:px-6 text-center">

            <span
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
                <i class="fa-solid fa-trophy"></i>
                Prestasi
            </span>

            <h1 class="mt-6 text-3xl md:text-5xl font-bold text-slate-900 leading-tight">
                {{ $prestasi->title }}
            </h1>

            <div class="flex items-center justify-center gap-3 mt-4">
                @php
                    $color = match ($prestasi->category) {
                        'Akademik' => 'bg-blue-600',
                        'Olahraga' => 'bg-green-600',
                        'Teknologi & Multimedia' => 'bg-purple-600',
                        'Seni' => 'bg-blue-500',
                        default => 'bg-slate-600',
                    };
                @endphp
                <span class="{{ $color }} text-white text-xs px-3 py-1 rounded-lg shadow">
                    {{ $prestasi->category }}
                </span>
                <span class="text-sm text-slate-500">{{ $prestasi->level }}</span>
                <span class="text-sm text-slate-500">•</span>
                <span class="text-sm text-slate-500">{{ $prestasi->year }}</span>
            </div>

        </div>

    </section>

    <section class="max-w-4xl mx-auto px-4 pb-20">

        <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">

            @if ($prestasi->image)
                <img src="{{ asset('storage/prestasi/' . $prestasi->image) }}" alt="{{ $prestasi->title }}"
                    class="w-full h-64 md:h-96 object-cover">
            @endif

            <div class="p-6 md:p-8">

                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 mb-4">
                    {{ $prestasi->title }}
                </h1>

                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                    {{ $prestasi->description }}
                </div>

            </div>

        </div>

        <div class="flex items-start gap-2 mb-6" data-aos="fade-up">
            <a href="{{ route('prestasi') }}"
                class="inline-flex items-center pgap-2 px-6 py-3 bg-blue-500 text-white text-sm font-semibold rounded-full hover:bg-blue-600 transition shadow-md">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Prestasi
            </a>
        </div>



    </section>

@endsection
