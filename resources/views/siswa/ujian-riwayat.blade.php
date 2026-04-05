@extends('layouts.master')
@section('title', 'Riwayat Ujian')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:20px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color); background:#f0f4ff; display:flex; align-items:center; gap:8px; font-weight:700; font-size:0.9rem; color:var(--text-main); }
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:8px 0; }

.riwayat-item {
    display:flex; align-items:center; gap:14px;
    padding:14px 20px; border-bottom:1px solid rgba(13,110,253,0.05);
    transition:var(--transition);
}
.riwayat-item:last-child { border-bottom:none; }
.riwayat-item:hover { background:rgba(13,110,253,0.025); }

.riwayat-avatar { width:44px; height:44px; background:linear-gradient(135deg,#198754,#20c997); border-radius:11px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:0.85rem; flex-shrink:0; box-shadow:0 2px 8px rgba(32,201,151,0.25); }

.riwayat-info { flex:1; min-width:0; }
.riwayat-name { font-size:0.875rem; font-weight:700; color:var(--text-main); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:5px; }
.riwayat-meta { display:flex; gap:6px; flex-wrap:wrap; }
.meta-tag { display:inline-flex; align-items:center; gap:4px; font-size:0.68rem; font-weight:600; padding:2px 8px; border-radius:12px; }
.tag-mapel  { background:rgba(13,110,253,0.08); color:#0d6efd; }
.tag-date   { background:rgba(108,117,125,0.08); color:#6c757d; }

.nilai-badge { display:inline-flex; align-items:center; justify-content:center; min-width:48px; padding:4px 10px; border-radius:20px; font-weight:800; font-size:0.82rem; flex-shrink:0; }
.nilai-a  { background:rgba(32,201,151,.12);  color:#198754; }
.nilai-b  { background:rgba(13,110,253,.1);   color:#0d6efd; }
.nilai-c  { background:rgba(255,193,7,.15);   color:#856404; }
.nilai-d  { background:rgba(220,53,69,.1);    color:#dc3545; }
.nilai-na { background:#f0f4ff; color:#94a3b8; }

.btn-cetak { display:inline-flex; align-items:center; gap:5px; padding:7px 13px; background:linear-gradient(135deg,#198754,#20c997); color:#fff; border:none; border-radius:8px; font-size:0.75rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; white-space:nowrap; flex-shrink:0; }
.btn-cetak:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(32,201,151,0.3); color:#fff; }

.search-wrap { position:relative; max-width:280px; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:38px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-clock-history me-2"></i>Riwayat Ujian <span class="count-badge" id="riwayat-count">0 ujian</span></h4>
        <p>Daftar ujian yang telah Anda kerjakan</p>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchRiwayat" class="form-control" placeholder="Cari nama ujian...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="riwayat-shown">0</span> ujian</div>
</div>

<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-list-ul"></i> Daftar Riwayat</div>
    <div class="panel-card-body" id="riwayatUjianContent">
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-hourglass-split"></i></div>
            <h6>Memuat riwayat ujian...</h6>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var allRiwayat = [];

function nilaiBadge(nilai) {
    if (nilai === null || nilai === undefined || nilai === '-' || nilai === '') {
        return '<span class="nilai-badge nilai-na">—</span>';
    }
    var n = parseFloat(nilai);
    if (isNaN(n)) return '<span class="nilai-badge nilai-na">—</span>';
    var cls = n >= 85 ? 'nilai-a' : n >= 70 ? 'nilai-b' : n >= 55 ? 'nilai-c' : 'nilai-d';
    return '<span class="nilai-badge ' + cls + '">' + n.toFixed(1) + '</span>';
}

function renderRiwayat(data) {
    var container = document.getElementById('riwayatUjianContent');
    document.getElementById('riwayat-count').textContent = allRiwayat.length + ' ujian';
    document.getElementById('riwayat-shown').textContent = data.length;

    if (!data.length) {
        container.innerHTML = '<div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Belum ada riwayat ujian</h6><p>Selesaikan ujian untuk melihat riwayat di sini</p></div>';
        return;
    }

    var html = '';
    data.forEach(function(r) {
        var nama    = r.nama || r.title || '-';
        var inisial = nama.substring(0,2).toUpperCase();
        var mapel   = r.mapel || '-';
        var tanggal = r.tanggal || '-';
        var nilai   = r.nilai !== undefined ? r.nilai : null;

        var cetakBtn = '';
        if (nilai !== null && nilai !== '-' && nilai !== '' && r.id) {
            cetakBtn = '<a href="/siswa/ujian/' + r.id + '/hasil"  class="btn-cetak"><i class="bi bi-printer"></i> Cetak</a>';
        }

        html += '<div class="riwayat-item" data-nama="' + nama.toLowerCase() + '">' +
            '<div class="riwayat-avatar">' + inisial + '</div>' +
            '<div class="riwayat-info">' +
                '<div class="riwayat-name">' + nama + '</div>' +
                '<div class="riwayat-meta">' +
                    '<span class="meta-tag tag-mapel"><i class="bi bi-journal"></i> ' + mapel + '</span>' +
                    '<span class="meta-tag tag-date"><i class="bi bi-calendar"></i> ' + tanggal + '</span>' +
                '</div>' +
            '</div>' +
            nilaiBadge(nilai) +
            cetakBtn +
        '</div>';
    });
    container.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/siswa/ujian/riwayat/json', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) {
        allRiwayat = Array.isArray(data) ? data : (data.data || []);
        renderRiwayat(allRiwayat);
    })
    .catch(function() {
        document.getElementById('riwayatUjianContent').innerHTML =
            '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6><p>Cek koneksi atau hubungi admin</p></div>';
    });

    document.getElementById('searchRiwayat').addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var filtered = !q ? allRiwayat : allRiwayat.filter(function(r) {
            return (r.nama||r.title||'').toLowerCase().includes(q);
        });
        renderRiwayat(filtered);
    });
});
</script>
@endpush