<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['tagline'] ?? 'Website Resmi Sekolah' }}">
    <title>@yield('title', '')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter'] },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .navbar-scrolled {
            background: rgba(15, 23, 42, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(51, 65, 85, 0.7) !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        #backToTop.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        [x-cloak] { display: none !important; }
    </style>

    @php
        if (!isset($settings)) {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        }
        $nav = [
            '/' => 'Beranda',
            'profil' => 'Profil',
            'berita' => 'Berita',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'data-guru' => 'Staf Pengajar',
            'galeri' => 'Galeri',
            'kontak' => 'Kontak',
        ];
    @endphp

    @if (!empty($settings['favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/settings/' . $settings['favicon']) }}">
    @endif
</head>

<body class="bg-white text-slate-800 font-sans antialiased">

    {{-- NAVBAR --}}
    <header id="mainHeader"
        class="fixed top-0 left-0 right-0 z-50 bg-transparent py-4 transition-all duration-300 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/20 shrink-0">
                    @if (!empty($settings['logo']))
                        <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                            class="w-7 h-7 object-contain rounded">
                    @else
                        <span class="material-symbols-outlined text-lg">school</span>
                    @endif
                </div>
                <div>
                    <a href="/" id="brandText"
                        class="font-extrabold text-xs tracking-tight uppercase leading-none text-white transition-colors duration-300">
                        {{ $settings['site_name'] ?? ($settings['nama_website'] ?? '') }}
                    </a>
                    @if (!empty($settings['tagline']))
                        <p class="text-[9px] text-slate-400 font-medium block mt-0.5 leading-none">
                            {{ $settings['tagline'] }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Desktop Nav --}}
            <nav class="hidden lg:flex items-center gap-1">
                @foreach ($nav as $url => $label)
                    <a href="{{ url($url) }}"
                        class="px-3.5 py-2 rounded-lg text-[10px] font-bold tracking-wider uppercase transition-all duration-200
                        {{ request()->is(ltrim($url, '/')) || (request()->path() === '/' && $url === '/')
                            ? 'text-blue-400 bg-blue-500/10'
                            : 'text-slate-300 hover:text-white hover:bg-slate-800/50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            {{-- Right --}}
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-[10px] px-4 py-2.5 rounded-lg transition-all shadow-md shadow-blue-500/10 flex items-center gap-1.5 leading-none uppercase tracking-wider">
                    <span class="material-symbols-outlined text-sm">login</span>
                    Sign In Portal
                </a>
            </div>

            {{-- Mobile --}}
            <button id="menuBtn"
                class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-white hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <div id="mobileMenu" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out lg:hidden">
            <div class="mx-4 mt-3 bg-slate-900/95 backdrop-blur-xl border border-slate-800 rounded-2xl p-5 shadow-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                    <span class="text-sm font-bold text-white uppercase tracking-tight">Menu</span>
                    <button id="closeMenu"
                        class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center hover:text-white">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach ($nav as $url => $label)
                        <a href="{{ url($url) }}"
                            class="block py-2.5 px-4 rounded-xl text-sm font-bold transition-all
                            {{ request()->is(ltrim($url, '/')) || (request()->path() === '/' && $url === '/')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
                <div class="mt-5 pt-5 border-t border-slate-800">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 py-3 bg-blue-600 text-white font-bold text-xs rounded-xl">
                        <span class="material-symbols-outlined text-sm">login</span>
                        Sign In Portal
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Back to Top --}}
    <button id="backToTop"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-500/30 flex items-center justify-center transition-all duration-300 opacity-0 invisible translate-y-5 hover:scale-110">
        <span class="material-symbols-outlined text-xl">arrow_upward</span>
    </button>

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            {{-- Col 1: Brand --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                        @if (!empty($settings['logo']))
                            <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                                class="w-6 h-6 object-contain rounded">
                        @else
                            <span class="material-symbols-outlined text-sm">school</span>
                        @endif
                    </div>
                    <span class="font-bold text-sm text-white">{{ $settings['site_name'] ?? ($settings['nama_website'] ?? '') }}</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    {{ $settings['visi'] ?? 'Mewujudkan lulusan yang berkarakter, unggul dalam prestasi, religius, kokoh dalam IPTEK, serta peduli lingkungan.' }}
                </p>
                <div class="flex items-center gap-3 pt-2">
                    @php
                        $socials = json_decode($settings['social_media'] ?? '[]', true);
                    @endphp
                    @if (!empty($socials))
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                class="w-8 h-8 rounded-full bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-all text-xs">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Col 2: Links --}}
            <div class="space-y-4">
                <h4 class="font-extrabold text-xs text-white uppercase tracking-wider">Akses Cepat</h4>
                <ul class="space-y-2.5">
                    @php
                        $footerMenus = [
                            ['title' => 'Profil Sekolah', 'url' => '/profil'],
                            ['title' => 'Berita Sekolah', 'url' => '/berita'],
                            ['title' => 'Prestasi Siswa', 'url' => '/prestasi'],
                            ['title' => 'Fasilitas', 'url' => '/fasilitas'],
                            ['title' => 'Galeri', 'url' => '/galeri'],
                            ['title' => 'Kontak', 'url' => '/kontak'],
                        ];
                    @endphp
                    @foreach ($footerMenus as $menu)
                        <li>
                            <a href="{{ $menu['url'] }}"
                                class="text-xs text-slate-400 hover:text-blue-400 transition flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-blue-400"></span>
                                {{ $menu['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3: Contact --}}
            <div class="space-y-4">
                <h4 class="font-extrabold text-xs text-white uppercase tracking-wider">Kontak</h4>
                <ul class="space-y-3 text-xs">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-sm text-blue-400 mt-0.5">location_on</span>
                        <span class="text-slate-400">{{ $settings['alamat'] ?? '-' }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-sm text-blue-400">mail</span>
                        <a href="mailto:{{ $settings['email'] ?? '#' }}" class="text-slate-400 hover:text-white transition">{{ $settings['email'] ?? '-' }}</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-sm text-blue-400">call</span>
                        <a href="tel:{{ $settings['telepon'] ?? '#' }}" class="text-slate-400 hover:text-white transition">{{ $settings['telepon'] ?? '-' }}</a>
                    </li>
                </ul>
            </div>

            {{-- Col 4: Powered by --}}
            <div class="space-y-4">
                <h4 class="font-extrabold text-xs text-white uppercase tracking-wider">Info</h4>
                <div class="bg-slate-900 rounded-xl p-4 border border-slate-800 space-y-2">
                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Akreditasi</p>
                    <p class="text-xs font-bold text-white">{{ $settings['akreditasi'] ?? 'A' }}</p>
                </div>
                <div class="pt-2">
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Powered by</p>
                    <a href="https://viteks.id" target="_blank"
                        class="text-xs text-cyan-400 hover:text-cyan-300 font-bold mt-1 inline-block">
                        Viteks
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3 text-[10px] text-slate-500 font-semibold">
                <p>&copy; {{ date('Y') }} {{ $settings['nama_website'] ?? '' }}. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="/" class="hover:text-white transition">Beranda</a>
                    <a href="/profil" class="hover:text-white transition">Profil</a>
                    <a href="/kontak" class="hover:text-white transition">Kontak</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Scroll effects
        const header = document.getElementById('mainHeader');
        const brandText = document.getElementById('brandText');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                header.classList.add('navbar-scrolled');
                if (brandText) brandText.classList.remove('text-white');
                if (brandText) brandText.classList.add('text-white');
            } else {
                header.classList.remove('navbar-scrolled');
                if (brandText) brandText.classList.remove('text-white');
                if (brandText) brandText.classList.add('text-white');
            }
        });

        // Back to top
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) backToTop.classList.add('show');
            else backToTop.classList.remove('show');
        });
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Mobile menu
        const menuBtn = document.getElementById('menuBtn');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        function toggleMobile(open) {
            if (open) {
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            } else {
                mobileMenu.style.maxHeight = '0px';
            }
        }

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                const isOpen = mobileMenu.style.maxHeight && mobileMenu.style.maxHeight !== '0px';
                toggleMobile(!isOpen);
            });
        }
        if (closeMenu && mobileMenu) {
            closeMenu.addEventListener('click', () => toggleMobile(false));
        }
    </script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 120 });
    </script>

    @stack('scripts')
</body>
</html>
