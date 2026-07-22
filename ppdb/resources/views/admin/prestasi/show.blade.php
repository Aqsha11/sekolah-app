@extends('admin.layouts.app')

@section('title', 'Detail Prestasi')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">{{ $prestasi->title }}</h1>
    <p class="text-gray-600">{{ $prestasi->category }} • {{ $prestasi->level }} • {{ $prestasi->year }}</p>
    <p class="mt-4">{{ $prestasi->description }}</p>

    @if($prestasi->image)
        <img src="{{ asset('storage/prestasi/'.$prestasi->image) }}" alt="Gambar" class="mt-4 w-64 rounded">
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.prestasi.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Kembali</a>
    </div>
</div>
@endsection
