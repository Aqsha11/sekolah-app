@extends('admin.layouts.app')

@section('title', 'Tambah Guru')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Guru</h1>

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

        <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>

            <label>NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border p-2 rounded">

            <label>Mata Pelajaran</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="w-full border p-2 rounded" required>

            <label>Jabatan</label>
            <input type="text" name="position" value="{{ old('position') }}" class="w-full border p-2 rounded" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded">

            <label>Foto</label>
            <input type="file" name="photo" class="w-full border p-2 rounded">
            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="{{ route('admin.guru.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Script preview foto --}}
    <script>
        document.getElementById('photoInput').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('previewPhoto');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
@endsection
