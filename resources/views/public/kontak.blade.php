@extends('public.layouts')

@section('title', 'Kontak Kami')

@section('content')

@php
    $alamat = $settings['alamat'] ?? 'Alamat sekolah belum diisi';
    $telepon = $settings['telepon'] ?? 'Telepon sekolah belum diisi';
    $email = $settings['email'] ?? 'Email sekolah belum diisi';
    $jam = $settings['jam_operasional'] ?? 'Senin - Jumat 07:00 - 14:00';
    // $maps = $settings['google_maps'] ?? 'https://www.google.com/maps?q=SMPN%201%20Lambandia&output=embed';
@endphp

{{-- HERO --}}
<section data-aos="fade-in" class="relative overflow-hidden py-20">

    <div class="absolute inset-0 bg-gradient-to-br from-[#C4E2F5]/50 via-white to-sky-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 text-center">

        <span
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500 text-white text-sm font-semibold shadow-sm">
            <i class="fa-solid fa-envelope"></i>
            Kontak Kami
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold text-slate-900">
            Hubungi Kami
        </h1>

        <p class="max-w-2xl mx-auto mt-5 text-slate-600 text-lg leading-relaxed">
            Silakan hubungi pihak sekolah melalui informasi berikut atau kirim pesan langsung melalui form kontak.
        </p>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- LEFT --}}
        <div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900">
                    Informasi Sekolah
                </h2>

                <p class="text-slate-600 mt-2">
                    Data kontak resmi
                </p>
            </div>

            <div class="space-y-4">

                <div data-aos="fade-up" data-aos-delay="0"
                    class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition duration-300 p-5 flex gap-4 border border-white/50">

                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900">
                            Alamat
                        </h3>

                        <p class="text-slate-600 mt-1 leading-relaxed text-sm">
                            {{ $settings['alamat'] ?? '-' }}
                        </p>
                    </div>

                </div>

                <div data-aos="fade-up" data-aos-delay="100"
                    class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition duration-300 p-5 flex gap-4 border border-white/50">

                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900">
                            Telepon
                        </h3>

                        <p class="text-slate-600 mt-1 text-sm">
                            {{ $settings['telepon'] ?? '-' }}
                        </p>
                    </div>

                </div>

                <div data-aos="fade-up" data-aos-delay="200"
                    class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition duration-300 p-5 flex gap-4 border border-white/50">

                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900">
                            Email
                        </h3>

                        <p class="text-slate-600 mt-1 text-sm">
                            {{ $settings['email'] ?? '-' }}
                        </p>
                    </div>

                </div>

                <div data-aos="fade-up" data-aos-delay="300"
                    class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition duration-300 p-5 flex gap-4 border border-white/50">

                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900">
                            Jam Operasional
                        </h3>

                        <p class="text-slate-600 mt-1 text-sm">
                            {{ $jam }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- <div class="mt-8 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-md overflow-hidden border border-white/50">

                <iframe src="{{ $maps }}" class="w-full h-72 rounded-lg" loading="lazy" allowfullscreen>
                </iframe>

            </div> --}}

        </div>

        {{-- RIGHT --}}
        <div>

            <div data-aos="fade-left" class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-6 md:p-8 border border-white/50">

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-slate-900">
                        Kirim Pesan
                    </h2>

                    <p class="text-slate-600 mt-2 text-sm">
                        Kami akan merespon pesan Anda secepat mungkin.
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kontak.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full rounded-lg border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 p-3 transition text-sm"
                            placeholder="Masukkan nama lengkap">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full rounded-lg border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 p-3 transition text-sm"
                            placeholder="email@gmail.com">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Subjek
                        </label>

                        <input type="text" name="subject" value="{{ old('subject') }}"
                            class="w-full rounded-lg border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 p-3 transition text-sm"
                            placeholder="Masukkan subjek pesan">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Pesan
                        </label>

                        <textarea name="message" rows="5"
                            class="w-full rounded-lg border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200/50 p-3 transition resize-none text-sm"
                            placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition duration-300">

                        <i class="fa-solid fa-paper-plane mr-2"></i>
                        Kirim Pesan

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection
