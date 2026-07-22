@extends('admin.layouts.app')

@section('title','Detail Fasilitas')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Detail Fasilitas</h1>

    <div class="space-y-4">
        <div>
            <h2 class="text-lg font-semibold">Nama Fasilitas</h2>
            <p class="text-gray-700">{{ $fasilitas->name }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Deskripsi</h2>
            <p class="text-gray-700">{{ $fasilitas->description }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Foto</h2>
            @if($fasilitas->image)
                <img src="{{ asset('storage/' . $fasilitas->image) }}" class="w-full md:w-1/2 rounded-lg shadow mt-2">
            @else
                <p class="text-gray-400">Tidak ada foto</p>
            @endif
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.fasilitas.edit',$fasilitas) }}" class="bg-primary-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-pen"></i> Edit</a>
        <a href="{{ route('admin.fasilitas.index') }}" class="bg-primary-600 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>
@endsection
