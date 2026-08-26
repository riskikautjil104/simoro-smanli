@extends('layouts.master')
@section('title', 'Berita Acara - ' . $exam->title)

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}
.page-header::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    top: -60px; right: -60px;
    pointer-events: none;
}
.page-header-content { position: relative; z-index: 2; }
.page-header h4 { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p  { font-size: 0.85rem; opacity: 0.85; margin: 0; }

.stat-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    height: 100%;
}
.stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.stat-icon.blue   { background: rgba(13,110,253,0.1); color: #0d6efd; }
.stat-icon.green  { background: rgba(25,135,84,0.1);  color: #198754; }
.stat-icon.yellow { background: rgba(255,193,7,0.15); color: #b78103; }
.stat-val { font-size: 1.5rem; font-weight: 800; color: #1e293b; line-height: 1.2; }
.stat-lbl { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.875rem; }
.table-card .table thead th {
    background: #f8faff;
    color: var(--text-main);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
    color: var(--text-main);
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

.search-wrap { position: relative; }
.search-wrap i {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
}
.search-wrap input {
    padding-left: 38px;
    border-radius: 50px;
    border: 1.5px solid var(--border-color);
    font-size: 0.875rem;
    height: 40px;
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('guru.berita-acara.index') }}" class="text-white text-decoration-none small opacity-75 hover-opacity-100">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Ujian
                </a>
            </div>
            <h4><i class="bi bi-file-earmark-ruled me-2"></i>Berita Acara: {{ $exam->title }}</h4>
            <p class="mb-0">
                <span class="me-3"><i class="bi bi-journal-bookmark me-1"></i>{{ $exam->subject ? $exam->subject->name : '-' }}</span>
                <span class="me-3"><i class="bi bi-building me-1"></i>Kelas: {{ $exam->schoolClass ? $exam->schoolClass->name : '-' }}</span>
                <span><i class="bi bi-calendar-event me-1"></i>{{ $exam->start_time ? $exam->start_time->format('d M Y, H:i') : '-' }} WIT</span>
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('guru.berita-acara.pdf', $exam->id) }}" class="btn btn-danger shadow-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF Resmi
            </a>
            <a href="{{ route('guru.berita-acara.excel', $exam->id) }}" class="btn btn-success shadow-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
            </a>
        </div>
    </div>
</div>

{{-- Statistik Presensi --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-val">{{ $totalPeserta }}</div>
                <div class="stat-lbl">Total Siswa Masuk / Hadir</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check2-circle"></i></div>
            <div>
                <div class="stat-val text-success">{{ $totalSelesai }}</div>
                <div class="stat-lbl">Selesai Mengerjakan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-val text-warning">{{ $totalBelum }}</div>
                <div class="stat-lbl">Belum Selesai / Sedang Tes</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Toolbar --}}
<div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white">
    <div class="row g-2 align-items-center">
        <div class="col-md-6 col-sm-6">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="searchPeserta" class="form-control" placeholder="Cari nama atau NIS siswa...">
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <select id="filterStatus" class="form-select rounded-pill">
                <option value="">Semua Status (Selesai & Belum)</option>
                <option value="Selesai">Hanya yang Selesai</option>
                <option value="Belum Selesai">Hanya yang Belum Selesai</option>
            </select>
        </div>
        <div class="col-md-2 text-end">
            <button id="btnResetFilter" class="btn btn-outline-secondary rounded-pill w-100">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </button>
        </div>
    </div>
</div>

{{-- Tabel Daftar Hadir & Selesai Siswa --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle" id="pesertaTable">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nama Lengkap Siswa</th>
                    <th>NIS / NISN</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Status Presensi</th>
                    <th>Nilai Akhir</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $s)
                <tr data-status="{{ $s['status'] }}">
                    <td class="fw-bold text-muted">{{ $s['no'] }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width:34px;height:34px;font-size:0.8rem;">
                                {{ strtoupper(substr($s['nama'], 0, 2)) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ $s['nama'] }}</span>
                        </div>
                    </td>
                    <td class="fw-bold">{{ $s['nis'] }}</td>
                    <td class="small text-muted">
                        {{ $s['start_time'] ? $s['start_time']->format('d M, H:i:s') : '-' }}
                    </td>
                    <td class="small text-muted">
                        {{ $s['end_time'] ? $s['end_time']->format('d M, H:i:s') : '—' }}
                    </td>
                    <td>
                        @if($s['status'] === 'Selesai')
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-15 text-warning rounded-pill px-3 py-1 fw-bold">
                                <i class="bi bi-hourglass-split me-1"></i> Belum Selesai
                            </span>
                        @endif
                    </td>
                    <td class="fw-bold text-primary">
                        {{ $s['score'] !== '-' ? number_format((float)$s['score'], 1) : '—' }}
                    </td>
                    <td>
                        @if($s['is_detected'])
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 small">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Terdeteksi
                            </span>
                        @else
                            <span class="text-success small"><i class="bi bi-shield-check me-1"></i> Normal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                        Belum ada siswa yang login atau mulai mengerjakan ujian ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput  = document.getElementById('searchPeserta');
    var statusSelect = document.getElementById('filterStatus');
    var btnReset     = document.getElementById('btnResetFilter');

    function applyFilter() {
        var q      = searchInput.value.toLowerCase().trim();
        var status = statusSelect.value;

        var rows = document.querySelectorAll('#pesertaTable tbody tr');
        rows.forEach(function(row) {
            var text      = row.textContent.toLowerCase();
            var rowStatus = row.getAttribute('data-status');

            var matchQ      = !q || text.includes(q);
            var matchStatus = !status || (rowStatus === status);

            row.style.display = (matchQ && matchStatus) ? '' : 'none';
        });
    }

    if (searchInput)  searchInput.addEventListener('input', applyFilter);
    if (statusSelect) statusSelect.addEventListener('change', applyFilter);
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            searchInput.value  = '';
            statusSelect.value = '';
            applyFilter();
        });
    }
});
</script>
@endpush
