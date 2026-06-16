@extends('admin.layouts.app')

@section('title', 'Kontak Masuk')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 flex items-center gap-2">
        <i class="fa-solid fa-envelope text-primary-600"></i>
        Kontak Masuk
    </h1>

    {{-- SEARCH --}}
    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">

        <input type="text" name="search" value="{{ request('search') }}"
            class="border p-2 rounded-lg w-full md:flex-1 focus:ring focus:ring-primary-300"
            placeholder="Cari nama atau email...">

        <select name="status"
            class="border p-2 rounded-lg focus:ring focus:ring-primary-300">

            <option value="">Semua Status</option>

            @foreach ($statuses as $key => $label)
                <option value="{{ $key }}" @selected(request('status') == $key)>
                    {{ $label }}
                </option>
            @endforeach

        </select>

        <button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
            <i class="fa-solid fa-search"></i>
            Cari
        </button>

    </form>

    {{-- TABLE DESKTOP --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="w-full border rounded-lg shadow-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($kontak as $item)

                    <tr class="hover:bg-gray-50 {{ $item->status == 'unread' ? 'bg-primary-50' : '' }}">

                        <td class="p-3 border font-semibold">
                            {{ $item->name }}
                        </td>

                        <td class="p-3 border">
                            {{ $item->email }}
                        </td>

                        <td class="p-3 border">

                            @if ($item->status == 'unread')
                                <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">
                                    Belum Dilihat
                                </span>

                            @elseif($item->status == 'read')
                                <span class="px-2 py-1 text-xs rounded bg-blue-500 text-white">
                                    Dilihat
                                </span>

                            @else
                                <span class="px-2 py-1 text-xs rounded bg-green-600 text-white">
                                    Dibalas
                                </span>
                            @endif

                        </td>

                        <td class="p-3 border">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.kontak.show', $item) }}"
                                    class="bg-primary-600 hover:bg-primary-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <form action="{{ route('admin.kontak.destroy', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus pesan ini?')">

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
                        <td colspan="4" class="text-center p-6 text-gray-500">
                            Tidak ada pesan
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">

        @forelse($kontak as $item)

            <div class="border rounded-lg p-4 shadow-sm
                {{ $item->status == 'unread' ? 'bg-primary-50' : '' }}">

                <div class="flex justify-between items-start">

                    <div>
                        <p class="font-bold text-gray-800">
                            {{ $item->name }}
                        </p>

                        <p class="text-sm text-gray-500 break-all">
                            {{ $item->email }}
                        </p>

                        <div class="mt-2">

                            @if ($item->status == 'unread')
                                <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">
                                    Unread
                                </span>

                            @elseif($item->status == 'read')
                                <span class="px-2 py-1 text-xs rounded bg-blue-500 text-white">
                                    Read
                                </span>

                            @else
                                <span class="px-2 py-1 text-xs rounded bg-green-600 text-white">
                                    Replied
                                </span>
                            @endif

                        </div>
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.kontak.show', $item) }}"
                        class="flex-1 bg-primary-600 text-white text-center py-1 rounded-lg text-sm">
                        Lihat
                    </a>

                    <form action="{{ route('admin.kontak.destroy', $item) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus pesan ini?')">

                        @csrf @method('DELETE')

                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="text-center p-6 text-gray-500">
                Tidak ada pesan
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $kontak->links() }}
    </div>

</div>
@endsection