@extends('admin.layouts.app')

@section('title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Jadwal Pelajaran</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1">Kelas</label>
                <select name="kelas_id" required class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Guru</label>
                <select name="guru_id" required class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} — {{ $g->subject ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran', $jadwal->mata_pelajaran) }}" placeholder="Contoh: Matematika" required
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block font-semibold mb-1">Hari</label>
                <select name="hari" required class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $h)
                        <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>

            <div>
                <label class="block font-semibold mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1">Ruangan</label>
            <input type="text" name="ruangan" value="{{ old('ruangan', $jadwal->ruangan) }}" placeholder="Contoh: R.01"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-primary-300">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-primary-500 hover:bg-primary-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Update
            </button>
            <a href="{{ route('admin.jadwal.index') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
