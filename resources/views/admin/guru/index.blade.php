@extends('admin.layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

        <h1 class="text-xl md:text-2xl font-bold">
            Data Guru
        </h1>

        <a href="{{ route('admin.guru.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah Guru
        </a>

    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= DESKTOP TABLE ================= --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="min-w-full border border-gray-200 rounded-lg">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">No.</th>
                    <th class="px-4 py-2 text-left font-semibold">Nama</th>
                    <th class="px-4 py-2 text-left font-semibold">NIP</th>
                    <th class="px-4 py-2 text-left font-semibold">Mapel</th>
                    <th class="px-4 py-2 text-left font-semibold">Email</th>
                    <th class="px-4 py-2 text-left font-semibold">Foto</th>
                    <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($gurus as $guru)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-2">
                            {{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}
                        </td>

                        <td class="px-4 py-2 font-semibold">{{ $guru->name }}</td>
                        <td class="px-4 py-2">{{ $guru->nip }}</td>
                        <td class="px-4 py-2">{{ $guru->subject }}</td>
                        <td class="px-4 py-2">{{ $guru->email }}</td>

                        <td class="px-4 py-2">
                            @if ($guru->photo)
                                <img src="{{ asset('storage/guru/' . $guru->photo) }}"
                                    class="w-14 h-14 object-cover rounded-lg border">
                            @else
                                <span class="text-gray-400 text-sm">Tidak Ada Foto</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.guru.edit', $guru->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.guru.destroy', $guru->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus guru ini?')">

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
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            Belum ada data guru
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>
    </div>

    {{-- ================= MOBILE CARD (FOCUS HERE) ================= --}}
    <div class="md:hidden space-y-3">

        @forelse($gurus as $guru)

            <div class="border rounded-lg p-4 shadow-sm bg-white">

                <div class="flex items-center gap-3">

                    {{-- FOTO --}}
                    @if ($guru->photo)
                        <img src="{{ asset('storage/guru/' . $guru->photo) }}"
                            class="w-14 h-14 rounded-full object-cover border">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                            No
                        </div>
                    @endif

                    {{-- INFO UTAMA --}}
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">
                            {{ $guru->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $guru->subject }} • NIP: {{ $guru->nip }}
                        </p>
                    </div>

                </div>

                {{-- EMAIL (opsional di bawah biar tidak penuh) --}}
                <p class="text-xs text-gray-500 mt-2 break-all">
                    {{ $guru->email }}
                </p>

                {{-- ACTION --}}
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.guru.edit', $guru->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <form action="{{ route('admin.guru.destroy', $guru->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus guru ini?')">

                        @csrf @method('DELETE')

                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="text-center text-gray-500 py-6">
                Belum ada data guru
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $gurus->links() }}
    </div>

</div>
@endsection