@extends('public.layouts')

@section('title', $news->title)

@section('content')

    @php
        use Illuminate\Support\Str;
    @endphp

    {{-- HERO BERITA --}}
    <section class="relative bg-slate-900 text-white overflow-hidden">

        @if ($news->image)
            <img src="{{ asset('storage/berita/' . $news->image) }}"
                class="absolute inset-0 w-full h-full object-cover opacity-40">
        @endif

        <div class="relative max-w-5xl mx-auto px-4 py-20 text-center">

            {{-- <p class="text-blue-400 text-sm mb-3">
                📢 Berita Sekolah
            </p> --}}

            <h1 class="text-3xl md:text-5xl font-bold leading-tight">
                {{ $news->title }}
            </h1>

            <p class="text-slate-300 text-sm mt-4">
                {{ $news->created_at->format('d M Y') }}
            </p>

        </div>

    </section>

    {{-- CONTENT --}}
    <section class="max-w-4xl mx-auto px-4 py-12">

        {{-- GAMBAR (mobile friendly tambahan) --}}
        @if ($news->image)
            <div class="mb-8">
                <img src="{{ asset('storage/berita/' . $news->image) }}" class="w-full rounded-xl shadow-lg">
            </div>
        @endif

        {{-- ISI BERITA --}}
        <article class="prose prose-slate max-w-none leading-relaxed">

            {!! $news->content !!}

        </article>

        {{-- BACK BUTTON --}}
        <div class="mt-10">
            <a href="{{ url('/berita') }}"
                class="bg-white text-center w-48 rounded-2xl h-12 relative text-black text-base font-semibold group block">
                <div
                    class="bg-blue-500 rounded-xl h-10 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[184px] z-10 duration-500">

                </div>
                <p class="translate-x-2 leading-[48px] relative z-20">Kembali ke Berita</p>
            </a>
        </div>

    </section>

@endsection
