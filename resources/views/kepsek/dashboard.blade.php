@extends('layouts.master')

@section('title', 'Dashboard Kepala Sekolah')

@push('styles')
<style>
.hero-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 10px 30px rgba(13,110,253,0.2);
}
.hero-header::before {
    content: '';
    position: absolute;
    width: 260px; height: 260px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
    top: -80px; right: -60px;
    pointer-events: none;
}
.hero-header::after {
    content: '';
    position: absolute;
    width: 150px; height: 150px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
    bottom: -50px; right: 180px;
    pointer-events: none;
}
.hero-content { position: relative; z-index: 2; }
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 30px;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Metric Cards */
.kpi-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color, #e2e8f0);
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    padding: 20px 22px;
    transition: all 0.25s ease;
    height: 100%;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(13,110,253,0.08);
    border-color: rgba(13,110,253,0.2);
}
.kpi-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.kpi-icon.blue   { background: rgba(13,110,253,0.1); color: #0d6efd; }
.kpi-icon.green  { background: rgba(25,135,84,0.1);  color: #198754; }
.kpi-icon.purple { background: rgba(111,66,193,0.1); color: #6f42c1; }
.kpi-icon.cyan   { background: rgba(13,202,240,0.12); color: #0891b2; }
.kpi-icon.yellow { background: rgba(255,193,7,0.15); color: #d97706; }
.kpi-icon.red    { background: rgba(220,53,69,0.1);  color: #dc3545; }

.kpi-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}
.kpi-lbl {
    font-size: 0.78rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* Chart Cards */
.chart-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--border-color, #e2e8f0);
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    padding: 22px 24px;
    height: 100%;
}
.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}
.chart-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

/* Table Card */
.table-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--border-color, #e2e8f0);
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.85rem; }
.table-card .table thead th {
    background: #f8faff;
    color: var(--text-main);
    font-weight: 600;
    font-size: 0.76rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 13px 16px;
    border-bottom: 1px solid #e2e8f0;
}
.table-card .table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}
</style>
@endpush

@section('layoutContent')

{{-- ── 1. Hero Header ── --}}
<div class="hero-header">
    <div class="hero-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <div class="hero-badge">
                <i class="bi bi-shield-check"></i> Executive Control & Analytics
            </div>
            <h3 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Kepala Sekolah' }}</h3>
            <p class="mb-0 text-white-50">
                Pusat Analisis Data, Evaluasi Hasil Ujian, dan Pemantauan Akademik SMA Negeri 5 Pulau Morotai
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('kepala-sekolah.monitoring') }}" class="btn btn-light rounded-pill px-3 shadow-sm fw-semibold">
                <i class="bi bi-tv me-1 text-primary"></i> Live Monitoring
            </a>
            <a href="{{ route('kepala-sekolah.laporan') }}" class="btn btn-outline-light rounded-pill px-3 fw-semibold">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekap Nilai
            </a>
        </div>
    </div>
</div>

{{-- ── 2. KPI Metrics Grid ── --}}
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Siswa Aktif</div>
                <div class="kpi-icon blue"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="kpi-val">{{ $totalSiswa }}</div>
            <div class="text-muted small mt-1">Siswa Terdaftar</div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Guru Pengampu</div>
                <div class="kpi-icon green"><i class="bi bi-person-video3"></i></div>
            </div>
            <div class="kpi-val">{{ $totalGuru }}</div>
            <div class="text-muted small mt-1">Tenaga Pendidik</div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Rombel / Kelas</div>
                <div class="kpi-icon cyan"><i class="bi bi-building"></i></div>
            </div>
            <div class="kpi-val">{{ $totalKelas }}</div>
            <div class="text-muted small mt-1">{{ $totalMapel }} Mata Pelajaran</div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Total Ujian</div>
                <div class="kpi-icon purple"><i class="bi bi-journal-check"></i></div>
            </div>
            <div class="kpi-val">{{ $totalUjian }}</div>
            <div class="text-muted small mt-1">Bank Ujian Aktif</div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Rata-Rata Nilai</div>
                <div class="kpi-icon yellow"><i class="bi bi-trophy-fill"></i></div>
            </div>
            <div class="kpi-val text-warning">{{ number_format($avgScore, 1) }}</div>
            <div class="text-muted small mt-1">Skala 0 - 100</div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-4 col-sm-6">
        <div class="kpi-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="kpi-lbl">Total Selesai</div>
                <div class="kpi-icon green"><i class="bi bi-check2-all"></i></div>
            </div>
            <div class="kpi-val text-success">{{ $totalCompleted }}</div>
            <div class="text-muted small mt-1">Dari {{ $totalSessions }} Sesi</div>
        </div>
    </div>
</div>

{{-- ── 3. Charts Section (4 Analytics Diagrams) ── --}}
<div class="row g-4 mb-4">
    {{-- Diagram 1: Rata-rata Nilai per Mapel --}}
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <h6 class="chart-card-title">
                    <i class="bi bi-bar-chart-fill text-primary"></i> Rata-Rata Nilai per Mata Pelajaran
                </h6>
                <span class="badge bg-light text-muted border">Evaluasi Akademik</span>
            </div>
            <div style="height: 280px; position: relative;">
                <canvas id="chartMapelScore"></canvas>
            </div>
        </div>
    </div>

    {{-- Diagram 2: Ketuntasan Belajar Siswa (KKM 75) --}}
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <h6 class="chart-card-title">
                    <i class="bi bi-pie-chart-fill text-success"></i> Ketuntasan Belajar (KKM ≥ 75)
                </h6>
                <span class="badge bg-light text-muted border">Rasio Kelulusan</span>
            </div>
            <div style="height: 220px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="chartKetuntasan"></canvas>
            </div>
            <div class="d-flex justify-content-around mt-3 pt-2 border-top text-center small">
                <div>
                    <span class="d-inline-block rounded-circle bg-success me-1" style="width:10px;height:10px;"></span>
                    <strong>Tuntas:</strong> {{ $tuntasCount }}
                </div>
                <div>
                    <span class="d-inline-block rounded-circle bg-danger me-1" style="width:10px;height:10px;"></span>
                    <strong>Belum:</strong> {{ $belumTuntasCount }}
                </div>
            </div>
        </div>
    </div>

    {{-- Diagram 3: Partisipasi Siswa per Ujian Terbaru --}}
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <h6 class="chart-card-title">
                    <i class="bi bi-graph-up-arrow text-cyan" style="color:#0891b2;"></i> Partisipasi & Kehadiran Siswa per Ujian
                </h6>
                <span class="badge bg-light text-muted border">Tren 6 Ujian Terakhir</span>
            </div>
            <div style="height: 260px; position: relative;">
                <canvas id="chartPartisipasi"></canvas>
            </div>
        </div>
    </div>

    {{-- Diagram 4: Analisis Integritas CBT --}}
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <h6 class="chart-card-title">
                    <i class="bi bi-shield-check text-purple" style="color:#6f42c1;"></i> Integritas Pengerjaan CBT
                </h6>
                <span class="badge bg-light text-muted border">Anti-Cheating</span>
            </div>
            <div style="height: 220px; position: relative;" class="d-flex align-items-center justify-content-center">
                <canvas id="chartIntegritas"></canvas>
            </div>
            <div class="d-flex justify-content-around mt-3 pt-2 border-top text-center small">
                <div>
                    <span class="d-inline-block rounded-circle bg-primary me-1" style="width:10px;height:10px;"></span>
                    <strong>Normal:</strong> {{ $normalCount }}
                </div>
                <div>
                    <span class="d-inline-block rounded-circle bg-danger me-1" style="width:10px;height:10px;"></span>
                    <strong>Terdeteksi:</strong> {{ $detectedCount }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── 4. Tabel Ujian & Evaluasi Terkini ── --}}
<div class="table-card">
    <div class="p-3 bg-white border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="bi bi-clipboard-data me-2 text-primary"></i>Ujian Terbaru & Rekapitulasi Kehadiran
        </h6>
        <a href="{{ route('kepala-sekolah.berita-acara') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            Lihat Semua Berita Acara <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Judul Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th>Total Peserta</th>
                    <th>Status Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentExams as $idx => $ex)
                <tr>
                    <td class="fw-bold text-muted">{{ $idx + 1 }}</td>
                    <td class="fw-semibold text-dark">{{ $ex->title }}</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">{{ $ex->subject ? $ex->subject->name : '-' }}</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">{{ $ex->schoolClass ? $ex->schoolClass->name : '-' }}</span></td>
                    <td class="text-muted small">{{ $ex->start_time ? $ex->start_time->format('d M Y, H:i') : '-' }}</td>
                    <td class="fw-bold">{{ $ex->total_peserta }} siswa</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $percent = $ex->total_peserta > 0 ? round(($ex->selesai_peserta / $ex->total_peserta) * 100) : 0;
                            @endphp
                            <div class="progress flex-grow-1" style="height: 6px; width: 80px;">
                                <div class="progress-bar bg-success" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="small fw-bold">{{ $ex->selesai_peserta }}/{{ $ex->total_peserta }} ({{ $percent }}%)</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada aktivitas ujian terkini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Chart Nilai per Mapel (Bar Chart)
    const mapelData = @json($mapelScores);
    const mapelLabels = mapelData.map(m => m.name);
    const mapelValues = mapelData.map(m => m.avg);

    new Chart(document.getElementById('chartMapelScore'), {
        type: 'bar',
        data: {
            labels: mapelLabels.length ? mapelLabels : ['Belum Ada Data'],
            datasets: [{
                label: 'Nilai Rata-rata',
                data: mapelValues.length ? mapelValues : [0],
                backgroundColor: 'rgba(13, 110, 253, 0.75)',
                borderColor: '#0d6efd',
                borderWidth: 1.5,
                borderRadius: 8,
                maxBarThickness: 45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Chart Ketuntasan (Doughnut Chart)
    new Chart(document.getElementById('chartKetuntasan'), {
        type: 'doughnut',
        data: {
            labels: ['Tuntas (≥75)', 'Belum Tuntas (<75)'],
            datasets: [{
                data: [{{ $tuntasCount }}, {{ $belumTuntasCount }}],
                backgroundColor: ['#198754', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Chart Partisipasi per Ujian (Line Chart)
    const recentExamsData = @json($recentExams);
    const examLabels = recentExamsData.map(e => e.title.substring(0, 18) + (e.title.length > 18 ? '...' : ''));
    const totalPesertaData = recentExamsData.map(e => e.total_peserta);
    const selesaiPesertaData = recentExamsData.map(e => e.selesai_peserta);

    new Chart(document.getElementById('chartPartisipasi'), {
        type: 'line',
        data: {
            labels: examLabels.length ? examLabels : ['Belum Ada Data'],
            datasets: [
                {
                    label: 'Total Siswa Masuk',
                    data: totalPesertaData.length ? totalPesertaData : [0],
                    borderColor: '#0891b2',
                    backgroundColor: 'rgba(8, 145, 178, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 4
                },
                {
                    label: 'Siswa Selesai',
                    data: selesaiPesertaData.length ? selesaiPesertaData : [0],
                    borderColor: '#198754',
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
            plugins: {
                legend: { position: 'top', align: 'end', labels: { boxWidth: 12 } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 4. Chart Integritas CBT (Pie Chart)
    new Chart(document.getElementById('chartIntegritas'), {
        type: 'pie',
        data: {
            labels: ['Pengerjaan Normal', 'Terdeteksi Pelanggaran'],
            datasets: [{
                data: [{{ $normalCount }}, {{ $detectedCount }}],
                backgroundColor: ['#0d6efd', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush
