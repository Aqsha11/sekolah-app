@extends('admin.layouts.app')

@section('title', 'Tambah Banner')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Banner</h1>

    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Subtitle</label>
            <textarea name="subtitle" rows="2"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">{{ old('subtitle') }}</textarea>
            @error('subtitle') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Gambar <span class="text-red-500">*</span></label>
            <input type="file" name="image" id="imageInput"
                class="w-full border rounded-lg p-2" required accept="image/*">
            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WebP, max 2MB</p>
            <div class="mt-3"><img id="previewImage" class="hidden w-48 h-32 object-cover rounded-lg border"></div>
            @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Link (opsional)</label>
            <input type="url" name="link" value="{{ old('link') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" placeholder="https://...">
            @error('link') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1">Urutan</label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" min="0">
                @error('order') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <span class="checkbox-wrapper">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span class="checkbox"></span>
                    </span>
                    <span class="font-semibold">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.banner.index') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const [file] = e.target.files;
    if (file) {
        const preview = document.getElementById('previewImage');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>
@endsection
