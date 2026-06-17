@extends('public.layouts')

@section('title', 'Beranda')

@section('content')

    @php
        use Illuminate\Support\Str;
        /*
|--------------------------------------------------------------------------
| HERO BANNER DATA
|--------------------------------------------------------------------------
*/
        $schoolName = $settings['nama_website'] ?? 'Portal Sekolah';
        $defaultDescription = 'Mewujudkan generasi berkarakter, disiplin, unggul, dan berwawasan global.';
        $slides = [];
        $backgrounds = [
            'bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900',
            'bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900',
            'bg-gradient-to-r from-indigo-950 via-indigo-900 to-slate-900',
        ];
        /*
|--------------------------------------------------------------------------
| AMBIL DATA BANNER DARI ADMIN
|--------------------------------------------------------------------------
*/
        if ($banners->isNotEmpty()) {
            foreach ($banners as $index => $banner) {
                $slides[] = [
                    'title' => $banner->title,
                    'description' => $banner->subtitle ?? $defaultDescription,
                    'background' => $backgrounds[$index % count($backgrounds)],
                    'image' => $banner->image ? asset('storage/' . $banner->image) : null,
                    'link' => $banner->link ? url($banner->link) : null,
                ];
            }
        } else {
            /*
|--------------------------------------------------------------------------
| DEFAULT BANNER
|--------------------------------------------------------------------------
*/
            $slides = [
                [
                    'title' => 'Membentuk Generasi Unggul Berkarakter',
                    'description' => $settings['hero_description'] ?? $defaultDescription,
                    'background' => $backgrounds[0],
                    'image' => null,
                    'link' => null,
                ],
                [
                    'title' => 'Prestasi Akademik & Non Akademik',
                    'description' => 'Sekolah membangun siswa kreatif dan inovatif.',
                    'background' => $backgrounds[1],
                    'image' => null,
                    'link' => null,
                ],
                [
                    'title' => 'Pembelajaran Modern Berbasis Teknologi',
                    'description' => 'Mendukung pendidikan digital masa depan.',
                    'background' => $backgrounds[2],
                    'image' => null,
                    'link' => null,
                ],
            ];
        }
    @endphp

    {{-- ============ HERO CAROUSEL ============ --}}
    <section class="relative min-h-[520px] sm:min-h-[580px] flex items-center overflow-hidden" x-data="heroCarousel({{ json_encode($slides) }})"
        x-init="init()">
        <template x-for="(slide, idx) in slides" :key="idx">
            <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out"
                :class="idx === current ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="absolute inset-0" :class="slide.bg">
                    <img x-show="slide.image" :src="slide.image" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/40 to-transparent"></div>

                <div
                    class="max-w-7xl mx-auto px-4 sm:px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 h-full items-center relative z-20 pt-20 sm:pt-24 pb-16">
                    <div class="lg:col-span-8 space-y-6">
                        <h2 class="text-2xl sm:text-3xl md:text-5xl font-extrabold tracking-tight leading-tight md:leading-none text-white max-w-2xl"
                            x-text="slide.title">
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl" x-text="slide.description">
                        </p>
                        <div class="flex flex-wrap items-center gap-3 pt-4">
                            <a x-show="slide.link" :href="slide.link"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 sm:px-6 py-3.5 rounded-xl shadow-lg shadow-blue-500/15 flex items-center gap-2 transition hover:scale-105">
                                Pelajari Selengkapnya
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Carousel controls --}}
        <div class="absolute bottom-6 left-0 right-0 z-30 max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <template x-for="(_, dotIdx) in slides" :key="dotIdx">
                    <button class="transition-all duration-300 h-2 rounded-full cursor-pointer"
                        :class="dotIdx === current ? 'w-8 bg-blue-500' : 'w-2 bg-slate-600'" @click="goTo(dotIdx)">
                    </button>
                </template>
            </div>
            <div class="flex gap-2">
                <button @click="prev()"
                    class="w-9 h-9 rounded-lg bg-slate-900/60 hover:bg-slate-900 text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer">
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button @click="next()"
                    class="w-9 h-9 rounded-lg bg-slate-900/60 hover:bg-slate-900 text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    {{-- ============ STATISTICS ============ --}}
    <section class="bg-slate-50 border-y border-slate-200 py-10 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $statIcons = [
                    'Fasilitas' => 'business',
                    'Guru' => 'group',
                    'Berita' => 'newspaper',
                    'Prestasi' => 'military_tech',
                ];
            @endphp
            @forelse ($statistics ?? [] as $stat)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                    class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm flex items-center sm:items-start gap-3 sm:gap-4 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <span
                            class="material-symbols-outlined text-lg sm:text-xl">{{ $statIcons[$stat->label] ?? 'bar_chart' }}</span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-900 leading-none truncate">
                            {{ $stat->value }}</h4>
                        <p
                            class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase mt-1 tracking-wide leading-none truncate">
                            {{ $stat->label }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-slate-400 text-xs">Data statistik belum tersedia</div>
            @endforelse
        </div>
    </section>

    {{-- ============ SAMBUTAN KEPSEK ============ --}}
    <section
        class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-center">
        <div class="lg:col-span-5 relative" data-aos="fade-right">
            <div class="absolute -top-4 -left-4 w-72 h-72 bg-blue-100 rounded-full blur-3xl opacity-45 -z-10"></div>
            @if (!empty($settings['hero_image']))
                <img src="{{ asset('storage/settings/' . $settings['hero_image']) }}" alt="Kepala Sekolah"
                    class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-xl border border-slate-100">
            @else
                <div
                    class="w-full h-80 md:h-96 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 border border-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-blue-300">person</span>
                </div>
            @endif
            @if (!empty($settings['kepala_sekolah']))
                <div
                    class="absolute bottom-4 left-4 bg-slate-900/90 backdrop-blur text-white px-4 py-2.5 rounded-xl border border-slate-700">
                    <span class="text-[9px] font-bold uppercase text-blue-400 tracking-wider">Kepala Sekolah</span>
                    <h5 class="text-xs font-black">{{ $settings['kepala_sekolah'] }}</h5>
                </div>
            @endif
        </div>

        <div class="lg:col-span-7 space-y-6" data-aos="fade-left">
            <span
                class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                Sambutan Kepala Sekolah
            </span>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-snug">
                Selamat Datang di {{ $settings['nama_website'] ?? 'Portal Sekolah' }}
            </h3>
            <div class="text-xs text-slate-600 leading-relaxed space-y-4">
                <p>{{ $settings['sambutan_kepsek'] ?? 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi sekolah kami.' }}
                </p>
                @if (!empty($settings['visi']))
                    <p class="font-semibold text-slate-700">Visi: {{ $settings['visi'] }}</p>
                @endif
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <a href="/profil"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow">
                    Lihat Visi Misi Sekolah
                </a>
                {{-- <a href="/kontak"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-5 py-3 rounded-xl transition">
                    Hubungi Tata Usaha
                </a> --}}
            </div>
        </div>
    </section>

    {{-- ============ QUICK PORTALS ============ --}}
    <section class="py-14 sm:py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center space-y-3 max-w-xl mx-auto mb-14">
                <span
                    class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                    Navigasi Cepat
                </span>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Jelajahi Portal Layanan</h3>
                <p class="text-xs text-slate-500">Dapatkan akses instan ke seluruh informasi penting sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="/profil"
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 text-left">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">school</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 uppercase">Profil & Sejarah</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed mt-2">Telusuri perjalanan sekolah serta visi
                        kurikulum kami.</p>
                </a>

                <a href="/prestasi"
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 text-left">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">trophy</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 uppercase">Prestasi Akademik</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed mt-2">Melihat torehan prestasi di berbagai bidang.
                    </p>
                </a>

                <a href="/data-guru"
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 text-left">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">group</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 uppercase">Staf Pengajar</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed mt-2">Kenali dewan guru profesional kami.</p>
                </a>

                <a href="/kontak"
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 text-left">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">forum</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 uppercase">Kotak Masukan</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed mt-2">Sampaikan saran, aspirasi, dan pengaduan.</p>
                </a>
            </div>
        </div>
    </section>

    {{-- ============ PROFIL ============ --}}
    <section
        class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center">
        <div data-aos="fade-right" class="space-y-6">
            <span
                class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                Tentang Sekolah
            </span>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-normal">
                Mengabdi Demi Mencerdaskan Kehidupan Bangsa
            </h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                {{ $settings['profil_sekolah'] ?? ($settings['tentang_sekolah'] ?? 'Deskripsi sekolah belum tersedia.') }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                <div class="flex items-start gap-2.5">
                    <div
                        class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 text-xs">
                        <span class="material-symbols-outlined text-sm">check</span>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-slate-800">Kurikulum Global</h5>
                        <p class="text-[11px] text-slate-500 mt-1">Interkoneksi materi dan ujian terstandar.</p>
                    </div>
                </div>
                <div class="flex items-start gap-2.5">
                    <div
                        class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 text-xs">
                        <span class="material-symbols-outlined text-sm">check</span>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-slate-800">Ekstrakurikuler Aktif</h5>
                        <p class="text-[11px] text-slate-500 mt-1">Membina bakat minat robotik dan atletik.</p>
                    </div>
                </div>
            </div>
            <a href="/profil"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs transition shadow-md">
                Selengkapnya
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="relative" data-aos="fade-left">
            <div class="absolute -top-4 -left-4 w-72 h-72 bg-blue-200 rounded-full blur-3xl opacity-40 -z-10"></div>
            @if (!empty($settings['profil_image']))
                <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}" alt="Profil Sekolah"
                    class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-xl border border-slate-100">
            @else
                <div
                    class="w-full h-80 md:h-96 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 border border-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-6xl text-blue-300">school</span>
                </div>
            @endif

        </div>
    </section>

    {{-- ============ PRESTASI ============ --}}
    <section class="py-14 sm:py-20 bg-slate-50 border-y border-slate-200" x-data="{ filter: 'Semua' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <span
                    class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                    Galeri Prestasi
                </span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-3">Prestasi</h3>
                <p class="text-xs text-slate-500 mt-2">Daftar torehan membanggakan yang diraih siswa-siswi di berbagai
                    bidang.</p>

                <div class="flex gap-2.5 overflow-x-auto pb-1 justify-center mt-6">
                    @php
                        $categories = ['Semua'];
                        foreach ($recentPrestasi as $p) {
                            if ($p->category && !in_array($p->category, $categories)) {
                                $categories[] = $p->category;
                            }
                        }
                    @endphp
                    @foreach ($categories as $cat)
                        <button @click="filter = '{{ $cat }}'"
                            class="px-4 py-2 text-xs font-bold rounded-xl border transition-all shrink-0 cursor-pointer"
                            :class="filter === '{{ $cat }}'
                                ?
                                'bg-blue-600 text-white border-transparent shadow' :
                                'bg-white hover:bg-slate-50 text-slate-600 border-slate-200'">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($recentPrestasi as $prestasi)
                    <div x-show="filter === 'Semua' || filter === '{{ $prestasi->category }}'"
                        x-transition:enter="transition ease-out duration-300" data-aos="fade-up"
                        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-[10px] bg-blue-50 text-blue-600 font-extrabold uppercase px-2.5 py-1 rounded-full">
                                {{ $prestasi->category ?? 'Prestasi' }}
                            </span>
                            @if ($prestasi->year)
                                <span class="text-[10px] font-semibold text-slate-400">{{ $prestasi->year }}</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900 mt-4 leading-snug">{{ $prestasi->title }}</h4>
                        @if ($prestasi->description)
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-2.5">
                                {{ Str::limit(strip_tags($prestasi->description), 100) }}</p>
                        @endif
                        @if ($prestasi->level)
                            <span
                                class="inline-block mt-3 text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $prestasi->level }}</span>
                        @endif
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 text-slate-400 text-xs">Belum ada data prestasi.</div>
                @endforelse
            </div>

            @if ($recentPrestasi->count() > 0)
                <div class="text-center mt-10">
                    <a href="/prestasi"
                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs transition">
                        Lihat Semua Prestasi
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ============ BERITA ============ --}}
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6" x-data="{ selectedNews: null }">
        <div class="text-center space-y-3 max-w-xl mx-auto mb-16" data-aos="fade-up">
            <span
                class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                Berita Sekolah
            </span>
            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Menyajikan Kabar Hangat & Terpercaya</h3>
            <p class="text-xs text-slate-500">Liputan kegiatan, pengumuman akademik, dan aktivitas sosial sekolah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($recentNews as $news)
                <article @click="selectedNews = {{ $news->id }}"
                    class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1.5 transition-all duration-300 cursor-pointer flex flex-col group"
                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="h-48 relative overflow-hidden bg-slate-100">
                        @if ($news->image)
                            <img src="{{ asset('storage/berita/' . $news->image) }}" alt="{{ $news->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-5xl">newspaper</span>
                            </div>
                        @endif
                        @if ($news->category)
                            <span
                                class="absolute top-4 left-4 bg-blue-600 text-white text-[9px] font-extrabold uppercase py-1 px-3 rounded-full shadow">
                                {{ $news->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-4 sm:p-6 space-y-3 flex flex-col flex-1">
                        <div>
                            <div
                                class="flex items-center gap-1.5 text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-sm">calendar_month</span>
                                <span>{{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                            <h4
                                class="font-extrabold text-sm text-slate-900 tracking-tight group-hover:text-blue-600 transition leading-snug">
                                {{ $news->title }}
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-normal mt-2 line-clamp-3">
                                {{ Str::limit(strip_tags($news->content), 120) }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-auto">
                            <span
                                class="text-[11px] font-bold text-blue-600 group-hover:text-blue-800 transition flex items-center gap-1">
                                Baca Selengkapnya
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400 text-xs">Belum ada berita tersedia.</div>
            @endforelse
        </div>

        @if ($recentNews->count() > 0)
            <div class="text-center mt-12">
                <a href="/berita"
                    class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs transition">
                    Lihat Semua Berita
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        @endif

        {{-- Berita Detail Modal --}}
        <template x-teleport="body">
            <div x-show="selectedNews !== null"
                class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto"
                x-cloak @click="selectedNews = null">
                <div @click.stop
                    class="bg-white rounded-3xl max-w-2xl w-full my-8 overflow-hidden shadow-2xl border border-slate-100 text-left">
                    @foreach ($recentNews as $news)
                        <div x-show="selectedNews === {{ $news->id }}" x-cloak>
                            <div class="h-56 sm:h-72 relative bg-slate-100">
                                @if ($news->image)
                                    <img src="{{ asset('storage/berita/' . $news->image) }}" alt="{{ $news->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined text-6xl">newspaper</span>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent">
                                </div>
                                <button @click="selectedNews = null"
                                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center transition cursor-pointer">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                                @if ($news->category)
                                    <span
                                        class="absolute bottom-6 left-6 bg-blue-600 text-white text-[10px] font-extrabold uppercase py-1.5 px-4 rounded-full shadow">
                                        {{ $news->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-6 sm:p-8 space-y-4 overflow-y-auto max-h-[65vh] sm:max-h-[50vh]">
                                <div>
                                    <div
                                        class="flex items-center gap-3 text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-3">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                                            {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                                        </span>
                                        <span>•</span>
                                        <span>Oleh: Admin</span>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-snug">
                                        {{ $news->title }}
                                    </h3>
                                </div>
                                <div
                                    class="text-xs text-slate-600 leading-relaxed space-y-4 border-b border-slate-100 pb-6">
                                    {!! nl2br(e($news->content)) !!}
                                </div>
                            </div>
                            <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-slate-100 flex justify-end">
                                <button @click="selectedNews = null"
                                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs px-5 py-2.5 rounded-xl transition cursor-pointer">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </template>
    </section>

    {{-- ============ FASILITAS ============ --}}
    <section class="py-14 sm:py-20 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center space-y-3 max-w-xl mx-auto mb-16" data-aos="fade-up">
                <span
                    class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                    Fasilitas Utama
                </span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Infrastruktur Kelas Dunia</h3>
                <p class="text-xs text-slate-500">Mendukung sarana belajar mengajar bagi seluruh peserta didik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($recentFasilitas as $item)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                        class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition duration-300 flex flex-col">
                        <div class="h-40 overflow-hidden bg-slate-100">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-5xl">business</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h4 class="font-bold text-sm text-slate-900">{{ $item->name }}</h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-2 flex-1">
                                {{ Str::limit(strip_tags($item->description), 100) }}
                            </p>
                            <a href="/fasilitas"
                                class="inline-flex items-center gap-1 mt-3 text-[10px] font-bold text-blue-600 hover:text-blue-700 uppercase tracking-wider">
                                Telusuri Area
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 text-slate-400 text-xs">Belum ada data fasilitas.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ GURU ============ --}}
    <section class="py-10 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6" x-data="{ search: '', deptFilter: 'Semua' }">
        <div class="text-center space-y-3 max-w-xl mx-auto mb-12" data-aos="fade-up">
            <span
                class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                Direktori Staf Pengajar
            </span>
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Dipimpin Praktisi Pendidikan
                Berkelas</h3>
            <p class="text-xs text-slate-500">Para guru merupakan lulusan universitas terbaik dan berlisensi profesional.
            </p>
        </div>

        <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl mb-10 flex flex-col md:flex-row gap-4 items-center justify-between shadow-sm"
            data-aos="fade-up">
            <div class="relative w-full md:max-w-md">
                <span
                    class="material-symbols-outlined text-sm text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2">search</span>
                <input type="text" x-model="search" placeholder="Cari guru berdasarkan nama atau bidang..."
                    class="w-full text-xs font-medium pl-9 pr-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
            </div>
            <div class="flex gap-2.5 overflow-x-auto pb-3 w-full scrollbar-hide">
                @php
                    $depts = ['Semua'];
                    foreach ($recentGuru as $g) {
                        if ($g->subject && !in_array($g->subject, $depts)) {
                            $depts[] = $g->subject;
                        }
                    }
                @endphp
                @foreach ($depts as $dept)
                    <button @click="deptFilter = '{{ $dept }}'"
                        class="px-4 py-2 text-xs font-bold rounded-xl border transition-all shrink-0 cursor-pointer"
                        :class="deptFilter === '{{ $dept }}'
                            ?
                            'bg-blue-600 text-white border-transparent shadow-md' :
                            'bg-white hover:bg-slate-100 text-slate-600 border-slate-200'">
                        {{ $dept }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($recentGuru as $guru)
                <div x-show="
                    (deptFilter === 'Semua' || deptFilter === '{{ $guru->subject }}')
&&
                    (search === '' ||
                        '{{ strtolower($guru->name) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower($guru->position ?? '') }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower($guru->subject ?? '') }}'.includes(search.toLowerCase()))"
                    x-transition:enter="transition ease-out duration-300" data-aos="fade-up"
                    data-aos-delay="{{ $loop->index * 100 }}"
                    class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm hover:shadow-lg hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                    <div
                        class="relative w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-slate-100 mb-4 bg-slate-100">
                        @if ($guru->photo)
                            <img src="{{ asset('storage/guru/' . $guru->photo) }}" alt="{{ $guru->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-3xl">person</span>
                            </div>
                        @endif
                    </div>
                    @if ($guru->subject)
                        <span
                            class="text-[9px] bg-slate-50 border border-slate-200 text-slate-500 px-2.5 py-1 rounded-full uppercase font-bold tracking-wider mb-3">
                            {{ $guru->subject }}
                        </span>
                    @endif
                    <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-blue-600 transition">
                        {{ $guru->name }}</h4>
                    @if ($guru->position)
                        <p class="text-[10px] text-blue-600 font-bold mt-1">{{ $guru->position }}</p>
                    @endif
                    @if ($guru->bio)
                        <p class="text-[10px] text-slate-500 leading-normal mt-3 line-clamp-2 italic">
                            "{{ Str::limit(strip_tags($guru->bio), 80) }}"
                        </p>
                    @endif
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400 text-xs">Belum ada data guru.</div>
            @endforelse
        </div>

        @if ($recentGuru->count() > 0)
            <div class="text-center mt-12">
                <a href="/data-guru"
                    class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs transition">
                    Lihat Semua Guru
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        @endif
    </section>

    {{-- ============ GALERI ============ --}}
    <section class="py-14 sm:py-20 bg-slate-50 border-y border-slate-200" x-data="{ lightbox: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center space-y-3 max-w-xl mx-auto mb-16" data-aos="fade-up">
                <span
                    class="bg-blue-50 text-blue-700 font-extrabold text-[10px] py-1.5 px-3 rounded-full tracking-wider uppercase inline-block">
                    Galeri Dokumentasi
                </span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Mengabadikan Momentum Kebersamaan</h3>
                <p class="text-xs text-slate-500">Klik foto untuk melihat pratinjau resolusi tinggi.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @forelse ($recentGaleri as $foto)
                    <div @click="lightbox = '{{ asset('storage/galeri/' . $foto->image) }}'"
                        class="group relative cursor-pointer overflow-hidden rounded-2xl border border-slate-200 shadow-sm aspect-[4/3] bg-slate-100"
                        data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        @if ($foto->image)
                            <img src="{{ asset('storage/galeri/' . $foto->image) }}" alt="{{ $foto->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-5xl">image</span>
                            </div>
                        @endif
                        <div
                            class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950 via-slate-900/40 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="text-[10px] text-white leading-relaxed font-semibold">{{ $foto->title }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 text-slate-400 text-xs">Belum ada galeri.</div>
                @endforelse
            </div>

            @if ($recentGaleri->count() > 0)
                <div class="text-center mt-10">
                    <a href="/galeri"
                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs transition">
                        Lihat Semua Galeri
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Lightbox --}}
        <template x-teleport="body">
            <div x-show="lightbox !== null"
                class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4" x-cloak
                @click="lightbox = null">
                <button @click="lightbox = null"
                    class="absolute top-6 right-6 w-10 h-10 rounded-full bg-slate-800 text-slate-300 hover:text-white flex items-center justify-center transition cursor-pointer">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div @click.stop class="max-w-4xl max-h-[85vh]">
                    <img :src="lightbox" alt="Preview"
                        class="rounded-2xl border border-slate-800 shadow-2xl max-w-full max-h-[80vh] object-contain">
                </div>
            </div>
        </template>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('heroCarousel', (initialSlides) => ({
                    current: 0,
                    slides: initialSlides,
                    timer: null,
                    init() {
                        if (this.slides.length > 1) {
                            this.timer = setInterval(() => this.next(), 6000);
                        }
                    },
                    goTo(idx) {
                        this.current = idx;
                        clearInterval(this.timer);
                        if (this.slides.length > 1) {
                            this.timer = setInterval(() => this.next(), 6000);
                        }
                    },
                    next() {
                        this.current = (this.current + 1) % this.slides.length;
                    },
                    prev() {
                        this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                    }
                }));
            });
        </script>
    @endpush

@endsection
