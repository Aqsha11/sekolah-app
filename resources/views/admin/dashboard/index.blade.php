@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang kembali, ' . (auth()->user()->name ?? 'Admin'))

@section('content')

    {{-- Header --}}
    <div class="mb-6 animate-fadein">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Selamat Datang </h2>
                <p class="text-gray-500 text-sm mt-0.5">Berikut ringkasan data sekolah Anda hari ini.</p>
            </div>
            <div
                class="hidden sm:flex items-center gap-2 text-xs text-gray-400 bg-white rounded-xl px-4 py-2 border border-gray-200 shadow-sm">
                <i class="fa-regular fa-calendar text-primary-500"></i>
                <span id="live-date"></span>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

        {{-- Users --}}
        <div class="card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm animate-fadein">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-primary-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-primary-600 text-lg"></i>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <i class="fa-solid fa-arrow-up text-[9px]"></i> Aktif
                </span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 mb-0.5">{{ $totalUsers ?? 0 }}</p>
            <p class="text-gray-500 text-xs">Total Users</p>
        </div>

        {{-- Berita --}}
        <div class="card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm animate-fadein-delay-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-primary-100 flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-primary-600 text-lg"></i>
                </div>
                <span class="text-xs font-medium text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full">
                    Berita
                </span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 mb-0.5">{{ $totalBerita ?? 0 }}</p>
            <p class="text-gray-500 text-xs">Total Berita</p>
        </div>

        {{-- Guru --}}
        <div class="card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm animate-fadein-delay-2">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-slate-600 text-lg"></i>
                </div>
                <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">
                    Guru
                </span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 mb-0.5">{{ $totalGuru ?? 0 }}</p>
            <p class="text-gray-500 text-xs">Total Guru</p>
        </div>

        {{-- Galeri --}}
        <div class="card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm animate-fadein-delay-3">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center">
                    <i class="fa-solid fa-images text-primary-700 text-lg"></i>
                </div>
                <span class="text-xs font-medium text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full">
                    Foto
                </span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 mb-0.5">{{ $totalGaleri ?? 0 }}</p>
            <p class="text-gray-500 text-xs">Total Galeri</p>
        </div>
    </div>

    {{-- Chart + Recent --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        {{-- Chart --}}
        <div class="lg:col-span-2 bg-gradient-to-br from-blue-50 to-white rounded-2xl border border-blue-100 shadow-sm p-6">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Statistik Konten</h3>
                    <p class="text-gray-400 text-xs mt-0.5">Ringkasan data keseluruhan</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-chart-column text-blue-600 text-xs"></i>
                </div>
            </div>

            {{-- FIX PENTING: tinggi chart dibatasi --}}
            <div class="h-48">
                <canvas id="statsChart"></canvas>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Akses Cepat</h3>
            <div class="space-y-2.5">
                <a href="{{ route('admin.berita.create') }}"
                    class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                        <i class="fa-solid fa-pen-to-square text-primary-600 text-xs group-hover:text-primary-700"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Tulis Berita</p>
                        <p class="text-[10px] text-gray-400">Publikasikan artikel baru</p>
                    </div>
                    <i
                        class="fa-solid fa-arrow-right text-gray-300 text-[10px] ml-auto group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all"></i>
                </a>

                <a href="{{ route('admin.guru.create') }}"
                    class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                        <i class="fa-solid fa-user-plus text-slate-600 text-xs group-hover:text-primary-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Tambah Guru</p>
                        <p class="text-[10px] text-gray-400">Daftarkan guru baru</p>
                    </div>
                    <i
                        class="fa-solid fa-arrow-right text-gray-300 text-[10px] ml-auto group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all"></i>
                </a>

                <a href="{{ route('admin.galeri.create') }}"
                    class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                        <i class="fa-solid fa-upload text-primary-700 text-xs group-hover:text-primary-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Upload Foto</p>
                        <p class="text-[10px] text-gray-400">Tambah galeri kegiatan</p>
                    </div>
                    <i
                        class="fa-solid fa-arrow-right text-gray-300 text-[10px] ml-auto group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all"></i>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                        <i class="fa-solid fa-sliders text-gray-600 text-xs group-hover:text-primary-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Pengaturan</p>
                        <p class="text-[10px] text-gray-400">Konfigurasi website</p>
                    </div>
                    <i
                        class="fa-solid fa-arrow-right text-gray-300 text-[10px] ml-auto group-hover:text-primary-400 group-hover:translate-x-0.5 transition-all"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent News + Messages --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Recent News --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Berita Terbaru</h3>
                <a href="{{ route('admin.berita.index') }}"
                    class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    Lihat semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentNews ?? [] as $news)
                    <div class="flex items-start gap-3 px-6 py-3.5 hover:bg-gray-50/60 transition-colors">
                        <div class="w-14 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                            @if ($news->image)
                                <img src="{{ asset('storage/berita/' . $news->image) }}" class="w-full h-full object-cover"
                                    alt="">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fa-solid fa-image text-lg"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 text-xs truncate">{{ $news->title ?? 'Tanpa Judul' }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ optional($news->created_at)->format('d M Y') }}
                            </p>
                            <div class="flex gap-2 mt-1.5">
                                @if ($news->is_published)
                                    <span
                                        class="text-[10px] bg-emerald-50 text-emerald-600 px-1.5 py-0.5 rounded font-medium">Published</span>
                                @else
                                    <span
                                        class="text-[10px] bg-amber-50 text-amber-600 px-1.5 py-0.5 rounded font-medium">Draft</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('admin.berita.edit', $news->id) }}"
                            class="flex-shrink-0 w-7 h-7 rounded-lg bg-gray-100 hover:bg-primary-100 flex items-center justify-center text-gray-400 hover:text-primary-600 transition-colors">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">
                        <i class="fa-solid fa-newspaper text-2xl mb-2 block text-gray-200"></i>
                        Belum ada berita terbaru
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Messages --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Pesan Masuk</h3>
                <a href="{{ route('admin.kontak.index') }}"
                    class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    Lihat semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentMessages ?? [] as $msg)
                    <div
                        class="flex items-start gap-3 px-6 py-3.5 hover:bg-gray-50/60 transition-colors {{ !$msg->is_read ? 'bg-primary-50/30' : '' }}">
                        <div
                            class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 text-primary-600 font-bold text-xs">
                            {{ strtoupper(substr($msg->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <p class="font-medium text-gray-800 text-xs truncate">
                                    {{ $msg->subject ?? 'Tanpa Subjek' }}</p>
                                @if (!$msg->is_read)
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500 flex-shrink-0"></span>
                                @endif
                            </div>
                            <p class="text-[10px] text-gray-500 truncate">{{ Str::limit($msg->body ?? '', 60) }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ optional($msg->created_at)->diffForHumans() }}
                            </p>
                        </div>
                        <a href="{{ route('admin.kontak.show', $msg->id) }}"
                            class="flex-shrink-0 w-7 h-7 rounded-lg bg-gray-100 hover:bg-primary-100 flex items-center justify-center text-gray-400 hover:text-primary-600 transition-colors">
                            <i class="fa-solid fa-eye text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">
                        <i class="fa-solid fa-envelope text-2xl mb-2 block text-gray-200"></i>
                        Belum ada pesan masuk
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Gallery --}}
    @if (isset($recentGaleri) && $recentGaleri->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Galeri Terbaru</h3>
                <a href="{{ route('admin.galeri.index') }}"
                    class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    Lihat semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="p-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach ($recentGaleri as $foto)
                    <div class="group relative rounded-xl overflow-hidden aspect-square bg-gray-100">
                        <img src="{{ asset('storage/galeri/' . $foto->image) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="">
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <a href="{{ route('admin.galeri.show', $foto->id) }}"
                                class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xs hover:bg-white/40 transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('statsChart');

            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Users', 'Berita', 'Guru', 'Galeri'],
                    datasets: [{
                        data: [
                            {{ $totalUsers ?? 0 }},
                            {{ $totalBerita ?? 0 }},
                            {{ $totalGuru ?? 0 }},
                            {{ $totalGaleri ?? 0 }},
                        ],
                        backgroundColor: [
                            '#2563eb',
                            '#3b82f6',
                            '#60a5fa',
                            '#93c5fd'
                        ],

                        borderSkipped: false,
                        hoverBackgroundColor: [
                            '#1d4ed8',
                            '#2563eb',
                            '#3b82f6',
                            '#60a5fa'
                        ],

                        barThickness: 28,
                        borderRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#dbeafe'
                            },
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

        });

        function updateDate() {
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            const now = new Date();
            document.getElementById('live-date').innerText =
                now.toLocaleDateString('id-ID', options);
        }

        updateDate(); // pertama kali load
        setInterval(updateDate, 60000); // update tiap 1 menit
    </script>
@endsection
