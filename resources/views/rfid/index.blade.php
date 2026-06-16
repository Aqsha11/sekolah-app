<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset('storage/settings/' . $settings['favicon']) }}">
    @endif
    <title>Absensi RFID - {{ $settings['nama_website'] ?? 'Sekolah' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        }

        .scan-area {
            transition: all 0.3s ease;
        }

        .scan-area.scanning {
            border-color: #22c55e;
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.3);
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.4s ease both;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div
                class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fa-solid fa-wifi text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Absensi RFID</h1>
            <p class="text-indigo-200 mt-1">{{ $settings['nama_website'] ?? 'Sekolah' }}</p>
        </div>

        {{-- Live Clock --}}
        <div class="text-center mb-4">
            <div id="live-clock" class="text-5xl font-bold text-white tracking-wider tabular-nums">00:00:00</div>
            <div id="live-date" class="text-indigo-300/70 text-sm mt-1"></div>
        </div>

        {{-- Scan Area --}}
        <div id="scan-area"
            class="scan-area bg-white/10 backdrop-blur-sm rounded-2xl p-8 border-2 border-indigo-400/30 text-center mb-6">
            <div class="relative inline-flex mb-4">
                <div class="pulse-ring absolute inset-0 rounded-full border-4 border-green-400"></div>
                <div class="w-24 h-24 bg-indigo-500/30 rounded-full flex items-center justify-center relative z-10">
                    <i class="fa-solid fa-circle-nodes text-4xl text-white"></i>
                </div>
            </div>
            <p id="scan-status" class="text-indigo-200 text-lg">Tap RFID Card Anda</p>
            <p class="text-indigo-300/60 text-sm mt-2">Dekatkan kartu RFID ke pembaca</p>
        </div>

        {{-- RFID Input (hidden, gets focus for scanner) --}}
        <input type="text" id="rfid-input"
            class="w-full text-center text-2xl font-mono bg-white/10 border border-indigo-400/30 rounded-xl px-4 py-3 text-white placeholder-indigo-300/30 outline-none focus:border-green-400 transition-colors"
            placeholder="Scan RFID..." autofocus>

        {{-- Result Card --}}
        <div id="result-card" class="hidden mt-6 fade-in-up"></div>

        {{-- Recent Activity --}}
        <div id="recent-activity" class="mt-6 bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-indigo-400/10">
            <h3 class="text-white/60 text-xs font-semibold uppercase tracking-wider mb-3">Aktivitas Terakhir</h3>
            <div id="activity-list" class="space-y-2">
                <p class="text-indigo-300/40 text-sm text-center">Belum ada aktivitas</p>
            </div>
        </div>
    </div>

    <script>
        // ===== WITA TIMEZONE (UTC+8) =====
        function waktuWITA() {
            const now = new Date();
            const utc = now.getTime() + now.getTimezoneOffset() * 60000;
            return new Date(utc + 8 * 3600000);
        }

        // ===== LIVE CLOCK =====
        function updateClock() {
            const now = waktuWITA();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').textContent = `${jam}:${menit}:${detik}`;

            const hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const hari = hariList[now.getDay()];
            const tgl = now.getDate();
            const bulan = bulanList[now.getMonth()];
            const tahun = now.getFullYear();
            document.getElementById('live-date').textContent = `${hari}, ${tgl} ${bulan} ${tahun}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ===== BATAS TERLAMBAT (WITA) =====
        function isTerlambat() {
            const now = waktuWITA();
            const jam = now.getHours();
            const menit = now.getMinutes();
            return jam > 7 || (jam === 7 && menit > 15);
        }

        const rfidInput = document.getElementById('rfid-input');
        const scanArea = document.getElementById('scan-area');
        const scanStatus = document.getElementById('scan-status');
        const resultCard = document.getElementById('result-card');
        const activityList = document.getElementById('activity-list');

        rfidInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                e.preventDefault();
                scanRfid(this.value.trim());
                this.value = '';
            }
        });

        // Auto focus
        document.addEventListener('click', () => rfidInput.focus());
        rfidInput.focus();

        function scanRfid(rfid) {
            scanArea.classList.add('scanning');
            scanStatus.textContent = 'Memuat...';

            fetch('{{ route('rfid.scan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        rfid: rfid
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    scanArea.classList.remove('scanning');

                    if (data.success) {
                        const isCheckIn = data.action === 'check_in';
                        const isTerlambat = data.terlambat;
                        const borderColor = isTerlambat ? 'bg-orange-500/20 border-orange-400' : (isCheckIn ?
                            'bg-green-500/20 border-green-400' : 'bg-blue-500/20 border-blue-400');
                        const textColor = isTerlambat ? 'text-orange-300' : (isCheckIn ? 'text-green-300' :
                            'text-blue-300');
                        resultCard.className = `fade-in-up mt-6 ${borderColor} border rounded-xl p-6 text-center`;
                        resultCard.innerHTML = `
                        <div class="text-4xl mb-2">${isTerlambat ? '<i class="fa-solid fa-clock text-orange-300"></i>' : (isCheckIn ? '<i class="fa-solid fa-check-circle text-green-300"></i>' : '<i class="fa-solid fa-right-from-bracket text-blue-300"></i>')}</div>
                        <h2 class="text-xl font-bold text-white">${data.siswa}</h2>
                        <p class="text-indigo-200 text-sm">${data.kelas}</p>
                        <div class="mt-3 ${textColor} font-semibold text-lg">
                            ${isTerlambat ? 'TERLAMBAT' : (data.action === 'check_in' ? 'CHECK IN' : 'CHECK OUT')}
                        </div>
                        <p class="text-indigo-300/80 text-sm mt-1">${data.waktu}</p>
                        ${data.durasi ? `<p class="text-indigo-300/60 text-xs mt-1">Durasi: ${data.durasi}</p>` : ''}
                    `;
                        resultCard.classList.remove('hidden');

                        // Add to activity
                        const dotColor = isTerlambat ? 'bg-orange-400' : (isCheckIn ? 'bg-green-400' : 'bg-blue-400');
                        const labelColor = isTerlambat ? 'text-orange-300' : (isCheckIn ? 'text-green-300' :
                            'text-blue-300');
                        const label = isTerlambat ? 'TERLAMBAT' : (data.action === 'check_in' ? 'CHECK IN' :
                            'CHECK OUT');
                        const activityItem = document.createElement('div');
                        activityItem.className = 'flex items-center justify-between text-sm fade-in-up';
                        activityItem.innerHTML = `
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full ${dotColor}"></span>
                            <span class="text-white">${data.siswa}</span>
                        </div>
                        <div class="text-right">
                            <span class="${labelColor} text-xs font-medium">${label}</span>
                            <span class="text-indigo-300/60 text-xs ml-2">${data.waktu}</span>
                        </div>
                    `;
                        activityList.prepend(activityItem);

                        const empty = activityList.querySelector('p');
                        if (empty) empty.remove();

                        scanStatus.textContent = 'Tap RFID Card Anda';
                    } else {
                        resultCard.className =
                            'fade-in-up mt-6 bg-red-500/20 border border-red-400 rounded-xl p-6 text-center';
                        resultCard.innerHTML = `
                        <div class="text-4xl mb-2"><i class="fa-solid fa-circle-xmark text-red-300"></i></div>
                        <h2 class="text-lg font-bold text-white">${data.message}</h2>
                    `;
                        resultCard.classList.remove('hidden');
                        scanStatus.textContent = 'Tap RFID Card Anda';
                    }
                })
                .catch(err => {
                    scanArea.classList.remove('scanning');
                    scanStatus.textContent = 'Tap RFID Card Anda';
                    resultCard.className =
                        'fade-in-up mt-6 bg-red-500/20 border border-red-400 rounded-xl p-6 text-center';
                    resultCard.innerHTML = `<h2 class="text-lg font-bold text-white">Error koneksi</h2>`;
                    resultCard.classList.remove('hidden');
                });

            // Auto-hide result after 5s
            setTimeout(() => {
                resultCard.classList.add('hidden');
            }, 5000);
        }
    </script>
</body>

</html>
