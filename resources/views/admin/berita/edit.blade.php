@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Berita</h1>

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

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Judul Berita</label>
                <input type="text" name="title" value="{{ old('title', $berita->title) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                        <option value="Umum" {{ old('category', $berita->category) == 'Umum' ? 'selected' : '' }}>Umum
                        </option>
                        <option value="Kegiatan" {{ old('category', $berita->category) == 'Kegiatan' ? 'selected' : '' }}>
                            Kegiatan</option>
                        <option value="Pengumuman"
                            {{ old('category', $berita->category) == 'Pengumuman' ? 'selected' : '' }}>
                            Pengumuman</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tanggal</label>

                    <input type="date" name="date"
                        value="{{ old('date', $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('Y-m-d') : '') }}"
                        class="w-full border rounded-lg p-2">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="is_published" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                    <option value="1" {{ old('is_published', $berita->is_published) == 1 ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ old('is_published', $berita->is_published) == 0 ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="content" class="w-full border rounded-lg p-2">
                {{ old('content', $berita->content) }}
            </textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Foto Berita</label>
                @if ($berita->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/berita/' . $berita->image) }}" alt="Foto Berita"
                            class="w-40 h-40 object-cover rounded-lg border">
                    </div>
                @endif
                <input type="file" name="image" id="imageInput"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

                {{-- Preview foto baru --}}
                <div class="mt-3">
                    <img id="previewImage" class="hidden w-40 h-40 object-cover rounded-lg border" alt="Preview Foto">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Update
                </button>
                <a href="{{ route('admin.berita.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Script preview foto --}}
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
