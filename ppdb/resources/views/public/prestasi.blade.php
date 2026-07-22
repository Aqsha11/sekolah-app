@extends('public.layouts')

@section('title', 'Prestasi Sekolah')

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">military_tech</span>
            Prestasi Sekolah
        </span>
        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">Prestasi & Pencapaian</h1>
        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Dokumentasi berbagai pencapaian akademik, non akademik, dan olahraga siswa.
        </p>
    </div>
</section>

{{-- STATS --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 -mt-10 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div data-aos="fade-up" data-aos-delay="0" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">emoji_events</span>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Prestasi</p>
                    <p class="text-2xl font-bold text-primary-600">{{ $prestasi->total() }}</p>
                </div>
            </div>
        </div>
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">category</span>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Kategori</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $prestasi->groupBy('category')->count() }}</p>
                </div>
            </div>
        </div>
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">trending_up</span>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Prestasi Terbaru</p>
                    <p class="text-sm font-semibold text-slate-900 line-clamp-1">{{ $prestasi->first()?->title ?? 'Belum ada data' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-16">

    @foreach (['Akademik', 'Olahraga', 'Teknologi & Multimedia', 'Seni'] as $kategori)
        @php
            $items = $prestasi->where('category', $kategori);
            $color = match ($kategori) {
                'Akademik' => 'bg-primary-600',
                'Olahraga' => 'bg-emerald-600',
                'Teknologi & Multimedia' => 'bg-purple-600',
                'Seni' => 'bg-amber-600',
                default => 'bg-slate-600',
            };
        @endphp

        <div class="mb-14">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">
                        <span class="{{ $color }} text-white text-xs px-3 py-1 rounded-lg shadow inline-block align-middle mr-2">{{ $kategori }}</span>
                    </h2>
                    <p class="text-slate-500 mt-2 text-sm">Daftar pencapaian siswa kategori {{ $kategori }}</p>
                </div>
                <span class="hidden md:flex items-center px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium">
                    {{ $items->count() }} Prestasi
                </span>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($items as $index2 => $item)
                    <a href="{{ route('prestasi.show', $item->id) }}"
                        data-aos="fade-up" data-aos-delay="{{ ($index2 % 3) * 100 }}"
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">

                        <div class="h-48 overflow-hidden bg-slate-100 relative">
                            @if ($item->image)
                                <img src="{{ asset('storage/prestasi/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-5xl">emoji_events</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                {{ $item->year }} &bull; {{ $item->level }}
                            </span>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-bold text-sm text-slate-900 group-hover:text-primary-600 transition leading-snug">{{ $item->title }}</h3>
                            @if ($item->description)
                                <p class="text-[11px] text-slate-500 leading-relaxed mt-2 flex-1 line-clamp-2">
                                    {{ Str::limit(strip_tags($item->description), 100) }}
                                </p>
                            @endif
                            <span class="inline-flex items-center gap-1 mt-3 text-[11px] font-bold text-primary-600 group-hover:text-primary-700 transition">
                                Lihat Detail
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </span>
                        </div>

                    </a>

                @empty

                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-300">emoji_events</span>
                            <h3 class="mt-4 text-lg font-semibold text-slate-700">Belum ada data prestasi {{ $kategori }}</h3>
                            <p class="text-slate-500 mt-2 text-sm">Data prestasi akan tampil di sini.</p>
                        </div>
                    </div>

                @endforelse

            </div>
        </div>
    @endforeach

    <div class="mt-10">
        {{ $prestasi->links() }}
    </div>

</section>

@endsection
