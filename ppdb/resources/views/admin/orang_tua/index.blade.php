@extends('admin.layouts.app')

@section('title', 'Kelola Orang Tua')

@section('content')
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

            <h1 class="text-xl md:text-2xl font-bold">
                Kelola Orang Tua
            </h1>

            <a href="{{ route('admin.orang_tua.create') }}"
                class="inline-flex items-center justify-center gap-2 
        bg-primary-600 hover:bg-primary-700 
        text-white px-4 py-2 rounded-lg text-sm font-semibold
        transition">

                <i class="fa-solid fa-user-plus"></i>
                Tambah Orang Tua

            </a>

        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">No.</th>
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Email</th>
                        <th class="px-4 py-2 text-left font-semibold">Jumlah Anak</th>
                        <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orangTuas as $ortu)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($orangTuas->currentPage() - 1) * $orangTuas->perPage() }}</td>
                            <td class="px-4 py-2 font-semibold">{{ $ortu->nama }}</td>
                            <td class="px-4 py-2">{{ $ortu->email }}</td>
                            <td class="px-4 py-2">{{ $ortu->anakSiswa()->count() }} siswa</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('admin.orang_tua.edit', $ortu->id) }}"
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-users-gear"></i> Atur Anak
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada akun orang tua</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD VIEW --}}
        <div class="md:hidden space-y-3">
            @forelse($orangTuas as $ortu)
                <div class="border rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-gray-800 truncate">{{ $ortu->nama }}</p>
                            <p class="text-sm text-gray-500 break-all">{{ $ortu->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $ortu->anakSiswa()->count() }} siswa terdaftar</p>
                        </div>
                        <span
                            class="text-xs text-gray-400 ml-2">#{{ $loop->iteration + ($orangTuas->currentPage() - 1) * $orangTuas->perPage() }}</span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.orang_tua.edit', $ortu->id) }}"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white text-center py-1.5 rounded-lg text-sm block">
                            <i class="fa-solid fa-users-gear"></i> Atur Anak
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-6">Belum ada akun orang tua</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $orangTuas->links() }}</div>
    </div>
@endsection
