<!DOCTYPE html>
<html class="h-full" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset('storage/settings/' . $settings['favicon']) }}">
    @endif
    <title>Presensi RFID - {{ $settings['nama_website'] ?? 'Sekolah' }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#1a1b22",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#fbf8ff",
                        "error": "#ba1a1a",
                        "on-primary-container": "#a8b8ff",
                        "tertiary-fixed": "#ffddb8",
                        "surface-dim": "#dad9e3",
                        "on-surface": "#1a1b22",
                        "on-primary-fixed": "#001453",
                        "surface-container": "#eeedf7",
                        "primary-fixed-dim": "#b8c4ff",
                        "on-tertiary-fixed": "#2a1700",
                        "primary-container": "#1e40af",
                        "surface-container-low": "#f4f2fc",
                        "on-secondary-fixed": "#002113",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#6b4200",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary": "#4c2e00",
                        "outline": "#757684",
                        "secondary-fixed": "#6ffbbe",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-container-highest": "#e3e1eb",
                        "surface-tint": "#3755c3",
                        "inverse-surface": "#2f3037",
                        "surface-variant": "#e3e1eb",
                        "secondary": "#006c49",
                        "surface-container-high": "#e8e7f1",
                        "primary-fixed": "#dde1ff",
                        "inverse-on-surface": "#f1f0fa",
                        "on-tertiary-container": "#ffa929",
                        "outline-variant": "#c4c5d5",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed-variant": "#173bab",
                        "tertiary-fixed-dim": "#ffb95f",
                        "background": "#fbf8ff",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#653e00",
                        "on-secondary-container": "#00714d",
                        "secondary-container": "#6cf8bb",
                        "inverse-primary": "#b8c4ff",
                        "primary": "#00288e",
                        "surface": "#fbf8ff",
                        "on-error-container": "#93000a",
                        "secondary-fixed-dim": "#4edea3",
                        "on-surface-variant": "#444653"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        sans: ["Inter"],
                    },
                    fontSize: {
                        "title-xl": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "subtitle-base": ["16px", { lineHeight: "24px", fontWeight: "500" }],
                        "caption-xs": ["12px", { lineHeight: "16px", fontWeight: "400" }],
                        "headline-2xl": ["24px", { lineHeight: "32px", fontWeight: "700" }],
                        "headline-2xl-mobile": ["20px", { lineHeight: "28px", fontWeight: "700" }]
                    }
                },
            },
        }
    </script>

    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.2; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        .pulse-effect {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        .digital-glow {
            text-shadow: 0 0 20px rgba(184, 196, 255, 0.5);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .toast-enter {
            animation: slide-up 0.5s ease forwards;
        }
        @keyframes slide-up {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-on-background min-h-screen text-surface-container-lowest font-sans overflow-hidden flex flex-col"
      x-data="rfidApp()">

    {{-- Top AppBar --}}
    <header class="flex items-center justify-between px-6 h-16 bg-transparent sticky top-0 z-40">
        <div class="flex items-center gap-3">
            @if (!empty($settings['logo']))
                <img src="{{ asset('storage/settings/' . $settings['logo']) }}" alt="Logo Sekolah"
                    class="w-8 h-8 rounded object-contain brightness-125">
            @else
                <span class="material-symbols-outlined text-primary-fixed-dim">school</span>
            @endif
            <h1 class="font-semibold text-lg tracking-tight">{{ $settings['site_name'] ?? $settings['nama_website'] ?? 'SMAN 1 INDONESIA' }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-secondary-fixed animate-pulse"></div>
            <span class="text-caption-xs text-secondary-fixed-dim uppercase tracking-widest digital-glow font-medium">Sistem Online</span>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col items-center justify-center relative px-6 py-4">
        {{-- Digital Clock --}}
        <div class="text-center z-10 mb-12">
            <div class="text-headline-2xl-mobile md:text-headline-2xl text-primary-fixed-dim digital-glow mb-1 tracking-tighter font-bold" id="clock">
                00:00:00
            </div>
            <div class="text-surface-variant text-xs uppercase tracking-widest opacity-80 font-medium">Waktu Indonesia Tengah (WITA)</div>
        </div>

        {{-- Scanning Area --}}
        <div class="relative flex items-center justify-center mb-16 z-10">
            <div class="absolute w-48 h-48 rounded-full border-2 border-primary-fixed-dim/30 pulse-effect"></div>
            <div class="absolute w-48 h-48 rounded-full border-2 border-primary-fixed-dim/30 pulse-effect" style="animation-delay: 0.6s"></div>
            <div class="absolute w-48 h-48 rounded-full border-2 border-primary-fixed-dim/30 pulse-effect" style="animation-delay: 1.2s"></div>

            <div class="relative w-40 h-56 glass-panel rounded-2xl flex flex-col items-center justify-center gap-4 shadow-2xl">
                <div class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-4xl text-on-primary-container" style="font-variation-settings: 'FILL' 1">contactless</span>
                </div>
                <div class="px-4 text-center">
                    <p class="text-xs text-surface-variant leading-tight">Tempelkan Kartu RFID Anda pada area ini</p>
                </div>
                <div class="absolute bottom-4 flex gap-1">
                    <div class="w-1 h-1 rounded-full bg-primary-fixed-dim"></div>
                    <div class="w-1 h-1 rounded-full bg-primary-fixed-dim opacity-50"></div>
                    <div class="w-1 h-1 rounded-full bg-primary-fixed-dim opacity-25"></div>
                </div>
            </div>
        </div>

        {{-- Hidden RFID Input (for hardware scanner) --}}
        <input type="text" id="rfid-input"
            class="absolute opacity-0 pointer-events-none"
            autofocus x-ref="rfidInput">

        {{-- Status --}}
        <div class="text-center z-10">
            <h2 class="text-base font-medium text-surface-container-lowest mb-1" id="scan-status">Silakan Scan Kartu RFID Anda</h2>
            <p class="text-sm text-surface-variant opacity-70">Pastikan kartu terdeteksi sepenuhnya</p>
        </div>

        {{-- Manual Input Toggle --}}
        <div class="z-10 mt-6">
            <button id="manual-toggle" onclick="toggleManualInput()"
                class="text-xs text-primary-fixed-dim/70 hover:text-primary-fixed-dim transition-colors flex items-center gap-1 mx-auto">
                <span class="material-symbols-outlined text-sm">keyboard</span>
                Masukkan Kode RFID Manual
            </button>

            <div id="manual-input-area" class="hidden mt-3 glass-panel rounded-2xl p-4 max-w-xs mx-auto">
                <div class="flex gap-2">
                    <input type="text" id="manual-rfid"
                        class="flex-1 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-surface-variant/50 outline-none focus:border-primary-fixed-dim transition-colors"
                        placeholder="Contoh: RFID001"
                        onkeydown="if(event.key==='Enter') manualScan()">
                    <button onclick="manualScan()"
                        class="bg-primary-fixed-dim text-on-primary-fixed px-4 py-2.5 rounded-xl text-sm font-semibold hover:brightness-110 transition-all active:scale-95 whitespace-nowrap">
                        Scan
                    </button>
                </div>
                <p class="text-[10px] text-surface-variant/60 mt-2 text-center">Ketik kode RFID lalu tekan Enter atau tombol Scan</p>
            </div>
        </div>
    </main>

    {{-- Recent Activity --}}
    <section class="glass-panel rounded-t-3xl p-6 z-20 max-h-[265px] overflow-hidden flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-medium text-primary-fixed-dim">Aktivitas Terakhir</h3>
            <span class="text-xs text-surface-variant font-medium">Hari Ini</span>
        </div>
        <div id="activity-list" class="space-y-3 overflow-y-auto">
            <p class="text-center text-sm text-surface-variant/50 py-4">Belum ada aktivitas scan</p>
        </div>
    </section>

    {{-- Toast Success --}}
    <div id="toast-success" class="fixed bottom-32 left-6 right-6 z-50 pointer-events-none hidden">
        <div class="bg-secondary-container text-on-secondary-container p-4 rounded-xl shadow-2xl flex items-center gap-4 toast-enter border-2 border-secondary-fixed">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
            <div>
                <p class="font-bold" id="toast-success-title">Scan Berhasil!</p>
                <p class="text-sm" id="toast-success-body">Halo, Selamat Pagi.</p>
            </div>
        </div>
    </div>

    {{-- Toast Error --}}
    <div id="toast-error" class="fixed bottom-32 left-6 right-6 z-50 pointer-events-none hidden">
        <div class="bg-error-container text-on-error-container p-4 rounded-xl shadow-2xl flex items-center gap-4 toast-enter border-2 border-error">
            <span class="material-symbols-outlined text-3xl">error</span>
            <div>
                <p class="font-bold">Scan Gagal</p>
                <p class="text-sm" id="toast-error-body">Kartu tidak terdaftar atau bermasalah.</p>
            </div>
        </div>
    </div>

    <script>
        // ===== WITA CLOCK =====
        function waktuWITA() {
            const now = new Date();
            const utc = now.getTime() + now.getTimezoneOffset() * 60000;
            return new Date(utc + 8 * 3600000);
        }

        function updateClock() {
            const wita = waktuWITA();
            const h = String(wita.getHours()).padStart(2, '0');
            const m = String(wita.getMinutes()).padStart(2, '0');
            const s = String(wita.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = h + ':' + m + ':' + s;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // ===== RFID SCAN LOGIC =====
        const rfidInput = document.getElementById('rfid-input');
        const scanStatus = document.getElementById('scan-status');
        const activityList = document.getElementById('activity-list');

        rfidInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                e.preventDefault();
                scanRfid(this.value.trim());
                this.value = '';
            }
        });

        // Auto-focus on page load and any click (unless inside manual input)
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#manual-input-area')) {
                rfidInput.focus();
            }
        });
        rfidInput.focus();

        function scanRfid(rfid) {
            scanStatus.textContent = 'Memproses...';

            fetch('{{ route('rfid.scan') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ rfid: rfid }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const isTerlambat = data.terlambat;
                    const isCheckIn = data.action === 'check_in';

                    // Update status
                    if (isTerlambat) {
                        scanStatus.textContent = data.siswa + ' - Terlambat';
                    } else if (isCheckIn) {
                        scanStatus.textContent = data.siswa + ' - Check In';
                    } else {
                        scanStatus.textContent = data.siswa + ' - Check Out';
                    }

                    // Show success toast
                    const toast = document.getElementById('toast-success');
                    document.getElementById('toast-success-title').textContent = isTerlambat ? 'Terlambat!' : (isCheckIn ? 'Check In Berhasil' : 'Check Out Berhasil');
                    document.getElementById('toast-success-body').textContent = data.siswa + ' — ' + data.kelas + ' (' + data.waktu + ')';
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 4000);

                    // Add to activity list
                    const dotColor = isTerlambat ? 'bg-tertiary-container' : (isCheckIn ? 'bg-secondary-fixed' : 'bg-primary-fixed');
                    const icon = isTerlambat ? 'warning' : 'check_circle';
                    const label = isTerlambat ? 'Terlambat ' + data.waktu : (isCheckIn ? 'Hadir Tepat Waktu' : 'Checkout ' + (data.durasi || ''));
                    const labelColor = isTerlambat ? 'text-tertiary-fixed-dim' : 'text-secondary-fixed-dim';

                    const item = document.createElement('div');
                    item.className = 'flex items-center justify-between rounded-xl bg-white/5 border border-white/10 p-3';
                    item.innerHTML =
                        '<div class="flex items-center gap-3">' +
                            '<div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">' +
                                '<span class="material-symbols-outlined text-lg text-' + (isTerlambat ? 'tertiary-fixed-dim' : 'secondary-fixed') + '" style="font-variation-settings: \'FILL\' 1">' + icon + '</span>' +
                            '</div>' +
                            '<div>' +
                                '<p class="text-sm font-semibold text-surface-container-lowest">' + data.siswa + '</p>' +
                                '<p class="text-xs ' + labelColor + '">' + label + '</p>' +
                            '</div>' +
                        '</div>' +
                        '<span class="text-xs text-surface-variant font-mono">' + data.waktu + '</span>';

                    activityList.insertBefore(item, activityList.firstChild);

                    // Remove empty placeholder
                    const empty = activityList.querySelector('p.text-center');
                    if (empty && empty.textContent.includes('Belum ada')) empty.remove();

                    // Keep only last 20 items
                    while (activityList.children.length > 20) {
                        activityList.removeChild(activityList.lastChild);
                    }
                } else {
                    // Show error toast
                    const toast = document.getElementById('toast-error');
                    document.getElementById('toast-error-body').textContent = data.message;
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 4000);

                    scanStatus.textContent = 'Scan Gagal';
                    setTimeout(() => { scanStatus.textContent = 'Silakan Scan Kartu RFID Anda'; }, 2000);
                }
            })
            .catch(function() {
                const toast = document.getElementById('toast-error');
                document.getElementById('toast-error-body').textContent = 'Error koneksi. Periksa jaringan Anda.';
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 4000);

                scanStatus.textContent = 'Error Koneksi';
                setTimeout(() => { scanStatus.textContent = 'Silakan Scan Kartu RFID Anda'; }, 2000);
            });
        }

        // ===== MANUAL RFID INPUT =====
        function toggleManualInput() {
            const area = document.getElementById('manual-input-area');
            const btn = document.getElementById('manual-toggle');
            const isHidden = area.classList.contains('hidden');
            area.classList.toggle('hidden');
            btn.innerHTML = isHidden
                ? '<span class="material-symbols-outlined text-sm">close</span> Tutup Input Manual'
                : '<span class="material-symbols-outlined text-sm">keyboard</span> Masukkan Kode RFID Manual';
            if (isHidden) {
                setTimeout(() => document.getElementById('manual-rfid').focus(), 100);
            }
        }

        function manualScan() {
            const input = document.getElementById('manual-rfid');
            const rfid = input.value.trim();
            if (!rfid) {
                input.classList.add('border-error', 'border-2');
                input.classList.remove('border-white/20');
                setTimeout(() => {
                    input.classList.remove('border-error', 'border-2');
                    input.classList.add('border-white/20');
                }, 1500);
                return;
            }
            scanRfid(rfid);
            input.value = '';
            // Keep focus on manual input after scan
            input.focus();
        }

        // ===== ATMOSPHERE MICRO-INTERACTION =====
        document.body.addEventListener('mousemove', function(e) {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            document.body.style.background = 'radial-gradient(circle at ' + (x * 100) + '% ' + (y * 100) + '%, #1e1b4b 0%, #020617 100%)';
        });
    </script>

</body>
</html>
