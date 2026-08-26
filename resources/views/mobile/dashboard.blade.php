@extends('layouts.master')
@section('title', 'Pengaturan Aplikasi Mobile — SIMORO SMANLI')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,#0d6efd,#06b6d4); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.08); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.35rem; font-weight:800; margin:0 0 4px; }
.page-header p { font-size:0.88rem; opacity:0.9; margin:0; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color, #e2e8f0); box-shadow:0 1px 3px rgba(0,0,0,0.05); overflow:hidden; margin-bottom:24px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color, #e2e8f0); background:#f8fafc; display:flex; align-items:center; justify-content:space-between; font-weight:700; font-size:0.92rem; color:#0f172a; }
.panel-card-header i { color:#0d6efd; }
.panel-card-body { padding:22px; }

.form-label { font-size:0.84rem; font-weight:700; color:#334155; margin-bottom:6px; }
.form-control { border-radius:10px; border:1.5px solid #cbd5e1; padding:9px 14px; font-size:0.88rem; transition:all 0.2s ease; }
.form-control:focus { border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,0.12); }
.form-text { font-size:0.75rem; color:#64748b; margin-top:4px; }

.color-input-wrap { display:flex; align-items:center; gap:10px; }
.color-preview { width:42px; height:42px; border-radius:10px; border:2px solid #cbd5e1; cursor:pointer; padding:0; flex-shrink:0; }

.btn-save { background:#0d6efd; color:#fff; border:none; padding:10px 22px; border-radius:10px; font-weight:700; font-size:0.88rem; transition:all 0.2s ease; }
.btn-save:hover { background:#0a58ca; transform:translateY(-1px); }

.toggle-wrap { display:flex; align-items:center; justify-content:space-between; padding:14px 0; border-bottom:1px solid #f1f5f9; }
.toggle-wrap:last-child { border-bottom:none; }
.toggle-label { font-weight:700; font-size:0.88rem; color:#1e293b; }
.toggle-desc { font-size:0.78rem; color:#64748b; margin-top:2px; }
.toggle-switch { position:relative; width:48px; height:24px; flex-shrink:0; }
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#cbd5e1; transition:0.3s; border-radius:24px; }
.toggle-slider:before { position:absolute; content:""; height:18px; width:18px; left:3px; bottom:3px; background:#fff; transition:0.3s; border-radius:50%; }
.toggle-switch input:checked + .toggle-slider { background:#0d6efd; }
.toggle-switch input:checked + .toggle-slider:before { transform:translateX(24px); }

.asset-preview-img { max-height:60px; max-width:100px; border-radius:8px; border:1px solid #e2e8f0; object-fit:contain; background:#f8fafc; padding:4px; }
.toast-box { position:fixed; bottom:24px; right:24px; z-index:9999; background:#10b981; color:#fff; padding:14px 20px; border-radius:12px; font-weight:700; font-size:0.9rem; box-shadow:0 10px 25px rgba(0,0,0,0.15); display:none; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4><i class="bi bi-phone me-2"></i>Pengaturan Aplikasi Mobile SIMORO</h4>
            <p>Kelola Base URL Server, Logo, Animasi Lottie, Fitur CBT, dan Aturan Melanjutkan Ujian secara terpusat via API.</p>
        </div>
        <a href="{{ url('/api/config') }}" target="_blank" class="btn btn-light btn-sm fw-bold rounded-pill px-3 shadow-sm">
            <i class="bi bi-code-square me-1"></i> Preview JSON API
        </a>
    </div>
</div>

<div id="toastMessage" class="toast-box">
    <i class="bi bi-check-circle-fill me-2"></i> Konfigurasi berhasil disimpan & disinkronisasi ke API!
</div>

{{-- 1. App Info & Endpoints --}}
<div class="panel-card" id="appFormCard">
    <div class="panel-card-header">
        <span><i class="bi bi-globe me-2"></i> 1. Informasi Aplikasi & Endpoint Server (Base URL)</span>
        <span class="badge bg-primary">App & URLs</span>
    </div>
    <div class="panel-card-body">
        <form id="appForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Aplikasi Mobile</label>
                    <input type="text" class="form-control" name="app_name" id="app_name" placeholder="Contoh: SIMORO Mobile">
                    <div class="form-text">Nama aplikasi yang tampil pada header dan splash screen mobile.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Resmi Sekolah</label>
                    <input type="text" class="form-control" name="school_name" id="school_name" placeholder="SMA Negeri 5 Pulau Morotai">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-primary"><i class="bi bi-link-45deg me-1"></i> Base URL REST API (PENTING)</label>
                    <input type="text" class="form-control font-monospace" name="base_url" id="base_url" placeholder="http://127.0.0.1:8000/api">
                    <div class="form-text text-danger fw-semibold">Endpoint API yang dipanggil oleh aplikasi mobile saat runtime.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Web Portal URL</label>
                    <input type="text" class="form-control font-monospace" name="web_url" id="web_url" placeholder="http://127.0.0.1:8000">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tagline Aplikasi</label>
                    <input type="text" class="form-control" name="tagline" id="tagline" placeholder="Sistem Ujian Online & Informasi Akademik">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi Sekolah</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Pulau Morotai, Maluku Utara">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Versi Mobile Saat Ini</label>
                    <input type="text" class="form-control" name="version" id="version" placeholder="2.0.0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Versi Minimum (Force Update)</label>
                    <input type="text" class="form-control" name="min_version" id="min_version" placeholder="1.0.0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Link Google Play Store</label>
                    <input type="text" class="form-control" name="playstore_url" id="playstore_url" placeholder="https://play.google.com/...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Link Apple App Store</label>
                    <input type="text" class="form-control" name="appstore_url" id="appstore_url" placeholder="https://apps.apple.com/...">
                </div>
                <div class="col-md-12 pt-2 border-top">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <span class="fw-bold text-danger">Mode Pemeliharaan (Maintenance Mode)</span>
                            <div class="form-text">Jika diaktifkan, aplikasi mobile akan memblokir akses ujian dan menampilkan pesan maintenance.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <label class="form-label mt-2">Pesan Pemeliharaan (Maintenance Message)</label>
                    <input type="text" class="form-control" name="maintenance_message" id="maintenance_message" placeholder="Aplikasi sedang dalam pemeliharaan berkala...">
                </div>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-save me-1"></i> Simpan Info & Endpoint</button>
        </form>
    </div>
</div>

{{-- 2. Assets & Media Upload --}}
<div class="panel-card" id="assetSection">
    <div class="panel-card-header">
        <span><i class="bi bi-images me-2"></i> 2. Upload Logo & Gambar Onboarding Mobile</span>
        <span class="badge bg-secondary">Assets & Media</span>
    </div>
    <div class="panel-card-body">
        <form id="assetsForm" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Logo Utama Aplikasi (PNG/SVG)</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <img id="preview_logo" src="{{ asset('assets/img/icon.png') }}" class="asset-preview-img" alt="Logo Preview">
                        <input type="file" class="form-control" name="logo" id="input_logo" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Logo Splash Screen</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <img id="preview_splash_logo" src="{{ asset('assets/img/icon.png') }}" class="asset-preview-img" alt="Splash Preview">
                        <input type="file" class="form-control" name="splash_logo" id="input_splash_logo" accept="image/*">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gambar Onboarding Slide 1</label>
                    <input type="file" class="form-control mb-1" name="onboarding_1" accept="image/*">
                    <div id="path_onboarding_1" class="small text-muted font-monospace text-truncate"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gambar Onboarding Slide 2</label>
                    <input type="file" class="form-control mb-1" name="onboarding_2" accept="image/*">
                    <div id="path_onboarding_2" class="small text-muted font-monospace text-truncate"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gambar Onboarding Slide 3</label>
                    <input type="file" class="form-control mb-1" name="onboarding_3" accept="image/*">
                    <div id="path_onboarding_3" class="small text-muted font-monospace text-truncate"></div>
                </div>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-cloud-arrow-up me-1"></i> Upload Logo & Gambar</button>
        </form>
    </div>
</div>

{{-- 3. Lottie Animations --}}
<div class="panel-card" id="lottieSection">
    <div class="panel-card-header">
        <span><i class="bi bi-file-earmark-play me-2"></i> 3. Animasi Lottie (JSON Files & URLs)</span>
        <span class="badge bg-dark">Lottie Animations</span>
    </div>
    <div class="panel-card-body">
        <form id="lottieForm" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Animasi Splash Screen / Loading (Upload .json atau Input URL)</label>
                    <input type="file" class="form-control mb-2" name="lottie_splash_file" accept=".json">
                    <input type="text" class="form-control font-monospace" name="lottie_splash" id="lottie_splash" placeholder="https://assets.lottiefiles.com/...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Animasi Selesai Ujian / Nilai Sukses</label>
                    <input type="file" class="form-control mb-2" name="lottie_exam_success_file" accept=".json">
                    <input type="text" class="form-control font-monospace" name="lottie_exam_success" id="lottie_exam_success" placeholder="https://assets.lottiefiles.com/...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Animasi Countdown Timer</label>
                    <input type="file" class="form-control mb-2" name="lottie_exam_timer_file" accept=".json">
                    <input type="text" class="form-control font-monospace" name="lottie_exam_timer" id="lottie_exam_timer" placeholder="URL Lottie Timer...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Animasi Deteksi Curang (Warning)</label>
                    <input type="file" class="form-control mb-2" name="lottie_warning_cheat_file" accept=".json">
                    <input type="text" class="form-control font-monospace" name="lottie_warning_cheat" id="lottie_warning_cheat" placeholder="URL Lottie Warning...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Animasi Layar Maintenance</label>
                    <input type="file" class="form-control mb-2" name="lottie_maintenance_file" accept=".json">
                    <input type="text" class="form-control font-monospace" name="lottie_maintenance" id="lottie_maintenance" placeholder="URL Lottie Maintenance...">
                </div>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-save me-1"></i> Simpan Animasi Lottie</button>
        </form>
    </div>
</div>

{{-- 4. Theme & Colors --}}
<div class="panel-card" id="themeFormCard">
    <div class="panel-card-header">
        <span><i class="bi bi-palette me-2"></i> 4. Tema & Warna Branding Aplikasi Mobile</span>
        <span class="badge bg-success">Theme & Colors</span>
    </div>
    <div class="panel-card-body">
        <form id="themeForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Warna Utama (Primary)</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_primary" value="#0d6efd">
                        <input type="text" class="form-control" name="primary" id="primary">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Sekunder (Secondary)</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_secondary" value="#6c757d">
                        <input type="text" class="form-control" name="secondary" id="secondary">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Aksen (Accent)</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_accent" value="#06b6d4">
                        <input type="text" class="form-control" name="accent" id="accent">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Background Layar</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_background" value="#ffffff">
                        <input type="text" class="form-control" name="background" id="background">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Kartu (Surface)</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_surface" value="#f8f9fa">
                        <input type="text" class="form-control" name="surface" id="surface">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Error / Bahaya</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_error" value="#dc3545">
                        <input type="text" class="form-control" name="error" id="error">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Sukses / Benar</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_success" value="#198754">
                        <input type="text" class="form-control" name="success" id="success">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Teks Utama</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_text_primary" value="#212529">
                        <input type="text" class="form-control" name="text_primary" id="text_primary">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Warna Teks Sekunder</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_text_secondary" value="#6c757d">
                        <input type="text" class="form-control" name="text_secondary" id="text_secondary">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-save me-1"></i> Simpan Tema & Warna</button>
        </form>
    </div>
</div>

{{-- 5. Features & CBT Security Rules --}}
<div class="panel-card" id="featuresFormCard">
    <div class="panel-card-header">
        <span><i class="bi bi-shield-check me-2"></i> 5. Fitur, Aturan Ujian & Sensor Keamanan Mobile</span>
        <span class="badge bg-warning text-dark">Feature Flags & Rules</span>
    </div>
    <div class="panel-card-body">
        <form id="featuresForm">
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Izinkan Siswa Melanjutkan Ujian jika Terkeluar (Resume Exam)</div>
                    <div class="toggle-desc">Jika aplikasi tertutup tidak sengaja, siswa dapat langsung melanjutkan ujian tanpa perlu reset pengawas.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="allow_resume_exam" id="allow_resume_exam" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Kunci Otomatis saat Terdeteksi Pindah Layar (Auto-Lock on Cheat)</div>
                    <div class="toggle-desc">Otomatis mengunci sesi ujian jika siswa meminimalkan aplikasi melebihi batas toleransi.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="auto_lock_on_detect" id="auto_lock_on_detect" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="row align-items-center py-2 border-bottom">
                <div class="col-md-8">
                    <div class="toggle-label">Batas Toleransi Keluar Aplikasi / Pindah Tab (Max Exit Attempts)</div>
                    <div class="toggle-desc">Berapa kali siswa boleh meminimalkan aplikasi sebelum sesi ujian terkunci permanen (0 = Tanpa batas).</div>
                </div>
                <div class="col-md-4">
                    <input type="number" min="0" max="10" class="form-control w-50" name="max_exit_attempts" id="max_exit_attempts" placeholder="3">
                </div>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Wajibkan Akses Lokasi GPS Aktif sebelum Ujian (Require GPS)</div>
                    <div class="toggle-desc">Siswa tidak dapat menekan tombol mulai jika izin lokasi peramban/perangkat belum aktif.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="require_gps" id="require_gps" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Tampilkan Halaman Pengenalan (Onboarding Screen)</div>
                    <div class="toggle-desc">Tampilkan slide pengenalan saat siswa pertama kali membuka aplikasi.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="show_onboarding" id="show_onboarding" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Fitur Notifikasi Mobile</div>
                    <div class="toggle-desc">Aktifkan lonceng dan push pemberitahuan jadwal ujian di aplikasi.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="show_notifications" id="show_notifications" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Fitur Pengajuan Buka Sesi Ujian (Reapply)</div>
                    <div class="toggle-desc">Izinkan siswa mengajukan pembukaan sesi jika ujian terkunci karena kendala teknis.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="enable_reapply" id="enable_reapply" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Tampilkan Nilai Langsung setelah Selesai Ujian</div>
                    <div class="toggle-desc">Tampilkan skor dan status KKM siswa seketika setelah menekan tombol submit ujian.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="show_score_after_exam" id="show_score_after_exam" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Izinkan Siswa Melihat Pembahasan Soal</div>
                    <div class="toggle-desc">Izinkan siswa membuka kunci jawaban dan pembahasan setelah selesai ujian.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="allow_review_answers" id="allow_review_answers" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Izinkan Screenshot / Tangkapan Layar</div>
                    <div class="toggle-desc">Standar: Nonaktif (aplikasi memblokir tangkapan layar demi kerahasiaan soal).</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="allow_screenshot" id="allow_screenshot" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-save me-1"></i> Simpan Fitur & Aturan Ujian</button>
        </form>
    </div>
</div>

{{-- 6. Contact & Legal --}}
<div class="panel-card" id="contactFormCard">
    <div class="panel-card-header">
        <span><i class="bi bi-headset me-2"></i> 6. Kontak Bantuan & Informasi Hukum</span>
        <span class="badge bg-info text-dark">Contact & Legal</span>
    </div>
    <div class="panel-card-body">
        <form id="contactForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">WhatsApp Helpdesk CBT</label>
                    <input type="text" class="form-control" name="contact_whatsapp" id="contact_whatsapp" placeholder="081234567890">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Bantuan Sekolah</label>
                    <input type="email" class="form-control" name="contact_email" id="contact_email" placeholder="admin@sma5.sch.id">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL Kebijakan Privasi (Privacy Policy)</label>
                    <input type="text" class="form-control" name="privacy_policy_url" id="privacy_policy_url" placeholder="http://127.0.0.1:8000/docs#kebijakan-privasi">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL Syarat & Ketentuan (Terms of Service)</label>
                    <input type="text" class="form-control" name="terms_url" id="terms_url" placeholder="http://127.0.0.1:8000/docs#syarat-ketentuan">
                </div>
            </div>
            <button type="submit" class="btn-save mt-4"><i class="bi bi-save me-1"></i> Simpan Kontak & Legal</button>
        </form>
    </div>
</div>

{{-- 7. Manajemen Banner & Iklan Interaktif (Carousel / Promo M-Banking) --}}
<div class="panel-card" id="bannerCard">
    <div class="panel-card-header d-flex justify-content-between align-items-center">
        <div>
            <span><i class="bi bi-badge-ad me-2"></i> 7. Manajemen Banner Promo &amp; Iklan Mobile (Carousel M-Banking)</span>
            <span class="badge bg-warning text-dark ms-2">Dynamic Carousel</span>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddBanner">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Banner Baru
        </button>
    </div>
    <div class="panel-card-body">
        <p class="text-muted small mb-3">
            Banner ini akan tampil sebagai <strong>Carousel Slider interaktif</strong> di halaman utama aplikasi mobile siswa (persis seperti banner promo pada aplikasi M-Banking / Marketplace).
        </p>

        {{-- Live Carousel Simulation Preview --}}
        <div class="mb-4 p-3 bg-light rounded-4 border">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-dark small"><i class="bi bi-phone me-1 text-primary"></i> Preview Carousel di Layar HP Siswa</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle small">{{ count($banners ?? []) }} Banner Terdaftar</span>
            </div>
            
            <div id="bannerCarouselPreview" class="carousel slide rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel" style="max-width: 650px; margin: 0 auto; background: #000;">
                <div class="carousel-indicators">
                    @forelse($banners ?? [] as $idx => $b)
                        @if($b->is_active)
                            <button type="button" data-bs-target="#bannerCarouselPreview" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-current="{{ $idx === 0 ? 'true' : 'false' }}"></button>
                        @endif
                    @empty
                        <button type="button" data-bs-target="#bannerCarouselPreview" data-bs-slide-to="0" class="active"></button>
                    @endforelse
                </div>
                <div class="carousel-inner">
                    @forelse($banners ?? [] as $idx => $b)
                        @if($b->is_active)
                            <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" data-bs-interval="4000">
                                <div style="position: relative; height: 200px; width: 100%; overflow: hidden; background: #1e293b;">
                                    <img src="{{ $b->image_url }}" class="d-block w-100 h-100" style="object-fit: cover; opacity: 0.85;" alt="{{ $b->title }}">
                                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.75) 100%);"></div>
                                    <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; color: #fff; z-index: 2;">
                                        <span class="badge rounded-pill mb-1 px-2.5 py-1" style="background-color: {{ $b->badge_color }}; font-size: 0.7rem; font-weight: 700;">{{ $b->badge_text }}</span>
                                        <h6 class="fw-bold mb-0 text-white text-truncate">{{ $b->title }}</h6>
                                        @if($b->subtitle)
                                            <p class="small mb-0 text-white-50 text-truncate" style="font-size: 0.78rem;">{{ $b->subtitle }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="carousel-item active">
                            <div style="height: 180px; display: flex; align-items: center; justify-content: center; background: #0f172a; color: #fff;">
                                <div class="text-center p-3">
                                    <i class="bi bi-images fs-2 text-primary"></i>
                                    <p class="mb-0 mt-1 small">Belum ada banner aktif. Klik "Tambah Banner Baru" di atas.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarouselPreview" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarouselPreview" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>

        {{-- Table List Banners --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr class="small text-uppercase text-secondary">
                        <th style="width: 50px;">No</th>
                        <th style="width: 140px;">Gambar</th>
                        <th>Judul &amp; Subtitle</th>
                        <th>Badge &amp; Aksi</th>
                        <th style="width: 80px;">Urutan</th>
                        <th style="width: 100px;" class="text-center">Status</th>
                        <th style="width: 120px;" class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody id="bannerTableBody">
                    @forelse($banners ?? [] as $index => $banner)
                    <tr id="bannerRow-{{ $banner->id }}">
                        <td class="fw-bold text-muted small">{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="rounded-3 shadow-sm border" style="width: 120px; height: 65px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $banner->title }}</div>
                            @if($banner->subtitle)
                                <div class="small text-muted text-truncate" style="max-width: 280px;">{{ $banner->subtitle }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill mb-1" style="background-color: {{ $banner->badge_color }};">{{ $banner->badge_text }}</span>
                            <div class="small text-secondary">
                                @if($banner->action_type === 'url')
                                    <i class="bi bi-box-arrow-up-right text-primary me-1"></i> <a href="{{ $banner->action_value }}" target="_blank" class="text-decoration-none small text-truncate d-inline-block" style="max-width: 150px;">{{ $banner->action_value }}</a>
                                @elseif($banner->action_type === 'exam')
                                    <i class="bi bi-file-earmark-text text-warning me-1"></i> ID Ujian: {{ $banner->action_value }}
                                @elseif($banner->action_type === 'announcement')
                                    <i class="bi bi-megaphone text-info me-1"></i> Pengumuman
                                @else
                                    <i class="bi bi-dash text-muted me-1"></i> Tidak ada aksi
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $banner->order }}</span>
                        </td>
                        <td class="text-center">
                            <label class="toggle-switch d-inline-block">
                                <input type="checkbox" onchange="toggleBannerStatus({{ $banner->id }})" {{ $banner->is_active ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 me-1" onclick='openEditBannerModal(@json($banner))' title="Edit Banner">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="deleteBanner({{ $banner->id }})" title="Hapus Banner">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada banner iklan atau promo yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Banner Baru --}}
<div class="modal fade" id="modalAddBanner" tabindex="-1" aria-labelledby="modalAddBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalAddBannerLabel"><i class="bi bi-plus-circle me-2"></i> Tambah Banner Iklan / Promo Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mobile.banners.store') }}" method="POST" enctype="multipart/form-data" id="formAddBanner">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Judul Banner <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required placeholder="Contoh: Try Out Akbar CBT SMANLI 2026">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subtitle / Deskripsi Singkat</label>
                            <input type="text" class="form-control" name="subtitle" placeholder="Contoh: Asah kemampuanmu dan raih skor tertinggi!">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Upload Gambar Banner (File)</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <div class="form-text">Rekomendasi rasio: 16:9 atau 2:1 (Format PNG/JPG/WebP, max 5MB).</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Atau Gunakan Image URL</label>
                            <input type="url" class="form-control" name="image_url" placeholder="https://domain.com/banner.jpg">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Teks Badge / Tag</label>
                            <input type="text" class="form-control" name="badge_text" value="PROMO" placeholder="Contoh: HOT, PROMO, INFO">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Warna Badge</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" name="badge_color" value="#0d6efd">
                                <span class="small text-muted">Pilih Warna</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Urutan Prioritas</label>
                            <input type="number" class="form-control" name="order" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Aksi Saat Banner Diklik</label>
                            <select class="form-select" name="action_type" id="add_action_type">
                                <option value="none">Tidak ada aksi (Hanya Gambar)</option>
                                <option value="url">Buka Link Web Eksternal (URL)</option>
                                <option value="exam">Buka Halaman Ujian (ID Ujian)</option>
                                <option value="announcement">Buka Pop-up Pengumuman</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Target Nilai Aksi (URL / ID Ujian)</label>
                            <input type="text" class="form-control" name="action_value" placeholder="https://sma5morotai.sch.id atau ID Ujian">
                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" value="1" checked>
                                <label class="form-check-label fw-bold" for="add_is_active">Aktifkan &amp; Tayangkan di Carousel Mobile</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-save me-1"></i> Simpan Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Banner --}}
<div class="modal fade" id="modalEditBanner" tabindex="-1" aria-labelledby="modalEditBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalEditBannerLabel"><i class="bi bi-pencil-square me-2"></i> Edit Banner Iklan / Promo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditBanner" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Judul Banner <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="edit_title" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subtitle / Deskripsi Singkat</label>
                            <input type="text" class="form-control" name="subtitle" id="edit_subtitle">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Ganti Gambar Banner (File)</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Atau Update Image URL</label>
                            <input type="url" class="form-control" name="image_url" id="edit_image_url">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Teks Badge / Tag</label>
                            <input type="text" class="form-control" name="badge_text" id="edit_badge_text">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Warna Badge</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" name="badge_color" id="edit_badge_color">
                                <span class="small text-muted">Pilih Warna</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Urutan Prioritas</label>
                            <input type="number" class="form-control" name="order" id="edit_order" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Aksi Saat Diklik</label>
                            <select class="form-select" name="action_type" id="edit_action_type">
                                <option value="none">Tidak ada aksi (Hanya Gambar)</option>
                                <option value="url">Buka Link Web Eksternal (URL)</option>
                                <option value="exam">Buka Halaman Ujian (ID Ujian)</option>
                                <option value="announcement">Buka Pop-up Pengumuman</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Target Nilai Aksi (URL / ID Ujian)</label>
                            <input type="text" class="form-control" name="action_value" id="edit_action_value">
                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                                <label class="form-check-label fw-bold" for="edit_is_active">Aktifkan &amp; Tayangkan di Carousel Mobile</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-check-circle me-1"></i> Perbarui Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function showToast() {
    var toast = document.getElementById('toastMessage');
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
}

// Load current config from server
fetch('/mobile/config', { headers: { 'Accept': 'application/json' } })
.then(r => r.ok ? r.json() : {})
.then(res => {
    var data = res.data || {};
    
    // 1. App Info
    if (data.app) {
        ['app_name', 'school_name', 'tagline', 'location', 'base_url', 'web_url', 'version', 'min_version', 'playstore_url', 'appstore_url', 'maintenance_message'].forEach(k => {
            var el = document.getElementById(k);
            if (el && data.app[k] !== undefined) el.value = data.app[k] || '';
        });
        if (document.getElementById('maintenance_mode')) {
            document.getElementById('maintenance_mode').checked = !!data.app.maintenance_mode;
        }
    }

    // 2. Assets & Media
    if (data.assets) {
        if (data.assets.logo_url && document.getElementById('preview_logo')) {
            document.getElementById('preview_logo').src = data.assets.logo_url;
        }
        if (data.assets.splash_logo_url && document.getElementById('preview_splash_logo')) {
            document.getElementById('preview_splash_logo').src = data.assets.splash_logo_url;
        }
        if (document.getElementById('path_onboarding_1')) {
            document.getElementById('path_onboarding_1').textContent = data.assets.onboarding_img_1 || '';
        }
        if (document.getElementById('path_onboarding_2')) {
            document.getElementById('path_onboarding_2').textContent = data.assets.onboarding_img_2 || '';
        }
        if (document.getElementById('path_onboarding_3')) {
            document.getElementById('path_onboarding_3').textContent = data.assets.onboarding_img_3 || '';
        }
    }

    // 3. Lottie Animations
    if (data.lottie) {
        ['lottie_splash', 'lottie_exam_success', 'lottie_exam_timer', 'lottie_warning_cheat', 'lottie_maintenance'].forEach(k => {
            var el = document.getElementById(k);
            if (el && data.lottie[k] !== undefined) el.value = data.lottie[k] || '';
        });
    }

    // 4. Theme Colors
    if (data.theme) {
        ['primary', 'secondary', 'accent', 'background', 'surface', 'error', 'success', 'text_primary', 'text_secondary'].forEach(c => {
            var textEl = document.getElementById(c);
            var colorEl = document.getElementById('color_' + c);
            if (textEl && data.theme[c] !== undefined) textEl.value = data.theme[c];
            if (colorEl && data.theme[c] !== undefined) colorEl.value = data.theme[c];
        });
    }

    // 5. Features & Security Rules
    if (data.features) {
        ['show_onboarding', 'show_notifications', 'enable_location_tracking', 'require_gps', 'enable_anti_cheat', 'auto_lock_on_detect', 'allow_resume_exam', 'enable_reapply', 'allow_screenshot', 'show_score_after_exam', 'allow_review_answers'].forEach(f => {
            var el = document.getElementById(f);
            if (el && data.features[f] !== undefined) el.checked = !!data.features[f];
        });
        if (document.getElementById('max_exit_attempts')) {
            document.getElementById('max_exit_attempts').value = data.features.max_exit_attempts ?? 3;
        }
    }

    // 6. Contact
    if (data.contact) {
        ['contact_whatsapp', 'contact_email', 'privacy_policy_url', 'terms_url'].forEach(k => {
            var el = document.getElementById(k);
            if (el && data.contact[k] !== undefined) el.value = data.contact[k] || '';
        });
    }
});

// Color picker sync
document.querySelectorAll('.color-preview').forEach(picker => {
    picker.addEventListener('input', function() {
        var name = this.id.replace('color_', '');
        var textEl = document.getElementById(name);
        if (textEl) textEl.value = this.value;
    });
});

// Form Submits
function handleFormSubmit(formId, endpoint) {
    document.getElementById(formId).addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        // Handle un-checked checkboxes
        this.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            formData.set(cb.name, cb.checked ? '1' : '0');
        });

        fetch(endpoint, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) showToast();
        })
        .catch(err => alert('Gagal menyimpan konfigurasi: ' + err));
    });
}

handleFormSubmit('appForm', '/mobile/config/app');
handleFormSubmit('assetsForm', '/mobile/config/assets');
handleFormSubmit('lottieForm', '/mobile/config/lottie');
handleFormSubmit('themeForm', '/mobile/config/theme');
handleFormSubmit('featuresForm', '/mobile/config/features');
handleFormSubmit('contactForm', '/mobile/config/contact');

// Banner JS Operations
function openEditBannerModal(banner) {
    var form = document.getElementById('formEditBanner');
    form.action = '/mobile/banners/' + banner.id;
    
    document.getElementById('edit_title').value = banner.title || '';
    document.getElementById('edit_subtitle').value = banner.subtitle || '';
    document.getElementById('edit_image_url').value = (banner.image && banner.image.startsWith('http')) ? banner.image : '';
    document.getElementById('edit_badge_text').value = banner.badge_text || 'INFO';
    document.getElementById('edit_badge_color').value = banner.badge_color || '#0d6efd';
    document.getElementById('edit_order').value = banner.order || 1;
    document.getElementById('edit_action_type').value = banner.action_type || 'none';
    document.getElementById('edit_action_value').value = banner.action_value || '';
    document.getElementById('edit_is_active').checked = !!banner.is_active;

    var modal = new bootstrap.Modal(document.getElementById('modalEditBanner'));
    modal.show();
}

function toggleBannerStatus(id) {
    fetch('/mobile/banners/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            showToast();
        } else {
            alert(d.message || 'Gagal mengubah status banner.');
        }
    })
    .catch(err => alert('Error: ' + err));
}

function deleteBanner(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus banner iklan ini?')) return;

    fetch('/mobile/banners/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            var row = document.getElementById('bannerRow-' + id);
            if (row) row.remove();
            showToast();
        } else {
            alert(d.message || 'Gagal menghapus banner.');
        }
    })
    .catch(err => alert('Error: ' + err));
}
</script>
@endpush
