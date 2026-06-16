@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-2xl shadow-lg p-8">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">

                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fa-solid fa-gear text-blue-600"></i>
                    Pengaturan Website
                </h1>


                <a href="{{ route('admin.settings.edit') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl flex items-center gap-2 transition">

                    <i class="fa-solid fa-pen"></i>
                    Edit Pengaturan

                </a>

            </div>


            @if (session('success'))
                <div class="mb-6 bg-green-100 text-green-700 px-5 py-3 rounded-xl">

                    {{ session('success') }}

                </div>
            @endif



            @php

                $logo = $settings['logo'] ?? null;
                $favicon = $settings['favicon'] ?? null;
                $profilImage = $settings['profil_image'] ?? null;
                $heroImage = $settings['hero_image'] ?? null;

                $socials = json_decode($settings['social_media'] ?? '[]', true);

            @endphp



            {{-- INFO CARD --}}

            <div class="grid md:grid-cols-2 gap-6">


                {{-- WEBSITE --}}

                <div class="card">

                    <h2 class="title">
                        Informasi Website
                    </h2>


                    <p>
                        <b>Nama Website</b><br>
                        {{ $settings['nama_website'] ?? '-' }}
                    </p>


                    <p>
                        <b>Tagline</b><br>
                        {{ $settings['tagline'] ?? '-' }}
                    </p>


                    <p>
                        <b>Nama Sekolah</b><br>
                        {{ $settings['nama_sekolah'] ?? '-' }}
                    </p>


                </div>



                {{-- KONTAK --}}

                <div class="card">


                    <h2 class="title">
                        Kontak
                    </h2>


                    <p>📧 {{ $settings['email'] ?? '-' }}</p>

                    <p>📞 {{ $settings['telepon'] ?? '-' }}</p>

                    <p>💬 {{ $settings['whatsapp'] ?? '-' }}</p>

                    <p>📍 {{ $settings['alamat'] ?? '-' }}</p>


                </div>





                {{-- SOSMED --}}

                <div class="card">


                    <h2 class="title">
                        Sosial Media
                    </h2>


                    @forelse($socials as $social)
                        <div class="flex items-center gap-3 mb-3">

                            <i class="{{ $social['icon'] }}"></i>


                            <div>

                                <p class="font-semibold">
                                    {{ $social['name'] }}
                                </p>


                                <a href="{{ $social['url'] }}" target="_blank" class="text-blue-600 text-sm">

                                    {{ $social['url'] }}

                                </a>

                            </div>


                        </div>


                    @empty

                        <p class="text-gray-400">
                            Belum ada sosial media
                        </p>
                    @endforelse



                </div>




                {{-- KEPALA SEKOLAH --}}

                <div class="card">


                    <h2 class="title">
                        Kepala Sekolah
                    </h2>


                    <p>

                        <b>Nama</b><br>

                        {{ $settings['nama_kepsek'] ?? '-' }}

                    </p>



                    <p class="mt-3">

                        <b>Sambutan</b><br>

                        {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 200) }}

                    </p>



                </div>


            </div>





            {{-- MEDIA --}}


            <div class="mt-10">


                <h2 class="text-xl font-bold mb-5">
                    Media Website
                </h2>


                <div class="grid md:grid-cols-4 gap-6">


                    @foreach ([
            'Logo' => $logo,
            'Favicon' => $favicon,
            'Profil Sekolah' => $profilImage,
            'Foto Kepsek' => $heroImage,
        ] as $name => $image)
                        <div class="card text-center">


                            <h3 class="font-semibold mb-4">
                                {{ $name }}
                            </h3>



                            @if ($image)
                                <img src="{{ asset('storage/settings/' . $image) }}"
                                    class="mx-auto rounded-xl h-32 object-cover">
                            @else
                                <p class="text-gray-400">
                                    Tidak ada gambar
                                </p>
                            @endif



                        </div>
                    @endforeach



                </div>


            </div>





            {{-- PROFIL SEKOLAH --}}


            <div class="mt-10 card">


                <h2 class="title mb-6">
                    Profil Sekolah
                </h2>



                <div class="space-y-5">


                    <div>

                        <b>Profil</b>

                        <p>
                            {{ $settings['profil_sekolah'] ?? '-' }}
                        </p>

                    </div>



                    <div>

                        <b>Visi</b>

                        <p>
                            {{ $settings['visi'] ?? '-' }}
                        </p>

                    </div>



                    <div>

                        <b>Misi</b>

                        <p>
                            {!! nl2br(e($settings['misi'] ?? '-')) !!}
                        </p>

                    </div>




                    <div>

                        <b>Sejarah</b>

                        <p>
                            {{ $settings['sejarah'] ?? '-' }}
                        </p>

                    </div>



                </div>


            </div>


        </div>


    </div>




    <style>
        .card {

            @apply bg-white border rounded-2xl p-6 shadow-sm hover:shadow-md transition;

        }


        .title {

            @apply text-xl font-bold mb-5 flex items-center gap-2;

        }
    </style>


@endsection
