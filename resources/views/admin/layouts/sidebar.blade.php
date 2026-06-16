<div class="w-72 bg-slate-950 text-white min-h-screen sidebar-scroll overflow-y-auto flex flex-col justify-between">

    {{-- HEADER --}}
    <div>
        {{-- <div class="p-6 border-b border-slate-800">
            <h1 class="text-2xl font-bold"></h1>
        </div> --}}

        <div class="p-4 space-y-2">

            {{-- ======================
                MENU UNTUK SEMUA ROLE
            ======================= --}}

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.berita.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.berita.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Berita</span>
            </a>

            <a href="{{ route('admin.prestasi.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.prestasi.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-trophy"></i>
                <span>Prestasi</span>
            </a>

            <a href="{{ route('admin.guru.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.guru.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Guru</span>
            </a>

            <a href="{{ route('admin.galeri.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.galeri.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-images"></i>
                <span>Galeri</span>
            </a>

            <a href="{{ route('admin.fasilitas.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.fasilitas.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-building"></i>
                <span>Fasilitas</span>
            </a>

            <a href="{{ route('admin.kontak.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.kontak.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-envelope"></i>
                <span>Pesan Masuk</span>
            </a>

            <a href="{{ route('admin.banner.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.banner.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-images"></i>
                <span>Banner</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.siswa.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Siswa</span>
            </a>

            <a href="{{ route('admin.absensi.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.absensi.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Absensi</span>
            </a>

            <a href="{{ route('admin.orang_tua.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.orang_tua.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-people-arrows"></i>
                <span>Orang Tua</span>
            </a>

            <a href="{{ route('admin.kelas.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.kelas.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-school"></i>
                <span>Kelas</span>
            </a>

            <a href="{{ route('admin.agenda.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.agenda.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-calendar"></i>
                <span>Agenda</span>
            </a>

            <a href="{{ route('admin.alumni.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.alumni.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Alumni</span>
            </a>

            {{-- <a href="{{ route('admin.tentang.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.tentang.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-globe"></i>
                <span>Tentang Website</span>
            </a> --}}

            <a href="{{ route('admin.settings.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan Website</span>
            </a>

            {{-- ======================
                MENU KHUSUS GURU
            ======================= --}}
            @role('guru')
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase text-blue-400 tracking-wider px-4">
                        Menu Guru
                    </p>
                </div>
            @endrole


            {{-- ======================
                MENU ADMIN & SUPER ADMIN
            ======================= --}}
            @hasanyrole('admin|super_admin')
                <div class="pt-4 pb-2">
                    <p class="text-xs uppercase text-blue-400 tracking-wider px-4">
                        Administrator
                    </p>
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                    {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>

                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                    {{ request()->routeIs('admin.roles.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Roles</span>
                </a>

                <a href="{{ route('admin.permissions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                    {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                    <i class="fa-solid fa-key"></i>
                    <span>Permissions</span>
                </a>
            @endhasanyrole


            {{-- ======================
                ACCOUNT (SEMUA ROLE)
            ======================= --}}
            <div class="pt-4 pb-2">
                <p class="text-xs uppercase text-blue-400 tracking-wider px-4">
                    Account
                </p>
            </div>

            <a href="{{ route('admin.profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition 
                {{ request()->routeIs('admin.profile.*') ? 'bg-slate-800' : 'hover:bg-slate-800' }}">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="p-4 border-t border-slate-800 text-xs text-blue-400">
        © {{ date('Y') }} 
    </div>
</div>
