@extends('admin.layouts.app')

@section('title', 'Tambah Berita')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Berita</h1>

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

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- TITLE (FIX: dari judul → title) --}}
            <div>
                <label class="block font-semibold mb-1">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- CATEGORY (FIX: kategori → category) --}}
                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Umum" {{ old('category') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Kegiatan" {{ old('category') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Pengumuman" {{ old('category') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman
                        </option>
                    </select>
                </div>

                {{-- TANGGAL (opsional, kalau belum dipakai di DB aman dihapus) --}}
                <div>
                    <label class="block font-semibold mb-1">Tanggal</label>
                    <input type="date" name="published_at" value="{{ old('published_at') }}"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                </div>
            </div>

            {{-- STATUS (opsional juga, aman kalau tidak dipakai) --}}
            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="is_published" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                    <option value="0" {{ old('is_published') == 0 ? 'selected' : '' }}>Draft</option>
                    <option value="1" {{ old('is_published') == 1 ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            {{-- CONTENT (FIX: deskripsi → content) --}}
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="content" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" rows="5" required>{{ old('content') }}</textarea>
            </div>

            {{-- IMAGE --}}
            <div>
                <label class="block font-semibold mb-1">Foto Berita</label>
                <input type="file" name="image" id="imageInput"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">

                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

                {{-- Preview --}}
                <div class="mt-3">
                    <img id="previewImage" class="hidden w-40 h-40 object-cover rounded-lg border">
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="{{ route('admin.berita.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    {{-- PREVIEW IMAGE --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('previewImage');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
@endsection
