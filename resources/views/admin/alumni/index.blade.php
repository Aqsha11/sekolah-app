@extends('admin.layouts.app')

@section('title', 'Data Alumni')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-xl md:text-2xl font-bold">
            Data Alumni
        </h1>
        <a href="{{ route('admin.alumni.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah Alumni
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-3">No</th>
                    <th class="text-left p-3">Nama</th>
                    <th class="text-left p-3">Tahun Lulus</th>
                    <th class="text-left p-3">Pekerjaan</th>
                    <th class="text-center p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-medium">{{ $item->nama }}</td>
                        <td class="p-3">{{ $item->tahun_lulus }}</td>
                        <td class="p-3">{{ $item->pekerjaan ?? '-' }}</td>
                        <td class="p-3 text-center">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.alumni.edit', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.alumni.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus alumni ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-10">
                            Belum ada data alumni
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $alumni->links() }}
    </div>
</div>
@endsection
