@extends('admin.layouts.app')

@section('title', 'Kelola Banner')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-xl md:text-2xl font-bold">Kelola Banner</h1>
        <a href="{{ route('admin.banner.create') }}"
            class="bg-primary-500 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm sm:text-base">
            <i class="fa-solid fa-plus"></i>
            Tambah Banner
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Urutan</th>
                    <th class="px-4 py-2 text-left">Gambar</th>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($banners as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-center">{{ $item->order }}</td>
                        <td class="px-4 py-2">
                            <div class="w-24 h-14 overflow-hidden rounded border bg-gray-100">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-xs text-gray-400 flex items-center justify-center h-full">No</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2 font-medium">{{ $item->title }}</td>
                        <td class="px-4 py-2">
                            @if ($item->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.banner.edit', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus banner ini?')">
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
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada banner</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($banners as $item)
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex gap-3">
                    <div class="w-20 h-14 shrink-0 overflow-hidden rounded border bg-gray-100">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-xs text-gray-400 flex items-center justify-center h-full">Tidak Ada Foto</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-gray-800 truncate">{{ $item->title }}</p>
                        <p class="text-xs text-gray-500">Urutan: {{ $item->order }}</p>
                        <div class="mt-1">
                            @if ($item->is_active)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('admin.banner.edit', $item->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1.5 rounded-lg text-sm">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus banner ini?')">
                        @csrf @method('DELETE')
                        <button class="w-full bg-red-600 text-white py-1.5 rounded-lg text-sm">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">Belum ada banner</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $banners->links() }}</div>
</div>
@endsection
