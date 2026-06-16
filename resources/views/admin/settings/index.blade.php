@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
<div class="bg-white p-4 md:p-6 rounded-xl shadow">

    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 flex items-center gap-2">
        <i class="fa-solid fa-gear text-primary-600"></i>
        Pengaturan Website
    </h1>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @php
        use Illuminate\Support\Str;

        $img  = $settings['profil_image'] ?? null;
        $hero = $settings['hero_image'] ?? null;
    @endphp

    {{-- TABLE DESKTOP --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

            <thead class="bg-primary-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Profil</th>
                    <th class="px-4 py-3 text-left">Hero</th>
                    <th class="px-4 py-3 text-left">Profil Sekolah</th>
                    <th class="px-4 py-3 text-left">Sambutan</th>
                    <th class="px-4 py-3 text-left">Kepala Sekolah</th>
                    <th class="px-4 py-3 text-left">Visi</th>
                    <th class="px-4 py-3 text-left">Misi</th>
                    <th class="px-4 py-3 text-left">Sejarah</th>
                    <th class="px-4 py-3 text-left">Kontak</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                <tr class="hover:bg-gray-50">

                    {{-- PROFIL --}}
                    <td class="px-4 py-3">
                        @if ($img)
                            <img src="{{ asset('storage/settings/'.$img) }}"
                                class="w-16 h-16 object-cover rounded-lg border shadow">
                        @else
                            <div class="w-16 h-16 bg-gray-100 flex items-center justify-center rounded-lg text-xs text-gray-400">
                                Tidak Ada Foto
                            </div>
                        @endif
                    </td>

                    {{-- HERO --}}
                    <td class="px-4 py-3">
                        @if ($hero)
                            <img src="{{ asset('storage/settings/'.$hero) }}"
                                class="w-24 h-16 object-cover rounded-lg border shadow">
                        @else
                            <div class="w-24 h-16 bg-gray-100 flex items-center justify-center rounded-lg text-xs text-gray-400">
                                No Hero
                            </div>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['profil_sekolah'] ?? '-', 50) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 50) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['nama_kepsek'] ?? '-', 50) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['visi'] ?? '-', 40) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['misi'] ?? '-', 40) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($settings['sejarah'] ?? '-', 50) }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="text-xs space-y-1">
                            <div>📧 {{ $settings['email'] ?? '-' }}</div>
                            <div>📞 {{ $settings['telepon'] ?? '-' }}</div>
                            <div>📍 {{ $settings['alamat'] ?? '-' }}</div>

                        </div>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.settings.show') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-sm">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.settings.edit') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                        </div>
                    </td>

                </tr>

            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-4">

        <div class="border rounded-lg p-4 shadow-sm">

            {{-- IMAGES --}}
            <div class="flex gap-3 mb-3">

                @if ($img)
                    <img src="{{ asset('storage/settings/'.$img) }}"
                        class="w-14 h-14 object-cover rounded-lg border">
                @endif

                @if ($hero)
                    <img src="{{ asset('storage/settings/'.$hero) }}"
                        class="w-20 h-14 object-cover rounded-lg border">
                @endif

            </div>

            {{-- CONTENT --}}
            <div class="space-y-2 text-sm text-gray-700">

                <p><span class="font-semibold">Profil:</span> {{ Str::limit($settings['profil_sekolah'] ?? '-', 80) }}</p>
                <p><span class="font-semibold">Sambutan:</span> {{ Str::limit($settings['sambutan_kepsek'] ?? '-', 80) }}</p>
                <p><span class="font-semibold">Kepala Sekolah:</span> {{ $settings['nama_kepsek'] ?? '-' }}</p>
                <p><span class="font-semibold">Visi:</span> {{ Str::limit($settings['visi'] ?? '-', 80) }}</p>
                <p><span class="font-semibold">Misi:</span> {{ Str::limit($settings['misi'] ?? '-', 80) }}</p>
                <p><span class="font-semibold">Sejarah:</span> {{ Str::limit($settings['sejarah'] ?? '-', 80) }}</p>

                <div class="pt-2 text-xs text-gray-600">
                    <p>📧 {{ $settings['email'] ?? '-' }}</p>
                    <p>📞 {{ $settings['telepon'] ?? '-' }}</p>
                    <p>📍 {{ $settings['alamat'] ?? '-' }}</p>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex gap-2 mt-4">

                <a href="{{ route('admin.settings.show') }}"
                    class="flex-1 bg-primary-600 text-white text-center py-1 rounded-lg text-sm">
                    Lihat
                </a>

                <a href="{{ route('admin.settings.edit') }}"
                    class="flex-1 bg-blue-500 text-white text-center py-1 rounded-lg text-sm">
                    Edit
                </a>

            </div>

        </div>

    </div>

</div>
@endsection