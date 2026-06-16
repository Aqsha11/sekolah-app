@extends('admin.layouts.app')

@section('title', 'Tambah Prestasi')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Prestasi</h1>

        {{-- Alert error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Grid 2 kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Nama Prestasi</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                    <p class="text-xs text-gray-500 mt-1">Contoh: Juara 1 Olimpiade Matematika</p>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik" {{ old('category') == 'Akademik' ? 'selected' : '' }}>Akademik & Sains
                        </option>
                        <option value="Olahraga" {{ old('category') == 'Olahraga' ? 'selected' : '' }}>Olahraga & Fisik
                        </option>
                        <option value="Teknologi & Multimedia"
                            {{ old('category') == 'Teknologi & Multimedia' ? 'selected' : '' }}>Teknologi & Multimedia
                        </option>
                        <option value="Seni" {{ old('category') == 'Seni' ? 'selected' : '' }}>Seni & Kreativitas</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tingkat</label>
                    <select name="level" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach (['Kelas', 'Gugus/Subrayon', 'Kecamatan', 'Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'] as $lvl)
                            <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>
                                {{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tahun</label>
                    <input type="number" name="year" value="{{ old('year') }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" rows="4">{{ old('description') }}</textarea>
            </div>

            {{-- Upload gambar --}}
            <div>
                <label class="block font-semibold mb-1">Gambar</label>
                <input type="file" name="image" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>
            </div>

            {{-- Tombol aksi --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.prestasi.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
