@extends('admin.layouts.app')

@section('title', 'Detail Role')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-purple-600"></i> Detail Role
        </h1>

        {{-- Info Role --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm text-gray-500">Nama Role</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $role->name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm text-gray-500">Jumlah Permissions</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $role->permissions->count() }}</p>
            </div>
        </div>

        {{-- Permissions --}}
        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-key text-primary-600"></i> Permissions
            </h2>
            <div class="flex flex-wrap gap-3">
                @forelse($role->permissions as $perm)
                    <span class="px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-medium">
                        {{ $perm->name }}
                    </span>
                @empty
                    <p class="text-gray-400">Tidak ada permissions</p>
                @endforelse
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex gap-3">
            <a href="{{ route('admin.roles.edit', $role->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.roles.index') }}"
                class="bg-primary-600 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
