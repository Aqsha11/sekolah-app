@extends('admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6"><i class="fa-solid fa-pen text-blue-600"></i> Edit Permission</h1>

    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block font-semibold mb-1">Nama Permission</label>
            <input type="text" name="name" value="{{ old('name',$permission->name) }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">Guard Name</label>
            <input type="text" name="guard_name" value="{{ old('guard_name',$permission->guard_name) }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                <i class="fa-solid fa-save"></i> Update
            </button>
            <a href="{{ route('admin.permissions.index') }}" class="bg-primary-600 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
