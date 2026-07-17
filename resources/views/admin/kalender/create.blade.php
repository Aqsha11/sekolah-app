@extends('admin.layouts.app')

@section('title', 'Tambah Event Kalender')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Tambah Event Kalender</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kalender.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Judul Event</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                placeholder="Contoh: Libur Semester Ganjil"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
        </div>

        <div>
            <label class="block font-semibold mb-1">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
            <textarea name="deskripsi" rows="3"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300"
                placeholder="Deskripsi singkat tentang event ini...">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal Selesai <span class="text-gray-400 font-normal">(opsional — untuk event multi-hari)</span></label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1">Tipe Event</label>
                <select name="tipe" required class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="libur" {{ old('tipe') == 'libur' ? 'selected' : '' }}>🏖️ Libur</option>
                    <option value="ujian" {{ old('tipe') == 'ujian' ? 'selected' : '' }}>📝 Ujian</option>
                    <option value="kegiatan" {{ old('tipe') == 'kegiatan' ? 'selected' : '' }}>🎯 Kegiatan Sekolah</option>
                    <option value="penting" {{ old('tipe') == 'penting' ? 'selected' : '' }}>⚠️ Hari Penting</option>
                </select>
            </div>

            <div class="flex items-end">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', 1) ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-primary-500 focus:ring-primary-300">
                    <span class="font-semibold">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.kalender.index') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
