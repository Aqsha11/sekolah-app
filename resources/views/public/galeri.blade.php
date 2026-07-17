@extends('public.layouts')

@section('title', 'Galeri Sekolah')

@section('content')

@php
    $schoolName = $settings['nama_website'] ?? '';
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">photo_library</span>
            Galeri Sekolah
        </span>
        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">Galeri {{ $schoolName }}</h1>
        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Kumpulan foto kegiatan, dokumentasi acara, dan aktivitas sekolah.
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20" x-data="{ lightbox: null }">

    @if ($galeris->count() > 0)

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($galeris as $index => $galeri)

                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                    @click="lightbox = '{{ asset('storage/galeri/' . $galeri->image) }}'"
                    class="group relative cursor-pointer overflow-hidden rounded-2xl border border-slate-200 shadow-sm aspect-[4/3] bg-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                    @if($galeri->image)
                        <img src="{{ asset('storage/galeri/' . $galeri->image) }}" alt="{{ $galeri->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <span class="material-symbols-outlined text-5xl">image</span>
                        </div>
                    @endif

                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950 via-slate-900/40 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-sm text-white leading-relaxed font-semibold">{{ $galeri->title }}</p>
                        @if ($galeri->category)
                            <span class="inline-block mt-1 text-[10px] bg-white/20 backdrop-blur text-white px-2 py-0.5 rounded-full">{{ $galeri->category }}</span>
                        @endif
                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-12">
            {{ $galeris->links() }}
        </div>

    @else

        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300">photo_library</span>
            <h3 class="mt-6 text-2xl font-bold text-slate-700">Belum Ada Galeri</h3>
            <p class="mt-2 text-slate-500">Foto galeri akan tampil di sini.</p>
        </div>

    @endif

    {{-- Lightbox --}}
    <template x-teleport="body">
        <div x-show="lightbox !== null"
            class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4" x-cloak
            @click="lightbox = null">
            <button @click="lightbox = null"
                class="absolute top-6 right-6 w-10 h-10 rounded-full bg-slate-800 text-slate-300 hover:text-white flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div @click.stop class="max-w-4xl max-h-[85vh]">
                <img :src="lightbox" alt="Preview"
                    class="rounded-2xl border border-slate-800 shadow-2xl max-w-full max-h-[80vh] object-contain">
            </div>
        </div>
    </template>

</section>

@endsection
