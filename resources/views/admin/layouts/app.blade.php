<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar scrollbar */
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(234, 179, 8, 0.35);
            border-radius: 10px;
        }

        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(208, 205, 198, 0.6);
        }

        /* Smooth transitions */
        .sidebar-link {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #3b82f6;
            border-radius: 0 4px 4px 0;
            transition: height 0.2s ease;
        }

        .sidebar-link.active::before,
        .sidebar-link:hover::before {
            height: 60%;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.12);
            color: #60a5fa;
        }

        .sidebar-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.06);
            color: #f1f2f5;
        }

        /* Card hover lift */
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(226, 218, 218, 0.08);
        }

        /* Overlay */
        #sidebar-overlay {
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        /* Slide-in animation */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadein {
            animation: fadeIn 0.35s ease both;
        }

        .animate-fadein-delay-1 {
            animation: fadeIn 0.35s ease 0.05s both;
        }

        .animate-fadein-delay-2 {
            animation: fadeIn 0.35s ease 0.1s both;
        }

        .animate-fadein-delay-3 {
            animation: fadeIn 0.35s ease 0.15s both;
        }

        /* Table styles */
        .data-table th {
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
        }

        .data-table tbody tr {
            transition: background 0.15s;
        }

        /* Badge pulse */
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        .accent-text {
            color: #2563eb;
        }

        /* ── 3D Checkbox ── */
        .checkbox-wrapper {
            position: relative;
            cursor: pointer;
            display: inline-block;
            width: 28px;
            height: 28px;
            flex-shrink: 0;
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }

        .checkbox-wrapper:hover {
            transform: rotateX(10deg) rotateY(10deg);
        }

        .checkbox-wrapper input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
            margin: 0;
        }

        .checkbox-wrapper .checkbox {
            position: relative;
            display: block;
            width: 100%;
            height: 100%;
            background: #2c2c2c;
            border-radius: 7px;
            box-shadow:
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 -4px 8px rgba(0, 0, 0, 0.2),
                inset 0 4px 8px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .checkbox-wrapper .checkbox::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: linear-gradient(45deg, #00ff87, #60efff, #00ff87, #60efff);
            background-size: 300% 300%;
            border-radius: 7px;
            opacity: 0;
            transform-origin: center;
            transform: scale(0) rotate(180deg);
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .checkbox-wrapper .checkbox::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.5) rotate(-45deg);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1;
            line-height: 1;
        }

        .checkbox-wrapper:hover .checkbox {
            transform: translateY(-2px) translateZ(5px);
            box-shadow:
                0 8px 12px rgba(0, 0, 0, 0.4),
                inset 0 -4px 8px rgba(0, 0, 0, 0.2),
                inset 0 4px 8px rgba(255, 255, 255, 0.1);
        }

        .checkbox-wrapper input:checked~.checkbox::before {
            opacity: 1;
            transform: scale(1) rotate(0deg);
            animation: checkboxGradientMove 3s linear infinite;
        }

        .checkbox-wrapper input:checked~.checkbox::after {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1) rotate(0deg);
            filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.5));
            transition-delay: 0.2s;
        }

        .checkbox-wrapper input:checked~.checkbox {
            transform: translateY(-2px) translateZ(10px);
            animation: checkboxGlowPulse 2s infinite;
        }

        @keyframes checkboxGradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes checkboxGlowPulse {

            0%,
            100% {
                box-shadow:
                    0 8px 12px rgba(0, 0, 0, 0.4),
                    inset 0 -4px 8px rgba(0, 0, 0, 0.2),
                    inset 0 4px 8px rgba(255, 255, 255, 0.1),
                    0 0 12px rgba(96, 239, 255, 0.5);
            }

            50% {
                box-shadow:
                    0 8px 12px rgba(0, 0, 0, 0.4),
                    inset 0 -4px 8px rgba(0, 0, 0, 0.2),
                    inset 0 4px 8px rgba(255, 255, 255, 0.1),
                    0 0 20px rgba(0, 255, 135, 0.8);
            }
        }

        .checkbox-wrapper input:active~.checkbox::before {
            transition: 0s;
            opacity: 0.5;
        }

        /* ── Three‑Body Loading ── */
        .three-body {
            --uib-size: 35px;
            --uib-speed: 0.8s;
            --uib-color: #d3c9ab;
            position: relative;
            display: inline-block;
            height: var(--uib-size);
            width: var(--uib-size);
            animation: spin78236 calc(var(--uib-speed) * 2.5) infinite linear;
        }

        .three-body__dot {
            position: absolute;
            height: 100%;
            width: 30%;
        }

        .three-body__dot:after {
            content: '';
            position: absolute;
            height: 0%;
            width: 100%;
            padding-bottom: 100%;
            background-color: var(--uib-color);
            border-radius: 50%;
        }

        .three-body__dot:nth-child(1) {
            bottom: 5%;
            left: 0;
            transform: rotate(60deg);
            transform-origin: 50% 85%;
        }

        .three-body__dot:nth-child(1)::after {
            bottom: 0;
            left: 0;
            animation: wobble1 var(--uib-speed) infinite ease-in-out;
            animation-delay: calc(var(--uib-speed) * -0.3);
        }

        .three-body__dot:nth-child(2) {
            bottom: 5%;
            right: 0;
            transform: rotate(-60deg);
            transform-origin: 50% 85%;
        }

        .three-body__dot:nth-child(2)::after {
            bottom: 0;
            left: 0;
            animation: wobble1 var(--uib-speed) infinite calc(var(--uib-speed) * -0.15) ease-in-out;
        }

        .three-body__dot:nth-child(3) {
            bottom: -5%;
            left: 0;
            transform: translateX(116.666%);
        }

        .three-body__dot:nth-child(3)::after {
            top: 0;
            left: 0;
            animation: wobble2 var(--uib-speed) infinite ease-in-out;
        }

        @keyframes spin78236 {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes wobble1 {

            0%,
            100% {
                transform: translateY(0%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateY(-66%) scale(0.65);
                opacity: 0.8;
            }
        }

        @keyframes wobble2 {

            0%,
            100% {
                transform: translateY(0%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateY(66%) scale(0.65);
                opacity: 0.8;
            }
        }

        /* ── Loading Overlay ── */
        .loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-overlay .loading-text {
            color: #2563eb;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* ── File Upload (Uiverse Yaya12085 style) ── */
        .custum-file-upload {
            height: 160px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            border: 2px dashed #cacaca;
            background-color: rgba(255, 255, 255, 1);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .custum-file-upload:hover {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .custum-file-upload .icon svg {
            height: 64px;
            fill: rgba(75, 85, 99, 1);
            transition: fill 0.3s ease;
        }

        .custum-file-upload:hover .icon svg {
            fill: #3b82f6;
        }

        .custum-file-upload .text span {
            font-weight: 400;
            color: rgba(75, 85, 99, 1);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .custum-file-upload:hover .text span {
            color: #3b82f6;
        }

        .custum-file-upload input {
            display: none;
        }

        .custum-file-upload.has-file {
            border-color: #22c55e;
            background-color: rgba(34, 197, 94, 0.03);
        }
    </style>

    @yield('styles')
</head>

<body class="h-full bg-slate-50 text-slate-800">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    <div class="flex h-full min-h-screen">

        {{-- ========== SIDEBAR ========== --}}
        <aside id="sidebar"
            class="fixed top-0 left-0 h-full w-64 bg-primary-950 z-40 flex flex-col overflow-y-auto
                -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

            {{-- Logo --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-10 py-4 mt-2 mx-2 rounded-lg text-white text-lg font-bold">
                @if (!empty($settings['logo']))
                    <img src="{{ asset('storage/settings/' . $settings['logo']) }}"
                        class="w-11 h-11 rounded-full ring-2 ring-blue-500/30 object-cover">
                @else
                    <img src="{{ asset('images/tutwuri.png') }}"
                        class="w-11 h-11 rounded-full ring-2 ring-blue-500/30 object-cover">
                @endif
                <span>SMPN 1 Jakarta</span>
            </a>

            {{-- navbar --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5">

                {{-- ===== ORANG TUA MENU ===== --}}
                @hasrole('orang_tua')
                    <p class="text-primary-500 text-[10px] font-semibold uppercase tracking-widest px-3 py-2 mt-1 mb-1">
                        Monitoring
                    </p>

                    <a href="{{ route('orangtua.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('orangtua.*') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('orangtua.*') ? 'bg-white/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-chart-line text-sm"></i>
                        </span>
                        <span>Kehadiran Anak</span>
                    </a>
                @endhasrole

                {{-- ===== MENU UMUM (semua role kecuali orang_tua) ===== --}}
                @unlessrole('orang_tua')
                    <p class="text-primary-500 text-[10px] font-semibold uppercase tracking-widest px-3 py-2 mt-1 mb-1">
                        Menu Utama
                    </p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-chart-pie text-sm"></i>
                        </span>
                        <span>Dashboard</span>
                    </a>

                    @can('manage berita')
                        <a href="{{ route('admin.berita.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.berita.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-newspaper text-sm"></i>
                            </span>
                            <span>Berita</span>
                        </a>
                    @endcan

                    @can('manage guru')
                        <a href="{{ route('admin.guru.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.guru.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-chalkboard-user text-sm"></i>
                            </span>
                            <span>Guru</span>
                        </a>
                    @endcan

                    @can('manage galeri')
                        <a href="{{ route('admin.galeri.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.galeri.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-images text-sm"></i>
                            </span>
                            <span>Galeri</span>
                        </a>
                    @endcan

                    @can('manage fasilitas')
                        <a href="{{ route('admin.fasilitas.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.fasilitas.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-school text-sm"></i>
                            </span>
                            <span>Fasilitas</span>
                        </a>
                    @endcan

                    @can('manage prestasi')
                        <a href="{{ route('admin.prestasi.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.prestasi.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-trophy text-sm"></i>
                            </span>
                            <span>Prestasi</span>
                        </a>
                    @endcan

                    @can('manage banner')
                        <a href="{{ route('admin.banner.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.banner.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-sliders-h text-sm"></i>
                            </span>
                            <span>Banner</span>
                        </a>
                    @endcan

                    @can('manage kontak')
                        <a href="{{ route('admin.kontak.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.kontak.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </span>
                            <span>Kontak</span>

                            @if (isset($unreadMessages) && $unreadMessages > 0)
                                <span
                                    class="ml-auto bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full badge-pulse">
                                    {{ $unreadMessages }}
                                </span>
                            @endif
                        </a>
                    @endcan

                    @can('manage absensi')
                        <p class="text-primary-500 text-[10px] font-semibold uppercase tracking-widest px-3 py-2 mt-4 mb-1">
                            Absensi
                        </p>

                        <a href="{{ route('admin.absensi.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.absensi.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-clipboard-check text-sm"></i>
                            </span>
                            <span>Absensi</span>
                        </a>
                    @endcan

                    @can('manage siswa')
                        <a href="{{ route('admin.siswa.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.siswa.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-user-graduate text-sm"></i>
                            </span>
                            <span>Siswa</span>
                        </a>

                        <a href="{{ route('admin.orang_tua.index') }}"
                            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.orang_tua.*') ? 'active' : '' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.orang_tua.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                                <i class="fa-solid fa-people-arrows text-sm"></i>
                            </span>
                            <span>Orang Tua</span>
                        </a>
                    @endcan

                    <a href="{{ route('rfid.index') }}" target="_blank"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-primary-500">
                            <i class="fa-solid fa-credit-card text-sm"></i>
                        </span>
                        <span>RFID Scanner</span>
                    </a>
                @endunlessrole

                {{-- ===== CONFIG (permission-based) ===== --}}
                @can('manage users')
                    <p class="text-primary-500 text-[10px] font-semibold uppercase tracking-widest px-3 py-2 mt-4 mb-1">
                        Configuration
                    </p>

                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-users text-sm"></i>
                        </span>
                        <span>Users</span>
                    </a>
                @endcan

                @can('manage roles')
                    <a href="{{ route('admin.roles.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.roles.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </span>
                        <span>Roles</span>
                    </a>
                @endcan

                @can('manage permissions')
                    <a href="{{ route('admin.permissions.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.permissions.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-key text-sm"></i>
                        </span>
                        <span>Permissions</span>
                    </a>
                @endcan

                @can('manage website')
                    <a href="{{ route('admin.settings.index') }}"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.settings.*') ? 'bg-primary-500/30 text-white' : 'text-primary-500' }}">
                            <i class="fa-solid fa-sliders text-sm"></i>
                        </span>
                        <span>Pengaturan</span>
                    </a>
                @endcan

            </nav>

            {{-- User Footer --}}
            <div class="px-3 py-4 border-t border-white/10 flex-shrink-0">
                <a href="{{ route('admin.profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors group">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center flex-shrink-0 text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-primary-400 text-[10px] truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <i
                        class="fa-solid fa-chevron-right text-primary-500 text-xs group-hover:text-white transition-colors"></i>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors text-sm font-medium">
                        <span class="w-8 h-8 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                        </span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ========== MAIN CONTENT ========== --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

            {{-- Topbar --}}
            <header
                class="sticky top-0 z-20 bg-white/80 backdrop-blur-xl border-b border-gray-200/70 flex items-center gap-4 px-4 lg:px-6 h-16 flex-shrink-0">
                {{-- Hamburger --}}
                <button onclick="openSidebar()"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                {{-- Breadcrumb / Page Title --}}
                <div class="flex-1 min-w-0">
                    <h1 class="font-semibold text-gray-800 text-sm truncate">@yield('title', 'Dashboard')</h1>
                    <p class="text-gray-400 text-xs hidden sm:block">@yield('subtitle', 'SMPN 1 Lambandia Admin Panel')</p>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    {{-- Notification bell --}}
                    <a href="{{ route('admin.kontak.index') }}"
                        class="relative w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors"
                        title="Pesan Masuk">
                        <i class="fa-regular fa-bell text-sm"></i>
                        @if (isset($unreadMessages) && $unreadMessages > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                        @endif
                    </a>

                    {{-- View Site --}}
                    <a href="/" target="_blank"
                        class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        Lihat Website
                    </a>

                    {{-- Avatar --}}
                    <div class="relative" x-data="{ open: false }">
                        <button onclick="toggleDropdown()"
                            class="flex items-center gap-2 pl-2 pr-3 py-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <div
                                class="w-7 h-7 rounded-lg bg-primary-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span
                                class="hidden sm:block text-xs font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-[10px]"></i>
                        </button>

                        <div id="user-dropdown"
                            class="hidden absolute right-0 top-12 w-44 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                            <a href="{{ route('admin.profile.edit') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-user text-gray-400 w-4"></i> Profil Saya
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i class="fa-solid fa-sign-out-alt w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div id="flash-success"
                    class="mx-4 lg:mx-6 mt-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm animate-fadein">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()"
                        class="ml-auto text-emerald-400 hover:text-emerald-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div id="flash-error"
                    class="mx-4 lg:mx-6 mt-4 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm animate-fadein">
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-rose-400 hover:text-rose-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-6 animate-fadein">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="px-6 py-4 border-t border-white/10 bg-slate-900 text-center text-xs text-slate-300">
                © {{ date('Y') }} SMPN 1 Lambandia — Admin Panel
                <span class="block sm:inline sm:ml-1">
                    | Powered by
                    <a href="https://viteks.id" target="_blank"
                        class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                        <img src="https://viteks.id/storage/site/J5MNxOhayYQO9ENI3oFOxy0fQd50ll84bFpyFshl.png"
                            class="h-3 w-auto inline-block" alt="VITEKS">
                        VITEKS
                    </a>
                </span>
            </footer>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // Sidebar mobile toggle
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // User dropdown
        function toggleDropdown() {
            const d = document.getElementById('user-dropdown');
            d.classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const dd = document.getElementById('user-dropdown');
            if (dd && !dd.classList.contains('hidden') && !dd.parentElement.contains(e.target)) {
                dd.classList.add('hidden');
            }
        });

        // Auto-dismiss flash messages
        setTimeout(() => {
            ['flash-success', 'flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.remove();
            });
        }, 5000);
    </script>

    @yield('scripts')

    {{-- Global Loading Overlay --}}
    <div id="loadingOverlay" class="loading-overlay">
        <div class="three-body">
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
        </div>
        <span class="loading-text">Memuat...</span>
    </div>

    <script>
        function showLoading(text = 'Memuat...') {
            const overlay = document.getElementById('loadingOverlay');
            overlay.querySelector('.loading-text').textContent = text;
            overlay.classList.add('active');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        // Auto-show loading on all form submissions
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                showLoading();
            }
        });

        // File upload styling (Uiverse Yaya12085)
        (function() {
            document.querySelectorAll('input[type="file"]').forEach(function(input) {
                if (input.closest('.custum-file-upload')) return;

                var wrapper = document.createElement('label');
                wrapper.className = 'custum-file-upload';

                var inputId = input.id || 'file-' + Math.random().toString(36).slice(2, 8);
                input.id = inputId;
                wrapper.setAttribute('for', inputId);

                var iconDiv = document.createElement('div');
                iconDiv.className = 'icon';
                iconDiv.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 16.5V3.75m0 0L7.5 8.25M12 3.75l4.5 4.5M20.25 16.5v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V16.5"/></svg>';

                var textDiv = document.createElement('div');
                textDiv.className = 'text';
                textDiv.innerHTML = '<span>Klik untuk upload</span>';

                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(iconDiv);
                wrapper.appendChild(textDiv);
                wrapper.appendChild(input);

                input.addEventListener('change', function() {
                    var text = wrapper.querySelector('.text span');
                    if (this.files && this.files[0]) {
                        text.textContent = this.files[0].name;
                        wrapper.classList.add('has-file');
                    } else {
                        text.textContent = 'Klik untuk upload';
                        wrapper.classList.remove('has-file');
                    }
                });
            });
        })();
    </script>
</body>

</html>
