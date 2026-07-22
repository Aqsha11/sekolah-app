@extends('public.layouts')

@section('title', 'Fasilitas Sekolah')

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-semibold shadow-sm">
            <span class="material-symbols-outlined text-sm">apartment</span>
            Fasilitas Sekolah
        </span>
        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">Sarana & Prasarana</h1>
        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Fasilitas terbaik untuk mendukung proses pembelajaran yang nyaman, aman, dan berkualitas bagi seluruh peserta didik.
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    @if($fasilitas->count())

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($fasilitas as $index => $item)

                <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                    class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">

                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-5xl">apartment</span>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 bg-primary-600 text-white text-[10px] font-bold uppercase px-2.5 py-1 rounded-full shadow">
                            Aktif
                        </span>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-sm text-slate-900">{{ $item->name }}</h3>
                        <p class="text-[11px] text-slate-500 leading-relaxed mt-2 flex-1 line-clamp-3">
                            {{ $item->description }}
                        </p>
                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-12">
            {{ $fasilitas->links() }}
        </div>

    @else

        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300">apartment</span>
            <h3 class="mt-6 text-2xl font-bold text-slate-700">Belum Ada Fasilitas</h3>
            <p class="mt-2 text-slate-500">Data fasilitas sekolah belum tersedia.</p>
        </div>

    @endif

</section>

@endsection
