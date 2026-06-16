@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">Detail Pesan Kontak</h1>

        {{-- STATUS BADGE --}}
        <div class="mb-6">
            <span
                class="px-3 py-1 rounded-full text-white text-sm
            {{ $kontak->status == 'unread' ? 'bg-red-500' : 'bg-green-600' }}">
                {{ strtoupper($kontak->status) }}
            </span>
        </div>

        <div class="space-y-5">

            <div>
                <h2 class="text-sm font-semibold text-gray-500">Nama</h2>
                <p class="text-gray-800 font-medium text-lg">
                    {{ $kontak->name }}
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500">Email</h2>
                <p class="text-gray-700">
                    {{ $kontak->email }}
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500">Subject</h2>
                <p class="text-gray-700">
                    {{ $kontak->subject }}
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500">Pesan</h2>
                <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-line">
                    {{ $kontak->message }}
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-500">Tanggal</h2>
                <p class="text-gray-700">
                    {{ $kontak->created_at->format('d M Y H:i') }}
                </p>
            </div>

        </div>

        {{-- ACTION --}}
        <div class="mt-8 flex gap-3">

            {{-- MARK AS READ --}}
            @if ($kontak->status == 'unread')
                <form action="{{ route('admin.kontak.read', $kontak->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                        Tandai Dibaca
                    </button>
                </form>
            @endif

            {{-- BACK --}}
            <a href="{{ route('admin.kontak.index') }}"
                class="bg-primary-600 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">

                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

        </div>

    </div>
@endsection
