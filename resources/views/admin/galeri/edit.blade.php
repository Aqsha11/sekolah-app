@extends('admin.layouts.app')

@section('title','Edit Foto Galeri')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Foto Galeri</h1>

    <form action="{{ route('admin.galeri.update',$galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        <div>
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title',$galeri->title) }}" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" rows="4">{{ old('description',$galeri->description) }}</textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Foto</label>
            @if($galeri->image)
                <img src="{{ asset('storage/galeri/'.$galeri->image) }}" class="w-32 h-32 object-cover rounded-lg border mb-3">
            @endif
            <input type="file" name="image" id="imageInput" class="w-full border rounded-lg p-2">
            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/GIF, max 2MB</p>
            <div class="mt-3"><img id="previewImage" class="hidden w-32 h-32 object-cover rounded-lg border"></div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-save"></i> Update</button>
            <a href="{{ route('admin.galeri.index') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-times"></i> Batal</a>
        </div>
    </form>
</div>
<script>
document.getElementById('imageInput').addEventListener('change', e=>{
    const [file]=e.target.files;
    if(file){const preview=document.getElementById('previewImage');preview.src=URL.createObjectURL(file);preview.classList.remove('hidden');}
});
</script>
@endsection
