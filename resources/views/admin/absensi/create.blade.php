@extends('admin.layouts.app')

@section('title', 'Catat Absensi Manual')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow max-w-2xl mx-auto">
    <h1 class="text-xl md:text-2xl font-bold mb-6">Catat Absensi Manual</h1>

    <form action="{{ route('admin.absensi.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Siswa</label>
            <select name="siswa_id" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                <option value="">Pilih Siswa</option>
                @foreach ($siswas as $s)
                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }} ({{ $s->nis }} - {{ $s->kelas }})
                    </option>
                @endforeach
            </select>
            @error('siswa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jam Check In</label>
                <input type="time" name="check_in" value="{{ old('check_in') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jam Check Out</label>
                <input type="time" name="check_out" value="{{ old('check_out') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="alpha" {{ old('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('admin.absensi.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
