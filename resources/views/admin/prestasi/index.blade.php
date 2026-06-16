@extends('admin.layouts.app')

@section('title', 'Data Prestasi')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

        <h1 class="text-xl md:text-2xl font-bold">
            Data Prestasi
        </h1>

        <a href="{{ route('admin.prestasi.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah Prestasi
        </a>

    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE DESKTOP --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="min-w-full border border-gray-200 rounded-lg">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">No</th>
                    <th class="px-4 py-2 text-left font-semibold">Nama Prestasi</th>
                    <th class="px-4 py-2 text-left font-semibold">Kategori</th>
                    <th class="px-4 py-2 text-left font-semibold">Tingkat</th>
                    <th class="px-4 py-2 text-left font-semibold">Tahun</th>
                    <th class="px-4 py-2 text-left font-semibold">Foto</th>
                    <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($prestasi as $item)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-2">
                            {{ $loop->iteration + ($prestasi->currentPage() - 1) * $prestasi->perPage() }}
                        </td>

                        <td class="px-4 py-2 font-semibold">
                            {{ $item->title }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $item->category }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $item->level }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $item->year }}
                        </td>

                        <td class="px-4 py-2">
                            @if ($item->image)
                                <img src="{{ asset('storage/prestasi/' . $item->image) }}"
                                    class="w-20 h-20 object-cover rounded-lg border">
                            @else
                                <span class="text-gray-400 text-sm">Tidak Ada Foto</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.prestasi.edit', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.prestasi.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus prestasi ini?')">

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
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data prestasi
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">

        @forelse($prestasi as $item)
            <div class="border rounded-lg p-4 shadow-sm">

                <div class="flex gap-3">

                    {{-- IMAGE --}}
                    @if ($item->image)
                        <img src="{{ asset('storage/prestasi/' . $item->image) }}"
                            class="w-16 h-16 object-cover rounded-lg border">
                    @else
                        <div class="w-16 h-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 rounded-lg">
                            Tidak Ada Foto
                        </div>
                    @endif

                    {{-- INFO --}}
                    <div class="flex-1">

                        <p class="font-bold text-gray-800">
                            {{ $item->title }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ $item->category }} • {{ $item->level }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Tahun: {{ $item->year }}
                        </p>

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.prestasi.edit', $item->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                        Edit
                    </a>

                    <form action="{{ route('admin.prestasi.destroy', $item->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus prestasi ini?')">

                        @csrf @method('DELETE')

                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Belum ada data prestasi
            </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $prestasi->links() }}
    </div>

</div>
@endsection