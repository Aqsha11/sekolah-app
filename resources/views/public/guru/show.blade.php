@extends('public.layouts')

@section('title', $teacher->name)

@section('content')

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-6xl mx-auto px-4 md:px-6">

        {{-- <a href="{{ route('guru.index') }}"
            class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-500 text-sm font-semibold transition mb-6">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Kembali ke daftar guru
        </a> --}}

        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg flex-shrink-0 bg-slate-200">

                @if ($teacher->photo)
                    <img src="{{ asset('storage/guru/' . $teacher->photo) }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-user text-3xl"></i>
                    </div>
                @endif

            </div>

            <div>

                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm mb-3">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Detail Guru
                </span>

                <h1 class="text-3xl md:text-5xl font-bold text-slate-900">
                    {{ $teacher->name }}
                </h1>

                <p class="text-slate-600 mt-2 text-lg">
                    {{ $teacher->position ?? 'Guru' }}
                </p>

            </div>

        </div>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-6xl mx-auto px-4 md:px-6 pb-20">

    <div class="max-w-3xl">

        <div class="bg-white rounded-xl shadow-md border border-slate-100 p-8">

            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                Informasi Guru
            </h3>

            <div class="space-y-5">

                <div class="flex items-center gap-4 p-5 bg-slate-50 rounded-2xl">

                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-book"></i>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Mata Pelajaran</p>
                        <p class="font-semibold text-slate-800">
                            {{ $teacher->subject ?? '-' }}
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-4 p-5 bg-slate-50 rounded-2xl">

                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-semibold text-slate-800">
                            {{ $teacher->email ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="mt-8">
                <a href="{{ route('guru.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 text-white text-sm font-semibold rounded-full hover:bg-blue-600 transition shadow-md">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke daftar guru
                </a>
            </div>

        </div>

    </div>

</section>

@endsection
