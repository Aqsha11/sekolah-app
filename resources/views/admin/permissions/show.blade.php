@extends('admin.layouts.app')

@section('title', 'Detail Permission')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6"><i class="fa-solid fa-key text-primary-600"></i> Detail Permission</h1>

    <div class="space-y-4">
        <div>
            <h3 class="text-sm text-gray-500">Nama Permission</h3>
            <p class="text-lg font-semibold text-gray-800">{{ $permission->name }}</p>
        </div>

        <div>
            <h3 class="text-sm text-gray-500">Guard Name</h3>
            <p class="text-lg font-semibold text-gray-800">{{ $permission->guard_name }}</p>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.permissions.edit',$permission->id) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <a href="{{ route('admin.permissions.index') }}"
           class="bg-primary-600 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
