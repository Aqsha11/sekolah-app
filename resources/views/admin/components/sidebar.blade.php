<div class="w-72 bg-slate-950 text-white min-h-screen sidebar-scroll overflow-y-auto flex flex-col justify-between">

    {{-- HEADER --}}
    <div>
        <div class="p-6 border-b border-slate-800">
            {{-- <h1 class="text-2xl font-bold">/h1> --}}
            {{-- <p class="text-blue-200 text-sm">Lambandia</p> --}}
        </div>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        {{-- MENU --}}
        <div class="p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-house"></i></span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.berita.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.berita.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-newspaper"></i></span>
                <span>Kelola Berita</span>
            </a>

            <a href="{{ route('admin.prestasi.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.prestasi.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-trophy"></i></span>
                <span>Kelola Prestasi</span>
            </a>

            <a href="{{ route('admin.guru.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.guru.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-chalkboard-teacher"></i></span>
                <span>Kelola Guru</span>
            </a>

            <a href="{{ route('admin.galeri.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.galeri.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-images"></i></span>
                <span>Galeri Kegiatan</span>
            </a>

            <a href="{{ route('admin.fasilitas.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.fasilitas.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-school"></i></span>
                <span>Kelola Fasilitas</span>
            </a>

            <a href="{{ route('admin.kontak.index') }}"
                class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.kontak.*') ? 'bg-slate-800' : '' }}">

                <div class="flex items-center gap-3">
                    <span><i class="fa-solid fa-envelope"></i></span>
                    <span>Pesan Masuk</span>
                </div>

                @if ($unreadMessages > 0)
                    <span class="bg-red-500 text-xs px-2 py-1 rounded-full">
                        {{ $unreadMessages }}
                    </span>
                @endif
            </a>

            {{-- SUPER ADMIN --}}
            @role('admin|super_admin')
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase text-blue-400 tracking-wider px-4">
                        Administrator
                    </p>
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : '' }}">
                    <span><i class="fa-solid fa-users"></i></span>
                    <span>Kelola Users</span>
                </a>

                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.roles.*') ? 'bg-slate-800' : '' }}">
                    <span><i class="fa-solid fa-shield-alt"></i></span>
                    <span>Roles</span>
                </a>

                <a href="{{ route('admin.permissions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-800' : '' }}">
                    <span><i class="fa-solid fa-key"></i></span>
                    <span>Permissions</span>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800' : '' }}">
                    <span><i class="fa-solid fa-cog"></i></span>
                    <span>Pengaturan Website</span>
                </a>
            @endrole

            {{-- PROFILE --}}
            <div class="pt-4 pb-2">
                <p class="text-xs uppercase text-blue-400 tracking-wider px-4">
                    Account
                </p>
            </div>

            <a href="{{ route('admin.profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition {{ request()->routeIs('admin.profile.*') ? 'bg-slate-800' : '' }}">
                <span><i class="fa-solid fa-user"></i></span>
                <span>Profile Admin</span>
            </a>

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="p-4 border-t border-slate-800">

        <div class="mb-4 px-2">
            <p class="font-semibold text-sm">
                {{ auth()->user()->name }}
            </p>

            <p class="text-xs text-blue-400">
                {{ auth()->user()->email }}
            </p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 transition">
                <span><i class="fa-solid fa-sign-out-alt"></i></span>
                <span>Logout</span>
            </button>
        </form>

    </div>

</div>
