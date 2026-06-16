@extends('admin.layouts.app')

@section('title', 'Kelola Permissions')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 flex items-center gap-2">
        <i class="fa-solid fa-key text-primary-600"></i>
        Kelola Permissions
    </h1>

    {{-- Topbar --}}
    <div class="flex flex-col md:flex-row md:justify-between gap-3 mb-6">

        <form method="GET" action="{{ route('admin.permissions.index') }}"
            class="flex w-full md:w-auto gap-2">

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari permission..."
                class="w-full md:w-64 border rounded-lg px-3 py-2 focus:ring focus:ring-primary-300">

            <button type="submit"
                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>

        <a href="{{ route('admin.permissions.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 md:px-6 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah
        </a>
    </div>

    {{-- TABLE DESKTOP --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full border-collapse rounded-lg shadow-sm">
            <thead>
                <tr class="bg-primary-50 text-left text-gray-700">
                    <th class="px-4 py-3 border">#</th>
                    <th class="px-4 py-3 border">Nama Permission</th>
                    <th class="px-4 py-3 border">Guard</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($permissions as $index => $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border">
                            {{ $permissions->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-3 border font-semibold">
                            {{ $permission->name }}
                        </td>

                        <td class="px-4 py-3 border">
                            {{ $permission->guard_name }}
                        </td>

                        <td class="px-4 py-3 border">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.permissions.show', $permission->id) }}"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus permission ini?')">
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
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Tidak ada permission
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($permissions as $index => $permission)
            <div class="border rounded-lg p-4 shadow-sm">

                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-gray-800">
                            {{ $permission->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Guard: {{ $permission->guard_name }}
                        </p>
                    </div>

                    <span class="text-xs text-gray-400">
                        #{{ $permissions->firstItem() + $index }}
                    </span>
                </div>

                <div class="flex gap-2 mt-3">

                    <a href="{{ route('admin.permissions.show', $permission->id) }}"
                        class="flex-1 bg-primary-600 text-white text-center py-1 rounded-lg text-sm">
                        Lihat
                    </a>

                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                        class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                        Edit
                    </a>

                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')

                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                            Hapus
                        </button>
                    </form>

                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Tidak ada permission
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $permissions->links() }}
    </div>

</div>
@endsection