@extends('admin.layouts.app')

@section('title', 'Tambah Orang Tua')

@section('content')

<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <div class="flex items-center gap-3 mb-6">

        <a href="{{ route('admin.orang_tua.index') }}"
            class="bg-gray-200 hover:bg-gray-300 px-3 py-1.5 rounded-lg text-sm">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        <h1 class="text-xl md:text-2xl font-bold">
            Tambah Akun Orang Tua
        </h1>

    </div>


    <form method="POST" action="{{ route('admin.orang_tua.store') }}">
        @csrf


        {{-- Nama --}}
        <div class="mb-4">

            <label class="block text-sm font-medium mb-2">
                Nama Orang Tua
            </label>

            <input type="text"
                name="nama"
                value="{{ old('nama') }}"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200"
                placeholder="Masukkan nama orang tua"
                required>

            @error('nama')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>



        {{-- Email --}}
        <div class="mb-4">

            <label class="block text-sm font-medium mb-2">
                Email Login
            </label>

            <input type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200"
                placeholder="contoh@email.com"
                required>

            @error('email')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>



        {{-- Password --}}
        <div class="mb-4">

            <label class="block text-sm font-medium mb-2">
                Password
            </label>

            <input type="password"
                name="password"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200"
                placeholder="Minimal 8 karakter"
                required>

            @error('password')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>



        {{-- Konfirmasi Password --}}
        <div class="mb-4">

            <label class="block text-sm font-medium mb-2">
                Konfirmasi Password
            </label>

            <input type="password"
                name="password_confirmation"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-primary-200"
                placeholder="Ulangi password"
                required>

        </div>



        {{-- Pilih Anak --}}
        <div class="mb-5">

            <label class="block text-sm font-medium mb-2">
                Pilih Anak (Siswa)
            </label>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">


                @forelse($siswas as $siswa)

                <label
                    class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">

                    <span class="checkbox-wrapper">

                        <input type="checkbox"
                            name="siswa_ids[]"
                            value="{{ $siswa->id }}">

                        <span class="checkbox"></span>

                    </span>


                    <div>

                        <div class="font-medium text-sm">
                            {{ $siswa->nama }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ $siswa->kelas }} - {{ $siswa->nis }}
                        </div>

                    </div>

                </label>


                @empty

                <p class="text-gray-500">
                    Belum ada data siswa.
                </p>

                @endforelse


            </div>

        </div>



        <div class="flex gap-2">


            <button type="submit"
                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">

                <i class="fa-solid fa-save"></i>
                Simpan

            </button>



            <a href="{{ route('admin.orang_tua.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">

                Batal

            </a>


        </div>


    </form>

</div>

@endsection