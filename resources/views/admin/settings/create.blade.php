@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">


        {{-- HEADER --}}

        <div class="bg-white rounded-2xl shadow p-6">

            <h1 class="text-3xl font-bold flex items-center gap-3">
                <i class="fa-solid fa-gear text-primary-600"></i>
                Pengaturan Website
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola informasi utama website sekolah
            </p>

        </div>





        {{-- ALERT --}}

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


                <h2 class="text-xl font-bold mb-5 flex items-center gap-2">

                    <i class="fa-solid fa-school text-primary-600"></i>

                    Profil Sekolah

                </h2>



                <label class="font-semibold">

                    Deskripsi Sekolah

                </label>


                <textarea name="profil_sekolah" rows="5" placeholder="Tuliskan deskripsi singkat tentang profil sekolah..."
                    class="w-full border rounded-xl px-4 py-3 mt-2 focus:ring focus:ring-primary-300">


{{ old('profil_sekolah', $settings['profil_sekolah'] ?? '') }}


</textarea>



            </div>








            {{-- VISI MISI --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5 flex items-center gap-2">

                    <i class="fa-solid fa-bullseye text-green-600"></i>

                    Visi & Misi

                </h2>




                <div class="grid md:grid-cols-2 gap-6">



                    <div>

                        <label class="font-semibold">
                            Visi
                        </label>


                        <textarea name="visi" rows="5" placeholder="Masukkan visi sekolah..."
                            class="w-full border rounded-xl px-4 py-3 mt-2 focus:ring focus:ring-primary-300">


{{ old('visi', $settings['visi'] ?? '') }}


</textarea>


                    </div>





                    <div>

                        <label class="font-semibold">
                            Misi
                        </label>


                        <textarea name="misi" rows="5" placeholder="Tuliskan misi sekolah..."
                            class="w-full border rounded-xl px-4 py-3 mt-2 focus:ring focus:ring-primary-300">


{{ old('misi', $settings['misi'] ?? '') }}


</textarea>


                    </div>



                </div>


            </div>









            {{-- KONTAK --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5 flex items-center gap-2">

                    <i class="fa-solid fa-phone text-blue-600"></i>

                    Kontak Sekolah

                </h2>




                <div class="grid md:grid-cols-2 gap-6">



                    <div>

                        <label class="font-semibold">

                            Email

                        </label>


                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                            placeholder="contoh@email.com" class="w-full border rounded-xl px-4 py-3 mt-2">


                    </div>





                    <div>

                        <label class="font-semibold">

                            Telepon

                        </label>


                        <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}"
                            placeholder="0401-123456" class="w-full border rounded-xl px-4 py-3 mt-2">


                    </div>



                </div>


            </div>









            {{-- ALAMAT --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5 flex items-center gap-2">

                    <i class="fa-solid fa-location-dot text-red-600"></i>

                    Alamat Sekolah

                </h2>



                <input type="text" name="alamat" value="{{ old('alamat', $settings['alamat'] ?? '') }}"
                    placeholder="Alamat sekolah" class="w-full border rounded-xl px-4 py-3">


            </div>









            {{-- FOTO PROFIL --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5 flex items-center gap-2">


                    <i class="fa-solid fa-image text-purple-600"></i>


                    Foto Profil Sekolah


                </h2>





                <input type="file" name="profil_image" class="w-full border rounded-xl p-3">



                <p class="text-sm text-gray-500 mt-2">

                    Format JPG/PNG/WebP maksimal 2MB

                </p>




                @if (!empty($settings['profil_image']))
                    <div class="mt-5">


                        <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}"
                            class="w-56 h-40 object-cover rounded-xl shadow border">


                    </div>
                @endif



            </div>









            {{-- BUTTON --}}

            <div class="bg-white rounded-2xl shadow p-6 flex flex-wrap gap-3">



                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl flex items-center gap-2">


                    <i class="fa-solid fa-save"></i>

                    Simpan


                </button>





                <a href="{{ route('admin.dashboard') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl flex items-center gap-2">


                    <i class="fa-solid fa-xmark"></i>

                    Batal


                </a>




            </div>





        </form>



    </div>




@endsection
