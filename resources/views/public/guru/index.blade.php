@extends('public.layouts')

@section('title', 'Guru & Tenaga Pendidik')

@section('content')

@php
    $schoolName = $settings['nama_website'] ?? 'Sekolah';
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">groups</span>
            Tenaga Pendidik
        </span>
        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">Guru & Tenaga Pendidik</h1>
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

                <a href="{{ route('guru.show', $teacher->id) }}"
                    data-aos="fade-up"
                    class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col text-center">

                    <div class="h-56 overflow-hidden bg-slate-100">
                        @if ($teacher->photo)
                            <img src="{{ asset('storage/guru/' . $teacher->photo) }}" alt="{{ $teacher->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-5xl">person</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-sm text-slate-900 group-hover:text-primary-600 transition">{{ $teacher->name }}</h3>
                        <p class="text-[11px] text-primary-600 font-semibold mt-1">{{ $teacher->position ?? 'Guru' }}</p>
                        @if ($teacher->subject)
                            <span class="inline-block mt-2 text-[10px] bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full font-medium self-center">
                                {{ $teacher->subject }}
                            </span>
                        @endif
                    </div>

                </a>

            @endforeach

        </div>

    @else

        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300">groups</span>
            <h3 class="mt-6 text-2xl font-bold text-slate-700">Belum Ada Data Guru</h3>
            <p class="mt-2 text-slate-500">Data guru akan tampil di sini.</p>
        </div>

    @endif

</section>

@endsection
