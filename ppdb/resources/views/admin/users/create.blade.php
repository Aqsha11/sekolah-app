@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')

    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-user-plus text-primary-600"></i>
                Tambah User
            </h1>

            <p class="text-slate-500 mt-2">
                Tambahkan akun pengguna baru ke dalam sistem.
            </p>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="p-6 md:p-8 space-y-6">

                    {{-- NAME --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">

                        @error('name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">

                        @error('email')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            No. WhatsApp <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>

                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 082116052300"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">

                        @error('phone')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Password
                            </label>

                            <input type="password" name="password" placeholder="Masukkan password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">

                            @error('password')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Konfirmasi Password
                            </label>

                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                    </div>

                    {{-- ROLE & STATUS --}}
                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Role
                            </label>

                            <select name="role" class="w-full rounded-xl border border-slate-300 px-4 py-3">

                                <option value="">Pilih Role</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach

                            </select>

                            @error('role')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Status
                            </label>

                            <select name="is_active"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>

                            </select>
                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="bg-slate-50 border-t border-slate-200 px-6 md:px-8 py-5">

                    <div class="flex flex-col sm:flex-row gap-3 justify-end">

                        <a href="{{ route('admin.users.index') }}"
                            class="px-5 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-center">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold flex items-center justify-center gap-2">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan User

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
