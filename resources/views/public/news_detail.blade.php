@extends('public.layouts')

@section('title', $berita->title)

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-5xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-newspaper"></i>
            {{ $berita->category ?? 'Berita' }}
        </span>

        <h1 class="mt-6 text-3xl md:text-5xl font-bold text-slate-900 leading-tight">
            {{ $berita->title }}
        </h1>

        <p class="mt-4 text-slate-500 text-sm">
            {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-4xl mx-auto px-4 py-12">

    @if($berita->image)
        <div class="mb-8 rounded-xl overflow-hidden shadow-lg" data-aos="fade-up">
            <img src="{{ asset('storage/berita/' . $berita->image) }}" class="w-full">
        </div>
    @endif

    <article class="prose prose-slate max-w-none leading-relaxed" data-aos="fade-up">
        {!! $berita->content !!}
    </article>

    <div class="mt-10" data-aos="fade-up">
        <a href="{{ route('berita.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 text-white text-sm font-semibold rounded-full hover:bg-blue-600 transition shadow-md">
            <i class="fa-solid fa-arrow-left text-xs"></i>
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
               class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition border border-slate-100 group">

                <h3 class="font-bold text-slate-900 group-hover:text-blue-500 transition">
                    {{ $item->title }}
                </h3>

                <p class="text-sm text-slate-500 mt-2 line-clamp-2">
                    {{ Str::limit(strip_tags($item->content), 100) }}
                </p>

                <span class="text-xs text-slate-400 mt-3 block">
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                </span>

            </a>
        @endforeach

    </div>

</section>
@endif

@endsection
