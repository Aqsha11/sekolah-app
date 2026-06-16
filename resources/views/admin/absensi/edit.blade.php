@extends('admin.layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow max-w-2xl mx-auto">
    <h1 class="text-xl md:text-2xl font-bold mb-6">Edit Absensi</h1>

    <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
            <p class="font-semibold">{{ $absensi->siswa->nama }}</p>
            <p class="text-sm text-gray-500">{{ $absensi->siswa->nis }} - {{ $absensi->siswa->kelas }}</p>
            <p class="text-sm text-gray-500">Tanggal: {{ $absensi->tanggal->format('d M Y') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Jam Check In</label>
                <input type="time" name="check_in" value="{{ old('check_in', $absensi->check_in?->format('H:i')) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jam Check Out</label>
                <input type="time" name="check_out" value="{{ old('check_out', $absensi->check_out?->format('H:i')) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" required class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200">
                <option value="hadir" {{ old('status', $absensi->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="terlambat" {{ old('status', $absensi->status) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="izin" {{ old('status', $absensi->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ old('status', $absensi->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="alpha" {{ old('status', $absensi->status) == 'alpha' ? 'selected' : '' }}>Alpha</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">Update</button>
            <a href="{{ route('admin.absensi.index') }}" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
