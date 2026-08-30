<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Kebijakan Privasi (Privacy Policy) — MORO⁵SMART & SIMORO SMAN 5 Pulau Morotai</title>
    <meta name="description" content="Kebijakan Privasi resmi aplikasi mobile MORO⁵SMART dan platform SIMORO SMA Negeri 5 Pulau Morotai untuk perlindungan data siswa, guru, dan staf.">
    <meta name="keywords" content="Privacy Policy MORO5SMART, Kebijakan Privasi SIMORO, SMAN 5 Morotai Privacy Policy">

    <!-- Favicon -->
    <link href="{{ asset('assets/frondend/assets/img/favicon.svg') }}" rel="icon" type="image/svg+xml">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --primary-soft: #f0f9ff;
            --accent: #06b6d4;
            --secondary: #10b981;
            --danger: #ef4444;
            --ink: #0f172a;
            --ink-muted: #64748b;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --radius-lg: 20px;
            --radius-md: 14px;
            --shadow-md: 0 10px 30px -5px rgba(2, 132, 199, 0.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--ink);
            line-height: 1.7;
        }

        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .hero-banner {
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 50%, #06b6d4 100%);
            color: white;
            padding: 60px 0 50px;
            border-radius: 0 0 32px 32px;
            margin-bottom: 40px;
        }

        .policy-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.82rem;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .policy-item {
            margin-bottom: 32px;
        }

        .policy-item h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .policy-item h3 i {
            color: var(--primary);
        }

        .permission-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 22px;
            margin-bottom: 14px;
            border-left: 4px solid var(--primary);
        }

        .permission-box.danger-border {
            border-left-color: var(--danger);
        }

        .permission-box.success-border {
            border-left-color: var(--secondary);
        }

        .permission-name {
            font-weight: 800;
            color: var(--ink);
            font-size: 0.98rem;
            margin-bottom: 4px;
        }

        .permission-desc {
            font-size: 0.9rem;
            color: var(--ink-muted);
            margin-bottom: 0;
        }

        .footer-custom {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 30px 0;
            margin-top: 60px;
            font-size: 0.9rem;
            color: var(--ink-muted);
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark text-decoration-none" href="/">
                <span class="badge bg-primary px-2.5 py-1.5 rounded-3 fw-bold">MORO⁵</span>
                <span style="letter-spacing: -0.5px; color: var(--primary-dark);">SMART & SIMORO</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="/" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                    <i class="bi bi-house-door me-1"></i> Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Header -->
    <header class="hero-banner text-center">
        <div class="container">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                <i class="bi bi-shield-check me-1"></i> KEBIJAKAN PRIVASI RESMI
            </span>
            <h1 class="fw-bolder mb-2" style="font-size: 2.3rem;">Kebijakan Privasi MORO⁵SMART</h1>
            <p class="lead mb-0 opacity-90 mx-auto" style="max-width: 680px; font-size: 1.05rem;">
                SMA Negeri 5 Pulau Morotai berkomitmen penuh untuk melindungi privasi dan keamanan data seluruh siswa, guru, satpam, dan orang tua.
            </p>
            <p class="small mt-3 mb-0 opacity-75">Terakhir Diperbarui: 31 Agustus 2026</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="policy-card">
                    <!-- 1. Pendahuluan -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-info-circle"></i> 1. Pendahuluan</div>
                        <h3><i class="bi bi-building"></i> Tentang Aplikasi & Pengembang</h3>
                        <p>
                            Aplikasi mobile <strong>MORO⁵SMART</strong> dan platform web <strong>SIMORO</strong> (Sistem Informasi Manajemen & CBT Online) dikembangkan dan dikelola secara resmi oleh <strong>SMA Negeri 5 Pulau Morotai</strong>, beralamat di Kabupaten Pulau Morotai, Provinsi Maluku Utara, Indonesia.
                        </p>
                        <p>
                            Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan aplikasi mobile MORO⁵SMART maupun platform SIMORO. Dengan mengunduh dan menggunakan aplikasi ini, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini.
                        </p>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 2. Data yang Dikumpulkan -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-database-check"></i> 2. Informasi yang Kami Kumpulkan</div>
                        <h3><i class="bi bi-person-lines-fill"></i> Data Pengguna & Akademik</h3>
                        <p>Kami hanya mengumpulkan data yang diperlukan secara sah untuk operasional administrasi sekolah, proses belajar-mengajar, dan keamanan lingkungan sekolah:</p>
                        <ul>
                            <li><strong>Identitas Akun</strong>: Nama lengkap, Nomor Induk Siswa Nasional (NISN), Nomor Induk Siswa (NIS), Nomor Induk Pegawai (NIP), kelas, rombongan belajar, agama/kepercayaan (untuk penyesuaian soal ujian Pendidikan Agama), dan alamat email resmi.</li>
                            <li><strong>Data Kehadiran & Gerbang</strong>: Waktu presensi masuk dan pulang di pos gerbang sekolah atau kelas, status kehadiran (hadir/terlambat/izin/sakit), dan log scan barcode/QR.</li>
                            <li><strong>Data Evaluasi & CBT</strong>: Riwayat pengerjaan ujian berbasis komputer (CBT), jawaban soal, nilai tugas, dan materi bahan ajar.</li>
                            <li><strong>Tanda Tangan Digital</strong>: Goresan tanda tangan digital siswa/guru yang disimpan untuk dicantumkan secara sah pada Berita Acara Ujian dan Kartu Ujian.</li>
                        </ul>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 3. Penggunaan Izin Perangkat Sensitif -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-shield-lock"></i> 3. Izin Akses Perangkat (Device Permissions)</div>
                        <h3><i class="bi bi-phone"></i> Transparansi Penggunaan Izin Khusus</h3>
                        <p>Aplikasi MORO⁵SMART meminta izin tertentu pada perangkat Android/iOS Anda dengan tujuan operasional yang jelas sebagai berikut:</p>

                        <!-- Kamera -->
                        <div class="permission-box">
                            <div class="permission-name"><i class="bi bi-camera-video me-1 text-primary"></i> Kamera (android.permission.CAMERA)</div>
                            <p class="permission-desc">
                                Digunakan <strong>semata-mata untuk memindai QR Code</strong> pada Kartu Pelajar Digital, QR Code Pos Gerbang Satpam, dan QR Code Login Ruang Ujian CBT. Kamera <strong>tidak pernah</strong> merekam diam-diam, tidak mengambil foto tanpa persetujuan, dan tidak menyiarkan rekaman video ke pihak ketiga manapun.
                            </p>
                        </div>

                        <!-- Lokasi -->
                        <div class="permission-box">
                            <div class="permission-name"><i class="bi bi-geo-alt me-1 text-primary"></i> Lokasi (ACCESS_FINE_LOCATION & ACCESS_COARSE_LOCATION)</div>
                            <p class="permission-desc">
                                Digunakan untuk <strong>verifikasi radius kehadiran (Geofencing)</strong> saat siswa atau guru melakukan presensi di lingkungan SMA Negeri 5 Pulau Morotai. Data koordinat GPS hanya diproses saat proses presensi berlangsung dan <strong>tidak pernah</strong> melacak pergerakan pengguna di luar jam sekolah.
                            </p>
                        </div>

                        <!-- Biometrik / Sidik Jari -->
                        <div class="permission-box success-border">
                            <div class="permission-name"><i class="bi bi-fingerprint me-1 text-success"></i> Autentikasi Biometrik (USE_BIOMETRIC & USE_FINGERPRINT)</div>
                            <p class="permission-desc">
                                Digunakan untuk fitur <strong>Login Cepat dengan Sidik Jari</strong> pada perangkat yang mendukung. 
                                <br><strong>PENTING:</strong> Data fisik sidik jari diproses secara lokal 100% oleh sistem keamanan perangkat (Android Keystore / Secure Enclave). Aplikasi MORO⁵SMART dan server SMA Negeri 5 Pulau Morotai <strong>TIDAK PERNAH mengakses, membaca, atau menyimpan data sidik jari Anda di server</strong>.
                            </p>
                        </div>

                        <!-- Notifikasi & Alarm -->
                        <div class="permission-box">
                            <div class="permission-name"><i class="bi bi-bell me-1 text-primary"></i> Notifikasi & Pengingat Alarm (POST_NOTIFICATIONS)</div>
                            <p class="permission-desc">
                                Digunakan untuk mengirimkan <strong>pengumuman resmi sekolah, pengingat jadwal ujian CBT, dan alarm batas waktu penutupan gerbang sekolah</strong> agar siswa tidak terlambat. Pengguna dapat mengatur atau menonaktifkan nada alarm melalui menu pengaturan profil.
                            </p>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 4. Keamanan & Penyimpanan Data -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-lock"></i> 4. Keamanan & Enkripsi Data</div>
                        <h3><i class="bi bi-shield-shaded"></i> Perlindungan Informasi</h3>
                        <p>
                            Seluruh komunikasi data antara aplikasi MORO⁵SMART dan server SIMORO dilindungi menggunakan protokol enkripsi standar industri <strong>HTTPS / TLS 1.3</strong>. Token otentikasi disimpan dalam penyimpanan terenkripsi perangkat (Flutter Secure Storage / Android EncryptedSharedPreferences).
                        </p>
                        <p>
                            <strong>Kami tidak menjual, menyewakan, atau membagikan data pribadi siswa/guru kepada pengiklan, pihak ketiga komersial, atau platform pemasaran manapun.</strong> Data hanya digunakan secara eksklusif untuk kepentingan pendidikan di lingkungan SMA Negeri 5 Pulau Morotai.
                        </p>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 5. Perlindungan Privasi Anak & Siswa -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-people"></i> 5. Privasi Siswa Di Bawah Umur</div>
                        <h3><i class="bi bi-person-heart"></i> Komitmen Terhadap Perlindungan Anak</h3>
                        <p>
                            Sebagian besar pengguna aplikasi MORO⁵SMART adalah siswa sekolah menengah atas (usia 15–18 tahun). Pendaftaran akun dilakukan secara terpusat oleh Administrator SMA Negeri 5 Pulau Morotai dengan persetujuan pihak sekolah dan wali murid. Tidak ada konten komersial, iklan pihak ketiga, atau pelacakan perilaku yang ditujukan kepada siswa di dalam aplikasi ini.
                        </p>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 6. Hak Pengguna & Penghapusan Data -->
                    <div class="policy-item">
                        <div class="section-badge"><i class="bi bi-trash3"></i> 6. Hak Akses & Penghapusan Data</div>
                        <h3><i class="bi bi-person-x"></i> Permohonan Hapus Akun / Data (Data Deletion)</h3>
                        <p>
                            Siswa yang telah lulus atau mutasi dari SMA Negeri 5 Pulau Morotai dapat meminta penonaktifan akun atau penghapusan data riwayat pribadi dengan menghubungi operator/admin SIMORO sekolah melalui email resmi: <strong>sman5morotai@gmail.com</strong> atau datang langsung ke ruang Tata Usaha SMA Negeri 5 Pulau Morotai.
                        </p>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">

                    <!-- 7. Kontak Resmi -->
                    <div class="policy-item mb-0">
                        <div class="section-badge"><i class="bi bi-envelope"></i> 7. Hubungi Kami</div>
                        <h3><i class="bi bi-geo-alt-fill"></i> Layanan Informasi & Kontak</h3>
                        <p>Jika Anda memiliki pertanyaan, saran, atau permohonan terkait Kebijakan Privasi ini, silakan hubungi tim pengelola:</p>
                        <div class="bg-light p-3.5 rounded-3 border">
                            <p class="mb-1 fw-bold text-dark">SMA NEGERI 5 PULAU MOROTAI</p>
                            <p class="mb-1 text-muted small"><i class="bi bi-geo-alt me-1"></i> Kabupaten Pulau Morotai, Provinsi Maluku Utara, Indonesia</p>
                            <p class="mb-1 text-muted small"><i class="bi bi-envelope me-1"></i> Email: <a href="mailto:sman5morotai@gmail.com" class="text-decoration-none">sman5morotai@gmail.com</a></p>
                            <p class="mb-0 text-muted small"><i class="bi bi-globe me-1"></i> Website Resmi: <a href="https://sma-n5-morotai.id" target="_blank" class="text-decoration-none">https://sma-n5-morotai.id</a></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-1 fw-semibold text-dark">© 2026 SMA Negeri 5 Pulau Morotai. All Rights Reserved.</p>
            <p class="small text-muted mb-0">Sistem Informasi Manajemen & CBT Online (SIMORO) — Aplikasi Mobile MORO⁵SMART</p>
        </div>
    </footer>

</body>
</html>
