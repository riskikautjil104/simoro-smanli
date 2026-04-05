@extends('layouts.master')
@section('title', 'Bank Soal')

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
.panel-card-body { padding:20px; }

.filter-select { height:40px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; padding:0 16px; transition:var(--transition); }
.filter-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:40px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }

.table-card { background:#fff; border-radius:12px; overflow:hidden; border:1px solid var(--border-color); }
.table-card .table { margin:0; font-size:0.83rem; }
.table-card .table thead th { background:#f0f4ff; font-weight:600; font-size:0.73rem; text-transform:uppercase; letter-spacing:0.4px; padding:12px 14px; border-bottom:1px solid var(--border-color); color:var(--text-main); white-space:nowrap; }
.table-card .table tbody td { padding:11px 14px; vertical-align:middle; border-bottom:1px solid rgba(13,110,253,0.04); color:var(--text-main); max-width:220px; }
.table-card .table tbody tr:last-child td { border-bottom:none; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }

.soal-text-cell { max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:500; }
.soal-text-cell img { max-width: 100%; height: auto; max-height: 120px; display: block; border-radius: 4px; }
.badge-tipe { display:inline-flex; align-items:center; gap:4px; font-size:0.7rem; font-weight:700; padding:3px 9px; border-radius:20px; white-space:nowrap; }
.badge-pg    { background:rgba(13,110,253,0.1); color:#0d6efd; }
.badge-essay { background:rgba(111,66,193,0.1); color:#6f42c1; }
.badge-mapel { background:rgba(13,110,253,0.08); color:#0d6efd; font-size:0.7rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.badge-kelas { background:rgba(32,201,151,0.1); color:#198754; font-size:0.7rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.kunci-badge { display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:50%; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; font-size:0.72rem; font-weight:800; }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }

.btn-header { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,0.2); color:#fff !important; border:1.5px solid rgba(255,255,255,0.45); padding:9px 20px; border-radius:50px; font-size:0.875rem; font-weight:600; backdrop-filter:blur(8px); cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; }
.btn-header:hover { background:rgba(255,255,255,0.32); transform:translateY(-2px); color:#fff !important; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-archive me-2"></i>Bank Soal <span class="count-badge" id="soal-count">0 soal</span></h4>
            <p>Kelola seluruh soal yang telah Anda buat</p>
        </div>
        <a href="{{ route('guru.soal.create') }}" class="btn-header">
            <i class="bi bi-plus-lg"></i> Tambah Soal
        </a>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-funnel"></i> Filter & Pencarian</div>
    <div class="panel-card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Kelas</label>
                <select id="filter-kelas" class="form-select filter-select w-100">
                    <option value="">Semua Kelas</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mata Pelajaran</label>
                <select id="filter-mapel" class="form-select filter-select w-100">
                    <option value="">Semua Mapel</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ujian</label>
                <select id="filter-ujian" class="form-select filter-select w-100">
                    <option value="">Semua Ujian</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari Soal</label>
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchSoal" class="form-control" placeholder="Cari pertanyaan...">
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button id="btn-filter" class="btn btn-primary" style="border-radius:50px;padding:8px 22px;">
                <i class="bi bi-search me-1"></i> Terapkan
            </button>
            <button id="btn-reset" class="btn btn-outline-secondary ms-2" style="border-radius:50px;padding:8px 20px;">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
            <span class="ms-3" style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="soal-shown">0</span> soal</span>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="soal-table">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Pertanyaan</th>
                    <th>Tipe</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Ujian</th>
                    <th>Opsi A</th>
                    <th>Opsi B</th>
                    <th>Opsi C</th>
                    <th>Opsi D</th>
                    <th>Kunci</th>
                </tr>
            </thead>
            <tbody id="soal-tbody">
                <tr><td colspan="11">
                    <div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
var soalData    = [];
var examsData   = [];
var subjectsData = [];
var kelasData   = [];

function tipeBadge(type) {
    var t = (type||'').toLowerCase();
    if (t === 'essay' || t === 'esai') return '<span class="badge-tipe badge-essay"><i class="bi bi-pencil-square"></i> Esai</span>';
    return '<span class="badge-tipe badge-pg"><i class="bi bi-ui-radios"></i> PG</span>';
}

function renderTable(data) {
    var tbody = document.getElementById('soal-tbody');
    document.getElementById('soal-count').textContent = soalData.length + ' soal';
    document.getElementById('soal-shown').textContent = data.length;

    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="11"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Data tidak ditemukan</h6><p>Coba ubah filter atau tambah soal baru</p></div></td></tr>';
        return;
    }
    var rows = '';
    data.forEach(function(s, idx) {
        var ujian    = examsData.find(function(e){ return e.id === s.exam_id; });
        var kelasNm  = ujian && ujian.school_class ? ujian.school_class.name : '-';
        var ujianNm  = ujian ? ujian.title : '-';
        var mapelNm  = s.subject ? s.subject.name : '-';
        var pertanyaan = s.pertanyaan || s.question_text || '-';
        var kunci    = s.jawaban_benar || s.answer_key || '';

        rows += '<tr>' +
            '<td>' + (idx+1) + '</td>' +
            '<td><div class="soal-text-cell" title="' + pertanyaan.replace(/"/g,'&quot;') + '">' + pertanyaan + '</div></td>' +
            '<td>' + tipeBadge(s.type) + '</td>' +
            '<td><span class="badge-mapel">' + mapelNm + '</span></td>' +
            '<td><span class="badge-kelas">' + kelasNm + '</span></td>' +
            '<td style="font-size:.78rem;">' + ujianNm + '</td>' +
            '<td style="font-size:.78rem;">' + (s.opsi_a||'-') + '</td>' +
            '<td style="font-size:.78rem;">' + (s.opsi_b||'-') + '</td>' +
            '<td style="font-size:.78rem;">' + (s.opsi_c||'-') + '</td>' +
            '<td style="font-size:.78rem;">' + (s.opsi_d||'-') + '</td>' +
            '<td>' + (kunci ? '<span class="kunci-badge">' + kunci + '</span>' : '<span style="color:#ccc;">—</span>') + '</td>' +
        '</tr>';
    });
    tbody.innerHTML = rows;
}

function applyFilters() {
    var kelasId  = document.getElementById('filter-kelas').value;
    var mapelId  = document.getElementById('filter-mapel').value;
    var ujianId  = document.getElementById('filter-ujian').value;
    var q        = document.getElementById('searchSoal').value.toLowerCase().trim();
    var filtered = soalData;

    if (kelasId) filtered = filtered.filter(function(s) {
        var ujian = examsData.find(function(e){ return e.id === s.exam_id; });
        return ujian && ujian.school_class && ujian.school_class.id == kelasId;
    });
    if (mapelId) filtered = filtered.filter(function(s){ return s.subject_id == mapelId; });
    if (ujianId) filtered = filtered.filter(function(s){ return s.exam_id == ujianId; });
    if (q) filtered = filtered.filter(function(s){
        return (s.pertanyaan||s.question_text||'').toLowerCase().includes(q);
    });

    renderTable(filtered);
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/guru/soal/filters', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(filter) {
        subjectsData = filter.subjects || [];
        examsData    = filter.exams    || [];

        var kelasSet = new Map();
        subjectsData.forEach(function(m){ (m.classes||[]).forEach(function(k){ kelasSet.set(k.id, k.name); }); });
        examsData.forEach(function(e){ if(e.school_class) kelasSet.set(e.school_class.id, e.school_class.name); });
        kelasData = Array.from(kelasSet, function(e){ return {id:e[0],name:e[1]}; });

        var kSel = document.getElementById('filter-kelas');
        kelasData.forEach(function(k){ kSel.innerHTML += '<option value="'+k.id+'">'+k.name+'</option>'; });

        var mSel = document.getElementById('filter-mapel');
        subjectsData.forEach(function(m){ mSel.innerHTML += '<option value="'+m.id+'">'+m.name+'</option>'; });

        var uSel = document.getElementById('filter-ujian');
        examsData.forEach(function(u){ uSel.innerHTML += '<option value="'+u.id+'">'+(u.title||u.nama||'')+'</option>'; });

        /* After filters ready, load soal */
        return fetch('/guru/soal/list', { headers:{'Accept':'application/json'} });
    })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) { soalData = data; renderTable(data); })
    .catch(function() {
        document.getElementById('soal-tbody').innerHTML = '<tr><td colspan="11"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
    });

    document.getElementById('btn-filter').addEventListener('click', applyFilters);
    document.getElementById('searchSoal').addEventListener('input', applyFilters);
    document.getElementById('btn-reset').addEventListener('click', function() {
        document.getElementById('filter-kelas').value = '';
        document.getElementById('filter-mapel').value = '';
        document.getElementById('filter-ujian').value = '';
        document.getElementById('searchSoal').value   = '';
        renderTable(soalData);
    });
});
</script>
@endpush