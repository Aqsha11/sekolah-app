@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fa-solid fa-user text-primary-600"></i> Detail User
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm text-gray-500">Nama</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
            </div>

            <div>
                <h3 class="text-sm text-gray-500">Email</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
            </div>

            <div>
                <h3 class="text-sm text-gray-500">No. WhatsApp</h3>
                <p class="text-lg font-semibold text-gray-800">
                    @if ($user->phone)
                        <span class="text-green-600">{{ $user->phone }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>
            </div>

            <div>
                <h3 class="text-sm text-gray-500">Role</h3>
                @php $role = $user->getRoleNames()->first(); @endphp
                <span
                    class="px-3 py-1 rounded-full text-sm
                @if ($role === 'super_admin') bg-purple-100 text-purple-700
                @elseif($role === 'admin') bg-primary-100 text-primary-700
                @elseif($role === 'operator') bg-green-100 text-green-700
                @else bg-gray-100 text-gray-700 @endif">
                    {{ $role ?? 'No Role' }}
                </span>
            </div>

            <div>
                <h3 class="text-sm text-gray-500">Status</h3>
                @if ($user->is_active)
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Aktif</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">Nonaktif</span>
                @endif
            </div>

            <div class="md:col-span-2">
                <h3 class="text-sm text-gray-500">Tanggal Dibuat</h3>
                <p class="text-lg text-gray-800">{{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="bg-primary-600 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
