@extends('public.layouts')

@section('title', $berita->title)

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-5xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">newspaper</span>
            {{ $berita->category ?? 'Berita' }}
        </span>
        <h1 class="mt-6 text-3xl md:text-5xl font-bold text-slate-900 leading-tight">{{ $berita->title }}</h1>
        <p class="mt-4 text-slate-500 text-sm flex items-center justify-center gap-1.5">
            <span class="material-symbols-outlined text-sm">calendar_month</span>
            {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-4xl mx-auto px-4 py-12">

    @if($berita->image)
        <div class="mb-8 rounded-2xl overflow-hidden shadow-lg" data-aos="fade-up">
            <img src="{{ asset('storage/berita/' . $berita->image) }}" alt="{{ $berita->title }}" class="w-full">
        </div>
    @endif

    <article class="prose prose-slate max-w-none leading-relaxed" data-aos="fade-up">
        {!! clean_html($berita->content) !!}
    </article>

    <div class="mt-10" data-aos="fade-up">
        <a href="{{ route('berita.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition shadow-md">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Berita
        </a>
    </div>

</section>

{{-- RELATED NEWS --}}
@if($relatedNews->count())
<section class="max-w-5xl mx-auto px-4 pb-20">

    <h2 class="text-xl font-bold text-slate-900 mb-6" data-aos="fade-up">Berita Terkait</h2>

    <div class="grid md:grid-cols-2 gap-6">

        @foreach($relatedNews as $index => $item)
            <a href="{{ route('berita.show', $item->slug) }}"
               data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
               class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">

                @if ($item->image)
                    <div class="h-32 overflow-hidden rounded-xl mb-3 bg-slate-100">
                        <img src="{{ asset('storage/berita/' . $item->image) }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                @endif

                <h3 class="font-bold text-sm text-slate-900 group-hover:text-primary-600 transition">{{ $item->title }}</h3>
                <p class="text-[11px] text-slate-500 mt-2 line-clamp-2">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                <span class="text-[10px] text-slate-400 mt-3 block flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">calendar_month</span>
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                </span>

            </a>
        @endforeach

    </div>

</section>
@endif

@endsection
