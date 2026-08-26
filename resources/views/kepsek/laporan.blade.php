@extends('layouts.master')

@section('title', 'Rekap Hasil Ujian - Kepala Sekolah')

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
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-bar-graph me-2"></i>Rekapitulasi Hasil Ujian Sekolah</h4>
            <p class="mb-0 text-white-50">Laporan evaluasi nilai dan hasil ujian seluruh mata pelajaran dan kelas</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-light rounded-pill px-3 shadow-sm">
                <i class="bi bi-printer me-1"></i> Cetak Halaman
            </button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <div class="row g-2 align-items-center">
        <div class="col-md-3">
            <select id="filterExam" class="form-select rounded-pill">
                <option value="">-- Semua Ujian --</option>
                @foreach($exams as $ex)
                    <option value="{{ $ex->id }}">{{ $ex->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterClass" class="form-select rounded-pill">
                <option value="">-- Semua Kelas --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterSubject" class="form-select rounded-pill">
                <option value="">-- Semua Mapel --</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 text-end">
            <button id="btnFilter" class="btn btn-primary rounded-pill w-100">
                <i class="bi bi-filter me-1"></i> Terapkan Filter
            </button>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle" id="tableLaporan">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Ujian</th>
                    <th>Waktu Mulai - Selesai</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tbodyLaporan">
                <tr><td colspan="9" class="text-center py-5 text-muted">Memuat data rekap nilai...</td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function loadData() {
        const examId    = document.getElementById('filterExam').value;
        const classId   = document.getElementById('filterClass').value;
        const subjectId = document.getElementById('filterSubject').value;

        const params = new URLSearchParams();
        if (examId) params.append('exam_id', examId);
        if (classId) params.append('class_id', classId);
        if (subjectId) params.append('subject_id', subjectId);

        fetch('/kepala-sekolah/laporan/data?' + params.toString())
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById('tbodyLaporan');
            if (!data.length) {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-2 d-block mb-2"></i>Tidak ada data nilai yang sesuai filter.</td></tr>';
                return;
            }

            let html = '';
            data.forEach((d, idx) => {
                const score = parseFloat(d.nilai) || 0;
                const scoreBadge = d.nilai !== '-' 
                    ? (score >= 75 ? `<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold fs-6">${d.nilai}</span>` : `<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-bold fs-6">${d.nilai}</span>`)
                    : '—';

                html += `<tr>
                    <td class="fw-bold text-muted">${idx + 1}</td>
                    <td class="fw-semibold text-dark">${d.nama}</td>
                    <td><strong>${d.nis}</strong></td>
                    <td><span class="badge bg-light text-dark border">${d.kelas}</span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">${d.mapel}</span></td>
                    <td><span class="small text-muted">${d.ujian}</span></td>
                    <td class="small text-muted">${d.mulai} - ${d.selesai}</td>
                    <td>${scoreBadge}</td>
                    <td><span class="badge bg-light text-muted border">${d.status}</span></td>
                </tr>`;
            });

            tbody.innerHTML = html;
        })
        .catch(err => {
            document.getElementById('tbodyLaporan').innerHTML = '<tr><td colspan="9" class="text-center py-4 text-danger">Gagal memuat rekap data.</td></tr>';
        });
    }

    loadData();
    document.getElementById('btnFilter').addEventListener('click', loadData);
});
</script>
@endpush
