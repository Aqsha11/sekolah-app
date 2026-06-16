@extends('admin.layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow max-w-2xl mx-auto">
    <h1 class="text-xl md:text-2xl font-bold mb-6">Edit Siswa</h1>

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">NIS</label>
                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">RFID Tag</label>
                <input type="text" name="rfid" value="{{ old('rfid', $siswa->rfid) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200"
                    placeholder="Kosongkan jika belum punya RFID">
                @error('rfid') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Kelas</label>
                <select name="kelas" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                    @foreach ($kelasList as $k)
                        <option value="{{ $k }}" {{ old('kelas', $siswa->kelas) == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                @error('kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jurusan</label>
                <select name="jurusan" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                    @foreach ($jurusanList as $j)
                        <option value="{{ $j }}" {{ old('jurusan', $siswa->jurusan) == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jurusan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.siswa.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
