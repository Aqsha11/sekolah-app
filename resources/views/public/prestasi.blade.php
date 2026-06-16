@extends('public.layouts')

@section('title', 'Prestasi Sekolah')

@section('content')

<style>
    .card-prestasi {
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

    .card-prestasi .card-icon {
        width: 64px;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
    }

    .card-prestasi:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-prestasi .card-content {
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

    .card-prestasi:hover .card-content {
        transform: rotateX(0deg);
    }

    .card-prestasi .card-title {
        margin: 0;
        font-size: 16px;
        color: #333;
        font-weight: 700;
    }

    .card-prestasi:hover .card-icon {
        scale: 0;
    }

    .card-prestasi .card-description {
        margin: 10px 0 0;
        font-size: 13px;
        color: #555;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-prestasi .card-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        backdrop-filter: blur(4px);
        color: #fff;
    }

    .card-prestasi .card-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 0;
    }

    .card-prestasi:hover .card-image {
        scale: 0;
    }

    .card-prestasi .card-meta {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        background: rgba(15, 23, 42, 0.8);
        color: #fff;
        backdrop-filter: blur(4px);
    }
</style>

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-trophy"></i>
            Prestasi Sekolah
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
            Prestasi & Pencapaian
        </h1>

        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Dokumentasi berbagai pencapaian akademik, non akademik, dan olahraga siswa.
        </p>

    </div>

</section>

{{-- STATS --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 -mt-10 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div data-aos="fade-up" data-aos-delay="0" class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 border border-white/50">
            <h3 class="text-sm text-slate-600 font-medium">Total Prestasi</h3>
            <p class="text-3xl font-bold text-blue-500 mt-2">
                {{ $prestasi->total() }}
            </p>
        </div>

        <div data-aos="fade-up" data-aos-delay="100" class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 border border-white/50">
            <h3 class="text-sm text-slate-600 font-medium">Kategori</h3>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $prestasi->groupBy('category')->count() }}
            </p>
        </div>

        <div data-aos="fade-up" data-aos-delay="200" class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 border border-white/50">
            <h3 class="text-sm text-slate-600 font-medium">Prestasi Terbaru</h3>
            <p class="text-lg font-semibold text-slate-900 mt-2 line-clamp-1">
                {{ $prestasi->first()?->title ?? 'Belum ada data' }}
            </p>
        </div>

    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-16">

    @foreach (['Akademik', 'Olahraga', 'Teknologi & Multimedia', 'Seni'] as $kategori)
        @php
            $items = $prestasi->where('category', $kategori);
        @endphp

        <div class="mb-14">

            <div class="flex items-center justify-between mb-8">

                <div>
                    <h2 class="text-3xl font-bold text-slate-900">

                        @php
                            $color = match ($kategori) {
                                'Akademik' => 'bg-blue-600',
                                'Olahraga' => 'bg-green-600',
                                'Teknologi & Multimedia' => 'bg-purple-600',
                                'Seni' => 'bg-blue-500',
                                default => 'bg-slate-600',
                            };
                        @endphp

                        <span class="{{ $color }} text-white text-xs px-3 py-1 rounded-lg shadow">
                            {{ $kategori }}
                        </span>

                    </h2>

                    <p class="text-slate-600 mt-2">
                        Daftar pencapaian siswa kategori {{ $kategori }}
                    </p>
                </div>

                <span
                    class="hidden md:flex items-center px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium">
                    {{ $items->count() }} Prestasi
                </span>

            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($items as $index2 => $item)

                    <div data-aos="fade-up" data-aos-delay="{{ ($index2 % 3) * 100 }}" class="card-prestasi">

                        @if ($item->image)
                            <img src="{{ asset('storage/prestasi/' . $item->image) }}" alt="{{ $item->title }}" class="card-image">
                        @else
                            <i class="fa-solid fa-trophy card-icon text-6xl text-slate-400"></i>
                        @endif

                        <span class="card-badge" style="background: rgba(34, 197, 94, 0.9);">Aktif</span>

                        <span class="card-meta">{{ $item->year }} • {{ $item->level }}</span>

                        <div class="card-content">
                            <h3 class="card-title">{{ $item->title }}</h3>
                            <p class="card-description">{{ $item->description }}</p>
                            <div class="mt-3">
                                <a href="{{ route('prestasi.show', $item->id) }}"
                                    class="text-blue-500 text-sm font-semibold hover:underline inline-flex items-center gap-1">
                                    Lihat Detail <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                @empty

                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center">
                            <i class="fa-solid fa-trophy text-5xl text-slate-300"></i>
                            <h3 class="mt-4 text-lg font-semibold text-slate-700">
                                Belum ada data prestasi {{ $kategori }}
                            </h3>
                            <p class="text-slate-500 mt-2">
                                Data prestasi akan tampil di sini.
                            </p>
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
