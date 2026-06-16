@extends('admin.layouts.app')

@section('title','Detail Galeri')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Detail Foto Galeri</h1>

    <div class="space-y-4">
        <div>
            <h2 class="text-lg font-semibold">Judul</h2>
            <p class="text-gray-700">{{ $galeri->title }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Deskripsi</h2>
            <p class="text-gray-700">{{ $galeri->description }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Foto</h2>
            @if($galeri->image)
                <img src="{{ asset('storage/galeri/'.$galeri->image) }}" class="w-full md:w-1/2 rounded-lg shadow mt-2">
            @else
                <p class="text-gray-400">Tidak ada foto</p>
            @endif
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.galeri.edit',$galeri->id) }}" class="bg-primary-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-pen"></i> Edit</a>
        <a href="{{ route('admin.galeri.index') }}" class="bg-primary-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>
@endsection
