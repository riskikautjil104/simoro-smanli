<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pusat Dokumentasi dan Panduan Pengguna — SIMORO SMANLI v2.0</title>
    <meta name="description" content="Dokumentasi resmi dan panduan lengkap penggunaan aplikasi SIMORO SMANLI (CBT Online SMA Negeri 5 Morotai) untuk Siswa, Guru, Admin, dan Kepala Sekolah.">
    <meta name="keywords" content="SIMORO Docs, Panduan SIMORO, Panduan CBT SMANLI, Dokumentasi Ujian Online, Panduan Guru, Panduan Siswa, Panduan Kepala Sekolah">

    <!-- Favicon -->
    <link href="{{ asset('assets/frondend/assets/img/favicon.svg') }}" rel="icon" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('assets/frondend/assets/img/favicon.ico') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0a58ca;
            --primary-soft: #eff6ff;
            --primary-border: #bfdbfe;
            --accent: #06b6d4;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --purple: #8b5cf6;
            --ink: #0f172a;
            --ink-muted: #64748b;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --radius-lg: 18px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 20px -2px rgba(13, 110, 253, 0.08);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--ink);
            line-height: 1.7;
            scroll-behavior: smooth;
        }

        /* NAVBAR */
        .docs-navbar {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1050;
            padding: 14px 0;
        }
        .docs-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--ink);
            font-weight: 800;
            font-size: 1.15rem;
        }
        .docs-brand img {
            height: 38px;
            width: auto;
        }
        .docs-version-badge {
            font-size: 0.72rem;
            font-weight: 700;
            background: var(--primary-soft);
            color: var(--primary);
            padding: 3px 9px;
            border-radius: 20px;
            border: 1px solid var(--primary-border);
        }

        /* HERO BANNER */
        .docs-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #1e40af 50%, #06b6d4 100%);
            padding: 56px 0 64px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .docs-hero::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
            top: -150px;
            right: -50px;
        }
        .docs-hero h1 {
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }
        .docs-hero p {
            font-size: 1.05rem;
            opacity: 0.92;
            max-width: 760px;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .search-box-wrap {
            max-width: 620px;
            position: relative;
        }
        .search-box-wrap input {
            height: 52px;
            padding-left: 48px;
            border-radius: 50px;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.95);
            font-size: 0.95rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            transition: var(--transition);
        }
        .search-box-wrap input:focus {
            background: #ffffff;
            border-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            outline: none;
        }
        .search-box-wrap i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.2rem;
        }

        /* ROLE QUICK SELECTOR */
        .role-nav-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 16px;
            box-shadow: var(--shadow-sm);
            margin-top: -30px;
            position: relative;
            z-index: 10;
        }
        .role-tab-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--ink-muted);
            border: 1px solid transparent;
            background: transparent;
            transition: var(--transition);
            width: 100%;
            text-align: left;
            text-decoration: none;
        }
        .role-tab-btn:hover {
            background: var(--bg-page);
            color: var(--primary);
        }
        .role-tab-btn.active {
            background: var(--primary-soft);
            color: var(--primary);
            border-color: var(--primary-border);
        }

        /* SIDEBAR */
        .docs-sidebar {
            position: sticky;
            top: 86px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            padding-right: 12px;
        }
        .docs-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .docs-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar-section-title {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            margin: 20px 0 8px 8px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.84rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: var(--transition);
        }
        .sidebar-link:hover {
            color: var(--primary);
            background: rgba(13, 110, 253, 0.06);
            transform: translateX(3px);
        }
        .sidebar-link.active {
            color: var(--primary);
            background: var(--primary-soft);
            font-weight: 700;
        }

        /* DOC SECTION */
        .doc-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 34px 38px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 30px;
        }
        .doc-section-header {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .doc-section-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0;
        }
        .doc-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .doc-badge.student { background: #dcfce7; color: #15803d; }
        .doc-badge.teacher { background: #e0e7ff; color: #4338ca; }
        .doc-badge.admin   { background: #fef3c7; color: #b45309; }
        .doc-badge.kepsek  { background: #fae8ff; color: #86198f; }
        .doc-badge.new     { background: #ffe4e6; color: #e11d48; }

        /* STEP CARDS */
        .step-card {
            border: 1px solid #edf2f7;
            background: #fafbfc;
            border-radius: var(--radius-md);
            padding: 22px 24px;
            margin-bottom: 20px;
            transition: var(--transition);
        }
        .step-card:hover {
            border-color: var(--primary-border);
            background: #ffffff;
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.88rem;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .step-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        /* CALLOUTS */
        .callout {
            border-left: 4px solid;
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            margin: 16px 0;
            font-size: 0.88rem;
        }
        .callout-info {
            background: #f0f9ff;
            border-color: #0284c7;
            color: #0369a1;
        }
        .callout-warning {
            background: #fffbeb;
            border-color: #f59e0b;
            color: #92400e;
        }
        .callout-success {
            background: #f0fdf4;
            border-color: #10b981;
            color: #065f46;
        }
        .callout-danger {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }

        /* FEATURE BENTO */
        .feature-bento {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px;
            height: 100%;
            transition: var(--transition);
        }
        .feature-bento:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }
        .feature-bento-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 14px;
        }

        /* BUTTON TAG MOCKUP */
        .btn-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .btn-tag.primary { background: #0d6efd; color: #fff; border-color: #0d6efd; }
        .btn-tag.success { background: #198754; color: #fff; border-color: #198754; }
        .btn-tag.danger  { background: #dc3545; color: #fff; border-color: #dc3545; }
        .btn-tag.warning { background: #ffc107; color: #000; border-color: #ffc107; }
        .btn-tag.info    { background: #0dcaf0; color: #000; border-color: #0dcaf0; }

        .code-inline {
            font-family: 'Fira Code', monospace;
            background: #f1f5f9;
            color: #0f172a;
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 0.85em;
            border: 1px solid #e2e8f0;
        }

        /* FAQ ACCORDION */
        .accordion-item {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md) !important;
            margin-bottom: 12px;
            overflow: hidden;
        }
        .accordion-button {
            font-weight: 700;
            font-size: 0.95rem;
            padding: 16px 20px;
            background: #fff;
            color: var(--ink);
        }
        .accordion-button:not(.collapsed) {
            background: var(--primary-soft);
            color: var(--primary);
            box-shadow: none;
        }
        .accordion-body {
            padding: 18px 20px;
            font-size: 0.9rem;
            color: #334155;
            line-height: 1.65;
        }

        .docs-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 40px 0;
            margin-top: 60px;
            color: var(--ink-muted);
            font-size: 0.88rem;
        }

        @media (max-width: 991px) {
            .docs-sidebar { display: none; }
            .doc-section { padding: 22px 18px; }
            .docs-hero h1 { font-size: 1.75rem; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header class="docs-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="docs-brand">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo">
                <div>
                    SIMORO <span class="text-primary">SMANLI</span>
                    <span class="docs-version-badge ms-1">Docs v2.0</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    Beranda
                </a>
                <a href="{{ route('public.pengumuman') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Pengumuman Kelulusan
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Masuk Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Login CBT
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO BANNER -->
    <section class="docs-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-20 rounded-pill text-white small fw-bold mb-3">
                        Pusat Panduan dan Dokumentasi Resmi
                    </div>
                    <h1>Dokumentasi dan Manual Penggunaan SIMORO SMANLI</h1>
                    <p>Buku petunjuk operasional lengkap dan terperinci untuk Siswa, Guru Mata Pelajaran, Administrator, dan Kepala Sekolah pada Sistem Informasi Ujian Online SMA Negeri 5 Pulau Morotai versi 2.0.</p>

                    <div class="search-box-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" id="docSearch" class="form-control" placeholder="Cari topik panduan (contoh: arsip ujian, tambah soal, berita acara, ttd digital, kelulusan)...">
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/img/people.svg') }}" alt="CBT Docs" style="max-height: 220px; opacity: 0.9;">
                </div>
            </div>
        </div>
    </section>

    <!-- ROLE QUICK SELECTOR TABS -->
    <div class="container">
        <div class="role-nav-card">
            <div class="row g-2">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#fitur-baru" class="role-tab-btn active">
                        <i class="bi bi-stars text-danger"></i>
                        <span>Fitur Baru v2.0</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#panduan-siswa" class="role-tab-btn">
                        <i class="bi bi-person-fill text-success"></i>
                        <span>Panduan Siswa</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#panduan-guru" class="role-tab-btn">
                        <i class="bi bi-person-badge-fill text-primary"></i>
                        <span>Panduan Guru</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#panduan-admin" class="role-tab-btn">
                        <i class="bi bi-shield-lock-fill text-warning"></i>
                        <span>Panduan Admin</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#panduan-kepsek" class="role-tab-btn">
                        <i class="bi bi-briefcase-fill text-purple" style="color: #8b5cf6;"></i>
                        <span>Kepala Sekolah</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#faq" class="role-tab-btn">
                        <i class="bi bi-question-circle-fill text-info"></i>
                        <span>Tanya Jawab</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container py-5">
        <div class="row">

            <!-- Sidebar Desktop -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="docs-sidebar">
                    <div class="sidebar-section-title">FITUR BARU v2.0</div>
                    <a href="#fitur-arsip-ujian" class="sidebar-link"><i class="bi bi-archive"></i> Arsip Ujian Selesai</a>
                    <a href="#fitur-berita-acara" class="sidebar-link"><i class="bi bi-file-earmark-text"></i> Berita Acara CBT</a>
                    <a href="#fitur-ttd" class="sidebar-link"><i class="bi bi-pen"></i> Tanda Tangan Digital</a>
                    <a href="#fitur-role-kepsek" class="sidebar-link"><i class="bi bi-person-workspace"></i> Role Kepala Sekolah</a>
                    <a href="#fitur-alumni" class="sidebar-link"><i class="bi bi-mortarboard"></i> Kelulusan dan Alumni</a>
                    <a href="#fitur-analitik" class="sidebar-link"><i class="bi bi-bar-chart"></i> Analitik Dashboard</a>

                    <div class="sidebar-section-title">PANDUAN SISWA</div>
                    <a href="#siswa-login" class="sidebar-link"><i class="bi bi-box-arrow-in-right"></i> Login dan Akun</a>
                    <a href="#siswa-mulai" class="sidebar-link"><i class="bi bi-play-circle"></i> Memulai Ujian CBT</a>
                    <a href="#siswa-pengerjaan" class="sidebar-link"><i class="bi bi-check2-circle"></i> Menjawab PG dan Esai</a>
                    <a href="#siswa-keamanan" class="sidebar-link"><i class="bi bi-shield-exclamation"></i> Proteksi Anti-Curang</a>
                    <a href="#siswa-hasil" class="sidebar-link"><i class="bi bi-printer"></i> Cek Nilai dan Cetak PDF</a>

                    <div class="sidebar-section-title">PANDUAN GURU</div>
                    <a href="#guru-ttd" class="sidebar-link"><i class="bi bi-pen-fill"></i> Atur TTD Digital Guru</a>
                    <a href="#guru-soal" class="sidebar-link"><i class="bi bi-collection"></i> Tambah Bank Soal</a>
                    <a href="#guru-ujian" class="sidebar-link"><i class="bi bi-calendar-plus"></i> Buat Jadwal Ujian</a>
                    <a href="#guru-arsip" class="sidebar-link"><i class="bi bi-archive-fill"></i> Mengarsipkan Ujian</a>
                    <a href="#guru-periksa" class="sidebar-link"><i class="bi bi-check2-square"></i> Koreksi Jawaban Esai</a>
                    <a href="#guru-berita-acara" class="sidebar-link"><i class="bi bi-file-earmark-pdf"></i> Export Berita Acara</a>

                    <div class="sidebar-section-title">PANDUAN ADMIN</div>
                    <a href="#admin-dashboard" class="sidebar-link"><i class="bi bi-speedometer2"></i> Dashboard Analitik</a>
                    <a href="#admin-master" class="sidebar-link"><i class="bi bi-database"></i> Kelola Data Master</a>
                    <a href="#admin-monitoring" class="sidebar-link"><i class="bi bi-tv"></i> Live Monitoring dan Reset</a>
                    <a href="#admin-kelulusan" class="sidebar-link"><i class="bi bi-mortarboard-fill"></i> Kelulusan Kelas XII</a>
                    <a href="#admin-alumni" class="sidebar-link"><i class="bi bi-archive"></i> Tabel Alumni SMA 5</a>

                    <div class="sidebar-section-title">KEPALA SEKOLAH</div>
                    <a href="#kepsek-ttd" class="sidebar-link"><i class="bi bi-patch-check"></i> Pasang NIP dan TTD</a>
                    <a href="#kepsek-analitik" class="sidebar-link"><i class="bi bi-pie-chart"></i> Analisis Eksekutif</a>
                    <a href="#kepsek-monitoring" class="sidebar-link"><i class="bi bi-eye"></i> Pemantauan Live</a>
                    <a href="#kepsek-berita-acara" class="sidebar-link"><i class="bi bi-file-text"></i> Tinjau Berita Acara</a>

                    <div class="sidebar-section-title">BANTUAN</div>
                    <a href="#faq" class="sidebar-link"><i class="bi bi-question-circle"></i> Tanya Jawab Teknis</a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">

                <!-- =======================================================
                     1. FITUR BARU SIMORO v2.0
                     ======================================================= -->
                <section id="fitur-baru" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-stars text-danger"></i> Daftar Lengkap Fitur Baru SIMORO Versi 2.0
                        </h2>
                        <span class="doc-badge new">Rilis v2.0</span>
                    </div>
                    <p class="text-muted">Aplikasi SIMORO SMANLI versi 2.0 membawa pembaruan besar pada tata kelola ujian, otomatisasi administrasi guru, pengawasan integritas, analitik data sekolah, dan legalitas dokumen resmi.</p>

                    <div class="row g-3 mt-1">
                        <!-- Fitur 1: Arsip Ujian -->
                        <div class="col-md-6" id="fitur-arsip-ujian">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#f1f5f9;color:#475569;"><i class="bi bi-archive-fill"></i></div>
                                <h5 class="fw-bold">1. Arsip Ujian yang Selesai</h5>
                                <p class="text-muted small mb-2">Ujian yang telah selesai dilaksanakan dapat dipindahkan ke halaman Arsip Ujian. Hal ini menjaga agar daftar ujian aktif tetap bersih, teratur, dan tidak menumpuk saat ada puluhan ujian.</p>
                                <div class="small text-secondary fw-semibold">Ujian terarsip dapat dipulihkan kembali kapan saja jika dibutuhkan.</div>
                            </div>
                        </div>

                        <!-- Fitur 2: Berita Acara -->
                        <div class="col-md-6" id="fitur-berita-acara">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#eff6ff;color:#0d6efd;"><i class="bi bi-file-earmark-text-fill"></i></div>
                                <h5 class="fw-bold">2. Berita Acara Pelaksanaan CBT</h5>
                                <p class="text-muted small mb-2">Setiap guru mata pelajaran dapat menerbitkan Berita Acara Pelaksanaan Ujian secara instan, lengkap dengan absensi siswa hadir, nilai akhir, serta catatan integritas pengerjaan.</p>
                                <div class="small text-primary fw-semibold">Dapat langsung diunduh ke format PDF Resmi dan format Excel (.xlsx).</div>
                            </div>
                        </div>

                        <!-- Fitur 3: TTD Digital -->
                        <div class="col-md-6" id="fitur-ttd">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#f0fdf4;color:#10b981;"><i class="bi bi-pen-fill"></i></div>
                                <h5 class="fw-bold">3. Tanda Tangan Digital Resmi</h5>
                                <p class="text-muted small mb-2">Mendukung pembuatan tanda tangan digital melalui layar sentuh/mouse atau mengunggah gambar stempel/tanda tangan transparan berformat PNG. Otomatis disematkan pada seluruh dokumen cetak.</p>
                                <div class="small text-success fw-semibold">Memberikan keabsahan hukum pada Lembar Hasil Siswa dan Berita Acara.</div>
                            </div>
                        </div>

                        <!-- Fitur 4: Role Kepala Sekolah -->
                        <div class="col-md-6" id="fitur-role-kepsek">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#fae8ff;color:#a855f7;"><i class="bi bi-person-workspace"></i></div>
                                <h5 class="fw-bold">4. Portal Khusus Kepala Sekolah</h5>
                                <p class="text-muted small mb-2">Role independen untuk Kepala Sekolah dengan hak akses pemantauan (Read-Only) dan analitik eksekutif. Kepala Sekolah dapat memantau pengerjaan siswa dan meninjau berita acara ujian sekolah.</p>
                                <div class="small text-purple fw-semibold" style="color:#a855f7;">Lengkap dengan input NIP/NIK dan Tanda Tangan Digital Kepala Sekolah.</div>
                            </div>
                        </div>

                        <!-- Fitur 5: Kelulusan & Alumni -->
                        <div class="col-md-6" id="fitur-alumni">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#fef3c7;color:#f59e0b;"><i class="bi bi-mortarboard-fill"></i></div>
                                <h5 class="fw-bold">5. Kelulusan Khusus Kelas XII dan Tabel Alumni</h5>
                                <p class="text-muted small mb-2">Logika kelulusan khusus bagi siswa tingkat akhir (Kelas XII). Siswa yang berstatus Lulus otomatis dipindahkan ke Tabel Alumni SMA Negeri 5 per angkatan, akun CBT dinonaktifkan, dan dilepas dari rombel kelas aktif.</p>
                                <div class="small text-warning fw-semibold">Tersedia filter angkatan dan cetak Buku Induk Alumni resmi (PDF/Excel).</div>
                            </div>
                        </div>

                        <!-- Fitur 6: Analitik Dashboard -->
                        <div class="col-md-6" id="fitur-analitik">
                            <div class="feature-bento">
                                <div class="feature-bento-icon" style="background:#ecfeff;color:#06b6d4;"><i class="bi bi-bar-chart-fill"></i></div>
                                <h5 class="fw-bold">6. Dashboard Analitik Data Master</h5>
                                <p class="text-muted small mb-2">Penyajian data modern dengan 8 kartu indikator utama dan 4 grafik visual Chart.js: Distribusi Siswa per Kelas, Komposisi Bank Soal (PG vs Esai), Tren Ujian Bulanan, dan Sebaran Nilai Siswa (Grade A hingga E).</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- =======================================================
                     2. PANDUAN SISWA
                     ======================================================= -->
                <section id="panduan-siswa" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-person-circle text-success"></i> Panduan Lengkap untuk Siswa
                        </h2>
                        <span class="doc-badge student">Siswa</span>
                    </div>

                    <!-- Siswa 1 -->
                    <div class="step-card" id="siswa-login">
                        <div class="step-title">
                            <span class="step-num">1</span> Cara Login ke Aplikasi CBT SIMORO
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Buka browser (disarankan Google Chrome atau Microsoft Edge terbaru).</li>
                            <li>Buka portal login melalui tombol <span class="btn-tag primary">Login CBT</span> di pojok kanan atas halaman web.</li>
                            <li>Masukkan <strong>Email Siswa</strong> dan <strong>Password</strong> akun resmi yang telah dibagikan oleh pihak panitia / sekolah.</li>
                            <li>Tekan tombol <span class="btn-tag primary">Log in</span>.</li>
                        </ol>
                        <div class="callout callout-warning">
                            <strong>Perhatian untuk Siswa yang Sudah Lulus:</strong> Akun siswa yang telah dinyatakan Lulus akan berstatus Alumni dan tidak dapat login ke aplikasi CBT.
                        </div>
                    </div>

                    <!-- Siswa 2 -->
                    <div class="step-card" id="siswa-mulai">
                        <div class="step-title">
                            <span class="step-num">2</span> Cara Membuka dan Memulai Ujian Online
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Setelah berhasil login, klik menu <strong>Daftar Ujian</strong> pada bilah menu di sebelah kiri.</li>
                            <li>Cari mata pelajaran yang sedang diujikan dengan status <strong>"Aktif"</strong>.</li>
                            <li>Klik tombol <span class="btn-tag primary">Mulai Ujian</span> pada kartu ujian terkait.</li>
                            <li>Halaman akan menampilkan informasi ujian: Judul Ujian, Guru Pengampu, Jumlah Butir Soal, Durasi Waktu, dan Petunjuk Teknis.</li>
                            <li>Jika peramban meminta izin akses lokasi (GPS), klik <strong>"Allow" / "Izinkan"</strong>.</li>
                            <li>Tekan tombol <span class="btn-tag success">Mulai Sekarang</span>. Layar akan otomatis masuk ke mode ujian.</li>
                        </ol>
                    </div>

                    <!-- Siswa 3 -->
                    <div class="step-card" id="siswa-pengerjaan">
                        <div class="step-title">
                            <span class="step-num">3</span> Tata Cara Menjawab Soal Pilihan Ganda dan Esai
                        </div>
                        <ul class="small text-muted mb-2">
                            <li><strong>Soal Pilihan Ganda:</strong> Klik pada salah satu lingkaran opsi jawaban (A, B, C, atau D). Jawaban Anda langsung tersimpan secara otomatis oleh sistem.</li>
                            <li><strong>Soal Essay / Uraian:</strong> Ketik uraian jawaban Anda pada kotak editor teks yang disediakan.</li>
                            <li><strong>Navigasi Soal:</strong> Gunakan tombol <span class="btn-tag">Sebelumnya</span> dan <span class="btn-tag primary">Berikutnya</span> untuk berpindah soal.</li>
                            <li><strong>Nomor Soal Cepat:</strong> Perhatikan panel nomor soal di sisi samping:
                                <ul>
                                    <li>Nomor berwarna <strong>Abu-abu</strong> menandakan soal belum dijawab.</li>
                                    <li>Nomor berwarna <strong>Biru / Hijau</strong> menandakan soal sudah terisi.</li>
                                </ul>
                            </li>
                            <li><strong>Menyelesaikan Ujian:</strong> Pada nomor soal terakhir, klik tombol <span class="btn-tag danger">Selesai Ujian</span>. Kotak konfirmasi akan muncul, klik <strong>"Ya, Saya Yakin"</strong> untuk mengirim jawaban.</li>
                        </ul>
                    </div>

                    <!-- Siswa 4 -->
                    <div class="step-card" id="siswa-keamanan">
                        <div class="step-title">
                            <span class="step-num">4</span> Ketentuan Keamanan dan Anti-Curang (CBT Security)
                        </div>
                        <p class="text-muted small">Aplikasi SIMORO dilengkapi sensor pengawas pengerjaan daring:</p>
                        <div class="callout callout-danger">
                            <ul class="mb-0">
                                <li><strong>Dilarang Berpindah Tab atau Aplikasi:</strong> Jika Anda membuka tab browser lain, membuka aplikasi percakapan, atau split screen, sistem akan mencatat pelanggaran secara otomatis.</li>
                                <li><strong>Penguncian Sesi:</strong> Pelanggaran berulang akan mengakibatkan ujian Anda terkunci otomatis. Jika terkunci, Anda wajib melapor ke Pengawas / Admin untuk permohonan Reset Sesi.</li>
                                <li><strong>Waktu Berjalan Mundur:</strong> Waktu ujian akan terus berjalan. Jika durasi habis, sistem akan otomatis mengumpulkan jawaban terakhir Anda.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Siswa 5 -->
                    <div class="step-card" id="siswa-hasil">
                        <div class="step-title">
                            <span class="step-num">5</span> Melihat Hasil Nilai dan Cetak Lembar Hasil Ujian (PDF)
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Setelah guru selesai memeriksa jawaban, buka menu <strong>Riwayat Ujian</strong> pada sidebar siswa.</li>
                            <li>Pilih ujian yang diinginkan, lalu klik tombol <span class="btn-tag info">Lihat Hasil</span>.</li>
                            <li>Halaman akan menampilkan nilai akhir, predikat capaian (Grade A, B, C, D), status ketuntasan KKM, serta rincian jawaban.</li>
                            <li>Klik tombol <span class="btn-tag success">Cetak Hasil</span>. Dokumen PDF resmi akan terbuka dengan memuat Kop Surat Sekolah, Logo Resmi, serta <strong>Tanda Tangan Digital Kepala Sekolah dan Guru Pengampu</strong>.</li>
                        </ol>
                    </div>
                </section>

                <!-- =======================================================
                     3. PANDUAN GURU
                     ======================================================= -->
                <section id="panduan-guru" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-person-badge text-primary"></i> Panduan Lengkap untuk Guru Mata Pelajaran
                        </h2>
                        <span class="doc-badge teacher">Guru Pengampu</span>
                    </div>

                    <!-- Guru 1: TTD -->
                    <div class="step-card" id="guru-ttd">
                        <div class="step-title">
                            <span class="step-num">1</span> Mengatur Tanda Tangan Digital Guru
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Login dengan akun Guru Mata Pelajaran.</li>
                            <li>Klik menu <strong>TTD Digital</strong> pada navigasi samping.</li>
                            <li>Pilih salah satu dari 2 metode pengisian tanda tangan:
                                <ul>
                                    <li><strong>Metode Canvas:</strong> Buat coretan tanda tangan langsung pada kotak putih menggunakan mouse komputer atau layar sentuh ponsel/tablet.</li>
                                    <li><strong>Metode Upload Gambar:</strong> Klik tombol <span class="btn-tag">Upload Gambar TTD</span>, lalu pilih file gambar scan tanda tangan transparan (disarankan format PNG).</li>
                                </ul>
                            </li>
                            <li>Tekan tombol <span class="btn-tag primary">Simpan Tanda Tangan</span>.</li>
                        </ol>
                    </div>

                    <!-- Guru 2: Bank Soal -->
                    <div class="step-card" id="guru-soal">
                        <div class="step-title">
                            <span class="step-num">2</span> Cara Menambah dan Mengelola Bank Soal
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Klik menu <strong>Bank Soal</strong> (<span class="code-inline">/guru/soal</span>).</li>
                            <li>Gunakan filter <strong>Pilih Mata Pelajaran</strong> dan <strong>Pilih Kelas</strong> untuk menyaring butir soal yang bersangkutan.</li>
                            <li>Klik tombol <span class="btn-tag primary">+ Tambah Soal</span> di pojok kanan atas.</li>
                            <li>Pada formulir pembuatan soal:
                                <ul>
                                    <li>Pilih <strong>Tipe Soal</strong>: Pilih <em>Pilihan Ganda</em> atau <em>Essay / Uraian</em>.</li>
                                    <li>Ketik isi soal pada kotak <strong>Pertanyaan</strong> (Anda dapat menyisipkan gambar, rumus, atau tabel melalui ikon toolbar editor).</li>
                                    <li>Jika tipe Pilihan Ganda: Isi teks pada kotak <strong>Opsi A, Opsi B, Opsi C, Opsi D</strong>, lalu pilih <strong>Kunci Jawaban</strong> yang benar.</li>
                                </ul>
                            </li>
                            <li>Tekan tombol <span class="btn-tag success">Simpan Soal</span>.</li>
                        </ol>
                    </div>

                    <!-- Guru 3: Jadwal Ujian -->
                    <div class="step-card" id="guru-ujian">
                        <div class="step-title">
                            <span class="step-num">3</span> Cara Membuat dan Menjadwalkan Ujian Baru
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Klik menu <strong>Ujian</strong> pada sidebar guru.</li>
                            <li>Tekan tombol <span class="btn-tag primary">+ Buat Ujian Baru</span>.</li>
                            <li>Isi informasi formulir ujian:
                                <ul>
                                    <li><strong>Judul Ujian:</strong> Contoh: <em>Penilaian Akhir Semester Ganjil Biologi XII IPA 1</em>.</li>
                                    <li><strong>Mata Pelajaran:</strong> Pilih mata pelajaran yang Anda ampu.</li>
                                    <li><strong>Kelas Sasaran:</strong> Pilih rombel kelas yang ditugaskan mengikuti ujian.</li>
                                    <li><strong>Durasi Pengerjaan:</strong> Masukkan jumlah menit pengerjaan (contoh: 90 menit).</li>
                                    <li><strong>Waktu Mulai dan Waktu Selesai:</strong> Tentukan jadwal akses pengerjaan.</li>
                                </ul>
                            </li>
                            <li>Pilih butir-butir soal yang akan digunakan dari Bank Soal dengan mencentang kotak pilihan.</li>
                            <li>Ubah status ujian menjadi <strong>"Aktif"</strong> jika ujian siap diselenggarakan.</li>
                            <li>Tekan tombol <span class="btn-tag success">Simpan Jadwal Ujian</span>.</li>
                        </ol>
                    </div>

                    <!-- Guru 4: Arsip Ujian -->
                    <div class="step-card" id="guru-arsip">
                        <div class="step-title">
                            <span class="step-num">4</span> Cara Mengarsipkan Ujian yang Telah Selesai
                        </div>
                        <p class="text-muted small mb-2">Agar daftar ujian aktif tidak menumpuk saat sudah menyelenggarakan banyak ujian, gunakan fitur arsip:</p>
                        <ol class="small text-muted mb-2">
                            <li>Buka menu <strong>Ujian</strong>.</li>
                            <li>Pada kartu ujian yang sudah tuntas dan nilainya lengkap, klik tombol titik tiga atau tombol <span class="btn-tag warning">Arsipkan Ujian</span>.</li>
                            <li>Ujian akan dipindahkan ke halaman <strong>Arsip Ujian</strong>.</li>
                            <li>Untuk melihat kembali daftar ujian yang diarsipkan, klik tombol <span class="btn-tag">Buka Arsip Ujian</span> di bagian atas halaman. Jika diperlukan, Anda dapat menekan tombol <span class="btn-tag success">Pulihkan Ujian</span> untuk mengembalikannya ke daftar aktif.</li>
                        </ol>
                    </div>

                    <!-- Guru 5: Periksa Esai -->
                    <div class="step-card" id="guru-periksa">
                        <div class="step-title">
                            <span class="step-num">5</span> Cara Mengoreksi Jawaban Esai dan Memberi Nilai
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Buka menu <strong>Ujian</strong>, lalu klik tombol <span class="btn-tag info">Peserta dan Nilai</span> pada ujian yang ingin dinilai.</li>
                            <li>Daftar seluruh siswa yang telah menyelesaikan ujian akan tampil.</li>
                            <li>Klik tombol <span class="btn-tag primary">Periksa Jawaban</span> pada baris nama siswa.</li>
                            <li>Soal Pilihan Ganda telah diskor otomatis oleh sistem. Untuk butir soal Esai, baca uraian jawaban siswa lalu ketik angka nilai (skala 0 hingga 100) pada kolom skor esai.</li>
                            <li>Klik tombol <span class="btn-tag success">Simpan Nilai</span>. Nilai akhir gabungan siswa akan otomatis terhitung dan status ujian siswa berubah menjadi <em>Sudah Diperiksa</em>.</li>
                        </ol>
                    </div>

                    <!-- Guru 6: Berita Acara -->
                    <div class="step-card" id="guru-berita-acara">
                        <div class="step-title">
                            <span class="step-num">6</span> Cara Menerbitkan dan Mengunduh Berita Acara CBT
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Klik menu <strong>Berita Acara</strong> pada sidebar guru.</li>
                            <li>Pilih ujian yang telah terlaksana, lalu klik tombol <span class="btn-tag primary">Lihat Berita Acara</span>.</li>
                            <li>Sistem akan menyusun Berita Acara Pelaksanaan Ujian secara otomatis yang memuat:
                                <ul>
                                    <li>Identitas Ujian (Mata Pelajaran, Kelas, Hari/Tanggal, Waktu).</li>
                                    <li>Rekapitulasi Kehadiran Peserta (Jumlah Terdaftar, Hadir, Tidak Hadir).</li>
                                    <li>Daftar Lengkap Nama Siswa beserta Nilai Akhir yang diperoleh.</li>
                                    <li>Tanda Tangan Digital Guru Mata Pelajaran dan Kepala Sekolah.</li>
                                </ul>
                            </li>
                            <li>Tekan tombol <span class="btn-tag danger">Export PDF</span> untuk mengunduh berkas PDF siap cetak.</li>
                            <li>Tekan tombol <span class="btn-tag success">Export Excel</span> jika ingin menyimpan berkas dalam format spreadsheet.</li>
                        </ol>
                    </div>
                </section>

                <!-- =======================================================
                     4. PANDUAN ADMINISTRATOR
                     ======================================================= -->
                <section id="panduan-admin" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-shield-lock text-warning"></i> Panduan Lengkap untuk Administrator
                        </h2>
                        <span class="doc-badge admin">Administrator</span>
                    </div>

                    <!-- Admin 1: Dashboard -->
                    <div class="step-card" id="admin-dashboard">
                        <div class="step-title">
                            <span class="step-num">1</span> Membaca dan Menganalisis Dashboard Utama
                        </div>
                        <ul class="small text-muted mb-2">
                            <li><strong>8 Kartu Metrik Ringkasan:</strong> Menampilkan total Siswa Aktif, Siswa Lulus (Alumni), Total Guru Pengajar, Rombel Kelas, Total Butir Bank Soal (PG dan Esai), Ujian Aktif, Arsip Ujian, dan Sesi Peserta Selesai.</li>
                            <li><strong>Diagram Distribusi Siswa per Kelas:</strong> Grafik batang yang menunjukkan kepadatan dan jumlah siswa di setiap rombongan belajar.</li>
                            <li><strong>Diagram Komposisi Bank Soal:</strong> Diagram donat perbandingan jumlah butir soal Pilihan Ganda terhadap butir soal Esai/Uraian.</li>
                            <li><strong>Diagram Tren Pelaksanaan Ujian:</strong> Grafik garis aktivitas ujian dan jumlah peserta per bulan selama 6 bulan terakhir.</li>
                            <li><strong>Diagram Distribusi Grade Nilai:</strong> Sebaran pencapaian skor siswa berdasarkan Grade A (skor 85 ke atas), Grade B (70-84), Grade C (55-69), Grade D (40-54), dan Grade E (di bawah 40).</li>
                        </ul>
                    </div>

                    <!-- Admin 2: Data Master -->
                    <div class="step-card" id="admin-master">
                        <div class="step-title">
                            <span class="step-num">2</span> Pengelolaan Data Master Sekolah
                        </div>
                        <ul class="small text-muted mb-2">
                            <li><strong>Data Kelas (<span class="code-inline">/admin/kelas</span>):</strong> Tekan tombol <span class="btn-tag primary">+ Tambah Kelas</span> untuk membuat rombel baru (misal: XII IPA 1, XI IPS 1).</li>
                            <li><strong>Data Guru (<span class="code-inline">/admin/guru</span>):</strong> Tekan tombol <span class="btn-tag primary">+ Tambah Guru</span> untuk menambahkan akun pendidik beserta penugasan mata pelajaran dan nomor kontak.</li>
                            <li><strong>Data Siswa (<span class="code-inline">/admin/siswa</span>):</strong> Tekan tombol <span class="btn-tag primary">+ Tambah Siswa</span> untuk menginput nama siswa, NISN/NIS, kelas rombel, email, dan nomor WhatsApp.</li>
                            <li><strong>Mata Pelajaran (<span class="code-inline">/admin/mapel</span>):</strong> Kelola seluruh mata pelajaran kurikulum sekolah.</li>
                        </ul>
                    </div>

                    <!-- Admin 3: Monitoring & Reset -->
                    <div class="step-card" id="admin-monitoring">
                        <div class="step-title">
                            <span class="step-num">3</span> Live Monitoring CBT dan Reset Sesi Siswa
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Klik menu <strong>Monitoring CBT</strong> (<span class="code-inline">/admin/monitoring</span>).</li>
                            <li>Admin dapat melihat status pengerjaan seluruh siswa secara langsung (Sedang Mengerjakan, Selesai, atau Terdeteksi Pelanggaran).</li>
                            <li>Jika siswa mengalami kendala perangkat mati, browser tertutup tidak sengaja, atau sesi terkunci karena deteksi pergantian tab:
                                <ul>
                                    <li>Cari nama siswa pada tabel monitoring.</li>
                                    <li>Klik tombol <span class="btn-tag warning">Reset Sesi / Approve Reapply</span>.</li>
                                    <li>Status ujian siswa akan dibuka kembali sehingga siswa dapat melanjutkan pengerjaan tanpa mengulang dari awal.</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <!-- Admin 4: Kelulusan Kelas XII -->
                    <div class="step-card" id="admin-kelulusan">
                        <div class="step-title">
                            <span class="step-num">4</span> Alur Penetapan Kelulusan Siswa Tingkat Akhir (Kelas XII)
                        </div>
                        <div class="callout callout-info">
                            <strong>Khusus Siswa Tingkat Akhir:</strong> Fitur kelulusan hanya memproses siswa kelas XII dan tidak akan mempengaruhi ujian harian/UTS siswa kelas X dan XI.
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Buka menu <strong>Kelulusan dan Alumni</strong> &rarr; pilih <strong>Evaluasi Kelulusan</strong> (<span class="code-inline">/admin/kelulusan</span>).</li>
                            <li>Klik tombol <span class="btn-tag info">Tarik Siswa Kelas XII</span>.</li>
                            <li>Pada jendela pop-up:
                                <ul>
                                    <li>Pilih <strong>Rombel / Kelas</strong> (pilih kelas XII tertentu atau <em>Semua Kelas XII</em>).</li>
                                    <li>Isi <strong>Tahun Angkatan</strong> (contoh: <span class="code-inline">2026</span>).</li>
                                    <li>Isi <strong>Tahun Ajaran</strong> (contoh: <span class="code-inline">2025/2026</span>).</li>
                                    <li>Tekan tombol <span class="btn-tag primary">Tarik Data Siswa</span>.</li>
                                </ul>
                            </li>
                            <li>Siswa yang ditarik akan masuk ke daftar evaluasi dengan status <em>Pending</em>.</li>
                            <li>Untuk meluluskan siswa:
                                <ul>
                                    <li><strong>Per Siswa:</strong> Tekan tombol <span class="btn-tag success">Luluskan</span> pada baris siswa yang bersangkutan.</li>
                                    <li><strong>Secara Massal:</strong> Tekan tombol <span class="btn-tag success">Luluskan Semua Siswa Ini &rarr; Pindahkan ke Alumni</span> di bagian atas tabel.</li>
                                </ul>
                            </li>
                            <li><strong>Otomatisasi Sistem:</strong> Saat dinyatakan LULUS:
                                <ul>
                                    <li>Data siswa langsung dipindahkan ke <strong>Tabel Alumni SMA Negeri 5</strong>.</li>
                                    <li>Akun login siswa dinonaktifkan otomatis dari sistem ujian CBT.</li>
                                    <li>Siswa dilepas dari rombel kelas aktif (<span class="code-inline">class_id</span> diset kosong) sehingga data kelas aktif tetap bersih.</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <!-- Admin 5: Alumni -->
                    <div class="step-card" id="admin-alumni">
                        <div class="step-title">
                            <span class="step-num">5</span> Manajemen Tabel Alumni SMA 5 per Angkatan
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Buka menu <strong>Tabel Alumni SMA 5</strong> (<span class="code-inline">/admin/kelulusan/alumni</span>).</li>
                            <li>Gunakan dropdown <strong>Filter Angkatan</strong> untuk menyaring data alumni berdasarkan tahun kelulusan tertentu (contoh: Angkatan 2026, Angkatan 2025).</li>
                            <li>Tekan tombol <span class="btn-tag success">Export Excel Alumni</span> untuk mengunduh rekap spreadsheet alumni.</li>
                            <li>Tekan tombol <span class="btn-tag danger">Cetak Buku Alumni (PDF)</span> untuk menghasilkan dokumen Buku Induk Alumni resmi berformat cetak lengkap dengan Kop Surat Sekolah dan Tanda Tangan Kepala Sekolah.</li>
                            <li><strong>Fitur Pembatalan / Pemulihan:</strong> Jika ada siswa yang keliru diluluskan atau perlu diaktifkan kembali, klik tombol <span class="btn-tag warning">Pulihkan Siswa</span>. Akun siswa akan aktif kembali dan dikembalikan ke kelas asalnya.</li>
                        </ol>
                    </div>
                </section>

                <!-- =======================================================
                     5. PANDUAN KEPALA SEKOLAH
                     ======================================================= -->
                <section id="panduan-kepsek" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-briefcase text-purple" style="color:#8b5cf6;"></i> Panduan Portal Eksekutif Kepala Sekolah
                        </h2>
                        <span class="doc-badge kepsek">Kepala Sekolah</span>
                    </div>
                    <p class="text-muted small">Portal Kepala Sekolah dirancang dengan hak akses <em>Read-Only dan Executive Analytics</em> sehingga aman dari risiko perubahan data ujian secara tidak sengaja.</p>

                    <!-- Kepsek 1 -->
                    <div class="step-card" id="kepsek-ttd">
                        <div class="step-title">
                            <span class="step-num">1</span> Pengaturan Profil, NIP, NIK, dan TTD Digital Kepala Sekolah
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Login dengan akun resmi Kepala Sekolah yang telah didaftarkan oleh Administrator.</li>
                            <li>Klik menu <strong>TTD Digital</strong> pada sidebar Kepala Sekolah.</li>
                            <li>Pastikan kolom <strong>Nama Lengkap</strong>, <strong>NIP</strong>, dan <strong>NIK</strong> telah terisi dengan benar.</li>
                            <li>Gunakan canvas untuk menandatangani secara digital atau tekan tombol <strong>Upload Gambar TTD</strong> untuk mengunggah scan stempel/tanda tangan resmi.</li>
                            <li>Klik tombol <span class="btn-tag primary">Simpan Tanda Tangan</span>. TTD ini akan otomatis terpasang pada <em>Lembar Hasil Ujian Siswa (PDF), Berita Acara Ujian CBT, dan Buku Induk Alumni</em>.</li>
                        </ol>
                    </div>

                    <!-- Kepsek 2 -->
                    <div class="step-card" id="kepsek-analitik">
                        <div class="step-title">
                            <span class="step-num">2</span> Analisis Mutu Pembelajaran pada Dashboard Eksekutif
                        </div>
                        <ul class="small text-muted mb-2">
                            <li><strong>Rata-rata Nilai per Mata Pelajaran:</strong> Menampilkan grafik komparasi performa capaian siswa di setiap mata pelajaran.</li>
                            <li><strong>Persentase Ketuntasan KKM:</strong> Analisis persentase siswa yang berhasil mencapai standar nilai KKM sekolah.</li>
                            <li><strong>Tren Partisipasi Bulanan:</strong> Menunjukkan grafik keikutsertaan siswa dalam ujian CBT selama 6 bulan terakhir.</li>
                            <li><strong>Indeks Integritas Pengerjaan:</strong> Persentase kepatuhan pengerjaan siswa tanpa catatan pelanggaran anti-curang.</li>
                        </ul>
                    </div>

                    <!-- Kepsek 3 -->
                    <div class="step-card" id="kepsek-monitoring">
                        <div class="step-title">
                            <span class="step-num">3</span> Pemantauan Live Pelaksanaan Ujian (Monitoring)
                        </div>
                        <p class="text-muted small">Buka menu <strong>Monitoring CBT</strong> untuk memantau status pengerjaan seluruh ruang ujian dan siswa secara langsung dan aman (read-only).</p>
                    </div>

                    <!-- Kepsek 4 -->
                    <div class="step-card" id="kepsek-berita-acara">
                        <div class="step-title">
                            <span class="step-num">4</span> Peninjauan dan Pengesahan Berita Acara Ujian
                        </div>
                        <ol class="small text-muted mb-2">
                            <li>Klik menu <strong>Berita Acara</strong> pada portal Kepala Sekolah.</li>
                            <li>Pilih mata pelajaran atau ujian yang telah selesai dilaksanakan oleh guru.</li>
                            <li>Periksa rincian absensi kehadiran siswa, nama guru pengampu, serta perolehan skor ujian.</li>
                            <li>Klik tombol <span class="btn-tag danger">Download PDF Berita Acara</span> untuk menyimpan arsip dokumen resmi sekolah.</li>
                        </ol>
                    </div>
                </section>

                <!-- =======================================================
                     6. TANYA JAWAB & BANTUAN TEKNIS (FAQ)
                     ======================================================= -->
                <section id="faq" class="doc-section">
                    <div class="doc-section-header">
                        <h2 class="doc-section-title">
                            <i class="bi bi-question-circle text-info"></i> Tanya Jawab dan Solusi Kendala Teknis (FAQ)
                        </h2>
                        <span class="doc-badge" style="background:#e0f2fe;color:#0369a1;">Pusat Bantuan</span>
                    </div>

                    <div class="accordion" id="accordionFaq">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Pertanyaan 1: Apa yang harus dilakukan jika browser siswa tidak sengaja tertutup saat ujian berlangsung?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    Seluruh butir jawaban yang telah diklik oleh siswa tersimpan secara langsung di server database (real-time). Siswa cukup membuka kembali alamat aplikasi, melakukan login, lalu menekan tombol <strong>Lanjutkan Ujian</strong> selama sisa waktu durasi pengerjaan masih tersedia. Jika sesi terkunci karena sensor anti-curang, Pengawas atau Admin dapat menekan tombol <strong>Reset Sesi</strong> pada menu Monitoring.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Pertanyaan 2: Mengapa gambar pada dokumen cetak PDF lembar hasil siswa atau berita acara tidak muncul?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    Pada SIMORO versi 2.0, sistem generator PDF telah dilengkapi konverter otomatis path lokal storage server. Pastikan guru mengunggah gambar soal melalui menu toolbar editor soal dan telah menyimpan tanda tangan digital di menu TTD Digital.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Pertanyaan 3: Mengapa siswa yang sudah dinyatakan lulus tidak dapat login ke aplikasi CBT?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    Ini adalah fitur pengamanan data otomatis. Siswa yang berstatus <strong>Lulus</strong> pada menu Kelulusan akan otomatis dinonaktifkan akunnya dan dipindahkan ke <strong>Tabel Alumni SMA Negeri 5</strong> agar tidak dapat mengakses materi ujian siswa aktif. Jika siswa tersebut perlu diaktifkan kembali, Admin dapat menekan tombol <strong>Pulihkan Siswa</strong> pada Tabel Alumni.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Pertanyaan 4: Apa fungsi fitur Arsip Ujian dan kapan sebaiknya digunakan?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    Fitur <strong>Arsip Ujian</strong> digunakan saat ujian telah selesai dilaksanakan dan seluruh nilainya sudah diperiksa. Dengan mengarsipkan ujian, daftar ujian aktif di dashboard guru dan admin akan tetap rapi dan tidak lambat saat sekolah telah menyelenggarakan puluhan hingga ratusan ujian. Ujian yang diarsipkan tetap tersimpan aman dan dapat dibuka kembali kapan saja.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Pertanyaan 5: Apakah Kepala Sekolah dapat mengubah soal atau menghapus data ujian guru?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    Tidak. Role Kepala Sekolah dirancang secara khusus dengan prinsip <em>Read-Only dan Eksekutif Monitoring</em>. Kepala Sekolah hanya dapat melihat grafik analisis nilai, memantau live pengerjaan CBT, meninjau berita acara, dan mengesahkan dokumen melalui tanda tangan digital resmi.
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="docs-footer text-center">
        <div class="container">
            <div class="mb-2">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" style="height: 32px;" class="me-2">
                <strong>SIMORO SMANLI v2.0</strong> &mdash; Sistem Informasi Ujian Online SMA Negeri 5 Pulau Morotai
            </div>
            <div class="small">
                Alamat: Jl. Sabatai Tua, Kab. Pulau Morotai, Maluku Utara &bull; Hak Cipta &copy; {{ date('Y') }} SMA Negeri 5 Morotai.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/frondend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Pencarian Topik Real-Time
        document.getElementById('docSearch').addEventListener('input', function (e) {
            var term = e.target.value.toLowerCase();
            var cards = document.querySelectorAll('.step-card, .feature-bento, .accordion-item');
            
            cards.forEach(function (card) {
                var text = card.textContent.toLowerCase();
                if (term === '' || text.includes(term)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Tab Role Quick Navigation
        var tabBtns = document.querySelectorAll('.role-tab-btn');
        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                tabBtns.forEach(function(b) { b.classList.remove('active'); });
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
