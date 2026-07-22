@extends('admin.layouts.app')

@section('title', 'Tambah Role')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">
            <i class="fa-solid fa-plus text-primary-600"></i> Tambah Role
        </h1>

        <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Nama Role</label>
                <input type="text" name="name"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-primary-300"
                    required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Permissions</label>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($permissions as $perm)
                        <label class="flex items-center gap-2">
                            <span class="checkbox-wrapper">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                                <span class="checkbox"></span>
                            </span>
                            <span>{{ $perm->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="{{ route('admin.roles.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection