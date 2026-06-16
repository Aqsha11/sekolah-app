@extends('admin.layouts.app')

@section('title', 'Edit Agenda')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">Edit Agenda</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.agenda.update', $agendum->id) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $agendum->judul) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $agendum->tanggal) }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">{{ old('deskripsi', $agendum->deskripsi) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.agenda.index') }}"
                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                    <i class="fa-solid fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
