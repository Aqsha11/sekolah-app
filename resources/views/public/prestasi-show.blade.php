@extends('public.layouts')

@section('title', $prestasi->title)

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-5xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">military_tech</span>
            Prestasi
        </span>
        <h1 class="mt-6 text-3xl md:text-5xl font-bold text-slate-900 leading-tight">{{ $prestasi->title }}</h1>
        <div class="flex items-center justify-center gap-3 mt-4 flex-wrap">
            @php
                $color = match ($prestasi->category) {
                    'Akademik' => 'bg-primary-600',
                    'Olahraga' => 'bg-emerald-600',
                    'Teknologi & Multimedia' => 'bg-purple-600',
                    'Seni' => 'bg-amber-600',
                    default => 'bg-slate-600',
                };
            @endphp
            <span class="{{ $color }} text-white text-xs px-3 py-1 rounded-lg shadow">{{ $prestasi->category }}</span>
            @if ($prestasi->level)
                <span class="text-sm text-slate-500 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">leaderboard</span>
                    {{ $prestasi->level }}
                </span>
            @endif
            @if ($prestasi->year)
                <span class="text-sm text-slate-500">•</span>
                <span class="text-sm text-slate-500 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    {{ $prestasi->year }}
                </span>
            @endif
        </div>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 pb-20">

    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-slate-100" data-aos="fade-up">

        @if ($prestasi->image)
            <div class="h-64 md:h-96 overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/prestasi/' . $prestasi->image) }}" alt="{{ $prestasi->title }}"
                    class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">{{ $prestasi->title }}</h1>
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                {!! nl2br(e($prestasi->description)) !!}
            </div>
        </div>

    </div>

    <div class="mt-6" data-aos="fade-up">
        <a href="{{ route('prestasi') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition shadow-md">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Prestasi
        </a>
    </div>

</section>

@endsection
