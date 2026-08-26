@extends('layouts.master')

@section('title', 'Dashboard Administrator')

@push('styles')
<style>
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

    /* Welcome Banner */
    .dash-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: var(--radius);
        padding: 30px 34px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(13,110,253,0.2);
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
    .dash-banner-content { position: relative; z-index: 2; }
    .dash-banner h5 { font-size: 1.4rem; font-weight: 700; margin-bottom: 8px; }
    .dash-banner p { font-size: 0.9rem; opacity: 0.9; margin-bottom: 20px; max-width: 520px; line-height: 1.5; }
    .dash-banner .btn-banner {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.5);
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 0.86rem;
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

    /* Stat Cards */
    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 20px 18px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(13,110,253,0.06);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: var(--transition);
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }
    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: rgba(13,110,253,0.1);  color: var(--primary); }
    .stat-icon.cyan   { background: rgba(13,202,240,0.12); color: #0aa2c0; }
    .stat-icon.green  { background: rgba(32,201,151,0.12); color: var(--secondary); }
    .stat-icon.orange { background: rgba(253,126,20,0.12); color: var(--warning); }
    .stat-icon.purple { background: rgba(111,66,193,0.12); color: #6f42c1; }
    .stat-icon.teal   { background: rgba(32,201,151,0.15); color: #0f766e; }
    .stat-icon.gray   { background: rgba(108,117,125,0.12);color: #495057; }
    .stat-icon.red    { background: rgba(220,53,69,0.12);  color: var(--danger); }

    .stat-body { flex: 1; min-width: 0; }
    .stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .stat-value {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
        margin-bottom: 2px;
    }
    .stat-desc { font-size: 0.75rem; color: var(--text-muted); }

    /* Chart Cards */
    .chart-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 22px 24px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(13,110,253,0.06);
        height: 100%;
    }
    .chart-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
    }
    .chart-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 2px;
    }
    .chart-card-sub { font-size: 0.76rem; color: var(--text-muted); }

    /* Skeleton loader */
    .skeleton {
        background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 50%, #e9ecef 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s infinite;
        border-radius: 8px;
        display: inline-block;
    }
    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .skeleton-num { height: 1.8rem; width: 45px; }

    .section-label {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
</style>
@endpush

@section('layoutContent')

{{-- ── WELCOME BANNER ── --}}
<div class="dash-banner">
    <div class="dash-banner-content">
        <h5>👋 Selamat Datang di Dashboard Admin SIMORO!</h5>
        <p>Pusat kendali komprehensif data siswa, guru, kelas, mata pelajaran, bank soal, pelaksanaan ujian CBT, dan analisis hasil ujian.</p>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="/admin/ujian" class="btn-banner">
                <i class="bi bi-file-earmark-text"></i> Kelola Ujian
            </a>
            <a href="/admin/soal" class="btn-banner">
                <i class="bi bi-question-circle"></i> Bank Soal
            </a>
            <a href="/admin/monitoring" class="btn-banner">
                <i class="bi bi-tv"></i> Monitoring CBT
            </a>
        </div>
    </div>
</div>

{{-- ── STAT CARDS GRID (8 METRICS) ── --}}
<div class="section-label"><i class="bi bi-grid-fill text-primary"></i> Ringkasan &amp; Statistik Data Master</div>
<div class="row g-3 mb-4">

    {{-- 1. Siswa Aktif --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Siswa Aktif</div>
                <div class="stat-value" id="val-siswa"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Siswa aktif belajar</div>
            </div>
        </div>
    </div>

    {{-- 2. Siswa Lulus / Alumni --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Siswa Lulus / Alumni</div>
                <div class="stat-value text-success" id="val-lulus"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Alumni terarsip</div>
            </div>
        </div>
    </div>

    {{-- 3. Guru --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon cyan"><i class="bi bi-person-badge-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Guru</div>
                <div class="stat-value" id="val-guru"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Tenaga pendidik aktif</div>
            </div>
        </div>
    </div>

    {{-- 4. Kelas / Rombel --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-building"></i></div>
            <div class="stat-body">
                <div class="stat-label">Rombel / Kelas</div>
                <div class="stat-value" id="val-kelas"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Kelas terdaftar</div>
            </div>
        </div>
    </div>

    {{-- 5. Total Bank Soal --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-collection-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Bank Soal</div>
                <div class="stat-value" id="val-soal"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc" id="val-soal-desc">PG &amp; Esai</div>
            </div>
        </div>
    </div>

    {{-- 6. Ujian Aktif --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-file-earmark-check-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Ujian Aktif</div>
                <div class="stat-value" id="val-ujian"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Ujian siap / berjalan</div>
            </div>
        </div>
    </div>

    {{-- 7. Arsip Ujian --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon gray"><i class="bi bi-archive-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Arsip Ujian</div>
                <div class="stat-value text-secondary" id="val-ujian-arsip"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc">Ujian tersimpan di arsip</div>
            </div>
        </div>
    </div>

    {{-- 8. Sesi Peserta Selesai --}}
    <div class="col-xl-3 col-lg-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon teal"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-body">
                <div class="stat-label">Sesi Selesai</div>
                <div class="stat-value text-teal" id="val-peserta-selesai"><span class="skeleton skeleton-num"></span></div>
                <div class="stat-desc" id="val-peserta-desc">Dari total sesi CBT</div>
            </div>
        </div>
    </div>

</div>

{{-- ── CHARTS ROW 1: SISWA PER KELAS & KOMPOSISI SOAL ── --}}
<div class="section-label"><i class="bi bi-bar-chart-fill text-primary"></i> Analisis Distribusi Siswa &amp; Bank Soal</div>
<div class="row g-3 mb-4">

    {{-- Diagram 1: Jumlah Siswa per Kelas --}}
    <div class="col-12 col-lg-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="bi bi-people me-1 text-primary"></i> Distribusi Jumlah Siswa per Kelas</div>
                    <div class="chart-card-sub">Jumlah siswa aktif di setiap rombongan belajar (kelas)</div>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">Kelas Aktif</span>
            </div>
            <div style="height: 240px; position: relative;">
                <canvas id="chartSiswaKelas"></canvas>
            </div>
        </div>
    </div>

    {{-- Diagram 2: Komposisi Bank Soal --}}
    <div class="col-12 col-lg-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="bi bi-pie-chart me-1 text-purple"></i> Komposisi Bank Soal</div>
                    <div class="chart-card-sub">Perbandingan Pilihan Ganda &amp; Esai</div>
                </div>
                <span class="badge bg-purple bg-opacity-10 text-purple rounded-pill px-3 py-1" style="color:#6f42c1;background:rgba(111,66,193,0.1);">Tipe Soal</span>
            </div>
            <div style="height: 190px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="chartKomposisiSoal"></canvas>
            </div>
            <div class="d-flex justify-content-around mt-3 pt-2 border-top text-center small" id="legendSoal">
                <div class="text-muted">Memuat data...</div>
            </div>
        </div>
    </div>

</div>

{{-- ── CHARTS ROW 2: TREN UJIAN & DISTRIBUSI NILAI ── --}}
<div class="section-label"><i class="bi bi-graph-up text-success"></i> Analisis Aktivitas CBT &amp; Hasil Ujian</div>
<div class="row g-3 mb-4">

    {{-- Diagram 3: Tren Ujian & Peserta Bulanan --}}
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="bi bi-graph-up-arrow me-1 text-primary"></i> Tren Ujian &amp; Peserta Bulanan</div>
                    <div class="chart-card-sub">Aktivitas pelaksanaan ujian 6 bulan terakhir</div>
                </div>
                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">6 Bulan</span>
            </div>
            <div style="height: 230px; position: relative;">
                <canvas id="chartUjian"></canvas>
            </div>
        </div>
    </div>

    {{-- Diagram 4: Distribusi Nilai Hasil Ujian --}}
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="bi bi-award me-1 text-warning"></i> Distribusi Nilai Hasil Ujian (Grade)</div>
                    <div class="chart-card-sub">Sebaran skor pencapaian ujian seluruh siswa</div>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Skala Nilai</span>
            </div>
            <div style="height: 230px; position: relative;">
                <canvas id="chartLaporan"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function setVal(id, value) {
        var el = document.getElementById(id);
        if (!el) return;
        el.innerHTML = value ?? '0';
    }

    /* ── 1. Fetch Stats ── */
    fetch('/admin/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        setVal('val-siswa',            data.total_siswa);
        setVal('val-lulus',            data.total_lulus);
        setVal('val-guru',             data.total_guru);
        setVal('val-kelas',            data.total_kelas);
        setVal('val-soal',             data.total_soal);
        setVal('val-ujian',            data.total_ujian);
        setVal('val-ujian-arsip',      data.total_ujian_arsip);
        setVal('val-peserta-selesai',  data.total_selesai);

        var elSoalDesc = document.getElementById('val-soal-desc');
        if (elSoalDesc) elSoalDesc.textContent = (data.total_soal_pg || 0) + ' PG · ' + (data.total_soal_essay || 0) + ' Esai';

        var elPesertaDesc = document.getElementById('val-peserta-desc');
        if (elPesertaDesc) elPesertaDesc.textContent = 'Dari ' + (data.total_peserta || 0) + ' total sesi pengerjaan';
    })
    .catch(function () {
        ['val-siswa','val-lulus','val-guru','val-kelas','val-soal','val-ujian','val-ujian-arsip','val-peserta-selesai']
            .forEach(function (id) { setVal(id, '—'); });
    });

    /* ── 2. Chart Configurations ── */
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size   = 11.5;
    Chart.defaults.color       = '#6c757d';

    var gridColor = 'rgba(0,0,0,0.04)';

    fetch('/admin/dashboard/chart', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(function (res) { return res.json(); })
    .then(function (chart) {

        /* ── Chart 1: Siswa per Kelas (Bar) ── */
        new Chart(document.getElementById('chartSiswaKelas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chart.kelas ? chart.kelas.labels : [],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: chart.kelas ? chart.kelas.data : [],
                    backgroundColor: 'rgba(13, 110, 253, 0.75)',
                    borderColor: '#0d6efd',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    maxBarThickness: 38
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { stepSize: 5 } }
                }
            }
        });

        /* ── Chart 2: Komposisi Soal (Doughnut) ── */
        var soalPg = chart.soal ? chart.soal.data[0] : 0;
        var soalEssay = chart.soal ? chart.soal.data[1] : 0;

        new Chart(document.getElementById('chartKomposisiSoal').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: chart.soal ? chart.soal.labels : ['PG', 'Esai'],
                datasets: [{
                    data: chart.soal ? chart.soal.data : [0, 0],
                    backgroundColor: ['#0d6efd', '#6f42c1'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: { legend: { display: false } }
            }
        });

        document.getElementById('legendSoal').innerHTML = `
            <div><span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#0d6efd;"></span><strong>PG:</strong> ${soalPg}</div>
            <div><span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#6f42c1;"></span><strong>Esai:</strong> ${soalEssay}</div>
        `;

        /* ── Chart 3: Tren Ujian & Peserta Bulanan (Line & Bar) ── */
        new Chart(document.getElementById('chartUjian').getContext('2d'), {
            type: 'line',
            data: {
                labels: chart.ujian ? chart.ujian.labels : [],
                datasets: [
                    {
                        label: 'Peserta Ujian',
                        data: chart.peserta ? chart.peserta.data : [],
                        borderColor: '#20c997',
                        backgroundColor: 'rgba(32,201,151,0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Jumlah Ujian',
                        data: chart.ujian ? chart.ujian.data : [],
                        borderColor: '#0d6efd',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 12 } } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: gridColor } }
                }
            }
        });

        /* ── Chart 4: Distribusi Nilai Hasil Ujian (Bar) ── */
        new Chart(document.getElementById('chartLaporan').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chart.laporan ? chart.laporan.labels : [],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: chart.laporan ? chart.laporan.data : [],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.75)',  // A - Green
                        'rgba(13, 110, 253, 0.75)', // B - Blue
                        'rgba(13, 202, 240, 0.75)', // C - Cyan
                        'rgba(253, 126, 20, 0.75)', // D - Orange
                        'rgba(220, 53, 69, 0.75)'   // E - Red
                    ],
                    borderRadius: 6,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { stepSize: 1 } }
                }
            }
        });

    })
    .catch(function (err) {
        console.warn('Chart data error:', err);
    });

});
</script>
@endpush
