@extends('public.layouts')

@section('title', 'Beranda')

@section('content')

    @php
        use Illuminate\Support\Str;

        $schoolName = $settings['nama_website'] ?? 'SMPN 1 Lambandia';
        $heroTitle = $settings['hero_title'] ?? $schoolName;
        $heroDesc =
            $settings['hero_description'] ??
            'Mewujudkan generasi berkarakter, disiplin, unggul, dan berwawasan global.';
        $heroImg = !empty($settings['hero_image'])
            ? asset('storage/settings/' . $settings['hero_image'])
            : asset('images/sekolah.jpg');

        $profileTitle = 'Profil Sekolah';
        $profileDesc =
            $settings['profil_sekolah'] ??
            'SMPN 1 Lambandia merupakan sekolah yang berkomitmen memberikan pendidikan berkualitas serta membentuk karakter siswa yang unggul dan berprestasi.';
        $profileImg = !empty($settings['profil_image'])
            ? asset('storage/settings/' . $settings['profil_image'])
            : asset('images/sekolah.jpg');
    @endphp

    {{-- ============ HERO BANNER ============ --}}
    <section id="bannerSlider" class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">

        @forelse($banners as $index => $banner)
            <div
                class="banner-slide absolute inset-0 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('storage/' . $banner->image) }}"
                    class="absolute inset-0 w-full h-full object-cover scale-105 banner-bg">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/70 to-slate-900/40"></div>

                <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
                    <div class="flex flex-col items-center justify-center min-h-[85vh] py-20">
                        <div class="space-y-6">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/20 backdrop-blur-sm text-white text-sm font-semibold border border-white/10">
                                <i class="fa-solid fa-school"></i>
                                {{ $schoolName }}
                            </span>
                            <h1
                                class="text-4xl sm:text-5xl md:text-7xl text-white font-bold leading-tight tracking-tight drop-shadow-lg">
                                {{ $banner->title }}
                            </h1>
                            @if ($banner->subtitle)
                                <p class="text-base sm:text-lg md:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
                                    {{ $banner->subtitle }}
                                </p>
                            @endif
                        </div>
                        @if ($banner->link)
                            <div class="pt-8">
                                <a href="{{ $banner->link }}"
                                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    Selengkapnya
                                    <i class="fa-solid fa-arrow-right text-sm"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <img src="{{ $heroImg }}" class="absolute inset-0 w-full h-full object-cover scale-105 banner-bg">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/70 to-slate-900/40"></div>

            <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
                <div class="flex flex-col items-center justify-center min-h-[85vh] py-20">
                    <div class="space-y-6">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/20 backdrop-blur-sm text-white text-sm font-semibold border border-white/10">
                            <i class="fa-solid fa-school"></i>
                            {{ $schoolName }}
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold leading-tight tracking-tight drop-shadow-lg">
                            {{ $settings['slider_title'] ?? $heroTitle }}
                        </h1>
                        <p class="text-base sm:text-lg md:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
                            {{ $settings['slider_description'] ?? $heroDesc }}
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 pt-8">
                        <a href="/profil"
                            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            <i class="fa-solid fa-newspaper"></i>
                            Tentang Kami
                        </a>
                        <a href="/kontak"
                            class="inline-flex items-center gap-2 border border-white/30 hover:border-white text-white/90 hover:text-white px-8 py-3.5 rounded-xl font-semibold transition-all bg-white/5 hover:bg-white/10 backdrop-blur-sm">
                            <i class="fa-solid fa-phone"></i>
                            Kontak Kami
                        </a>
                    </div>
                </div>
            </div>
        @endforelse

        @if ($banners->count() > 1)
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
                @foreach ($banners as $index => $banner)
                    <button onclick="goToSlide({{ $index }})"
                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 banner-dot {{ $index === 0 ? 'bg-blue-500 w-6' : 'bg-white/40 hover:bg-white/70' }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ============ STATISTIK ============ --}}
    <section class="max-w-7xl mx-auto px-4 md:px-6 -mt-14 relative z-20 pb-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">

            @php
                $statColors = [
                    'Fasilitas' => ['bg' => 'bg-blue-500', 'icon' => 'fa-building'],
                    'Guru' => ['bg' => 'bg-emerald-500', 'icon' => 'fa-chalkboard-user'],
                    'Berita' => ['bg' => 'bg-amber-500', 'icon' => 'fa-newspaper'],
                    'Prestasi' => ['bg' => 'bg-purple-500', 'icon' => 'fa-trophy'],
                ];
            @endphp

            @forelse($statistics ?? [] as $stat)
                @php $colors = $statColors[$stat->label] ?? ['bg' => 'bg-slate-500', 'icon' => 'fa-chart-bar']; @endphp

                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 text-center group border border-white/50">

                    <div
                        class="w-14 h-14 mx-auto rounded-xl {{ $colors['bg'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform text-white text-2xl shadow-lg">
                        <i class="fa-solid {{ $colors['icon'] }}"></i>
                    </div>

                    <h3 class="text-xs text-slate-500 font-semibold uppercase tracking-wider">{{ $stat->label }}</h3>
                    <p class="text-3xl font-extrabold text-slate-900 mt-1 group-hover:text-blue-500 transition-colors">
                        {{ $stat->value }}</p>

                </div>
            @empty
                <div class="col-span-4 text-center text-slate-400 py-8 bg-white/60 backdrop-blur-sm rounded-2xl">
                    <i class="fa-solid fa-chart-bar text-4xl mb-3 opacity-30"></i>
                    <p>Data statistik belum tersedia</p>
                </div>
            @endforelse

        </div>
    </section>

    {{-- ============ PROFIL ============ --}}
    <section class="max-w-7xl mx-auto px-4 md:px-6 pb-20">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            <div data-aos="fade-right" class="relative">
                <div class="absolute -inset-4 bg-gradient-to-br from-blue-500/20 to-transparent rounded-3xl blur-xl"></div>
                <img src="{{ $profileImg }}" class="relative rounded-2xl shadow-xl w-full h-80 md:h-96 object-cover">
            </div>

            <div data-aos="fade-left" class="space-y-6">

                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-sm font-semibold">
                    <i class="fa-solid fa-school"></i>
                    Profil Sekolah
                </span>

                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">{{ $profileTitle }}</h2>

                <p class="text-slate-600 text-lg leading-relaxed">{{ $profileDesc }}</p>

                <a href="/profil"
                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                    Selengkapnya
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

        </div>
    </section>

    {{-- ============ PRESTASI ============ --}}
    <section class="py-20 bg-white relative overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-500/5 rounded-full blur-[100px] pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 text-purple-600 text-sm font-semibold">
                        <i class="fa-solid fa-trophy"></i>
                        PRESTASI SEKOLAH
                    </span>

                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Prestasi Siswa</h2>

                    <p class="text-slate-500 mt-2 max-w-2xl">
                        Berbagai pencapaian dan penghargaan yang berhasil diraih oleh siswa maupun sekolah dalam bidang
                        akademik dan non akademik.
                    </p>
                </div>

                <a href="{{ route('prestasi') }}"
                    class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-purple-500 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    LIHAT SEMUA
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse($recentPrestasi as $index => $prestasi)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                        class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300">

                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            @if ($prestasi->image)
                                <img src="{{ asset('storage/prestasi/' . $prestasi->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-trophy text-5xl text-slate-300"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-3 py-1 bg-purple-500 text-white text-xs font-semibold rounded-full shadow">PRESTASI</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3
                                class="text-lg font-bold text-slate-900 mb-2 group-hover:text-purple-600 transition line-clamp-2">
                                {{ $prestasi->title }}
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($prestasi->description), 120) }}
                            </p>
                            <a href="{{ route('prestasi.show', $prestasi->id) }}"
                                class="inline-flex items-center gap-1 mt-4 text-purple-600 hover:text-purple-500 font-semibold text-sm transition">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <i class="fa-solid fa-trophy text-5xl text-slate-300 mb-3"></i>
                        <p class="text-slate-400">Belum ada data prestasi tersedia</p>
                    </div>
                @endforelse

            </div>

        </div>

    </section>

    {{-- ============ BERITA ============ --}}
    <section class="py-20 bg-slate-50 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-amber-500/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-amber-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 text-amber-600 text-sm font-semibold">
                        <i class="fa-solid fa-newspaper"></i>
                        INFORMASI SEKOLAH
                    </span>

                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Berita & Kegiatan</h2>

                    <p class="text-slate-500 mt-2 max-w-2xl">
                        Informasi terbaru seputar kegiatan, pengumuman, dan perkembangan sekolah.
                    </p>
                </div>

                <a href="{{ route('berita.index') }}"
                    class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-amber-500 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    LIHAT SEMUA
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">

                @forelse($recentNews as $index => $news)
                    <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all overflow-hidden group">

                        <div class="relative h-44 overflow-hidden bg-slate-200">
                            @if ($news->image)
                                <img src="{{ asset('storage/berita/' . $news->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-300">
                                    <i class="fa-solid fa-newspaper text-4xl text-white/40"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <span class="text-xs text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                            </span>
                            <h3 class="font-bold text-slate-900 mt-1 line-clamp-2 group-hover:text-amber-600 transition">
                                {{ $news->title }}
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($news->content), 80) }}
                            </p>
                            <a href="{{ route('berita.show', $news->slug) }}"
                                class="inline-flex items-center gap-1 mt-3 text-amber-600 hover:text-amber-500 font-semibold text-sm transition">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                    </article>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <i class="fa-solid fa-newspaper text-5xl text-slate-300 mb-3"></i>
                        <p class="text-slate-400">Belum ada berita tersedia</p>
                    </div>
                @endforelse

            </div>

        </div>

    </section>

    {{-- ============ FASILITAS ============ --}}
    <section class="py-20 bg-white relative overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-sm font-semibold">
                        <i class="fa-solid fa-building"></i>
                        SARANA SEKOLAH
                    </span>

                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Fasilitas</h2>

                    <p class="text-slate-500 mt-2 max-w-2xl">
                        Berbagai fasilitas unggulan sekolah yang mendukung pembelajaran aktif, kreatif, dan inovatif.
                    </p>
                </div>

                <a href="{{ route('fasilitas') }}"
                    class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    LIHAT SEMUA
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($recentFasilitas as $index => $item)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                        class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200 hover:border-blue-300 hover:shadow-xl transition-all">

                        <div class="relative h-48 overflow-hidden">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full bg-slate-300 flex items-center justify-center">
                                    <i class="fa-solid fa-school text-5xl text-slate-400"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full shadow">FASILITAS</span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">
                                {{ $item->name }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($item->description), 120) }}</p>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>

    {{-- ============ GURU ============ --}}
    <section class="py-20 bg-slate-50 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-emerald-500/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-emerald-500/5 rounded-full blur-[100px] pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-600 text-sm font-semibold">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        TENAGA PENDIDIK
                    </span>

                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Guru & Staff Profesional</h2>

                    <p class="text-slate-500 mt-2 max-w-2xl">
                        Didukung tenaga pendidik berpengalaman dan profesional untuk menciptakan pembelajaran modern
                        berkualitas.
                    </p>
                </div>

                <a href="{{ route('guru.index') }}"
                    class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    LIHAT SEMUA
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach ($recentGuru as $index => $guru)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}"
                        class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-emerald-300 hover:shadow-xl transition-all">

                        <div class="relative h-64 overflow-hidden bg-slate-100">
                            @if ($guru->photo)
                                <img src="{{ asset('storage/guru/' . $guru->photo) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-user text-5xl text-slate-400"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 text-center">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">
                                {{ $guru->name }}</h3>
                            <p class="text-emerald-600 text-sm font-semibold mt-1">{{ $guru->position }}</p>
                            <p class="text-slate-500 text-xs mt-2">{{ $guru->subject ?? 'Guru ' . $schoolName }}</p>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>

    {{-- ============ GALERI ============ --}}
    <section class="py-20 bg-white relative overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-rose-500/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-rose-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-rose-100 text-rose-600 text-sm font-semibold">
                        <i class="fa-solid fa-images"></i>
                        DOKUMENTASI SEKOLAH
                    </span>

                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Galeri Kegiatan</h2>

                    <p class="text-slate-500 mt-2 max-w-2xl">
                        Dokumentasi berbagai kegiatan sekolah, pembelajaran, dan aktivitas siswa.
                    </p>
                </div>

                <a href="{{ route('galeri.index') }}"
                    class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-slate-900 hover:bg-rose-500 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    LIHAT SEMUA
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

            </div>

            <style>
                .card-home-galeri {
                    position: relative;
                    width: 100%;
                    height: 280px;
                    background-color: #f2f2f2;
                    border-radius: 16px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    perspective: 1000px;
                    box-shadow: 0 0 0 5px #ffffff80;
                    transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                }

                .card-home-galeri .card-icon {
                    width: 56px;
                    transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    z-index: 1;
                }

                .card-home-galeri:hover {
                    transform: scale(1.05);
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                }

                .card-home-galeri .card-content {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    padding: 24px;
                    box-sizing: border-box;
                    background-color: #f2f2f2;
                    transform: rotateX(-90deg);
                    transform-origin: bottom;
                    transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .card-home-galeri:hover .card-content {
                    transform: rotateX(0deg);
                }

                .card-home-galeri .card-title {
                    margin: 0;
                    font-size: 18px;
                    color: #333;
                    font-weight: 700;
                }

                .card-home-galeri:hover .card-icon {
                    scale: 0;
                }

                .card-home-galeri .card-description {
                    margin: 10px 0 0;
                    font-size: 13px;
                    color: #555;
                    line-height: 1.5;
                    display: -webkit-box;
                    -webkit-line-clamp: 5;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }

                .card-home-galeri .card-badge {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    z-index: 2;
                    padding: 4px 12px;
                    border-radius: 999px;
                    font-size: 11px;
                    font-weight: 600;
                    background: rgba(34, 197, 94, 0.9);
                    color: #fff;
                    backdrop-filter: blur(4px);
                }

                .card-home-galeri .card-image {
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    z-index: 0;
                }

                .card-home-galeri:hover .card-image {
                    scale: 0;
                }
            </style>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @forelse($recentGaleri as $index => $foto)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="card-home-galeri">

                        <span class="card-badge">{{ $foto->category ?? 'Umum' }}</span>

                        @if ($foto->image)
                            <img src="{{ asset('storage/galeri/' . $foto->image) }}" alt="{{ $foto->title }}"
                                class="card-image">
                        @else
                            <i class="fa-solid fa-image card-icon text-5xl text-slate-400"></i>
                        @endif

                        <div class="card-content">
                            <h3 class="card-title">{{ $foto->title }}</h3>
                            <p class="card-description">{{ $foto->description ?? '' }}</p>
                        </div>

                    </div>
                @empty
                    <div class="col-span-4 text-center py-12">
                        <i class="fa-solid fa-image text-5xl text-slate-300 mb-3"></i>
                        <p class="text-slate-400">Belum ada galeri tersedia</p>
                    </div>
                @endforelse

            </div>

        </div>

    </section>

    @push('scripts')
        <script>
            // Banner zoom animation
            document.querySelectorAll('.banner-bg').forEach(img => {
                img.style.transition = 'transform 8s ease-out';
                img.style.transform = 'scale(1)';
                setTimeout(() => {
                    img.style.transform = 'scale(1.08)';
                }, 100);
            });

            // Banner Slider
            const bannerSlides = document.querySelectorAll('.banner-slide');
            const bannerDots = document.querySelectorAll('.banner-dot');
            let currentSlide = 0;
            let slideInterval;

            function goToSlide(index) {
                bannerSlides.forEach((slide, i) => {
                    slide.classList.toggle('opacity-100', i === index);
                    slide.classList.toggle('opacity-0', i !== index);
                });
                bannerDots.forEach((dot, i) => {
                    dot.classList.toggle('bg-blue-500', i === index);
                    dot.classList.toggle('bg-white/40', i !== index);
                    if (i === index) dot.classList.add('w-6');
                    else dot.classList.remove('w-6');
                });
                currentSlide = index;
            }

            function nextSlide() {
                goToSlide((currentSlide + 1) % bannerSlides.length);
            }

            if (bannerSlides.length > 1) {
                slideInterval = setInterval(nextSlide, 5000);
                document.getElementById('bannerSlider').addEventListener('mouseenter', () => clearInterval(slideInterval));
                document.getElementById('bannerSlider').addEventListener('mouseleave', () => {
                    slideInterval = setInterval(nextSlide, 5000);
                });
            }
        </script>
    @endpush

@endsection
