{{-- ============================================================
     guru-ujian.blade.php  —  Daftar Ujian Saya
     resources/views/guru/ujian.blade.php
============================================================ --}}
@extends('layouts.master')
@section('title', 'Daftar Ujian')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }
.btn-header { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,0.2); color:#fff !important; border:1.5px solid rgba(255,255,255,0.45); padding:9px 20px; border-radius:50px; font-size:0.875rem; font-weight:600; backdrop-filter:blur(8px); cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; }
.btn-header:hover { background:rgba(255,255,255,0.32); transform:translateY(-2px); color:#fff !important; }

.search-wrap { position:relative; max-width:280px; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:38px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }

.table-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; }
.table-card .table { margin:0; font-size:0.875rem; }
.table-card .table thead th { background:#f0f4ff; color:var(--text-main); font-weight:600; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; padding:14px 16px; border-bottom:1px solid var(--border-color); white-space:nowrap; }
.table-card .table tbody td { padding:13px 16px; vertical-align:middle; border-bottom:1px solid rgba(13,110,253,0.05); color:var(--text-main); }
.table-card .table tbody tr:last-child td { border-bottom:none; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }
.ujian-avatar { width:36px; height:36px; background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.78rem; flex-shrink:0; box-shadow:0 2px 8px rgba(13,110,253,0.25); }
.badge-mapel { display:inline-flex; align-items:center; gap:4px; background:rgba(13,110,253,0.08); color:var(--primary); font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.badge-kelas { display:inline-flex; align-items:center; gap:4px; background:rgba(32,201,151,0.1); color:#198754; font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.status-badge { display:inline-flex; align-items:center; gap:4px; font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:20px; }
.status-aktif    { background:rgba(32,201,151,0.12); color:#198754; }
.status-selesai  { background:rgba(108,117,125,0.1); color:#6c757d; }
.status-draft    { background:rgba(255,193,7,0.12); color:#856404; }
.btn-act { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; white-space:nowrap; margin:2px 2px 0 0; text-decoration:none; }
.btn-act-detail { background:rgba(13,202,240,0.1); color:#0a9bba; }
.btn-act-detail:hover { background:var(--accent); color:#fff; transform:translateY(-1px); }
.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-clipboard-plus me-2"></i>Daftar Ujian <span class="count-badge" id="ujian-count">0 ujian</span></h4>
            <p>Ujian yang telah Anda buat</p>
        </div>
        <a href="{{ route('guru.ujian.create') }}" class="btn-header">
            <i class="bi bi-plus-lg"></i> Buat Ujian Baru
        </a>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchUjian" class="form-control" placeholder="Cari nama ujian...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="ujian-shown">0</span> ujian</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="ujian-table">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Judul Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th style="width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="ujian-tbody">
                <tr><td colspan="9"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var allUjian = [];

    function statusBadge(status) {
        if (!status) return '<span class="status-badge status-draft">—</span>';
        var s = status.toLowerCase();
        if (s.includes('aktif') || s.includes('berlangsung')) return '<span class="status-badge status-aktif"><i class="bi bi-play-circle"></i> ' + status + '</span>';
        if (s.includes('selesai')) return '<span class="status-badge status-selesai"><i class="bi bi-check-circle"></i> ' + status + '</span>';
        return '<span class="status-badge status-draft"><i class="bi bi-clock"></i> ' + status + '</span>';
    }

    function renderUjian(data) {
        var tbody = document.getElementById('ujian-tbody');
        document.getElementById('ujian-count').textContent = data.length + ' ujian';
        document.getElementById('ujian-shown').textContent = data.length;
        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="9"><div class="empty-state"><div class="empty-icon"><i class="bi bi-clipboard-plus"></i></div><h6>Belum ada ujian</h6><p>Klik "Buat Ujian Baru" untuk memulai</p></div></td></tr>';
            return;
        }
        var rows = '';
        data.forEach(function(u, i) {
            var inisial  = (u.title||'U').substring(0,2).toUpperCase();
            var mapelNm  = u.subject ? u.subject.name : '-';
            var kelasNm  = u.school_class ? u.school_class.name : '-';
            rows += '<tr data-judul="' + (u.title||'').toLowerCase() + '">' +
                '<td>' + (i+1) + '</td>' +
                '<td><div class="d-flex align-items-center gap-2"><div class="ujian-avatar">' + inisial + '</div><span style="font-weight:600;">' + (u.title||'-') + '</span></div></td>' +
                '<td><span class="badge-mapel">' + mapelNm + '</span></td>' +
                '<td><span class="badge-kelas">' + kelasNm + '</span></td>' +
                '<td style="font-size:.8rem;">' + (u.start_time||'-') + '</td>' +
                '<td style="font-size:.8rem;">' + (u.end_time||'-') + '</td>' +
                '<td style="font-size:.8rem;">' + (u.duration ? u.duration + ' mnt' : '-') + '</td>' +
                '<td>' + statusBadge(u.status) + '</td>' +
                '<td><a class="btn-act btn-act-detail" href="/guru/ujian/' + u.id + '/detail"><i class="bi bi-eye"></i> Detail</a></td>' +
            '</tr>';
        });
        tbody.innerHTML = rows;
    }

    fetch('/guru/ujian/list', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) { allUjian = data; renderUjian(data); })
    .catch(function() {
        document.getElementById('ujian-tbody').innerHTML = '<tr><td colspan="9"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
    });

    document.getElementById('searchUjian').addEventListener('input', function() {
        var q    = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#ujian-tbody tr[data-judul]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-judul').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('ujian-shown').textContent = shown;
    });
});
</script>
@endpush