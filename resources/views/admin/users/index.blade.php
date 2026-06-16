@extends('admin.layouts.app')

@section('title', 'Kelola Users')

@section('content')
    <div class="bg-white p-4 md:p-6 rounded-xl shadow">

        <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 flex items-center gap-2">
            <i class="fa-solid fa-users-gear text-primary-600"></i>
            Kelola Users
        </h1>

        {{-- TOPBAR --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap w-full gap-2">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..."
                    class="w-full md:w-48 border rounded-lg px-3 py-2 focus:ring focus:ring-primary-300">

                <select name="role" class="border rounded-lg px-3 py-2 focus:ring focus:ring-primary-300">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="border rounded-lg px-3 py-2 focus:ring focus:ring-primary-300">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-search"></i>
                    Cari
                </button>

                @if (request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-400 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i>
                        Reset
                    </a>
                @endif
            </form>

            <div class="flex gap-2">
                <a href="{{ route('admin.users.export.excel', request()->query()) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 md:px-6 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('admin.users.create') }}"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 md:px-6 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    Tambah User
                </a>
            </div>

        </div>

        {{-- TABLE DESKTOP --}}
        <div class="hidden md:block overflow-x-auto">

            @php
                $grouped = $users->groupBy(fn($u) => $u->getRoleNames()->first() ?? 'unknown');
                $roleOrder = ['super_admin', 'admin', 'operator', 'editor', 'guru', 'orang_tua', 'unknown'];
                $sortedGroups = $grouped->sortBy(fn($g, $role) => array_search($role, $roleOrder) ?? 999);
            @endphp

            @foreach ($sortedGroups as $role => $groupUsers)
                @php
                    $roleLabel = ucfirst(str_replace('_', ' ', $role));
                    $headerBg = match ($role) {
                        'super_admin' => 'bg-purple-50',
                        'admin' => 'bg-primary-50',
                        'operator' => 'bg-green-50',
                        'guru' => 'bg-orange-50',
                        'orang_tua' => 'bg-teal-50',
                        'editor' => 'bg-primary-50',
                        default => 'bg-gray-50',
                    };
                    $badgeBg = match ($role) {
                        'super_admin' => 'bg-purple-100 text-purple-700',
                        'admin' => 'bg-primary-100 text-primary-700',
                        'operator' => 'bg-green-100 text-green-700',
                        'guru' => 'bg-orange-100 text-orange-700',
                        'orang_tua' => 'bg-teal-100 text-teal-700',
                        'editor' => 'bg-primary-100 text-primary-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div class="mb-8">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-2 px-1">
                        <span class="inline-block px-3 py-1 rounded-full {{ $badgeBg }} text-xs">
                            {{ $roleLabel }}
                        </span>
                        — {{ $groupUsers->count() }} user{{ $groupUsers->count() > 1 ? 's' : '' }}
                    </h3>

                    <table class="w-full border-collapse rounded-lg shadow-sm">
                        <thead>
                            <tr class="{{ $headerBg }} text-left text-gray-700">
                                <th class="px-4 py-3 border">No.</th>
                                <th class="px-4 py-3 border">Nama</th>
                                <th class="px-4 py-3 border">Email</th>
                                <th class="px-4 py-3 border">No. WA</th>

                                @if ($role === 'orang_tua')
                                    <th class="px-4 py-3 border">Jumlah Anak</th>
                                @else
                                    <th class="px-4 py-3 border">Role</th>
                                @endif

                                <th class="px-4 py-3 border">Status</th>
                                <th class="px-4 py-3 border text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($groupUsers as $index => $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 border">
                                        {{ $users->firstItem() + $index }}
                                    </td>

                                    <td class="px-4 py-3 border font-semibold">
                                        {{ $user->name }}
                                    </td>

                                    <td class="px-4 py-3 border">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-4 py-3 border">
                                        @if ($user->phone)
                                            <span class="text-green-600 font-medium">{{ $user->phone }}</span>
                                        @else
                                            <span class="text-gray-400">Tidak Ada No. Wa</span>
                                        @endif
                                    </td>

                                    @if ($role === 'orang_tua')
                                        <td class="px-4 py-3 border">
                                            <span class="font-semibold text-teal-700">
                                                {{ $anakCounts[$user->id] ?? 0 }} siswa
                                            </span>
                                        </td>
                                    @else
                                        <td class="px-4 py-3 border">
                                            <span class="px-3 py-1 rounded-full text-sm {{ $badgeBg }}">
                                                {{ $roleLabel }}
                                            </span>
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 border">
                                        @if ($user->is_active)
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 border">
                                        <div class="flex justify-center gap-2">
                                            @if ($role === 'orang_tua')
                                                <a href="{{ route('admin.orang_tua.edit', $user->id) }}"
                                                    class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-lg text-sm whitespace-nowrap"
                                                    title="Atur Anak">
                                                    <i class="fa-solid fa-users-gear"></i> Atur Anak
                                                </a>
                                            @endif

                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-sm">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        {{-- MOBILE CARD VIEW --}}
        <div class="md:hidden space-y-6">

            @foreach ($sortedGroups as $role => $groupUsers)
                @php
                    $roleLabel = ucfirst(str_replace('_', ' ', $role));
                    $badgeBg = match ($role) {
                        'super_admin' => 'bg-purple-100 text-purple-700',
                        'admin' => 'bg-primary-100 text-primary-700',
                        'operator' => 'bg-green-100 text-green-700',
                        'guru' => 'bg-orange-100 text-orange-700',
                        'orang_tua' => 'bg-teal-100 text-teal-700',
                        'editor' => 'bg-primary-100 text-primary-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-2">
                        <span class="inline-block px-3 py-1 rounded-full {{ $badgeBg }} text-xs">
                            {{ $roleLabel }}
                        </span>
                    </h3>

                    <div class="space-y-3">
                        @foreach ($groupUsers as $index => $user)
                            <div class="border rounded-lg p-4 shadow-sm">

                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 break-all">{{ $user->email }}</p>

                                        @if ($user->phone)
                                            <p class="text-sm text-green-600 mt-1">
                                                <i class="fa-brands fa-whatsapp"></i> {{ $user->phone }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @if ($role === 'orang_tua')
                                                <span class="px-2 py-1 text-xs rounded-full bg-teal-100 text-teal-700">
                                                    {{ $anakCounts[$user->id] ?? 0 }} anak
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full {{ $badgeBg }}">
                                                    {{ $roleLabel }}
                                                </span>
                                            @endif

                                            @if ($user->is_active)
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <span class="text-xs text-gray-400">
                                        #{{ $users->firstItem() + $index }}
                                    </span>
                                </div>

                                <div class="flex gap-2 mt-3">
                                    @if ($role === 'orang_tua')
                                        <a href="{{ route('admin.orang_tua.edit', $user->id) }}"
                                            class="flex-1 bg-teal-600 text-white text-center py-1 rounded-lg text-sm whitespace-nowrap">
                                            <i class="fa-solid fa-users-gear"></i> Atur Anak
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="flex-1 bg-primary-600 text-white text-center py-1 rounded-lg text-sm">
                                        Lihat
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="flex-1" onsubmit="return confirm('Yakin hapus user?')">
                                        @csrf @method('DELETE')
                                        <button class="w-full bg-red-600 text-white py-1 rounded-lg text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
@endsection
