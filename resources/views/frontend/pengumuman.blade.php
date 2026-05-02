<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengumuman Kelulusan - SMAN 5 Morotai</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        @media (prefers-color-scheme: dark) {
            .glass-panel {
                background: rgba(22, 22, 21, 0.85);
                border: 1px solid rgba(62, 62, 58, 0.5);
            }
        }
        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 12px;
            background: #f53003;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        @media (prefers-color-scheme: dark) {
            .countdown-item {
                background: #ff4433;
            }
        }
        .countdown-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
        .countdown-label { font-size: 0.7rem; text-transform: uppercase; font-weight: 500; margin-top: 4px; }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen relative flex flex-col items-center justify-center p-4">
    <!-- Decorative background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-red-100 dark:bg-red-900/20 blur-3xl opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-orange-100 dark:bg-orange-900/20 blur-3xl opacity-60"></div>
    </div>

    <!-- Optional Back button -->
    <div class="absolute top-6 left-6 z-20">
        <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium hover:text-[#f53003] dark:hover:text-[#ff4433] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="w-full max-w-2xl glass-panel rounded-2xl shadow-xl overflow-hidden p-6 md:p-10 relative z-10 transition-all duration-500 my-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight">Pengumuman Kelulusan</h1>
            <h2 class="text-xl md:text-2xl font-medium text-gray-600 dark:text-gray-400">SMA Negeri 5 Morotai</h2>
            <div class="inline-block mt-3 px-4 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-sm font-medium border border-gray-200 dark:border-gray-700">
                Tahun Ajaran 2026/2027
            </div>
        </div>

        <!-- Timer Section -->
        <div id="countdown-section" class="mb-10 hidden">
            <p class="text-center mb-6 font-medium text-lg text-gray-700 dark:text-gray-300">Pengumuman akan dibuka secara online dalam waktu:</p>
            <div class="flex justify-center gap-3 sm:gap-5">
                <div class="countdown-item">
                    <span id="days" class="countdown-value">00</span>
                    <span class="countdown-label">Hari</span>
                </div>
                <div class="countdown-item">
                    <span id="hours" class="countdown-value">00</span>
                    <span class="countdown-label">Jam</span>
                </div>
                <div class="countdown-item">
                    <span id="minutes" class="countdown-value">00</span>
                    <span class="countdown-label">Menit</span>
                </div>
                <div class="countdown-item">
                    <span id="seconds" class="countdown-value">00</span>
                    <span class="countdown-label">Detik</span>
                </div>
            </div>
            <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">Silakan kembali lagi saat hitungan mundur selesai.</p>
        </div>

        <!-- Check Form Section -->
        <div id="check-section" class="hidden">
            @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 flex items-start gap-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            @endif

            @if(session('result'))
                @php $grad = session('result'); @endphp
                <div class="mb-8 p-6 md:p-8 rounded-2xl border-2 {{ $grad->status == 'Lulus' ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800' : 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800' }} text-center transition-all shadow-sm">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2 {{ $grad->status == 'Lulus' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $grad->name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 font-mono tracking-widest font-medium mb-6">NISN: {{ $grad->nisn }}</p>
                    
                    <div class="inline-block px-8 py-3 rounded-full font-black tracking-widest text-xl mb-6 shadow-md transform {{ $grad->status == 'Lulus' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                        {{ strtoupper($grad->status) }}
                    </div>

                    @if($grad->status == 'Lulus')
                        <div class="bg-white/80 dark:bg-black/40 backdrop-blur-sm p-5 rounded-xl border border-green-100 dark:border-green-900/50">
                            <p class="text-[15px] text-gray-800 dark:text-gray-200 leading-relaxed font-medium">
                                "Selamat anda dinyatakan lulus berdasarkan surat Keputusan Kepala sekolah Nomor : 0008/SKKL/01/V/SMA5-PM/2026 tanggal 4 Mei 2026."
                            </p>
                        </div>
                    @else
                        <div class="bg-white/80 dark:bg-black/40 backdrop-blur-sm p-5 rounded-xl border border-red-100 dark:border-red-900/50">
                            <p class="text-[15px] text-gray-800 dark:text-gray-200 leading-relaxed font-medium">
                                "Maaf, anda dinyatakan belum lulus berdasarkan surat Keputusan Kepala sekolah Nomor : 0008/SKKL/01/V/SMA5-PM/2026 tanggal 4 Mei 2026."
                            </p>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <a href="{{ route('public.pengumuman') }}" class="inline-flex items-center gap-2 px-6 py-2.5 border border-gray-300 hover:border-gray-400 dark:border-gray-700 dark:hover:border-gray-600 bg-white/50 hover:bg-white dark:bg-[#161615] dark:hover:bg-black rounded-xl font-medium transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Cek NISN Lain
                    </a>
                </div>
            @else
                <form action="{{ route('public.pengumuman.cek') }}" method="POST" class="w-full">
                    @csrf
                    <div class="mb-6">
                        <label for="nisn" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 text-center">Silakan masukkan NISN Anda</label>
                        <input type="text" id="nisn" name="nisn" required autocomplete="off" class="w-full px-5 py-4 bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-xl text-xl focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:border-[#f53003] dark:focus:ring-[#ff4433] dark:focus:border-[#ff4433] transition-all text-center tracking-[0.25em] font-mono shadow-inner" placeholder="0012345678" value="{{ old('nisn') }}">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#1b1b18] hover:bg-black dark:bg-[#eeeeec] dark:hover:bg-white dark:text-[#1C1C1A] text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        LIHAT HASIL KELULUSAN
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>

        <!-- Warning Notice -->
        <div class="mt-10 p-5 bg-orange-50/80 dark:bg-orange-950/30 border-l-4 border-orange-500 rounded-r-xl border border-y-orange-100 border-r-orange-100 dark:border-y-orange-900/50 dark:border-r-orange-900/50">
            <h4 class="text-orange-800 dark:text-orange-500 font-bold mb-3 flex items-center gap-2 text-sm uppercase tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Himbauan Sekolah
            </h4>
            <ul class="list-disc pl-5 text-[13px] text-orange-700 dark:text-orange-400/90 space-y-1.5 leading-relaxed">
                <li>Siswa dilarang keras melakukan aksi corat-coret seragam sekolah.</li>
                <li>Dilarang melakukan konvoi kendaraan bermotor di jalan raya.</li>
                <li>Dilarang melakukan tindakan hura-hura yang mengganggu ketertiban umum.</li>
            </ul>
        </div>
    </div>

    <!-- Script to handle countdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Target date from controller
            const releaseDate = new Date("{{ $releaseDate }}").getTime();
            
            // Elements
            const countdownSection = document.getElementById('countdown-section');
            const checkSection = document.getElementById('check-section');
            const daysEl = document.getElementById('days');
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');

            function updateTimer() {
                const now = new Date().getTime();
                const distance = releaseDate - now;

                if (distance <= 0) {
                    countdownSection.classList.add('hidden');
                    checkSection.classList.remove('hidden');
                    return true; // Stop timer
                } else {
                    countdownSection.classList.remove('hidden');
                    checkSection.classList.add('hidden');

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    daysEl.innerText = days.toString().padStart(2, '0');
                    hoursEl.innerText = hours.toString().padStart(2, '0');
                    minutesEl.innerText = minutes.toString().padStart(2, '0');
                    secondsEl.innerText = seconds.toString().padStart(2, '0');
                    return false; // Continue timer
                }
            }

            // Run once immediately, if not done, set interval
            if (!updateTimer()) {
                const timer = setInterval(function() {
                    if (updateTimer()) {
                        clearInterval(timer);
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>
