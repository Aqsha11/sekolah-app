<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['tagline'] ?? 'Website Resmi Sekolah' }}">
    <title>@yield('title', '')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    @php
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $nav = [
            '/' => 'Beranda',
            'profil' => 'Profil',
            'berita' => 'Berita',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'data-guru' => 'Data Guru',
            'galeri' => 'Galeri',
            'kontak' => 'Kontak',
        ];
    @endphp

    @if (!empty($settings['favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/settings/' . $settings['favicon']) }}">
    @endif


</head>

<body class="bg-slate-50 text-slate-900">

    {{-- NAVBAR --}}
    <header id="mainHeader" class="sticky top-0 z-50 transition-all duration-300 bg-transparent py-5">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">

            {{-- Logo Brand --}}
            <div class="flex items-center gap-3">

                <div class="relative">
                    <span
                        class="absolute -inset-1 rounded-full bg-gradient-to-tr from-blue-500 to-blue-600 opacity-60 blur-sm">
                    </span>

                    <div
                        class="relative w-11 h-11 bg-slate-900 rounded-full flex items-center justify-center border border-white/20 overflow-hidden ring-2 ring-blue-400/20">

                        @if (!empty($settings['logo']))
                            <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                                class="w-7 h-7 object-cover rounded-full">
                        @endif

                    </div>
                </div>

                <div>
                    <a href="/" id="brandText"
                        class="text-base font-extrabold tracking-tight text-slate-900 leading-none transition-colors duration-300">

                        {{ $settings['nama_website'] ?? '' }}

                    </a>

                    @if (!empty($settings['tagline']))
                        <p class="text-[11px] text-slate-500">
                            {{ $settings['tagline'] }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Desktop Navigation --}}
            <nav
                class="hidden lg:flex items-center gap-1.5 bg-slate-900/90 py-1.5 px-2 rounded-full border border-slate-700/50 shadow-inner backdrop-blur-md">

                @foreach ($nav as $url => $label)
                    <a href="{{ url($url) }}"
                        class="px-4 py-2 rounded-full text-xs font-bold tracking-wide transition-all duration-300
                    {{ request()->is($url) || (request()->path() === '/' && $url === '/')
                        ? 'bg-blue-400 text-slate-950 shadow-md'
                        : 'text-slate-300 hover:text-white hover:bg-slate-800/70' }}">

                        {{ strtoupper($label) }}
                    </a>
                @endforeach

            </nav>

            {{-- Right Action --}}
            <div class="hidden lg:flex items-center gap-3">

                {{-- AI Button --}}
                {{-- <button
                    class="flex items-center gap-1.5 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-500 text-slate-950 text-xs font-black rounded-full shadow-lg shadow-blue-500/20 hover:scale-105 transition-all group">

                    <i class="fa-solid fa-robot text-slate-950 group-hover:rotate-12 transition-transform"></i>

                    TANYA AI
                </button> --}}

                {{-- Login --}}
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 bg-slate-900 border border-slate-800 text-white text-xs font-bold rounded-full hover:bg-slate-800 hover:text-blue-400 transition-all shadow-md inline-flex items-center gap-1.5">

                    LOGIN

                    <i class="fa-solid fa-arrow-right text-blue-400 text-[11px]"></i>
                </a>
            </div>

            {{-- Mobile Button --}}
            <button id="menuBtn"
                class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center transition-all text-slate-900 hover:bg-slate-200">

                <i class="fa-solid fa-bars text-lg"></i>
            </button>

        </div>

        {{-- MOBILE MENU --}}
        <div id="mobileMenu" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out lg:hidden">

            <div class="mx-4 mt-3 bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-2xl">

                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">

                    <div class="flex items-center gap-2">
                        <i class=" text-blue-500"></i>

                        <span class="text-sm font-bold text-white uppercase tracking-tight">
                            MENU
                        </span>
                    </div>

                    <button id="closeMenu"
                        class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center hover:text-white">

                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="space-y-1.5">

                    @foreach ($nav as $url => $label)
                        <a href="{{ url($url) }}"
                            class="block py-3 px-4 rounded-xl text-sm font-bold transition-all
                        {{ request()->is($url) || (request()->path() === '/' && $url === '/')
                            ? 'bg-blue-400 text-slate-950'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                            {{ $label }}
                        </a>
                    @endforeach

                </div>

                <div class="grid grid-cols-2 gap-3 mt-6 pt-5 border-t border-slate-800">

                    {{-- <button
                        class="flex items-center justify-center gap-1.5 py-3.5 bg-blue-500 rounded-2xl text-slate-950 font-black text-xs shadow-md">

                        <i class="fa-solid fa-robot"></i>

                        TANYA AI
                    </button> --}}

                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center py-3.5 bg-slate-800 border border-slate-700 text-white font-bold text-xs rounded-2xl">

                        LOGIN
                    </a>

                </div>

            </div>
        </div>
    </header>

    <button id="backToTop"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-full bg-blue-500 hover:bg-blue-400 text-slate-900 shadow-lg shadow-blue-500/30 flex items-center justify-center transition-all duration-300 opacity-0 invisible translate-y-5 hover:scale-110">

        <i class="fa-solid fa-arrow-up text-lg"></i>
    </button>

    <style>
        #backToTop.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>

    <script>
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {

            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }

        });

        backToTop.addEventListener('click', () => {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        });
    </script>


    <style>
        .navbar-scrolled {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(51, 65, 85, 0.7);
            padding-top: 0.8rem !important;
            padding-bottom: 0.8rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
    </style>

    <script>
        const header = document.getElementById('mainHeader');
        const brandText = document.getElementById('brandText');

        window.addEventListener('scroll', () => {

            if (window.scrollY > 20) {

                header.classList.add('navbar-scrolled');

                brandText.classList.remove('text-slate-900');
                brandText.classList.add('text-white');

            } else {

                header.classList.remove('navbar-scrolled');

                brandText.classList.remove('text-white');
                brandText.classList.add('text-slate-900');
            }
        });

        const menuButton = document.getElementById('menuBtn');
        const closeButton = document.getElementById('closeMenu');
        const mobileNavigation = document.getElementById('mobileMenu');


        if (menuButton && mobileNavigation) {

            menuButton.addEventListener('click', () => {

                mobileNavigation.style.maxHeight =
                    mobileNavigation.style.maxHeight &&
                    mobileNavigation.style.maxHeight !== '0px' ?
                    '0px' :
                    mobileNavigation.scrollHeight + 'px';

            });

        }


        if (closeButton && mobileNavigation) {

            closeButton.addEventListener('click', () => {

                mobileNavigation.style.maxHeight = '0px';

            });

        }
    </script>

    <style>
        .nav-wrap {
            position: relative;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 40px;
            padding: 0.45em;
            display: flex;
            align-items: center;
            gap: 0.15rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .nav-wrap .btn {
            padding: 0.45em 1.1em;
            color: rgba(255, 255, 255, 0.85);
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
            z-index: 1;
        }

        .nav-wrap .btn:hover {
            background: #e4ae0b;
            color: #1e293b;
        }

        .nav-wrap .btn.active {
            background: #e4ae0b;
            color: #1e293b;
        }

        .nav-wrap .login-btn {
            --primary-color: #e4ae0b;
            --secondary-color: #fff;
            --hover-color: #1e293b;
            --arrow-width: 10px;
            --arrow-stroke: 2px;
            box-sizing: border-box;
            border: 0;
            border-radius: 20px !important;
            color: var(--secondary-color);
            padding: 0.6em 1.2em !important;
            background: var(--primary-color);
            display: inline-flex;
            transition: 0.2s background;
            align-items: center;
            gap: 0.6em;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .nav-wrap .login-btn .arrow-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-wrap .login-btn .arrow {
            margin-top: 1px;
            width: var(--arrow-width);
            background: var(--primary-color);
            height: var(--arrow-stroke);
            position: relative;
            transition: 0.2s;
        }

        .nav-wrap .login-btn .arrow::before {
            content: "";
            box-sizing: border-box;
            position: absolute;
            border: solid var(--secondary-color);
            border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
            display: inline-block;
            top: -3px;
            right: 3px;
            transition: 0.2s;
            padding: 3px;
            transform: rotate(-45deg);
        }

        .nav-wrap .login-btn:hover {
            background-color: var(--hover-color) !important;
        }

        .nav-wrap .login-btn:hover .arrow {
            background: var(--secondary-color);
        }

        .nav-wrap .login-btn:hover .arrow:before {
            right: 0;
        }

        .login-btn-mobile {
            --primary-color: #e4ae0b;
            --secondary-color: #fff;
            --hover-color: #1e293b;
            --arrow-width: 10px;
            --arrow-stroke: 2px;
            box-sizing: border-box;
            border: 0;
            border-radius: 12px;
            color: var(--secondary-color);
            padding: 0.8em 1.4em;
            background: var(--primary-color);
            display: flex;
            transition: 0.2s background;
            align-items: center;
            justify-content: center;
            gap: 0.6em;
            font-weight: bold;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .login-btn-mobile .arrow-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-btn-mobile .arrow {
            margin-top: 1px;
            width: var(--arrow-width);
            background: var(--primary-color);
            height: var(--arrow-stroke);
            position: relative;
            transition: 0.2s;
        }

        .login-btn-mobile .arrow::before {
            content: "";
            box-sizing: border-box;
            position: absolute;
            border: solid var(--secondary-color);
            border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
            display: inline-block;
            top: -3px;
            right: 3px;
            transition: 0.2s;
            padding: 3px;
            transform: rotate(-45deg);
        }

        .login-btn-mobile:hover {
            background-color: var(--hover-color);
        }

        .login-btn-mobile:hover .arrow {
            background: var(--secondary-color);
        }

        .login-btn-mobile:hover .arrow:before {
            right: 0;
        }

        .nav-wrap .highlight {
            position: absolute;
            border: 2px solid #e4ae0b;
            border-radius: 10px;
            pointer-events: none;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            z-index: 0;
            top: 0;
            left: 0;
            width: 0;
            height: 0;
        }

        .hamburger-line,
        .hamburger-line::before,
        .hamburger-line::after {
            display: block;
            width: 22px;
            height: 2px;
            background: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger-line::before,
        .hamburger-line::after {
            content: '';
            position: absolute;
        }

        .hamburger-line::before {
            transform: translateY(-7px);
        }

        .hamburger-line::after {
            transform: translateY(7px);
        }

        .hamburger-btn.open .hamburger-line {
            background: transparent;
        }

        .hamburger-btn.open .hamburger-line::before {
            transform: rotate(45deg);
        }

        .hamburger-btn.open .hamburger-line::after {
            transform: rotate(-45deg);
        }
    </style>

    <script>
        (function() {
            const nav = document.getElementById('animatedNav');
            const highlight = document.getElementById('navHighlight');
            if (!nav || !highlight) return;
            const btns = nav.querySelectorAll('.btn');

            function moveHighlight(el) {
                const navRect = nav.getBoundingClientRect();
                const rect = el.getBoundingClientRect();
                highlight.style.left = (rect.left - navRect.left) + 'px';
                highlight.style.top = (rect.top - navRect.top) + 'px';
                highlight.style.width = rect.width + 'px';
                highlight.style.height = rect.height + 'px';
                highlight.style.opacity = 1;
            }

            function hideHighlight() {
                highlight.style.opacity = 0;
            }

            btns.forEach(function(btn) {
                btn.addEventListener('mouseenter', function() {
                    moveHighlight(btn);
                });
                btn.addEventListener('mouseleave', function() {
                    setTimeout(function() {
                        if (!nav.matches(':hover')) hideHighlight();
                    }, 100);
                });
            });

            nav.addEventListener('mouseleave', hideHighlight);
        })();
    </script>

    {{-- CONTENT --}}
    <main data-aos="fade-up">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="relative bg-slate-950 text-white mt-10 overflow-hidden border-t border-slate-800">

        {{-- Decorative top glow --}}
        <div
            class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-blue-500/50 to-transparent">
        </div>

        {{-- Decorative blur orbs --}}
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none">
        </div>

        <div
            class="absolute -bottom-40 -right-40 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Column 1 : School Identity --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    @if (!empty($settings['logo']))
                        <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                            class="w-7 h-7 object-cover rounded-full">
                    @endif

                    <h2 class="font-extrabold text-sm tracking-tight uppercase">
                        {{ $settings['nama_website'] ?? '' }}
                    </h2>
                </div>

                <p class="text-slate-400 text-xs leading-relaxed mb-6 font-semibold">
                    {{ $settings['visi'] ?? 'Mewujudkan lulusan yang berkarakter, unggul dalam prestasi, religius, kokoh dalam IPTEK, serta peduli lingkungan.' }}
                </p>

                {{-- Status sekolah --}}
                <div class="px-4 py-3 bg-slate-900 rounded-2xl border border-white/5 space-y-1">
                    <div class="text-[10px] font-black tracking-[0.2em] text-blue-400 uppercase">
                        Status Sekolah
                    </div>

                    <div class="text-[11px] text-slate-300 font-bold leading-relaxed">
                        Terakreditasi A
                    </div>
                </div>
            </div>

            {{-- Column 2 : Navigation --}}
            <div>
                <h3 class="font-black text-xs text-blue-400 uppercase tracking-widest mb-6">
                    Akses Cepat
                </h3>

                <ul class="space-y-3.5">

                    @php
                        $menus = [
                            ['title' => 'Profil Sekolah', 'url' => '/profil'],
                            ['title' => 'Berita Sekolah', 'url' => '/berita'],
                            ['title' => 'Prestasi Siswa', 'url' => '/prestasi'],
                            ['title' => 'Fasilitas', 'url' => '/fasilitas'],
                            ['title' => 'Galeri', 'url' => '/galeri'],
                            ['title' => 'Kontak', 'url' => '/kontak'],
                        ];
                    @endphp

                    @foreach ($menus as $menu)
                        <li>
                            <a href="{{ $menu['url'] }}"
                                class="text-slate-400 hover:text-blue-400 text-xs transition-all duration-300 flex items-center gap-2 group font-medium">

                                <span class="w-0 group-hover:w-2 h-px bg-blue-400 transition-all duration-300"></span>

                                {{ $menu['title'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>

            {{-- Column 3 : Kontak --}}
            <div>
                <h3 class="font-black text-xs text-blue-400 uppercase tracking-widest mb-6">
                    Informasi Kontak
                </h3>

                <p class="text-slate-400 text-xs mb-5 leading-relaxed font-semibold">
                    Hubungi pihak sekolah melalui informasi resmi berikut ini:
                </p>

                <div class="space-y-4">

                    <div class="flex items-start gap-3 text-slate-400 text-xs">
                        <i class="fa-solid fa-location-dot text-blue-400 mt-0.5"></i>

                        <span class="leading-relaxed">
                            {{ $settings['alamat'] ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 text-slate-400 text-xs">
                        <i class="fa-solid fa-envelope text-blue-400"></i>

                        <a href="mailto:{{ $settings['email'] ?? '#' }}"
                            class="hover:text-white transition-colors duration-200">
                            {{ $settings['email'] ?? '-' }}
                        </a>
                    </div>

                    <div class="flex items-center gap-3 text-slate-400 text-xs">
                        <i class="fa-solid fa-phone text-blue-400"></i>

                        <a href="tel:{{ $settings['telepon'] ?? '#' }}"
                            class="hover:text-white transition-colors duration-200">
                            {{ $settings['telepon'] ?? '-' }}
                        </a>
                    </div>

                </div>
            </div>

            {{-- Column 4 : Social Media --}}
            <div>
                <h3 class="font-black text-xs text-blue-400 uppercase tracking-widest mb-6">
                    Ikuti Kami
                </h3>

                <p class="text-slate-400 text-xs mb-5 font-semibold leading-relaxed">
                    Kunjungi media sosial resmi sekolah untuk melihat informasi terbaru,
                    kegiatan siswa, dan dokumentasi sekolah.
                </p>

                @php
                    $socials = json_decode($settings['social_media'] ?? '[]', true);
                @endphp

                <div class="flex gap-3 flex-wrap">

                    @if (!empty($socials))
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 bg-slate-900 hover:bg-blue-400 border border-white/5 text-slate-400 hover:text-slate-950 flex items-center justify-center rounded-xl transition-all">

                                <i class="{{ $social['icon'] }}"></i>

                            </a>
                        @endforeach
                    @else
                        <span class="text-xs text-slate-500">
                            Belum ada sosial media yang ditambahkan.
                        </span>
                    @endif

                </div>

                {{-- Powered by --}}
                <div class="mt-6 pt-5 border-t border-white/5">

                    <span class="text-[10px] text-slate-500 font-bold block uppercase tracking-wider">
                        POWERED BY
                    </span>

                    <a href="https://viteks.id" target="_blank" rel="noopener noreferrer"
                        class="text-xs text-cyan-400 hover:text-cyan-300 font-bold mt-1 inline-flex items-center gap-1.5 grayscale hover:grayscale-0 transition-all">

                        <img src="https://viteks.id/storage/site/J5MNxOhayYQO9ENI3oFOxy0fQd50ll84bFpyFshl.png"
                            class="h-4 w-auto inline-block bg-white rounded-md p-0.5" alt="VITEKS">

                        VITEKS

                    </a>

                </div>
            </div>

        </div>

        {{-- Bottom Footer --}}
        <div class="border-t border-white/5 relative bg-slate-950/80">

            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-bold">

                <p>
                    &copy; {{ date('Y') }}
                    {{ $settings['nama_website'] ?? '' }}.
                    Seluruh Hak Cipta Dilindungi.
                </p>

                <div class="flex gap-4 items-center">

                    <a href="/" class="hover:text-white transition-colors">
                        Beranda
                    </a>

                    <span>•</span>

                    <a href="/profil" class="hover:text-white transition-colors">
                        Profil
                    </a>

                    <span>•</span>

                    <a href="/kontak" class="hover:text-white transition-colors">
                        Kontak
                    </a>

                    @if (!empty($settings['jam_operasional']))
                        <div class="flex items-center gap-3 text-slate-400 text-xs">
                            <i class="fa-solid fa-clock text-blue-400"></i>
                            <span>{{ $settings['jam_operasional'] }}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const menuBtn = document.getElementById('menuBtn');
            const closeMenu = document.getElementById('closeMenu');
            const mobileMenu = document.getElementById('mobileMenu');

            if (menuBtn && mobileMenu) {

                menuBtn.addEventListener('click', function() {

                    const isOpen = mobileMenu.classList.contains('open');

                    if (isOpen) {

                        mobileMenu.style.maxHeight = '0px';
                        mobileMenu.classList.remove('open');

                    } else {

                        mobileMenu.style.maxHeight =
                            mobileMenu.scrollHeight + 'px';

                        mobileMenu.classList.add('open');

                    }

                });

            }


            if (closeMenu && mobileMenu) {

                closeMenu.addEventListener('click', function() {

                    mobileMenu.style.maxHeight = '0px';

                    mobileMenu.classList.remove('open');

                });

            }


        });
    </script>

    @stack('scripts')
</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 120
    });
</script>

</html>
