{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html> --}}
{{-- resources/views/layouts/guest.blade.php --}}
{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMORO SMANLI') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Pattern batik + wave Morotai */
        .batik-wave-pattern {
            position: relative;
            background-color: #eef2ff;
            background-image: 
                /* Wave 1 - gelombang besar dari kiri atas */
                radial-gradient(circle at 10% 30%, rgba(64,149,240,0.15) 0%, transparent 35%),
                radial-gradient(circle at 95% 70%, rgba(48,38,251,0.15) 0%, transparent 40%),
                /* Wave 2 - gelombang melintang */
                radial-gradient(ellipse at 20% 60%, rgba(64,149,240,0.12) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 40%, rgba(48,38,251,0.12) 0%, transparent 45%),
                /* Wave 3 - gelombang kecil (efek riak) */
                repeating-radial-gradient(circle at 30% 80%, rgba(64,149,240,0.08) 0px, transparent 8px, transparent 16px),
                repeating-radial-gradient(circle at 70% 20%, rgba(48,38,251,0.08) 0px, transparent 10px, transparent 20px),
                
                /* Motif batik kawung (lingkaran) */
                radial-gradient(circle at 15% 15%, rgba(64,149,240,0.1) 0%, transparent 20%),
                radial-gradient(circle at 85% 25%, rgba(48,38,251,0.1) 0%, transparent 22%),
                radial-gradient(circle at 45% 50%, rgba(64,149,240,0.1) 0%, transparent 18%),
                radial-gradient(circle at 65% 75%, rgba(48,38,251,0.1) 0%, transparent 20%),
                
                /* Motif parang (garis miring bergelombang) */
                repeating-linear-gradient(45deg, 
                    rgba(64,149,240,0.08) 0px, 
                    rgba(64,149,240,0.08) 3px,
                    transparent 3px, 
                    transparent 12px),
                repeating-linear-gradient(135deg, 
                    rgba(48,38,251,0.08) 0px, 
                    rgba(48,38,251,0.08) 3px,
                    transparent 3px, 
                    transparent 12px),
                
                /* Garis halus (tenun) */
                repeating-linear-gradient(0deg, 
                    rgba(64,149,240,0.04) 0px, 
                    rgba(64,149,240,0.04) 1px,
                    transparent 1px, 
                    transparent 6px),
                repeating-linear-gradient(90deg, 
                    rgba(48,38,251,0.04) 0px, 
                    rgba(48,38,251,0.04) 1px,
                    transparent 1px, 
                    transparent 6px);
        }

        /* Overlay tipis untuk menjaga keterbacaan */
        .batik-overlay {
            position: relative;
        }
        .batik-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(2px);
            z-index: 0;
        }
        .batik-overlay > * {
            position: relative;
            z-index: 1;
        }

        /* Card login dengan efek glass */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(64, 149, 240, 0.25);
            box-shadow: 0 25px 50px -12px rgba(48, 38, 251, 0.3);
        }

        /* Tombol gradien */
        .btn-primary {
            background: linear-gradient(135deg, #4095F0, #3026FB);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -8px rgba(64, 149, 240, 0.6);
        }

        /* Input focus */
        .input-focus:focus {
            border-color: #4095F0;
            box-shadow: 0 0 0 3px rgba(64, 149, 240, 0.25);
        }

        /* Animasi gelombang ekstra (opsional) */
        @keyframes waveMove {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
        .batik-wave-pattern {
            background-size: 200% 200%;
            animation: waveMove 30s ease-in-out infinite alternate;
        }
    </style>
</head>
<body class="batik-wave-pattern antialiased min-h-screen flex items-center justify-center">
    <div class="w-full sm:max-w-md px-6 py-8 login-card rounded-2xl shadow-2xl batik-overlay">
        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-[#4095F0] to-[#3026FB] text-white text-3xl font-bold shadow-lg mb-4">
                S
            </div>
            <h2 class="text-2xl font-bold text-gray-800">SIMORO SMANLI</h2>
            <p class="text-sm text-gray-600 mt-1">SMA Negeri 5 Morotai</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                <x-text-input id="email" 
                    class="block mt-1 w-full rounded-lg border-gray-300 input-focus" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required autofocus 
                    autocomplete="username" 
                    placeholder="nama@sekolah.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                <x-text-input id="password" 
                    class="block mt-1 w-full rounded-lg border-gray-300 input-focus"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#4095F0] shadow-sm focus:ring-[#4095F0]" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-[#4095F0] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4095F0]" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <button type="submit" class="btn-primary px-6 py-2.5 rounded-lg text-white font-semibold shadow-md transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 text-xs text-gray-500">
            &copy; {{ date('Y') }} SMA Negeri 5 Morotai. All rights reserved.
        </div>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMORO SMANLI') }} - Login</title>

    <!-- Fonts — sama dengan welcome page -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =============================================
           VARIABLES — identik dengan welcome.blade.php
        ============================================= */
        :root {
            --primary:      #0d6efd;
            --primary-dark: #0a58ca;
            --accent:       #0dcaf0;
            --secondary:    #20c997;
            --radius-btn:   50px;
            --transition:   all 0.3s ease;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* =============================================
           LEFT PANEL — hero gradient sama persis
        ============================================= */
        .login-left {
            display: none; /* hidden mobile, shown desktop */
            flex: 1;
            background: linear-gradient(135deg, rgba(13,110,253,0.96) 0%, rgba(13,202,240,0.90) 100%);
            position: relative;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        /* Decorative circles — sama dengan hero */
        .login-left::before {
            content: '';
            position: absolute;
            width: 480px; height: 480px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            top: -120px; right: -140px;
            animation: floatCircle 8s ease-in-out infinite;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: 60px; left: -70px;
            animation: floatCircle 11s ease-in-out infinite reverse;
        }

        @keyframes floatCircle {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-22px) scale(1.04); }
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: center;
            max-width: 420px;
        }

        .login-left-content .brand-logo {
            width: 72px; height: 72px;
            background: rgba(255,255,255,0.18);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .login-left-content .brand-logo img {
            width: 48px; height: 48px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .login-left-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.25;
        }

        .login-left-content p {
            font-size: 0.95rem;
            opacity: 0.85;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        /* Feature chips */
        .feature-chips {
            display: flex;
            flex-direction: column;
            gap: 12px;
            text-align: left;
        }

        .chip {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.88rem;
            font-weight: 500;
            animation: chipIn 0.6s ease both;
        }

        .chip:nth-child(1) { animation-delay: 0.2s; }
        .chip:nth-child(2) { animation-delay: 0.35s; }
        .chip:nth-child(3) { animation-delay: 0.5s; }

        @keyframes chipIn {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .chip-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* Wave divider between panels */
        .login-wave {
            position: absolute;
            right: -1px; top: 0; bottom: 0;
            width: 60px;
            z-index: 3;
        }

        .login-wave svg {
            width: 100%; height: 100%;
        }

        /* =============================================
           RIGHT PANEL — form
        ============================================= */
        .login-right {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            background: #f8f9fa;
            position: relative;
            overflow-y: auto;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 8px 40px rgba(13,110,253,0.10);
            border: 1px solid rgba(13,110,253,0.08);
            animation: cardIn 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 500;
            color: #888;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--primary); }
        .back-link svg   { width: 14px; height: 14px; }

        /* Card header */
        .card-header {
            margin-bottom: 28px;
        }

        .card-header .logo-wrap {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 6px 20px rgba(13,110,253,0.3);
        }

        .card-header .logo-wrap img {
            width: 34px; height: 34px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 0.85rem;
            color: #888;
        }

        /* Form elements */
        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 0.83rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
            color: #333;
            background: #f8f9fa;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-group input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.12);
        }

        .form-group input:focus + .input-icon,
        .form-group .input-wrap:focus-within .input-icon {
            color: var(--primary);
        }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            cursor: pointer;
            font-size: 0.95rem;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
        }

        .pwd-toggle:hover { color: var(--primary); }

        /* Error message */
        .field-error {
            font-size: 0.78rem;
            color: #dc3545;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Remember + Forgot row */
        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            margin-top: 6px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: #666;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: var(--primary-dark); text-decoration: underline; }

        /* Submit button — full width, consistent dengan welcome */
        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 24px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: var(--radius-btn);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(13,110,253,0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(13,110,253,0.4);
        }

        .btn-submit:active { transform: translateY(0); }

        /* Loading state */
        .btn-submit .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #ccc;
            font-size: 0.78rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        /* Register link */
        .register-prompt {
            text-align: center;
            font-size: 0.83rem;
            color: #888;
        }

        .register-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-prompt a:hover { color: var(--primary-dark); text-decoration: underline; }

        /* Session status */
        .session-status {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Footer */
        .card-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.75rem;
            color: #bbb;
        }

        /* =============================================
           DESKTOP — show left panel
        ============================================= */
        @media (min-width: 768px) {
            .login-left  { display: flex; max-width: 480px; }
            .login-right { width: auto; flex: 1; }
        }

        @media (min-width: 1024px) {
            .login-left { max-width: 520px; }
        }
    </style>
</head>

<body>

    <!-- ===== LEFT PANEL ===== -->
    <div class="login-left">
        <div class="login-left-content">

            <div class="brand-logo">
                <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo SIMORO">
            </div>

            <h1>SIMORO SMANLI</h1>
            <p>Platform ujian online resmi SMA Negeri 5 Morotai. Aman, cepat, dan terpercaya untuk setiap siswa dan guru.</p>

            <div class="feature-chips">
                <div class="chip">
                    <div class="chip-icon">🔒</div>
                    <div>
                        <div style="font-weight:600;">Aman & Terpercaya</div>
                        <div style="font-size:0.78rem;opacity:0.8;">Sistem anti-cheat realtime</div>
                    </div>
                </div>
                <div class="chip">
                    <div class="chip-icon">⚡</div>
                    <div>
                        <div style="font-weight:600;">Hasil Instan</div>
                        <div style="font-size:0.78rem;opacity:0.8;">Nilai langsung setelah ujian selesai</div>
                    </div>
                </div>
                <div class="chip">
                    <div class="chip-icon">📱</div>
                    <div>
                        <div style="font-weight:600;">Multi Device</div>
                        <div style="font-size:0.78rem;opacity:0.8;">HP, tablet, maupun komputer</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave pemisah ke kanan -->
        <div class="login-wave">
            <svg viewBox="0 0 60 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,0 C30,100 60,200 20,300 C0,380 50,450 30,550 C10,640 60,720 0,800 L60,800 L60,0 Z"
                      fill="#f8f9fa"/>
            </svg>
        </div>
    </div>

    <!-- ===== RIGHT PANEL ===== -->
    <div class="login-right">
        <div class="login-card">

            <!-- Back to home -->
            <a href="{{ url('/') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Beranda
            </a>

            <!-- Card header -->
            <div class="card-header">
                <div class="logo-wrap">
                    <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo">
                </div>
                <h2>Selamat Datang 👋</h2>
                <p>Masuk ke akun SIMORO SMANLI kamu</p>
            </div>

            <!-- Session status -->
            @if (session('status'))
                <div class="session-status">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@sman5morotai.sch.id"
                        >
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                    </div>
                    @error('email')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <button type="button" class="pwd-toggle" id="pwd-toggle" aria-label="Lihat password">
                            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="form-extras">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span class="spinner" id="spinner"></span>
                    <span id="btn-text">Masuk Sekarang</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" id="btn-arrow">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>

            </form>

            <!-- Register link -->
            @if (Route::has('register'))
                <div class="divider">atau</div>
                <div class="register-prompt">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            @endif

            <!-- Footer -->
            <div class="card-footer">
                © {{ date('Y') }} SMA Negeri 5 Morotai · All rights reserved
            </div>

        </div>
    </div>

    <script>
        // Password show/hide toggle
        var pwdInput  = document.getElementById('password');
        var pwdToggle = document.getElementById('pwd-toggle');
        var eyeIcon   = document.getElementById('eye-icon');

        var eyeOpen = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        var eyeOff  = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';

        if (pwdToggle && pwdInput) {
            pwdToggle.addEventListener('click', function () {
                var isPassword = pwdInput.type === 'password';
                pwdInput.type  = isPassword ? 'text' : 'password';
                eyeIcon.innerHTML = isPassword ? eyeOff : eyeOpen;
            });
        }

        // Loading state on submit
        var form      = document.getElementById('login-form');
        var submitBtn = document.getElementById('submit-btn');
        var spinner   = document.getElementById('spinner');
        var btnText   = document.getElementById('btn-text');
        var btnArrow  = document.getElementById('btn-arrow');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled        = true;
                spinner.style.display     = 'block';
                btnArrow.style.display    = 'none';
                btnText.textContent       = 'Memproses...';
                submitBtn.style.opacity   = '0.85';
            });
        }
    </script>

</body>
</html>