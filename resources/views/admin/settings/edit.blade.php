@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan Website')

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">


        {{-- HEADER --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <h1 class="text-3xl font-bold flex items-center gap-3">
                <i class="fa-solid fa-gear text-blue-600"></i>
                Pengaturan Website
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola semua informasi website sekolah
            </p>

        </div>



        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif




        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">


            @csrf
            @method('PUT')




            {{-- PROFIL SEKOLAH --}}

            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold mb-5 flex gap-2">
                    <i class="fa-solid fa-school text-blue-600"></i>
                    Profil Sekolah
                </h2>


                <div class="space-y-5">


                    <div>
                        <label class="font-semibold">
                            Profil Sekolah
                        </label>

                        <textarea name="profil_sekolah" rows="5" class="w-full border rounded-xl p-3 mt-2">

{{ old('profil_sekolah', $settings['profil_sekolah'] ?? '') }}

</textarea>

                    </div>



                    <div>

                        <label class="font-semibold">
                            Sambutan Kepala Sekolah
                        </label>


                        <textarea name="sambutan_kepsek" rows="5" class="w-full border rounded-xl p-3 mt-2">

{{ old('sambutan_kepsek', $settings['sambutan_kepsek'] ?? '') }}

</textarea>


                    </div>




                    <div class="grid md:grid-cols-2 gap-5">


                        <div>

                            <label class="font-semibold">
                                Visi
                            </label>


                            <textarea name="visi" rows="4" class="w-full border rounded-xl p-3 mt-2">

{{ old('visi', $settings['visi'] ?? '') }}

</textarea>

                        </div>



                        <div>

                            <label class="font-semibold">
                                Misi
                            </label>


                            <textarea name="misi" rows="4" class="w-full border rounded-xl p-3 mt-2">

{{ old('misi', $settings['misi'] ?? '') }}

</textarea>

                        </div>


                    </div>


                </div>

            </div>






            {{-- KONTAK --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-phone text-green-600"></i>
                    Kontak Sekolah
                </h2>


                <div class="grid md:grid-cols-2 gap-5">


                    <div>

                        <label>Email</label>

                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                            class="w-full border rounded-xl p-3 mt-2">

                    </div>




                    <div>

                        <label>Telepon</label>

                        <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}"
                            class="w-full border rounded-xl p-3 mt-2">

                    </div>


                </div>



                <div class="mt-5">

                    <label>Alamat</label>


                    <input type="text" name="alamat" value="{{ old('alamat', $settings['alamat'] ?? '') }}"
                        class="w-full border rounded-xl p-3 mt-2">


                </div>


            </div>






            {{-- KEPALA SEKOLAH --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-user-tie text-purple-600"></i>
                    Kepala Sekolah
                </h2>


                <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $settings['nama_kepsek'] ?? '') }}"
                    placeholder="Nama Kepala Sekolah" class="w-full border rounded-xl p-3">


            </div>






            {{-- MEDIA --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-image text-orange-600"></i>
                    Media Website
                </h2>



                <div class="grid md:grid-cols-2 gap-6">


                    <div>

                        <label>Foto Profil</label>

                        <input type="file" name="profil_image" class="w-full border rounded-xl p-3 mt-2">


                        @if (!empty($settings['profil_image']))
                            <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}"
                                class="mt-4 w-48 rounded-xl">
                        @endif


                    </div>



                    <div>

                        <label>Foto Kepala Sekolah</label>

                        <input type="file" name="hero_image" class="w-full border rounded-xl p-3 mt-2">


                        @if (!empty($settings['hero_image']))
                            <img src="{{ asset('storage/settings/' . $settings['hero_image']) }}"
                                class="mt-4 w-full h-40 object-cover rounded-xl">
                        @endif


                    </div>



                </div>


            </div>







            {{-- IDENTITAS WEBSITE --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-globe text-blue-600"></i>
                    Identitas Website
                </h2>



                <div class="grid md:grid-cols-2 gap-5">


                    <div>
                        <label>Nama Sekolah:</label>

                        <input name="nama_sekolah" value="{{ $settings['nama_sekolah'] ?? '' }}" class="input">

                    </div>


                    <div>

                        <label>Nama Website:</label>

                        <input name="nama_website" value="{{ $settings['nama_website'] ?? '' }}" class="input">

                    </div>



                    <div>

                        <label>Tagline:</label>

                        <input name="tagline" value="{{ $settings['tagline'] ?? '' }}" class="input">

                    </div>



                </div>


            </div>






            {{-- LOGO --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-image text-red-600"></i>
                    Logo Website
                </h2>



                <div class="grid md:grid-cols-2 gap-6">


                    <div>

                        <label>Logo</label>

                        <input type="file" name="logo" class="input">


                    </div>


                    <div>

                        <label>Favicon</label>

                        <input type="file" name="favicon" class="input">


                    </div>



                </div>


            </div>







            {{-- SOSIAL MEDIA --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-share-nodes text-blue-600"></i>
                    Sosial Media
                </h2>


                @php
                    $socials = json_decode($settings['social_media'] ?? '[]', true);
                @endphp


                <div id="social-wrapper" class="space-y-3">


                    @foreach ($socials as $i => $item)
                        <div class="grid grid-cols-12 gap-3">


                            <input name="social_media[{{ $i }}][name]" value="{{ $item['name'] }}"
                                class="input col-span-3">


                            <input name="social_media[{{ $i }}][icon]" value="{{ $item['icon'] }}"
                                class="input col-span-3">


                            <input name="social_media[{{ $i }}][url]" value="{{ $item['url'] }}"
                                class="input col-span-5">


                            <button type="button" class="bg-red-600 text-white rounded-lg">

                                ×


                            </button>


                        </div>
                    @endforeach


                </div>



                <button type="button" class="mt-5 bg-green-600 text-white px-5 py-2 rounded-lg">

                    + Tambah

                </button>


            </div>







            {{-- ACTION --}}

            <div class="bg-white rounded-2xl shadow p-6 flex gap-3">


                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">

                    <i class="fa fa-save"></i>
                    Simpan

                </button>



                <a href="{{ route('admin.settings.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Batal

                </a>


            </div>




        </form>


    </div>




    <style>
        .input {
            @apply w-full border rounded-xl p-3 mt-2;
        }
    </style>


@endsection
