@extends('layouts.master')

@section('title', 'Monitoring Ujian - Kepala Sekolah')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
}
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.86rem; }
.table-card .table thead th {
    background: #f8faff;
    font-weight: 600;
    font-size: 0.76rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
}
.table-card .table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
}
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}
.status-pill.online  { background: rgba(25,135,84,0.12); color: #198754; }
.status-pill.done    { background: rgba(13,110,253,0.12); color: #0d6efd; }
.status-pill.offline { background: rgba(108,117,125,0.1); color: #6c757d; }
.status-pill.alert   { background: rgba(220,53,69,0.15); color: #dc3545; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <h4 class="fw-bold mb-1"><i class="bi bi-tv me-2"></i>Monitoring Ujian Real-Time (Pantau Kepala Sekolah)</h4>
    <p class="mb-0 text-white-50">Pantau aktivitas siswa, sesi aktif, dan integritas pelaksanaan CBT secara langsung</p>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Pilih Ujian yang Dipantau:</label>
            <select id="selectExam" class="form-select rounded-pill">
                <option value="">-- Semua Ujian Aktif --</option>
                @foreach($exams as $ex)
                    <option value="{{ $ex->id }}">{{ $ex->title }} ({{ $ex->schoolClass ? $ex->schoolClass->name : '-' }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Cari Siswa:</label>
            <input type="text" id="searchSiswa" class="form-control rounded-pill" placeholder="Cari nama atau NIS siswa...">
        </div>
        <div class="col-md-2 text-end pt-md-3">
            <button id="btnRefresh" class="btn btn-outline-primary rounded-pill w-100">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle" id="tableMonitoring">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Ujian & Mapel</th>
                    <th>Waktu Mulai</th>
                    <th>Status Pengerjaan</th>
                    <th>Integritas CBT</th>
                </tr>
            </thead>
            <tbody id="tbodyMonitoring">
                <tr><td colspan="8" class="text-center py-5 text-muted">Memuat data monitoring...</td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let allData = [];

    function loadMonitoring() {
        const examId = document.getElementById('selectExam').value;
        fetch('/kepala-sekolah/monitoring/data' + (examId ? '?exam_id=' + examId : ''))
        .then(r => r.json())
        .then(data => {
            allData = data;
            renderTable(data);
        })
        .catch(err => {
            document.getElementById('tbodyMonitoring').innerHTML = '<tr><td colspan="8" class="text-center py-4 text-danger">Gagal memuat data monitoring.</td></tr>';
        });
    }

    function renderTable(data) {
        const tbody = document.getElementById('tbodyMonitoring');
        const q = document.getElementById('searchSiswa').value.toLowerCase().trim();

        const filtered = q ? data.filter(d => d.nama.toLowerCase().includes(q) || d.nis.toLowerCase().includes(q)) : data;

        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-2 d-block mb-2"></i>Tidak ada data sesi pengerjaan yang ditemukan.</td></tr>';
            return;
        }

        let html = '';
        filtered.forEach((d, idx) => {
            let statusBadge = '<span class="status-pill offline"><i class="bi bi-dash-circle"></i> Selesai/Keluar</span>';
            if (d.end_time !== '-') {
                statusBadge = '<span class="status-pill done"><i class="bi bi-check-circle-fill"></i> Selesai</span>';
            } else if (d.is_active) {
                statusBadge = '<span class="status-pill online"><i class="bi bi-broadcast"></i> Sedang Mengerjakan</span>';
            }

            let integritasBadge = '<span class="text-success small fw-semibold"><i class="bi bi-shield-check me-1"></i> Normal</span>';
            if (d.is_detected) {
                integritasBadge = '<span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-2 py-1 small fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdeteksi Keluar</span>';
            }

            html += `<tr>
                <td class="fw-bold text-muted">${idx + 1}</td>
                <td><div class="fw-semibold text-dark">${d.nama}</div></td>
                <td><strong>${d.nis}</strong></td>
                <td><span class="badge bg-light text-dark border">${d.kelas}</span></td>
                <td>
                    <div class="small fw-semibold">${d.ujian}</div>
                    <div class="text-muted small">${d.mapel}</div>
                </td>
                <td class="small">${d.start_time}</td>
                <td>${statusBadge}</td>
                <td>${integritasBadge}</td>
            </tr>`;
        });

        tbody.innerHTML = html;
    }

    loadMonitoring();

    document.getElementById('selectExam').addEventListener('change', loadMonitoring);
    document.getElementById('searchSiswa').addEventListener('input', () => renderTable(allData));
    document.getElementById('btnRefresh').addEventListener('click', loadMonitoring);

    // Auto refresh every 15 seconds
    setInterval(loadMonitoring, 15000);
});
</script>
@endpush
