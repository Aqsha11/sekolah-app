@extends('admin.layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-xl md:text-2xl font-bold">Data Siswa</h1>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.siswa.export.excel') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.siswa.create') }}"
                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                <i class="fa-solid fa-plus"></i> Tambah Siswa
            </a>
        </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">No.</th>
                    <th class="px-4 py-2 text-left font-semibold">Nama</th>
                    <th class="px-4 py-2 text-left font-semibold">NISN</th>
                    <th class="px-4 py-2 text-left font-semibold">Kelas</th>
                    <th class="px-4 py-2 text-left font-semibold">Jurusan</th>
                    <th class="px-4 py-2 text-left font-semibold">RFID</th>
                    <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswas as $siswa)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration + ($siswas->currentPage() - 1) * $siswas->perPage() }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $siswa->nama }}</td>
                        <td class="px-4 py-2">{{ $siswa->nis }}</td>
                        <td class="px-4 py-2">{{ $siswa->kelas }}</td>
                        <td class="px-4 py-2">{{ $siswa->jurusan }}</td>
                        <td class="px-4 py-2">
                            @if ($siswa->rfid)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-mono">{{ $siswa->rfid }}</span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data siswa</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($siswas as $siswa)
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-gray-800 truncate">{{ $siswa->nama }}</p>
                        <p class="text-sm text-gray-500">NIS: {{ $siswa->nis }}</p>
                    </div>
                    <span class="text-xs text-gray-400 ml-2">#{{ $loop->iteration + ($siswas->currentPage() - 1) * $siswas->perPage() }}</span>
                </div>
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-sm">
                    <span><span class="text-gray-500">Kelas:</span> {{ $siswa->kelas }}</span>
                    <span><span class="text-gray-500">Jurusan:</span> {{ $siswa->jurusan }}</span>
                </div>
                <div class="mt-1">
                    @if ($siswa->rfid)
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-mono">{{ $siswa->rfid }}</span>
                    @else
                        <span class="text-gray-400 text-sm">- RFID</span>
                    @endif
                </div>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1.5 rounded-lg text-sm">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus siswa ini?')">
                        @csrf @method('DELETE')
                        <button class="w-full bg-red-600 text-white py-1.5 rounded-lg text-sm">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">Belum ada data siswa</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $siswas->links() }}</div>
</div>
@endsection
