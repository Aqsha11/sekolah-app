@extends('admin.layouts.app')

@section('title', 'Tambah Permission')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6"><i class="fa-solid fa-plus text-primary-600"></i> Tambah Permission</h1>

    <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block font-semibold mb-1">Nama Permission</label>
            <input type="text" name="name" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">Guard Name</label>
            <input type="text" name="guard_name" value="web" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                <i class="fa-solid fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.permissions.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
