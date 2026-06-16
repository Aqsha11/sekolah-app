@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-6">

            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-gear text-primary-600"></i>
                Pengaturan Website
            </h1>

            <a href="{{ route('admin.settings.edit') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-pen"></i>
                Edit Pengaturan
            </a>

        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @php
            $logo = $settings['logo'] ?? null;
            $favicon = $settings['favicon'] ?? null;
            $profilImage = $settings['profil_image'] ?? null;
            $heroImage = $settings['hero_image'] ?? null;
            // $sliderImage = $settings['slider_image'] ?? null;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- WEBSITE --}}
            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">
                    Informasi Website
                </h2>

                <div class="space-y-3">

                    <div>
                        <span class="font-semibold">Nama Website :</span><br>
                        {{ $settings['nama_website'] ?? '-' }}
                    </div>

                    <div>
                        <span class="font-semibold">Tagline :</span><br>
                        {{ $settings['tagline'] ?? '-' }}
                    </div>

                    <div>
                        <span class="font-semibold">Nama Sekolah :</span><br>
                        {{ $settings['school_name'] ?? '-' }}
                    </div>

                </div>

            </div>

            {{-- KONTAK --}}
            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">
                    Kontak
                </h2>

                <div class="space-y-3">

                    <div>
                        📧 {{ $settings['email'] ?? '-' }}
                    </div>

                    <div>
                        📞 {{ $settings['telepon'] ?? '-' }}
                    </div>

                    <div>
                        💬 {{ $settings['whatsapp'] ?? '-' }}
                    </div>

                    <div>
                        📍 {{ $settings['alamat'] ?? '-' }}
                    </div>

                </div>

            </div>

            {{-- SOSMED --}}
            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">
                    Sosial Media
                </h2>

                <div class="space-y-2 text-sm">

                    @php
                        $socials = json_decode($settings['social_media'] ?? '[]', true);
                    @endphp

                    <div class="space-y-2">

                        @forelse($socials as $social)
                            <div class="flex items-center gap-2">

                                <i class="{{ $social['icon'] }}"></i>

                                <span class="font-medium">
                                    {{ $social['name'] }}
                                </span>

                                <a href="{{ $social['url'] }}" target="_blank" class="text-blue-600 hover:underline">

                                    {{ $social['url'] }}

                                </a>

                            </div>

                        @empty

                            <p class="text-gray-500">
                                Belum ada sosial media
                            </p>
                        @endforelse

                    </div>

                </div>

            </div>

            {{-- KEPALA SEKOLAH --}}
            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">
                    Kepala Sekolah
                </h2>

                <div class="space-y-3">

                    <div>
                        <span class="font-semibold">
                            Nama :
                        </span><br>
                        {{ $settings['nama_kepsek'] ?? '-' }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Sambutan :
                        </span><br>

                        {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 200) }}
                    </div>

                </div>

            </div>

        </div>

        {{-- GAMBAR --}}
        <div class="mt-8">

            <h2 class="font-bold text-lg mb-4">
                Media Website
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="border rounded-xl p-4 text-center">

                    <h3 class="font-medium mb-3">
                        Logo
                    </h3>

                    @if ($logo)
                        <img src="{{ asset('storage/settings/' . $logo) }}" class="w-24 h-24 mx-auto object-contain">
                    @else
                        <p class="text-gray-400">
                            Tidak ada logo
                        </p>
                    @endif

                </div>

                <div class="border rounded-xl p-4 text-center">

                    <h3 class="font-medium mb-3">
                        Favicon
                    </h3>

                    @if ($favicon)
                        <img src="{{ asset('storage/settings/' . $favicon) }}" class="w-16 h-16 mx-auto object-contain">
                    @else
                        <p class="text-gray-400">
                            Tidak ada favicon
                        </p>
                    @endif

                </div>

                <div class="border rounded-xl p-4 text-center">

                    <h3 class="font-medium mb-3">
                        Profil Sekolah
                    </h3>

                    @if ($profilImage)
                        <img src="{{ asset('storage/settings/' . $profilImage) }}"
                            class="w-full h-32 object-cover rounded-lg">
                    @else
                        <p class="text-gray-400">
                            Tidak ada gambar
                        </p>
                    @endif

                </div>

                <div class="border rounded-xl p-4 text-center">

                    <h3 class="font-medium mb-3">
                        Foto Kepsek
                    </h3>

                    @if ($heroImage)
                        <img src="{{ asset('storage/settings/' . $heroImage) }}" class="w-full h-32 object-cover rounded-lg">
                    @else
                        <p class="text-gray-400">
                            Tidak ada gambar
                        </p>
                    @endif

                </div>

                {{-- <div class="border rounded-xl p-4 text-center">

                    <h3 class="font-medium mb-3">
                        Slider
                    </h3>

                    @if ($sliderImage)
                        <img src="{{ asset('storage/settings/' . $sliderImage) }}"
                            class="w-full h-32 object-cover rounded-lg">
                    @else
                        <p class="text-gray-400">
                            Tidak ada slider
                        </p>
                    @endif

                </div> --}}

            </div>

        </div>

        {{-- PROFIL SEKOLAH --}}
        <div class="mt-8 border rounded-xl p-5">

            <h2 class="font-bold text-lg mb-4">
                Profil Sekolah
            </h2>

            <div class="space-y-6">

                <div>
                    <h3 class="font-semibold mb-2">
                        Profil
                    </h3>

                    {{ $settings['profil_sekolah'] ?? '-' }}
                </div>

                <div>
                    <h3 class="font-semibold mb-2">
                        Visi
                    </h3>

                    {{ $settings['visi'] ?? '-' }}
                </div>

                <div>
                    <h3 class="font-semibold mb-2">
                        Misi
                    </h3>

                    {!! nl2br(e($settings['misi'] ?? '-')) !!}
                </div>

                <div>
                    <h3 class="font-semibold mb-2">
                        Sejarah
                    </h3>

                    {{ $settings['sejarah'] ?? '-' }}
                </div>

            </div>

        </div>

    </div>

@endsection
