@extends('admin.layouts.app')

@section('title', 'Detail Berita')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Detail Berita</h1>

        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold">Judul Berita</h2>
                <p class="text-gray-700">{{ $berita->judul }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold">Kategori</h2>
                    <p class="text-gray-700">{{ $berita->kategori }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Tanggal</h2>
                    <p class="text-gray-700">{{ $berita->tanggal->format('d M Y') }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold">Status</h2>
                @if ($berita->status === 'published')
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Published</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">Draft</span>
                @endif
            </div>

            <div>
                <h2 class="text-lg font-semibold">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $berita->deskripsi }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold">Foto Berita</h2>
                @if ($berita->image)
                    <img src="{{ asset('storage/berita/' . $berita->image) }}" alt="Foto Berita"
                        class="w-full md:w-1/2 rounded-lg shadow mt-2">
                @else
                    <p class="text-gray-400">Tidak ada foto</p>
                @endif
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.berita.edit', $berita->id) }}"
                class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.berita.index') }}"
                class="bg-bg-red-600-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
