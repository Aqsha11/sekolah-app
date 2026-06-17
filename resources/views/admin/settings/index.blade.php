@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')


    <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">



        {{-- HEADER --}}

        <div class="bg-white rounded-2xl shadow border p-6">


            <div class="flex flex-col sm:flex-row justify-between gap-5 items-start sm:items-center">


                <div>

                    <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-3">

                        <i class="fa-solid fa-gear text-blue-600"></i>

                        Pengaturan Website

                    </h1>


                    <p class="text-gray-500 mt-2 text-sm">

                        Informasi dan identitas website sekolah

                    </p>


                </div>




                <a href="{{ route('admin.settings.edit') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl flex items-center gap-2">

                    <i class="fa-solid fa-pen"></i>

                    Edit Pengaturan

                </a>



            </div>


        </div>






        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-5 py-3 rounded-xl">

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







        {{-- INFORMASI UTAMA --}}

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">







            {{-- WEBSITE --}}

            <div class="card">


                <h2 class="title">

                    <i class="fa-solid fa-globe text-blue-600"></i>

                    Informasi Website

                </h2>



                <div class="space-y-4">


                    <div>

                        <span class="label">
                            Nama Website
                        </span>

                        <p>
                            {{ $settings['nama_website'] ?? '-' }}
                        </p>


                    </div>



                    <div>

                        <span class="label">
                            Nama Sekolah
                        </span>

                        <p>
                            {{ $settings['nama_sekolah'] ?? '-' }}
                        </p>


                    </div>




                    <div>

                        <span class="label">
                            Tagline
                        </span>

                        <p>
                            {{ $settings['tagline'] ?? '-' }}
                        </p>


                    </div>



                </div>


            </div>










            {{-- KONTAK --}}

            <div class="card">


                <h2 class="title">

                    <i class="fa-solid fa-phone text-green-600"></i>

                    Kontak Sekolah

                </h2>



                <div class="space-y-3 text-sm">


                    <p>
                        📧 {{ $settings['email'] ?? '-' }}
                    </p>


                    <p>
                        📞 {{ $settings['telepon'] ?? '-' }}
                    </p>


                    <p class="break-words">

                        📍 {{ $settings['alamat'] ?? '-' }}

                    </p>



                </div>



            </div>









            {{-- KEPSEK --}}

            <div class="card">


                <h2 class="title">

                    <i class="fa-solid fa-user-tie text-purple-600"></i>

                    Kepala Sekolah

                </h2>




                <span class="label">
                    Nama
                </span>


                <p>

                    {{ $settings['nama_kepsek'] ?? '-' }}

                </p>



                <div class="mt-5">


                    <span class="label">

                        Sambutan

                    </span>


                    <p class="text-gray-600 text-sm leading-relaxed">

                        {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 200) }}

                    </p>


                </div>


            </div>











            {{-- SOSIAL MEDIA --}}

            <div class="card md:col-span-2 xl:col-span-1">


                <h2 class="title">

                    <i class="fa-solid fa-share-nodes text-blue-600"></i>

                    Sosial Media

                </h2>



                @if (count($socials))


                    <div class="space-y-4">


                        @foreach ($socials as $social)
                            <div class="flex gap-3">


                                <i class="{{ $social['icon'] }} mt-1"></i>


                                <div>


                                    <p class="font-semibold text-sm">

                                        {{ $social['name'] }}

                                    </p>


                                    <a href="{{ $social['url'] }}" target="_blank" class="text-blue-600 text-xs break-all">

                                        {{ $social['url'] }}

                                    </a>



                                </div>



                            </div>
                        @endforeach


                    </div>
                @else
                    <p class="text-gray-400 text-sm">

                        Belum ada sosial media

                    </p>


                @endif


            </div>





        </div>









        {{-- MEDIA WEBSITE --}}


        <div class="bg-white rounded-2xl shadow border p-6">


            <h2 class="text-xl font-bold mb-5">

                <i class="fa-solid fa-image text-orange-600"></i>

                Media Website

            </h2>




            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">



                @foreach ([
            'Logo' => $logo,
            'Favicon' => $favicon,
            'Profil' => $profilImage,
            'Kepsek' => $heroImage,
        ] as $name => $image)
                    <div class="card text-center">


                        <h3 class="font-semibold mb-4">

                            {{ $name }}

                        </h3>



                        @if ($image)
                            <img src="{{ asset('storage/settings/' . $image) }}" class="w-full h-32 object-cover rounded-xl">
                        @else
                            <p class="text-gray-400 text-sm">

                                Tidak ada gambar

                            </p>
                        @endif



                    </div>
                @endforeach



            </div>



        </div>









        {{-- PROFIL SEKOLAH --}}


        <div class="card">


            <h2 class="title mb-6">


                <i class="fa-solid fa-school text-blue-600"></i>

                Profil Sekolah


            </h2>





            <div class="space-y-6 text-sm leading-relaxed">



                <div>

                    <b>
                        Profil
                    </b>


                    <p class="text-gray-600 mt-2">

                        {{ $settings['profil_sekolah'] ?? '-' }}

                    </p>


                </div>





                <div>

                    <b>
                        Visi
                    </b>


                    <p class="text-gray-600 mt-2">

                        {{ $settings['visi'] ?? '-' }}

                    </p>


                </div>






                <div>

                    <b>
                        Misi
                    </b>


                    <p class="text-gray-600 mt-2">

                        {!! nl2br(e($settings['misi'] ?? '-')) !!}

                    </p>


                </div>






                <div>

                    <b>
                        Sejarah
                    </b>


                    <p class="text-gray-600 mt-2">

                        {{ $settings['sejarah'] ?? '-' }}

                    </p>


                </div>




            </div>



        </div>





    </div>







    <style>
        .card {

            @apply bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition;

        }



        .title {

            @apply text-lg font-bold mb-5 flex items-center gap-2;

        }



        .label {

            @apply text-xs uppercase text-gray-500 font-semibold block mb-1;

        }
    </style>




@endsection
