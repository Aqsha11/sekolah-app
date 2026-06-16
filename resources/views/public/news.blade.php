@extends('public.layouts')

@section('title', 'Berita Sekolah')

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6">

        <div class="flex flex-col lg:flex-row items-center justify-between gap-10">

            <div class="max-w-3xl">

                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
                    <i class="fa-solid fa-newspaper"></i>
                    Berita Sekolah
                </span>

                <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
                    Berita & Kegiatan
                </h1>

                <p class="mt-5 text-slate-600 text-lg leading-relaxed">
                    Informasi terbaru seputar kegiatan sekolah, prestasi siswa, pengumuman, dan berbagai aktivitas.
                </p>

            </div>

            <div data-aos="fade-left" class="w-full lg:w-[350px]">

                <form action="{{ route('berita.index') }}" method="GET" class="bg-white/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/50">

                    <label class="text-sm text-slate-700 mb-3 block font-medium">
                        Cari Berita
                    </label>

                    <div class="flex gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari berita..."
                            class="flex-1 bg-white rounded-lg px-4 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm border border-slate-200">

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 rounded-lg font-semibold transition">
                            Cari
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

{{-- MAIN CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-16">

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 md:gap-10">

        {{-- CONTENT --}}
        <div class="lg:col-span-3">

            @if ($berita->count())

                {{-- FEATURED NEWS --}}
                @if ($berita->first())

                    <div data-aos="fade-up" class="relative overflow-hidden rounded-xl shadow-lg mb-12 group">

                        {{-- IMAGE --}}
                        @if ($berita->first()->image)
                            <img src="{{ asset('storage/berita/' . $berita->first()->image) }}"
                                alt="{{ $berita->first()->title }}"
                                class="w-full h-80 md:h-96 object-cover group-hover:scale-105 transition duration-700">
                        @else
                            <div
                                class="w-full h-80 md:h-96 bg-slate-300 flex items-center justify-center text-slate-500">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                        </div>

                        {{-- CONTENT --}}
                        <div class="absolute bottom-0 left-0 p-6 md:p-8 text-white">

                            <span
                                class="inline-flex px-4 py-2 rounded-lg bg-blue-500 text-slate-900 text-xs font-semibold mb-4">
                                Berita Utama
                            </span>

                            <h2 class="text-2xl md:text-3xl font-bold mb-3 max-w-3xl">
                                {{ $berita->first()->title }}
                            </h2>

                            <p class="text-slate-200 mb-4 max-w-2xl line-clamp-2 text-sm md:text-base">
                                {{ strip_tags($berita->first()->content) }}
                            </p>

                            <div class="flex items-center gap-4 text-sm text-slate-200 mb-4">

                                <span>
                                    📅
                                    {{ \Carbon\Carbon::parse($berita->first()->created_at)->translatedFormat('d F Y') }}
                                </span>

                                <span>
                                    🏷️
                                    {{ $berita->first()->category }}
                                </span>

                            </div>

                            <a href="{{ route('berita.show', $berita->first()->slug) }}"
                                class="bg-white text-center w-44 rounded-2xl h-10 relative text-black text-sm font-semibold group inline-flex items-center justify-center border border-slate-200">
                                <div
                                    class="bg-blue-500 rounded-xl h-8 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[168px] z-10 duration-500">

                                </div>
                                <span class="translate-x-2 z-20">Baca Selengkapnya</span>
                            </a>

                        </div>

                    </div>

                @endif

                {{-- GRID NEWS --}}
                <div class="grid md:grid-cols-2 gap-6">

                    @foreach ($berita->skip(1) as $index => $item)
                        <article data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}"
                            class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300">

                            {{-- IMAGE --}}
                            <div class="relative overflow-hidden h-40 md:h-48">

                                @if ($item->image)
                                    <img src="{{ asset('storage/berita/' . $item->image) }}" alt="{{ $item->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500">
                                        <i class="fa-solid fa-image text-3xl"></i>
                                    </div>
                                @endif

                                {{-- CATEGORY --}}
                                <div class="absolute top-3 left-3">

                                    <span class="bg-slate-900 text-white text-xs px-3 py-1 rounded-lg shadow">
                                        {{ $item->category }}
                                    </span>

                                </div>

                            </div>

                            {{-- CONTENT --}}
                            <div class="p-5">

                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">

                                    <span>
                                        📅
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                    </span>

                                </div>

                                <h3
                                    class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-blue-500 transition">

                                    {{ $item->title }}

                                </h3>

                                <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">

                                    {{ strip_tags($item->content) }}

                                </p>

                                {{-- BUTTON --}}
                                <div class="mt-4">

                                    <a href="{{ route('berita.show', $item->slug) }}"
                                        class="bg-white text-center w-44 rounded-2xl h-10 relative text-black text-sm font-semibold group inline-flex items-center justify-center border border-slate-200">
                                        <div
                                            class="bg-blue-500 rounded-xl h-8 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[168px] z-10 duration-500">

                                        </div>
                                        <span class="translate-x-2 z-20">Baca Selengkapnya</span>
                                    </a>

                                </div>

                            </div>

                        </article>
                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-12">
                    {{ $berita->links() }}
                </div>
            @else
                {{-- EMPTY --}}
                <div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-12 text-center">

                    <div class="text-5xl mb-4">
                        📰
                    </div>

                    <h3 class="text-2xl font-bold text-slate-700 mb-2">
                        Belum Ada Berita
                    </h3>

                    <p class="text-slate-500">
                        Data berita sekolah akan tampil di sini.
                    </p>

                </div>

            @endif

        </div>

        {{-- SIDEBAR --}}
        <aside class="space-y-6">

            {{-- KATEGORI --}}
            <div data-aos="fade-up" class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">
                    Kategori
                </h3>

                <div class="flex flex-wrap gap-2">

                    {{-- Semua --}}
                    <a href="{{ route('berita.index') }}"
                        class="px-3 py-2 rounded-lg text-xs font-medium transition
        {{ request('category') == null ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Semua
                    </a>

                    {{-- List kategori --}}
                    @foreach ($categories as $category)
                        <a href="{{ route('berita.index', ['category' => $category]) }}"
                            class="px-3 py-2 rounded-lg text-xs font-medium transition
            {{ request('category') == $category ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $category }}
                        </a>
                    @endforeach

                </div>
            </div>

            {{-- LATEST --}}
            <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-xl shadow-md p-6">

                <h3 class="text-lg font-bold text-slate-900 mb-4">
                    Berita Terbaru
                </h3>

                <div class="space-y-4">

                    @foreach ($artikelTerbaru as $latest)
                        <a href="{{ route('berita.show', $latest->slug) }}" class="flex gap-3 group">

                            {{-- IMAGE --}}
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">

                                @if ($latest->image)
                                    <img src="{{ asset('storage/berita/' . $latest->image) }}"
                                        alt="{{ $latest->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                @else
                                    <div
                                        class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500 text-xs">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif

                            </div>

                            {{-- TEXT --}}
                            <div class="flex-1 min-w-0">

                                <h4
                                    class="font-semibold text-slate-800 line-clamp-2 group-hover:text-blue-500 transition text-sm">

                                    {{ $latest->title }}

                                </h4>

                                <p class="text-xs text-slate-500 mt-1">

                                    {{ \Carbon\Carbon::parse($latest->created_at)->translatedFormat('d F Y') }}

                                </p>

                            </div>

                        </a>
                    @endforeach

                </div>

            </div>

        </aside>

    </div>

</section>

@endsection
