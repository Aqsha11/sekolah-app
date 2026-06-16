@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fa-solid fa-gear text-primary-600"></i> Pengaturan Website
        </h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Profil Sekolah --}}
            <div>
                <label class="block font-semibold mb-1">Profil Sekolah</label>
                <textarea name="profil_sekolah" rows="4" placeholder="Tuliskan deskripsi singkat tentang profil sekolah..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">{{ old('profil_sekolah', $settings['profil_sekolah'] ?? '') }}</textarea>
            </div>

            {{-- Visi --}}
            <div>
                <label class="block font-semibold mb-1">Visi</label>
                <textarea name="visi" rows="3" placeholder="Masukkan visi sekolah..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">{{ old('visi', $settings->visi ?? '') }}</textarea>
            </div>

            {{-- Misi --}}
            <div>
                <label class="block font-semibold mb-1">Misi</label>
                <textarea name="misi" rows="4" placeholder="Tuliskan misi sekolah, bisa lebih dari satu poin..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">{{ old('misi', $settings->misi ?? '') }}</textarea>
            </div>

            {{-- Kontak Sekolah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings->email ?? '') }}"
                        placeholder="contoh: info@smpn1lambandia.sch.id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $settings->telepon ?? '') }}"
                        placeholder="contoh: 0401-123456"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $settings->alamat ?? '') }}"
                    placeholder="contoh: Jl. Pendidikan No. 10, Lambandia"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">
            </div>

            {{-- FOTO PROFIL SEKOLAH --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Profil Sekolah
                </label>

                <input type="file" name="profil_image" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WebP, max 2MB</p>

                @if (!empty($settings['profil_image']))
                    <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}"
                        class="mt-3 w-48 h-32 object-cover rounded-lg shadow">
                @endif
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
