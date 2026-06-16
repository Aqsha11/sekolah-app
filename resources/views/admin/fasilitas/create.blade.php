@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">Tambah Fasilitas</h1>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block font-semibold mb-1">Nama Fasilitas</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">{{ old('description') }}</textarea>
            </div>

            {{-- STATUS (INI WAJIB) --}}
            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- IMAGE --}}
            <div>
                <label class="block font-semibold mb-1">Foto</label>
                <input type="file" name="image" id="imageInput" class="w-full border rounded-lg p-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

                <div class="mt-3">
                    <img id="previewImage" class="hidden w-32 h-32 object-cover rounded-lg border">
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="{{ route('admin.fasilitas.index') }}"
                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    {{-- PREVIEW IMAGE --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('previewImage');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
@endsection
