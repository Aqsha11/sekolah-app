<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $settings = \App\Models\Setting::pluck('value', 'key');
    @endphp
    <title>Login - {{ $settings['nama_website'] ?? 'Sekolah' }}</title>
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset('storage/settings/' . $settings['favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter']
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col lg:flex-row bg-white font-sans antialiased select-none">

    {{-- LEFT: BRANDING --}}
    <div
        class="hidden lg:flex w-1/2 bg-slate-950 text-white flex-col justify-between p-12 relative overflow-hidden border-r border-slate-900">
        {{-- Top Logo --}}
        <div class="flex items-center gap-3 relative z-10">
            @if (!empty($settings['logo']))
                <img src="{{ asset('storage/settings/' . $settings['logo']) }}" alt="Logo Sekolah"
                    class="w-10 h-10 rounded object-contain">
            @else
                <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-lg">school</span>
                </div>
            @endif
            <div>
                <h1 class="font-bold text-xs tracking-tight text-white leading-none">
                    {{ $settings['site_name'] ?? ($settings['nama_website'] ?? '') }}</h1>
                <span class="text-[9px] text-slate-500 font-bold block mt-1 uppercase"></span>
            </div>
        </div>

        {{-- Center Slogan --}}
        <div class="my-auto space-y-6 max-w-md relative z-10">
            {{-- <span class="inline-flex items-center gap-1.5 bg-blue-500/20 text-blue-300 font-extrabold text-[9px] py-1.5 px-3 rounded-full uppercase tracking-widest border border-blue-500/10">
                <span class="material-symbols-outlined text-sm animate-pulse">auto_awesome</span>
                DIGITAL SCHOOL PILOT
            </span> --}}
            <h2 class="text-3xl font-extrabold tracking-tight text-white leading-tight">
                Mari Mewujudkan <span class="text-blue-400">Pendidikan Digital Modern</span> Berbasis Integritas.
            </h2>
            <p class="text-xs text-slate-300 leading-relaxed font-normal">
                Sistem informasi akademik terpadu yang memfasilitasi administrasi kesiswaan terlengkap, monitoring
                absensi RFID real-time, serta transparansi pelaporan bagi orang tua murid.
            </p>
        </div>

        {{-- Footer --}}
        <div class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider relative z-10 text-center">
            &copy; {{ date('Y') }} {{ $settings['nama_website'] ?? '' }}. Hak Cipta Dilindungi Undang-Undang.
            <br>
            Powered by
            <a href="https://VITEKS.id" target="_blank" class="text-slate-600 hover:text-primary-600 hover:underline">
                VITEKS
            </a>
        </div>
    </div>

    {{-- RIGHT: LOGIN FORM --}}
    <div class="flex-1 flex flex-col justify-center items-center py-12 px-6 sm:px-12 bg-slate-50/50">
        <div
            class="w-full max-w-md space-y-8 bg-white p-8 rounded-xl border border-slate-200/80 shadow-md shadow-slate-100">

            {{-- Header --}}
            <div class="space-y-3 text-center lg:text-left">
                <div
                    class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex lg:hidden items-center justify-center mx-auto shadow-md">
                    @if (!empty($settings['logo']))
                        <img src="{{ asset('storage/settings/' . $settings['logo']) }}" alt="Logo Sekolah"
                            class="w-7 h-7 object-contain">
                    @else
                        <span class="material-symbols-outlined text-2xl">school</span>
                    @endif
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-none">Sign In ke Portal</h3>
                <p class="text-xs text-slate-500">Silakan pilih portal dan masukkan akun Anda.</p>
            </div>

            {{-- Role Tabs --}}
            <div class="grid grid-cols-2 p-1 bg-slate-100 rounded-lg" x-data="{ role: 'admin' }">

                <button type="button"
                    @click="
            role='admin';
            document.getElementById('btnText').innerText='Masuk Ke Portal Staff / Admin';"
                    :class="role === 'admin'
                        ?
                        'bg-white text-blue-600 shadow-sm' :
                        'text-slate-500 hover:text-slate-700'"
                    class="py-2 rounded-md text-xs font-semibold transition cursor-pointer">

                    <span class="material-symbols-outlined text-sm align-middle mr-1">
                        group
                    </span>
                    Staff / Admin
                </button>
                <button type="button"
                    @click="
            role='orang_tua';
            document.getElementById('btnText').innerText='Masuk Ke Portal Orang Tua';
        "
                    :class="role === 'orang_tua'
                        ?
                        'bg-white text-blue-600 shadow-sm' :
                        'text-slate-400 hover:text-slate-700'"
                    class="py-2 rounded-md text-xs font-semibold transition cursor-pointer">

                    <span class="material-symbols-outlined text-sm align-middle mr-1">
                        badge
                    </span>

                    Orang Tua / Wali
                </button>

            </div>

            {{-- Error & Status Messages --}}
            @if ($errors->any())
                <div
                    class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-xs font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-red-500">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-xs font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-emerald-500">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5 text-left">
                    <label for="email"
                        class="block text-[10px] font-bold text-slate-700 tracking-wide uppercase">Email Portal
                        Akademis</label>
                    <div class="relative rounded-xl">
                        <span
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-base">mail</span>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email', '') }}"
                            placeholder="Masukkan email"
                            class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-xl outline-none font-semibold text-xs transition-all"
                            required autofocus autocomplete="username">
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-1.5 text-left">
                    <label for="password"
                        class="block text-[10px] font-bold text-slate-700 tracking-wide uppercase">Password</label>
                    <div class="relative rounded-xl">
                        <span
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-base">lock</span>
                        </span>
                        <input type="password" name="password" id="password" value=""
                            placeholder="Masukkan password..."
                            class="w-full pl-9 pr-12 py-2.5 bg-white border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-xl outline-none font-semibold text-xs transition-all"
                            required autocomplete="current-password">
                        <button type="button" onclick="togglePass()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 transition cursor-pointer">
                            <span class="material-symbols-outlined text-base" id="passIcon">visibility</span>
                        </button>
                    </div>
                </div>

                {{-- Remember Me + SSL --}}
                <div class="flex items-center justify-between select-none font-semibold text-slate-500 py-1">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="remember" checked
                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs">Ingat Sesi Masuk Saya</span>
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        SSL Aman
                    </span>
                </div>

                {{-- Submit --}}
                <button type="submit" id="loginBtn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs py-3 rounded-lg transition-colors flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 shadow-sm">
                    <span id="btnText">Masuk Ke Portal Staff / Admin</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </form>
        </div>

        {{-- Footer Mobile --}}
        <p class="text-[10px] text-slate-400 mt-8 lg:hidden text-center">
            &copy; {{ date('Y') }} {{ $settings['nama_website'] ?? '' }}
            <br>
            Powered by
            <a href="https://VITEKS.id/" class="font-semibold text-primary-600 hover:underline">
                VITEKS
            </a>
        </p>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function togglePass() {
            const inp = document.getElementById('password');
            const icon = document.getElementById('passIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                inp.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        // Update button text based on role selection
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                const role = Alpine.store('role');
            });
        });
    </script>
    <script>
        // Keep button text synced with role (using Alpine's x-data)
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const email = document.getElementById('email').value;
            if (email.includes('ortu')) {
                btnText.textContent = 'Masuk Ke Portal Orang Tua';
            } else {
                btnText.textContent = 'Masuk Ke Portal Staff / Admin';
            }
        });
    </script>
</body>

</html>
