@extends('admin.layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">Edit Prestasi</h1>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NAMA --}}
                <div>
                    <label class="block font-semibold mb-1">Nama Prestasi</label>
                    <input type="text" name="title" value="{{ old('title', $prestasi->title) }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                </div>

                {{-- KATEGORI (SAMA PERSIS DENGAN CREATE) --}}
                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>

                        <option value="">-- Pilih Kategori --</option>

                        <option value="Akademik" {{ old('category', $prestasi->category) == 'Akademik' ? 'selected' : '' }}>
                            Akademik & Sains
                        </option>

                        <option value="Olahraga" {{ old('category', $prestasi->category) == 'Olahraga' ? 'selected' : '' }}>
                            Olahraga & Fisik
                        </option>

                        <option value="Teknologi & Multimedia"
                            {{ old('category', $prestasi->category) == 'Teknologi & Multimedia' ? 'selected' : '' }}>
                            Teknologi & Multimedia
                        </option>

                        <option value="Seni" {{ old('category', $prestasi->category) == 'Seni' ? 'selected' : '' }}>
                            Seni & Kreativitas
                        </option>

                    </select>
                </div>

                {{-- LEVEL --}}
                <div>
                    <label class="block font-semibold mb-1">Tingkat</label>
                    <select name="level" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>

                        @foreach (['Kelas', 'Gugus/Subrayon', 'Kecamatan', 'Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'] as $lvl)
                            <option value="{{ $lvl }}"
                                {{ old('level', $prestasi->level) == $lvl ? 'selected' : '' }}>
                                {{ $lvl }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- TAHUN --}}
                <div>
                    <label class="block font-semibold mb-1">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $prestasi->year) }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                </div>

            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">{{ old('description', $prestasi->description) }}</textarea>
            </div>

            {{-- GAMBAR --}}
            <div>
                <label class="block font-semibold mb-1">Gambar</label>

                <input type="file" name="image" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

                @if ($prestasi->image)
                    <img src="{{ asset('storage/prestasi/' . $prestasi->image) }}" class="mt-3 w-40 rounded-lg shadow">
                @endif

                <p class="text-xs text-gray-500 mt-1">
                    Kosongkan jika tidak ingin mengubah gambar
                </p>
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">

                    <i class="fa-solid fa-save"></i> Update

                </button>

                <a href="{{ route('admin.prestasi.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">

                    <i class="fa-solid fa-times"></i> Batal

                </a>

            </div>

        </form>
    </div>
@endsection
