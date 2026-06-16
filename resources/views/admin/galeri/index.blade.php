@extends('admin.layouts.app')

@section('title', 'Data Galeri')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

        <h1 class="text-xl md:text-2xl font-bold">
            Data Galeri
        </h1>

        <a href="{{ route('admin.galeri.create') }}"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Tambah Foto
        </a>

    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

        @forelse($galeri as $item)

            <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">

                {{-- IMAGE --}}
                <div class="h-40 bg-gray-100">

                    @if($item->image)
                        <img src="{{ asset('storage/galeri/' . $item->image) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                            Tidak Ada Foto
                        </div>
                    @endif

                </div>

                {{-- CONTENT --}}
                <div class="p-4 flex flex-col flex-1">

                    <h3 class="font-semibold text-lg text-gray-800">
                        {{ $item->title }}
                    </h3>

                    <p class="text-gray-500 text-sm mt-1 flex-1">
                        {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                    </p>

                    {{-- ACTION --}}
                    <div class="flex gap-2 mt-4">

                        <a href="{{ route('admin.galeri.show', $item->id) }}"
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-1 rounded-lg text-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.galeri.edit', $item->id) }}"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-1 rounded-lg text-sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form action="{{ route('admin.galeri.destroy', $item->id) }}"
                            method="POST"
                            class="flex-1"
                            onsubmit="return confirm('Yakin hapus foto ini?')">

                            @csrf @method('DELETE')

                            <button class="w-full bg-red-600 hover:bg-red-700 text-white py-1 rounded-lg text-sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full text-center text-gray-500 py-10">
                Belum ada data galeri
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $galeri->links() }}
    </div>

</div>
@endsection