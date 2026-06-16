@extends('admin.layouts.app')

@section('title', 'Edit Guru')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Guru</h1>

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

        <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Nama Guru</label>
                <input type="text" name="name" value="{{ old('nama', $guru->name) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>

            <div>
                <label class="block font-semibold mb-1">Mata Pelajaran</label>
                <input type="text" name="mapel" value="{{ old('mapel', $guru->subject) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $guru->email) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>

            <div>
                <label class="block font-semibold mb-1">Foto Guru</label>
                @if ($guru->photo)
                    <div class="mb-3">
                        <img src="{{ asset('storage/guru/' . $guru->photo) }}" alt="Foto Guru"
                            class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                @endif
                <input type="file" name="photo" id="photoInput"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>

                {{-- Preview foto baru --}}
                <div class="mt-3">
                    <img id="previewPhoto" class="hidden w-32 h-32 object-cover rounded-lg border" alt="Preview Foto">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Update
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
