@extends('public.layouts')

@section('title', 'Fasilitas Sekolah')

@section('content')

<style>
    .card-fasilitas {
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

    .card-fasilitas .card-icon {
        width: 64px;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
    }

    .card-fasilitas:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-fasilitas .card-content {
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

    .card-fasilitas:hover .card-content {
        transform: rotateX(0deg);
    }

    .card-fasilitas .card-title {
        margin: 0;
        font-size: 20px;
        color: #333;
        font-weight: 700;
    }

    .card-fasilitas:hover .card-icon {
        scale: 0;
    }

    .card-fasilitas .card-description {
        margin: 10px 0 0;
        font-size: 14px;
        color: #555;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-fasilitas .card-badge {
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

    .card-fasilitas .card-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 0;
    }

    .card-fasilitas:hover .card-image {
        scale: 0;
    }
</style>

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-school"></i>
            Fasilitas Sekolah
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
            Sarana & Prasarana
        </h1>

        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Fasilitas terbaik untuk mendukung proses pembelajaran yang nyaman,
            aman, dan berkualitas bagi seluruh peserta didik.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    @if($fasilitas->count())

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($fasilitas as $index => $item)

                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="card-fasilitas">

                    {{-- BADGE --}}
                    <span class="card-badge">Aktif</span>

                    {{-- FRONT: Image --}}
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="card-image">
                    @else
                        <i class="fa-solid fa-school card-icon text-6xl text-slate-400"></i>
                    @endif

                    {{-- BACK: Content on hover --}}
                    <div class="card-content">
                        <h3 class="card-title">{{ $item->name }}</h3>
                        <p class="card-description">{{ $item->description }}</p>
                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-12">
            {{ $fasilitas->links() }}
        </div>

    @else

        <div
            class="bg-white rounded-3xl border border-dashed border-slate-300 p-16 text-center">

            <i class="fa-solid fa-building text-6xl text-slate-300"></i>

            <h3 class="mt-6 text-2xl font-bold text-slate-700">
                Belum Ada Fasilitas
            </h3>

            <p class="mt-2 text-slate-500">
                Data fasilitas sekolah belum tersedia.
            </p>

        </div>

    @endif

</section>

@endsection