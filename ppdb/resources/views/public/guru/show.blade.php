@extends('public.layouts')

@section('title', $teacher->name)

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-100/50 via-white to-primary-50"></div>
    <div class="relative max-w-6xl mx-auto px-4 md:px-6">

        <a href="{{ route('guru.index') }}"
            class="inline-flex items-center gap-2 text-slate-600 hover:text-primary-600 text-sm font-semibold transition mb-6">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke daftar guru
        </a>

        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg flex-shrink-0 bg-slate-200">
                @if ($teacher->photo)
                    <img src="{{ asset('storage/guru/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-3xl">person</span>
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900">{{ $teacher->name }}</h1>
                <p class="text-slate-600 mt-1 text-lg">{{ $teacher->position ?? 'Guru' }}</p>
                @if ($teacher->subject)
                    <span class="inline-block mt-2 text-xs bg-primary-100 text-primary-700 px-3 py-1 rounded-full font-semibold">
                        {{ $teacher->subject }}
                    </span>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-6xl mx-auto px-4 md:px-6 pb-20">

    <div class="max-w-3xl space-y-8">

        {{-- Info Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-8" data-aos="fade-up">
            <h3 class="text-lg font-bold text-slate-900 mb-6">
                <span class="material-symbols-outlined text-sm align-middle mr-2 text-primary-600">info</span>
                Informasi Guru
            </h3>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">menu_book</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Mata Pelajaran</p>
                        <p class="font-semibold text-slate-800 text-sm">{{ $teacher->subject ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">mail</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Email</p>
                        <p class="font-semibold text-slate-800 text-sm">{{ $teacher->email ?? '-' }}</p>
                    </div>
                </div>

                @if ($teacher->bio)
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-lg">person</span>
                            </div>
                            <p class="text-xs text-slate-500 uppercase font-medium">Tentang</p>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed mt-2 pl-[52px]">{{ $teacher->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Back Button --}}
        <div data-aos="fade-up">
            <a href="{{ route('guru.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition shadow-md">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke daftar guru
            </a>
        </div>

    </div>

</section>

@endsection
