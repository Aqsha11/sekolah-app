@extends('public.layouts')

@section('title', 'Galeri Sekolah')

@section('content')

@php
    $schoolName = $settings['nama_website'] ?? '';
@endphp

<style>
    .card-galeri {
        position: relative;
        width: 100%;
        height: 300px;
        background-color: #f2f2f2;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        perspective: 1000px;
        box-shadow: 0 0 0 5px #ffffff80;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-galeri .card-icon {
        width: 64px;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
    }

    .card-galeri:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-galeri .card-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 24px;
        box-sizing: border-box;
        background-color: #f2f2f2;
        transform: rotateX(-90deg);
        transform-origin: bottom;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-galeri:hover .card-content {
        transform: rotateX(0deg);
    }

    .card-galeri .card-title {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 700;
    }

    .card-galeri:hover .card-icon {
        scale: 0;
    }

    .card-galeri .card-description {
        margin: 10px 0 0;
        font-size: 13px;
        color: #555;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-galeri .card-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        background: rgba(34, 197, 94, 0.9);
        color: #fff;
        backdrop-filter: blur(4px);
    }

    .card-galeri .card-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 0;
    }

    .card-galeri:hover .card-image {
        scale: 0;
    }
</style>

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-images"></i>
            Galeri Sekolah
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
            Galeri {{ $schoolName }}
        </h1>

        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Kumpulan foto kegiatan, dokumentasi acara, dan aktivitas sekolah.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    @if ($galeris->count() > 0)

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($galeris as $index => $galeri)

                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="card-galeri">

                    <span class="card-badge">{{ $galeri->category ?? 'Umum' }}</span>

                    @if($galeri->image)
                        <img src="{{ asset('storage/galeri/' . $galeri->image) }}" alt="{{ $galeri->title }}" class="card-image">
                    @else
                        <i class="fa-solid fa-image card-icon text-6xl text-slate-400"></i>
                    @endif

                    <div class="card-content">
                        <h3 class="card-title">{{ $galeri->title }}</h3>
                        <p class="card-description">{{ $galeri->description ?? '' }}</p>
                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-12">
            {{ $galeris->links() }}
        </div>

    @else

        <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-16 text-center">

            <i class="fa-solid fa-images text-6xl text-slate-300"></i>

            <h3 class="mt-6 text-2xl font-bold text-slate-700">
                Belum Ada Galeri
            </h3>

            <p class="mt-2 text-slate-500">
                Foto galeri akan tampil di sini.
            </p>

        </div>

    @endif

</section>

@endsection
