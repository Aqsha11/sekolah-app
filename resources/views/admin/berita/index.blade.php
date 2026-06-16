@extends('admin.layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

        <h1 class="text-xl md:text-2xl font-bold">
            Kelola Berita
        </h1>

        <a href="{{ route('admin.berita.create') }}"
            class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah Berita
        </a>

    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= TABLE DESKTOP ================= --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="min-w-full border border-gray-200 rounded-lg">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Foto</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($berita as $item)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-2">
                            {{ $loop->iteration + ($berita->currentPage() - 1) * $berita->perPage() }}
                        </td>

                        <td class="px-4 py-2 font-medium">
                            {{ $item->title }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $item->category ?? '-' }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $item->created_at->format('d M Y') }}
                        </td>

                        <td class="px-4 py-2">
                            <div class="w-14 h-10 overflow-hidden rounded border bg-gray-100">
                                @if ($item->image)
                                    <img src="{{ asset('storage/berita/' . $item->image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="text-xs text-gray-400 flex items-center justify-center h-full">
                                        No
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-2">
                            @if ($item->is_published)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Published
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-center">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.berita.edit', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.berita.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus berita ini?')">

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
                            Belum ada berita
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>
    </div>

    {{-- ================= MOBILE CARD ================= --}}
    <div class="md:hidden space-y-3">

        @forelse($berita as $item)

            <div class="border rounded-lg p-4 shadow-sm bg-white">

                <div class="flex gap-3">

                    {{-- IMAGE --}}
                    <div class="w-16 h-14 bg-gray-100 rounded overflow-hidden flex-shrink-0">

                        @if ($item->image)
                            <img src="{{ asset('storage/berita/' . $item->image) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="text-xs text-gray-400 flex items-center justify-center h-full">
                                No
                            </div>
                        @endif

                    </div>

                    {{-- INFO --}}
                    <div class="flex-1">

                        <p class="font-semibold text-gray-800 line-clamp-2">
                            {{ $item->title }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $item->category ?? '-' }} • {{ $item->created_at->format('d M Y') }}
                        </p>

                        <div class="mt-2">
                            @if ($item->is_published)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Published
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                    Draft
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.berita.edit', $item->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <form action="{{ route('admin.berita.destroy', $item->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus berita ini?')">

                        @csrf @method('DELETE')

                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="text-center text-gray-500 py-6">
                Belum ada berita
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $berita->links() }}
    </div>

</div>
@endsection