@extends('admin.layouts.app')

@section('title', 'Atur Anak - ' . $orangTua->nama)

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.orang_tua.index') }}"
            class="bg-gray-200 hover:bg-gray-300 px-3 py-1.5 rounded-lg text-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Atur Anak: {{ $orangTua->nama }}</h1>
    </div>

    <form method="POST" action="{{ route('admin.orang_tua.update', $orangTua->id) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Pilih Siswa yang menjadi anak dari <strong>{{ $orangTua->nama }}</strong></label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach ($siswas as $siswa)
                    <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ in_array($siswa->id, $terpilih) ? 'bg-primary-50 border-primary-300' : '' }}">
                        <span class="checkbox-wrapper">
                            <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}"
                                {{ in_array($siswa->id, $terpilih) ? 'checked' : '' }}>
                            <span class="checkbox"></span>
                        </span>
                        <div>
                            <div class="font-medium text-sm">{{ $siswa->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $siswa->kelas }} - {{ $siswa->nis }}</div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.orang_tua.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
