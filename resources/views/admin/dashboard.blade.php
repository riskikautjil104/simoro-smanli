@extends('layouts.master')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* =============================================
       VARIABLES — identik dengan welcome & login
    ============================================= */
    :root {
        --primary:      #0d6efd;
        --primary-dark: #0a58ca;
        --accent:       #0dcaf0;
        --secondary:    #20c997;
        --warning:      #fd7e14;
        --danger:       #dc3545;
        --bg-page:      #f0f4ff;
        --bg-card:      #ffffff;
        --text-main:    #1a1a2e;
        --text-muted:   #6c757d;
        --radius:       16px;
        --shadow:       0 2px 16px rgba(13,110,253,0.08);
        --shadow-hover: 0 8px 32px rgba(13,110,253,0.16);
        --transition:   all 0.3s ease;
    }

    body { background: var(--bg-page) !important; }

    /* =============================================
       WELCOME BANNER
    ============================================= */
    .dash-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: var(--radius);
        padding: 32px 36px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .dash-banner::before {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
        top: -100px; right: 200px;
        pointer-events: none;
    }

    .dash-banner::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        bottom: -60px; right: 320px;
        pointer-events: none;
    }

    .dash-banner-content { position: relative; z-index: 2; }

    .dash-banner h5 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .dash-banner p {
        font-size: 0.9rem;
        opacity: 0.88;
        margin-bottom: 20px;
        max-width: 480px;
        line-height: 1.6;
    }

    .dash-banner .btn-banner {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.5);
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: var(--transition);
    }

    .dash-banner .btn-banner:hover {
        background: rgba(255,255,255,0.35);
        color: #fff;
        transform: translateY(-2px);
    }

    .dash-banner-img {
        position: absolute;
        right: 0; bottom: 0;
        height: 100%;
        max-height: 180px;
        opacity: 0.18;
        pointer-events: none;
        z-index: 1;
    }

    /* =============================================
       STAT CARDS
    ============================================= */
    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 24px 20px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(13,110,253,0.06);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: var(--transition);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-icon.blue   { background: rgba(13,110,253,0.1);  color: var(--primary); }
    .stat-icon.cyan   { background: rgba(13,202,240,0.1);  color: #0aa2c0; }
    .stat-icon.green  { background: rgba(32,201,151,0.1);  color: var(--secondary); }
    .stat-icon.orange { background: rgba(253,126,20,0.12); color: var(--warning); }

    .stat-body { flex: 1; min-width: 0; }

    .stat-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-desc {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .stat-trend {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .stat-trend.up   { background: rgba(32,201,151,0.12); color: var(--secondary); }
    .stat-trend.info { background: rgba(13,110,253,0.10); color: var(--primary); }

    /* =============================================
       CHART CARDS
    ============================================= */
    .chart-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(13,110,253,0.06);
        height: 100%;
    }

    .chart-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .chart-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 2px;
    }

    .chart-card-sub {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .chart-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .chart-badge.blue   { background: rgba(13,110,253,0.10); color: var(--primary); }
    .chart-badge.green  { background: rgba(32,201,151,0.10); color: var(--secondary); }
    .chart-badge.cyan   { background: rgba(13,202,240,0.12); color: #0aa2c0; }

    .chart-big-num {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1;
        margin-bottom: 2px;
    }

    /* =============================================
       SKELETON LOADER
    ============================================= */
    .skeleton {
        background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 50%, #e9ecef 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s infinite;
        border-radius: 8px;
    }

    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .skeleton-num {
        height: 2rem;
        width: 60px;
        display: inline-block;
        vertical-align: middle;
    }

    /* =============================================
       SECTION LABEL
    ============================================= */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 12px;
        padding-left: 2px;
    }

    /* Fade in animation */
    .fade-up {
        animation: fadeUp 0.5s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .delay-1 { animation-delay: 0.08s; }
    .delay-2 { animation-delay: 0.16s; }
    .delay-3 { animation-delay: 0.24s; }
    .delay-4 { animation-delay: 0.32s; }
    .delay-5 { animation-delay: 0.40s; }
    .delay-6 { animation-delay: 0.48s; }
</style>
@endpush

@section('layoutContent')

{{-- ── WELCOME BANNER ── --}}
<div class="dash-banner fade-up">
    <div class="dash-banner-content">
        <h5>👋 Selamat Datang, Admin!</h5>
        <p>Kelola data siswa, guru, kelas, mata pelajaran, ujian, soal, monitoring, dan laporan hasil ujian di satu tempat.</p>
        <a href="/admin/ujian" class="btn-banner">
            <i class="bi bi-play-fill"></i> Kelola Ujian
        </a>
    </div>
    <img src="{{ asset('assets/img/people.svg') }}" alt="" class="dash-banner-img">
</div>

{{-- ── STAT CARDS ── --}}
<div class="section-label">Ringkasan Data</div>
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3 fade-up delay-1">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Siswa</div>
                <div class="stat-value" id="val-siswa">
                    <span class="skeleton skeleton-num"></span>
                </div>
                <div class="stat-desc">Siswa aktif terdaftar</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-up delay-2">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Guru</div>
                <div class="stat-value" id="val-guru">
                    <span class="skeleton skeleton-num"></span>
                </div>
                <div class="stat-desc">Guru pengajar aktif</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-up delay-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Kelas</div>
                <div class="stat-value" id="val-kelas">
                    <span class="skeleton skeleton-num"></span>
                </div>
                <div class="stat-desc">Kelas aktif</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3 fade-up delay-4">
        <div class="stat-card">
            <div class="stat-icon cyan">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Mapel</div>
                <div class="stat-value" id="val-mapel">
                    <span class="skeleton skeleton-num"></span>
                </div>
                <div class="stat-desc">Mata pelajaran aktif</div>
            </div>
        </div>
    </div>

</div>

{{-- ── CHARTS ROW 1 ── --}}
<div class="section-label">Statistik Ujian</div>
<div class="row g-3 mb-4">

    <div class="col-12 col-md-6 fade-up delay-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title">Total Ujian</div>
                    <div class="chart-big-num" id="val-ujian">
                        <span class="skeleton skeleton-num"></span>
                    </div>
                    <div class="chart-card-sub">Ujian aktif &amp; selesai</div>
                </div>
                <span class="chart-badge blue">
                    <i class="bi bi-clipboard-data"></i> Ujian
                </span>
            </div>
            <canvas id="chartUjian" height="110"></canvas>
        </div>
    </div>

    <div class="col-12 col-md-6 fade-up delay-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title">Monitoring Ujian</div>
                    <div class="chart-big-num" id="val-peserta">
                        <span class="skeleton skeleton-num"></span>
                    </div>
                    <div class="chart-card-sub">Peserta ujian online</div>
                </div>
                <span class="chart-badge green">
                    <i class="bi bi-activity"></i> Peserta
                </span>
            </div>
            <canvas id="chartPeserta" height="110"></canvas>
        </div>
    </div>

</div>

{{-- ── CHART LAPORAN ── --}}
<div class="section-label">Laporan Hasil Ujian</div>
<div class="row g-3 mb-4">
    <div class="col-12 fade-up delay-5">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title">Laporan Hasil Ujian</div>
                    <div class="chart-card-sub">Statistik nilai, kelulusan, dan analisis hasil ujian</div>
                </div>
                <span class="chart-badge cyan">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </span>
            </div>
            <canvas id="chartLaporan" height="100"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Admin Welcome Popup (show once per session) ── */
   /* ── Admin Welcome Popup (muncul setiap buka dashboard) ── */
setTimeout(() => {
    Swal.fire({
        icon: 'success',
        title: '🎉 Selamat Datang Admin!',
        html: 'Sekarang Anda sudah bisa <strong>input nilai</strong>!<br>' +
              'Caranya: <em>periksa jawaban → berikan nilai → simpan</em>',
        timer: 7000,
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: true,
        allowEscapeKey: true,
        width: '500px',
        customClass: {
            popup: 'animate__animated animate__bounceIn'
        }
    });
}, 300);

    /* ── Helpers ── */
    function setVal(id, value) {
        var el = document.getElementById(id);
        if (!el) return;
        el.innerHTML = value ?? '—';
    }

    /* ── Fetch stats ── */
    fetch('/admin/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        setVal('val-siswa',   data.total_siswa);
        setVal('val-guru',    data.total_guru);
        setVal('val-kelas',   data.total_kelas);
        setVal('val-mapel',   data.total_mapel);
        setVal('val-ujian',   data.total_ujian);
        setVal('val-peserta', data.total_peserta);
    })
    .catch(function () {
        ['val-siswa','val-guru','val-kelas','val-mapel','val-ujian','val-peserta']
            .forEach(function (id) { setVal(id, '—'); });
    });

    /* ── Chart defaults ── */
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#6c757d';

    var gridColor  = 'rgba(0,0,0,0.05)';
    var commonOpts = {
        plugins : { legend: { display: false } },
        scales  : {
            x: { grid: { color: gridColor }, ticks: { maxRotation: 0 } },
            y: { beginAtZero: true, grid: { color: gridColor } }
        }
    };

    /* ── Fetch charts ── */
    fetch('/admin/dashboard/chart', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(function (res) { return res.json(); })
    .then(function (chart) {

        /* Ujian — line chart, warna primary */
        new Chart(document.getElementById('chartUjian').getContext('2d'), {
            type: 'line',
            data: {
                labels: chart.ujian.labels,
                datasets: [{
                    label: 'Ujian',
                    data:  chart.ujian.data,
                    borderColor:     '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.08)',
                    borderWidth: 2,
                    pointBackgroundColor: '#0d6efd',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: commonOpts
        });

        /* Peserta — bar chart, warna secondary */
        new Chart(document.getElementById('chartPeserta').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chart.peserta.labels,
                datasets: [{
                    label: 'Peserta',
                    data:  chart.peserta.data,
                    backgroundColor: 'rgba(32,201,151,0.75)',
                    borderColor:     '#20c997',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: commonOpts
        });

        /* Laporan — bar chart, warna accent */
        new Chart(document.getElementById('chartLaporan').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chart.laporan.labels,
                datasets: [{
                    label: 'Nilai',
                    data:  chart.laporan.data,
                    backgroundColor: 'rgba(13,202,240,0.7)',
                    borderColor:     '#0dcaf0',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: commonOpts
        });

    })
    .catch(function (err) {
        console.warn('Chart data error:', err);
    });

});
</script>
@endpush
{{-- @extends('layouts.master')

@section('title', 'Dashboard')

@section('layoutContent')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 d-flex flex-column flex-md-row align-items-center justify-content-between animate__animated animate__fadeInDown" style="background:#f8f9fa;">
            <div class="mb-3 mb-md-0">
                <h5 class="fw-bold text-primary mb-2 animate__animated animate__fadeInLeft">Selamat datang di SMA5 CBT!</h5>
                <div class="mb-2 animate__animated animate__fadeInLeft animate__delay-1s">Sistem ujian dan ulangan online SMA Negeri 5.<br>Kelola data siswa, guru, kelas, mapel, ujian, soal, monitoring, dan laporan hasil ujian.</div>
                <a href="/admin/ujian" class="btn btn-primary btn-sm animate__animated animate__pulse animate__infinite">Mulai Ujian</a>
            </div>
            <img src="{{ asset('assets/img/people.svg') }}" alt="CBT" width="300" class="d-none d-md-block animate__animated animate__fadeInRight">
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp" style="background:linear-gradient(135deg,#e0ffe7 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-people-fill text-success" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Siswa</div>
            <div class="display-5 fw-bold text-success">0</div>
            <div class="small text-muted">Siswa aktif terdaftar</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-1s" style="background:linear-gradient(135deg,#e0f0ff 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-person-badge-fill text-primary" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Guru</div>
            <div class="display-5 fw-bold text-primary">0</div>
            <div class="small text-muted">Guru pengajar aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-2s" style="background:linear-gradient(135deg,#fffbe0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-building text-warning" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Kelas</div>
            <div class="display-5 fw-bold text-warning">0</div>
            <div class="small text-muted">Kelas aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-3s" style="background:linear-gradient(135deg,#ffe0e0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-journal-bookmark-fill text-danger" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Mapel</div>
            <div class="display-5 fw-bold text-danger">0</div>
            <div class="small text-muted">Mata pelajaran aktif</div>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeInUp">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Total Ujian</div>
                    <div class="display-6 fw-bold text-primary">0</div>
                    <div class="small text-muted">Ujian aktif & selesai</div>
                </div>
                <i class="bi bi-clipboard-data text-primary" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartUjian" height="120"></canvas>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Monitoring Ujian</div>
                    <div class="display-6 fw-bold text-success">0</div>
                    <div class="small text-muted">Peserta ujian online</div>
                </div>
                <i class="bi bi-activity text-success" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartPeserta" height="120"></canvas>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeIn animate__delay-2s">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Laporan Hasil Ujian</div>
                    <div class="small text-muted">Statistik nilai, kelulusan, dan analisis hasil ujian.</div>
                </div>
                <i class="bi bi-bar-chart-line text-info" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartLaporan" height="120"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/admin/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        document.querySelectorAll('.display-5.text-success')[0].textContent = data.total_siswa;
        document.querySelectorAll('.display-5.text-primary')[0].textContent = data.total_guru;
        document.querySelectorAll('.display-5.text-warning')[0].textContent = data.total_kelas;
        document.querySelectorAll('.display-5.text-danger')[0].textContent = data.total_mapel;
        document.querySelector('.display-6.text-primary').textContent = data.total_ujian;
        document.querySelector('.display-6.text-success').textContent = data.total_peserta;
    });

    // Chart data real
    fetch('/admin/dashboard/chart', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(chart => {
        // Ujian chart
        const ctxUjian = document.getElementById('chartUjian').getContext('2d');
        new Chart(ctxUjian, {
            type: 'line',
            data: {
                labels: chart.ujian.labels,
                datasets: [{
                    label: 'Ujian',
                    data: chart.ujian.data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
        // Peserta chart
        const ctxPeserta = document.getElementById('chartPeserta').getContext('2d');
        new Chart(ctxPeserta, {
            type: 'bar',
            data: {
                labels: chart.peserta.labels,
                datasets: [{
                    label: 'Peserta',
                    data: chart.peserta.data,
                    backgroundColor: '#198754',
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
        // Laporan chart
        const ctxLaporan = document.getElementById('chartLaporan').getContext('2d');
        new Chart(ctxLaporan, {
            type: 'bar',
            data: {
                labels: chart.laporan.labels,
                datasets: [{
                    label: 'Nilai',
                    data: chart.laporan.data,
                    backgroundColor: '#0dcaf0',
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    });
});
</script>
@endpush --}}
