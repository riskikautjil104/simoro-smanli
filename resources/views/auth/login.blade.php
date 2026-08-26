<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMORO SMANLI') }} — Masuk</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
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
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* ===== LEFT PANEL ===== */
        .login-left {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: #fff;
            padding: 48px;
            position: relative;
            overflow: hidden;
            width: 45%;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            max-width: 420px;
        }

        .brand-logo {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .brand-logo img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .login-left h1 {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .login-left p {
            font-size: 0.92rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .feature-chips {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .chip {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 12px 18px;
            border-radius: 16px;
        }

        .chip-icon {
            font-size: 1.3rem;
        }

        /* ===== RIGHT PANEL ===== */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            padding: 40px 36px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(13,110,253,0.08);
            border: 1px solid #e2e8f0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 0.84rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary);
            transform: translateX(-3px);
        }

        .card-header-box {
            margin-bottom: 26px;
        }

        .card-header-box h2 {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .card-header-box p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .session-status {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
            color: #1e293b;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-wrap input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.12);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
        }

        .pwd-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .pwd-toggle:hover {
            color: var(--primary);
        }

        .field-error {
            font-size: 0.78rem;
            color: #dc3545;
            font-weight: 500;
            margin-top: 5px;
        }

        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            margin-top: 4px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: #64748b;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

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
            font-weight: 700;
            border: none;
            border-radius: var(--radius-btn);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(13,110,253,0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13,110,253,0.4);
        }

        .docs-banner {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 0.82rem;
            color: #64748b;
        }

        .docs-banner a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: underline;
        }

        .card-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        @media (min-width: 992px) {
            .login-left { display: flex; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT PANEL ===== -->
    <div class="login-left">
        <div class="login-left-content">
            <div class="brand-logo">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo SIMORO" onerror="this.src='{{ asset('assets/frondend/assets/img/logo.png') }}'">
            </div>

            <h1>SIMORO SMANLI</h1>
            <p>Platform Sistem Ujian Online (CBT) &amp; Akademik Resmi SMA Negeri 5 Pulau Morotai. Aman, cepat, dan transparan.</p>

            <div class="feature-chips">
                <div class="chip">
                    <div class="chip-icon">🔒</div>
                    <div>
                        <div style="font-weight:700;">Anti-Curang Terpadu</div>
                        <div style="font-size:0.78rem;opacity:0.85;">Sensor pindah layar &amp; pelacakan GPS</div>
                    </div>
                </div>
                <div class="chip">
                    <div class="chip-icon">⚡</div>
                    <div>
                        <div style="font-weight:700;">Auto-Save &amp; Hasil Realtime</div>
                        <div style="font-size:0.78rem;opacity:0.85;">Jawaban tersimpan otomatis per butir soal</div>
                    </div>
                </div>
                <div class="chip">
                    <div class="chip-icon">📱</div>
                    <div>
                        <div style="font-weight:700;">Aplikasi Mobile Terintegrasi</div>
                        <div style="font-size:0.78rem;opacity:0.85;">Dapat diakses via Web, Android &amp; iOS</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT PANEL ===== -->
    <div class="login-right">
        <div class="login-card">

            <a href="{{ url('/') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="card-header-box">
                <h2>Selamat Datang 👋</h2>
                <p>Masuk ke akun portal SIMORO SMANLI</p>
            </div>

            @if (session('status'))
                <div class="session-status">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <!-- Email / Identitas -->
                <div class="form-group">
                    <label for="email">Email atau NIS</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@sekolah.com atau NIS"
                        >
                    </div>
                    @error('email')
                        <div class="field-error"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <button type="button" class="pwd-toggle" id="pwd-toggle" aria-label="Lihat password">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="form-extras">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span id="btn-text">Masuk Sekarang</span>
                    <i class="bi bi-arrow-right" id="btn-arrow"></i>
                </button>
            </form>

            <div class="docs-banner">
                Butuh bantuan / panduan penggunaan? <br>
                <a href="{{ route('public.docs') }}" target="_blank">
                    <i class="bi bi-journal-text me-1"></i> Buka Dokumentasi &amp; Panduan Lengkap
                </a>
            </div>

            <div class="card-footer">
                &copy; {{ date('Y') }} SMA Negeri 5 Pulau Morotai &bull; All rights reserved.
            </div>

        </div>
    </div>

    <script>
        // Password toggle
        var pwdInput  = document.getElementById('password');
        var pwdToggle = document.getElementById('pwd-toggle');
        var eyeIcon   = document.getElementById('eye-icon');

        if (pwdToggle && pwdInput) {
            pwdToggle.addEventListener('click', function () {
                var isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        }
    </script>
</body>
</html>
