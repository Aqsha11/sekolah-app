@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan Website')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fa-solid fa-pen text-blue-600"></i>
            Edit Pengaturan Website
        </h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            {{-- PROFIL SEKOLAH --}}
            <div>
                <label class="block font-semibold mb-1">Profil Sekolah</label>
                <textarea name="profil_sekolah" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('profil_sekolah', $settings['profil_sekolah'] ?? '') }}</textarea>
            </div>

            {{-- SAMBUTAN KEPALA SEKOLAH (BARU) --}}
            <div>
                <label class="block font-semibold mb-1">Sambutan Kepala Sekolah</label>
                <textarea name="sambutan_kepsek" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('sambutan_kepsek', $settings['sambutan_kepsek'] ?? '') }}</textarea>
            </div>

            {{-- VISI --}}
            <div>
                <label class="block font-semibold mb-1">Visi</label>
                <textarea name="visi" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('visi', $settings['visi'] ?? '') }}</textarea>
            </div>

            {{-- MISI --}}
            <div>
                <label class="block font-semibold mb-1">Misi</label>
                <textarea name="misi" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('misi', $settings['misi'] ?? '') }}</textarea>
            </div>

            {{-- SEJARAH --}}
            <div>
                <label class="block font-semibold mb-1">Sejarah Sekolah</label>
                <textarea name="sejarah" rows="5" class="w-full border rounded-lg px-4 py-2">{{ old('sejarah', $settings['sejarah'] ?? '') }}</textarea>
            </div>

            {{-- KONTAK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

            </div>

            {{-- ALAMAT --}}
            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $settings['alamat'] ?? '') }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            {{-- NAMA KEPALA SEKOLAH --}}
            <div>
                <label class="block font-semibold mb-1">Nama Kepala Sekolah</label>
                <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $settings['nama_kepsek'] ?? '') }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            {{-- FOTO PROFIL --}}
            <div>
                <label class="block font-semibold mb-2">Foto Profil Sekolah</label>

                <input type="file" name="profil_image" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WebP, max 2MB</p>

                @if (!empty($settings['profil_image']))
                    <div class="mt-3">
                        <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}"
                            class="w-48 h-32 object-cover rounded-lg shadow border">
                    </div>
                @endif
            </div>

            {{-- HERO IMAGE --}}
            <div>
                <label class="block font-semibold mb-2">Foto Kepsek</label>

                <input type="file" name="hero_image" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WebP, max 2MB</p>

                @if (!empty($settings['hero_image']))
                    <div class="mt-3">
                        <img src="{{ asset('storage/settings/' . $settings['hero_image']) }}"
                            class="w-full h-40 object-cover rounded-lg shadow border">
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-2">Belum ada background</p>
                @endif
            </div>

            {{-- =========================
    IDENTITAS WEBSITE
========================= --}}
            <div class="border-t pt-6">

                <h2 class="text-lg font-bold mb-4">
                    Identitas Website
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block font-semibold mb-1">
                            Nama Website
                        </label>

                        <input type="text" name="nama_website"
                            value="{{ old('nama_website', $settings['nama_website'] ?? '') }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">
                            Tagline Website
                        </label>

                        <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? '') }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                </div>

            </div>

            {{-- =========================
    LOGO WEBSITE
========================= --}}
            <div class="border-t pt-6">

                <h2 class="text-lg font-bold mb-4">
                    Logo Website
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block font-semibold mb-2">
                            Logo Website
                        </label>

                        <input type="file" name="logo" class="w-full border rounded-lg p-2">

                        @if (!empty($settings['logo']))
                            <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                                class="w-32 h-32 object-contain border rounded-lg mt-3 p-2">
                        @endif
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Favicon
                        </label>

                        <input type="file" name="favicon" class="w-full border rounded-lg p-2">

                        @if (!empty($settings['favicon']))
                            <img src="{{ asset('storage/settings/' . $settings['favicon']) }}"
                                class="w-16 h-16 object-contain border rounded-lg mt-3 p-2">
                        @endif
                    </div>

                </div>

            </div>

            {{-- =========================
    SLIDER HOMEPAGE
========================= --}}
            <div class="border-t pt-6">

                <h2 class="text-lg font-bold mb-4">
                    Slider Homepage
                </h2>

                <div class="space-y-4">

                    <div>
                        <label class="block font-semibold mb-1">
                            Judul Slider
                        </label>

                        <input type="text" name="slider_title"
                            value="{{ old('slider_title', $settings['slider_title'] ?? '') }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">
                            Deskripsi Slider
                        </label>

                        <textarea name="slider_description" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('slider_description', $settings['slider_description'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">
                            Text Tombol Slider
                        </label>

                        <input type="text" name="slider_button"
                            value="{{ old('slider_button', $settings['slider_button'] ?? '') }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">
                            Link Tombol Slider
                        </label>

                        <input type="text" name="slider_link"
                            value="{{ old('slider_link', $settings['slider_link'] ?? '') }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Gambar Slider
                        </label>

                        <input type="file" name="slider_image" class="w-full border rounded-lg p-2">

                        @if (!empty($settings['slider_image']))
                            <img src="{{ asset('storage/settings/' . $settings['slider_image']) }}"
                                class="w-full max-w-md rounded-lg border mt-3">
                        @endif
                    </div>

                </div>

            </div>

            {{-- =========================
SOSIAL MEDIA
========================= --}}
            <div class="border-t pt-6">

                <h2 class="text-lg font-bold mb-4">
                    Sosial Media
                </h2>

                @php
                    $socials = json_decode($settings['social_media'] ?? '[]', true);
                @endphp

                <div id="social-wrapper">

                    @foreach ($socials as $index => $social)
                        <div class="grid grid-cols-12 gap-3 mb-3 social-item">

                            <input type="text" name="social_media[{{ $index }}][name]"
                                value="{{ $social['name'] ?? '' }}" placeholder="Nama Platform"
                                class="col-span-3 border rounded-lg px-3 py-2">

                            <input type="text" name="social_media[{{ $index }}][icon]"
                                value="{{ $social['icon'] ?? '' }}" placeholder="fab fa-facebook"
                                class="col-span-3 border rounded-lg px-3 py-2">

                            <input type="url" name="social_media[{{ $index }}][url]"
                                value="{{ $social['url'] ?? '' }}" placeholder="https://..."
                                class="col-span-5 border rounded-lg px-3 py-2">

                            <button type="button" onclick="this.parentElement.remove()"
                                class="col-span-1 bg-red-600 text-white rounded-lg">

                                ×

                            </button>

                        </div>
                    @endforeach

                </div>

                <button type="button" onclick="addSocialMedia()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                    + Tambah Sosial Media

                </button>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3 pt-4">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    Update
                </button>

                <a href="{{ route('admin.settings.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    Batal
                </a>

            </div>

        </form>

    </div>

    <script>
        let socialIndex = {{ count($socials ?? []) }};

        function addSocialMedia() {
            const html = `
        <div class="grid grid-cols-12 gap-3 mb-3 social-item">

            <input
                type="text"
                name="social_media[${socialIndex}][name]"
                placeholder="Nama Platform"
                class="col-span-3 border rounded-lg px-3 py-2">

            <input
                type="text"
                name="social_media[${socialIndex}][icon]"
                placeholder="fab fa-facebook"
                class="col-span-3 border rounded-lg px-3 py-2">

            <input
                type="url"
                name="social_media[${socialIndex}][url]"
                placeholder="https://..."
                class="col-span-5 border rounded-lg px-3 py-2">

            <button
                type="button"
                onclick="this.parentElement.remove()"
                class="col-span-1 bg-red-600 text-white rounded-lg">

                ×

            </button>

        </div>
    `;

            document
                .getElementById('social-wrapper')
                .insertAdjacentHTML('beforeend', html);

            socialIndex++;
        }
    </script>
@endsection
