@extends('public.layouts')

@section('title', 'Guru & Tenaga Pendidik')

@section('content')

@php
    $schoolName = $settings['site_name'] ?? 'Sekolah';
@endphp

<style>
    .card-guru {
        position: relative;
        width: 100%;
        height: 320px;
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

    .card-guru .card-icon {
        width: 64px;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
    }

    .card-guru:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-guru .card-content {
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
        text-align: center;
    }

    .card-guru:hover .card-content {
        transform: rotateX(0deg);
    }

    .card-guru .card-title {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 700;
    }

    .card-guru:hover .card-icon {
        scale: 0;
    }

    .card-guru .card-subtitle {
        margin: 6px 0 0;
        font-size: 13px;
        color: #666;
    }

    .card-guru .card-subject {
        margin: 10px 0 0;
        font-size: 12px;
        color: #555;
        line-height: 1.5;
    }

    .card-guru .card-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 0;
    }

    .card-guru:hover .card-image {
        scale: 0;
    }
</style>

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-chalkboard-user"></i>
            Tenaga Pendidik
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
            Guru & Tenaga Pendidik
        </h1>

        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Daftar guru dan tenaga pendidik {{ $schoolName }} yang berdedikasi dalam mendidik dan membimbing siswa.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    @if ($teachers->count() > 0)

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @foreach ($teachers as $teacher)

                <div data-aos="fade-up" class="card-guru">

                    @if ($teacher->photo)
                        <img src="{{ asset('storage/guru/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="card-image">
                    @else
                        <i class="fa-solid fa-user-graduate card-icon text-6xl text-slate-400"></i>
                    @endif

                    <div class="card-content">
                        <h3 class="card-title">{{ $teacher->name }}</h3>
                        <p class="card-subtitle">{{ $teacher->position ?? 'Guru' }}</p>
                        @if ($teacher->subject)
                            <p class="card-subject">{{ $teacher->subject }}</p>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('guru.show', $teacher->id) }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 text-white text-sm font-semibold rounded-full hover:bg-blue-600 transition">
                                Detail
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-16 text-center">

            <i class="fa-solid fa-users text-6xl text-slate-300"></i>

            <h3 class="mt-6 text-2xl font-bold text-slate-700">
                Belum Ada Data Guru
            </h3>

            <p class="mt-2 text-slate-500">
                Data guru akan tampil di sini.
            </p>

        </div>

    @endif

</section>

@endsection
