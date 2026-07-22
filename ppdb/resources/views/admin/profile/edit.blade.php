@extends('admin.layouts.app')

@section('title', 'Profile Admin')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-user text-primary-600"></i> Profile Admin
    </h1>

    {{-- ICON AVATAR DEFAULT --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="w-20 h-20 flex items-center justify-center rounded-full bg-primary-600 text-white">
            <i class="fa-solid fa-user text-3xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    {{-- FORM UPDATE PROFILE --}}
    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- NAME --}}
        <div>
            <label class="block text-sm font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-primary-300">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-primary-300">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-primary-600 text-white px-5 py-2 rounded-lg hover:bg-primary-700 flex items-center gap-2">
            <i class="fa-solid fa-save"></i> Simpan Profil
        </button>
    </form>

    {{-- FORM CHANGE PASSWORD --}}
    <hr class="my-6">

    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-lock text-red-600"></i> Ubah Password
    </h2>

    <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-5">
        @csrf

        {{-- CURRENT PASSWORD --}}
        <div>
            <label class="block text-sm font-medium">Password Lama</label>
            <input type="password" name="current_password"
                class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-red-300">
            @error('current_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- NEW PASSWORD --}}
        <div>
            <label class="block text-sm font-medium">Password Baru</label>
            <input type="password" name="password"
                class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-red-300">
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <label class="block text-sm font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border rounded-lg p-2 mt-1 focus:ring focus:ring-red-300">
        </div>

        <button type="submit"
            class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 flex items-center gap-2">
            <i class="fa-solid fa-key"></i> Update Password
        </button>
    </form>

</div>

@endsection
