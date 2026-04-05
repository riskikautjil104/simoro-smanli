@extends('layouts.master')
@section('title', 'Hasil Ujian')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:24px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color); background:#f0f4ff; display:flex; align-items:center; gap:8px; font-weight:700; font-size:0.9rem; color:var(--text-main); }
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:20px; }

.filter-select { height:40px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; padding:0 16px; transition:var(--transition); }
.filter-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.export-bar { display:flex; flex-wrap:wrap; gap:8px; }
.btn-export { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:50px; font-size:0.8rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; }
.btn-export-pdf   { background:rgba(220,53,69,0.1); color:#dc3545; border:1px solid rgba(220,53,69,0.2); }
.btn-export-pdf:hover   { background:#dc3545; color:#fff; transform:translateY(-1px); }
.btn-export-excel { background:rgba(32,201,151,0.12); color:#198754; border:1px solid rgba(32,201,151,0.25); }
.btn-export-excel:hover { background:#198754; color:#fff; transform:translateY(-1px); }

/* TTD */
.ttd-wrap { background:#f8faff; border:1px solid var(--border-color); border-radius:12px; padding:16px; display:inline-flex; flex-direction:column; gap:10px; align-items:flex-start; }
.ttd-wrap label { font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; }
#ttd-canvas { border:1.5px solid rgba(13,110,253,0.2); border-radius:10px; background:#fff; cursor:crosshair; display:block; box-shadow:0 2px 8px rgba(13,110,253,0.08); }
.btn-export-ttd { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; background:rgba(255,193,7,0.12); color:#856404; border:1px solid rgba(255,193,7,0.25); }
.btn-export-ttd:hover { background:#ffc107; color:#000; transform:translateY(-1px); }

/* Table */
.table-card { background:#fff; border-radius:12px; overflow:hidden; border:1px solid var(--border-color); }
.table-card .table { margin:0; font-size:0.85rem; }
.table-card .table thead th { background:#f0f4ff; font-weight:600; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.4px; padding:12px 16px; border-bottom:1px solid var(--border-color); color:var(--text-main); white-space:nowrap; }
.table-card .table tbody td { padding:12px 16px; vertical-align:middle; border-bottom:1px solid rgba(13,110,253,0.04); }
.table-card .table tbody tr:last-child td { border-bottom:none; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }

.nilai-badge { display:inline-flex; align-items:center; justify-content:center; min-width:48px; padding:4px 10px; border-radius:20px; font-weight:700; font-size:0.82rem; }
.nilai-a { background:rgba(32,201,151,.12); color:#198754; }
.nilai-b { background:rgba(13,110,253,.1);  color:var(--primary); }
.nilai-c { background:rgba(255,193,7,.15);  color:#856404; }
.nilai-d { background:rgba(220,53,69,.1);   color:#dc3545; }
.nilai-na{ background:#f0f4ff; color:#94a3b8; }

.status-badge { display:inline-flex; align-items:center; gap:4px; font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:20px; }
.status-selesai  { background:rgba(32,201,151,0.12); color:#198754; }
.status-proses   { background:rgba(255,193,7,0.12);  color:#856404; }
.status-lainnya  { background:rgba(108,117,125,0.1); color:#6c757d; }

.empty-state { text-align:center; padding:48px 24px; }
.empty-state .empty-icon { width:68px; height:68px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.7rem; color:var(--primary); margin-bottom:14px; }
.empty-state h6 { font-weight:700; margin-bottom:5px; }
.empty-state p  { font-size:0.83rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-bar-chart-line me-2"></i>Hasil Ujian Siswa</h4>
        <p>Lihat dan ekspor hasil ujian siswa yang Anda ampu</p>
    </div>
</div>

{{-- Filter --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-funnel"></i> Filter</div>
    <div class="panel-card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Siswa</label>
                <select id="filter-siswa" class="form-select filter-select w-100">
                    <option value="">Semua Siswa</option>
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
                <button id="btn-filter" class="btn btn-primary w-100" style="border-radius:50px;height:40px;">
                    <i class="bi bi-search me-1"></i> Terapkan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hasil + TTD --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-table"></i> Data Hasil Ujian</div>
    <div class="panel-card-body">

        {{-- Export --}}
        <div class="d-flex flex-wrap gap-3 align-items-start mb-4">
            <div class="export-bar">
                <button class="btn-export btn-export-pdf"   id="btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                <button class="btn-export btn-export-excel" id="btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
            </div>
            <div class="ttd-wrap">
                <label><i class="bi bi-pen me-1"></i>Tanda Tangan Guru</label>
                <canvas id="ttd-canvas" width="260" height="80"></canvas>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn-export-ttd" id="btn-clear-ttd"><i class="bi bi-eraser"></i> Bersihkan</button>
                    <div id="ttd-guru-preview"></div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="table" id="hasil-table">
                    <thead>
                        <tr>
                            <th style="width:48px;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Ujian</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>TTD Siswa</th>
                        </tr>
                    </thead>
                    <tbody id="hasil-tbody">
                        <tr><td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="bi bi-hourglass-split"></i></div>
                                <h6>Memuat data...</h6>
                            </div>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
var hasilData = [];

function nilaiBadge(nilai) {
    if (nilai === null || nilai === undefined || nilai === '') return '<span class="nilai-badge nilai-na">—</span>';
    var n = parseFloat(nilai);
    var cls = n >= 85 ? 'nilai-a' : n >= 70 ? 'nilai-b' : n >= 55 ? 'nilai-c' : 'nilai-d';
    return '<span class="nilai-badge ' + cls + '">' + n.toFixed(1) + '</span>';
}

function statusBadge(status) {
    if (!status) return '<span class="status-badge status-lainnya">—</span>';
    var s = status.toLowerCase();
    if (s.includes('selesai')) return '<span class="status-badge status-selesai"><i class="bi bi-check-circle"></i> ' + status + '</span>';
    if (s.includes('proses') || s.includes('berjalan')) return '<span class="status-badge status-proses"><i class="bi bi-clock"></i> ' + status + '</span>';
    return '<span class="status-badge status-lainnya">' + status + '</span>';
}

function renderTable(data) {
    var tbody = document.getElementById('hasil-tbody');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Data tidak ditemukan</h6><p>Coba ubah filter</p></div></td></tr>';
        return;
    }
    var rows = '';
    data.forEach(function(h, idx) {
        var siswaNama = h.student ? h.student.name : '-';
        var kelasNama = h.exam && h.exam.school_class ? h.exam.school_class.name : '-';
        var ujianNama = h.exam ? (h.exam.title || h.exam.nama || '-') : '-';
        var mapelNama = h.exam && h.exam.subject ? h.exam.subject.name : '-';
        var ttdImg    = h.student && h.student.ttd_signature
            ? '<img src="' + h.student.ttd_signature + '" style="max-width:80px;max-height:36px;border-radius:4px;">'
            : '<span style="color:#ccc;font-size:.75rem;">—</span>';
        rows += '<tr>' +
            '<td>' + (idx+1) + '</td>' +
            '<td style="font-weight:600;">' + siswaNama + '</td>' +
            '<td>' + kelasNama + '</td>' +
            '<td>' + ujianNama + '</td>' +
            '<td>' + mapelNama + '</td>' +
            '<td>' + nilaiBadge(h.score ?? h.nilai) + '</td>' +
            '<td>' + statusBadge(h.status) + '</td>' +
            '<td>' + ttdImg + '</td>' +
        '</tr>';
    });
    tbody.innerHTML = rows;
}

function applyFilters() {
    var siswaId = document.getElementById('filter-siswa').value;
    var mapelId = document.getElementById('filter-mapel').value;
    var ujianId = document.getElementById('filter-ujian').value;
    var filtered = hasilData;
    if (siswaId) filtered = filtered.filter(function(h){ return h.student && h.student.id == siswaId; });
    if (mapelId) filtered = filtered.filter(function(h){ return h.exam && h.exam.subject && h.exam.subject.id == mapelId; });
    if (ujianId) filtered = filtered.filter(function(h){ return h.exam && h.exam.id == ujianId; });
    renderTable(filtered);
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── TTD Canvas ── */
    var canvas  = document.getElementById('ttd-canvas');
    var ctx     = canvas.getContext('2d');
    var drawing = false;
    canvas.addEventListener('mousedown', function(e) { drawing=true; ctx.beginPath(); ctx.moveTo(e.offsetX,e.offsetY); });
    canvas.addEventListener('mousemove', function(e) { if(!drawing) return; ctx.lineTo(e.offsetX,e.offsetY); ctx.stroke(); });
    canvas.addEventListener('mouseup',    function()  { drawing=false; });
    canvas.addEventListener('mouseleave', function()  { drawing=false; });
    document.getElementById('btn-clear-ttd').addEventListener('click', function() {
        ctx.clearRect(0,0,canvas.width,canvas.height);
    });

    /* ── Load filters ── */
    fetch('/guru/hasil/filters')
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(filter) {
        var mapelSel = document.getElementById('filter-mapel');
        (filter.subjects||[]).forEach(function(m){ mapelSel.innerHTML += '<option value="'+m.id+'">'+m.name+'</option>'; });
        var ujianSel = document.getElementById('filter-ujian');
        (filter.exams||[]).forEach(function(u){ ujianSel.innerHTML += '<option value="'+u.id+'">'+(u.title||u.nama||'')+'</option>'; });
    });

    /* ── Load data ── */
    fetch('/guru/hasil/list')
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(data) {
        hasilData = data.results || data || [];

        /* Dropdown siswa unik */
        var siswaSet = new Map();
        hasilData.forEach(function(h){ if(h.student) siswaSet.set(h.student.id, h.student.name); });
        var siswaSel = document.getElementById('filter-siswa');
        siswaSet.forEach(function(name, id){ siswaSel.innerHTML += '<option value="'+id+'">'+name+'</option>'; });

        /* TTD guru */
        if (data.guru_ttd) {
            var img = document.createElement('img');
            img.src = data.guru_ttd;
            img.style.cssText = 'max-width:80px;max-height:40px;border-radius:6px;border:1px solid #e2e8f7;';
            document.getElementById('ttd-guru-preview').appendChild(img);
        }

        renderTable(hasilData);
    })
    .catch(function() {
        document.getElementById('hasil-tbody').innerHTML =
            '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
    });

    document.getElementById('btn-filter').addEventListener('click', applyFilters);

    /* ── Export PDF ── */
    document.getElementById('btn-export-pdf').addEventListener('click', function() {
        var jsPDF = window.jspdf.jsPDF;
        var doc = new jsPDF();
        doc.setFontSize(14); doc.text('Hasil Ujian Siswa', 10, 12);
        doc.setFontSize(9);
        var y = 22;
        hasilData.forEach(function(h, idx) {
            var line = (idx+1) + '. ' + (h.student?h.student.name:'-') + ' | ' + (h.exam?h.exam.title:'-') + ' | Nilai: ' + (h.score??'-');
            doc.text(line, 10, y); y += 8;
            if (y > 280) { doc.addPage(); y = 12; }
        });
        doc.save('hasil-ujian.pdf');
    });

    /* ── Export Excel ── */
    document.getElementById('btn-export-excel').addEventListener('click', function() {
        var ws = XLSX.utils.json_to_sheet(hasilData.map(function(h, idx) { return {
            No: idx+1,
            Siswa: h.student ? h.student.name : '-',
            Kelas: h.exam && h.exam.school_class ? h.exam.school_class.name : '-',
            Ujian: h.exam ? (h.exam.title||'-') : '-',
            Mapel: h.exam && h.exam.subject ? h.exam.subject.name : '-',
            Nilai: h.score ?? '-',
            Status: h.status ?? '-'
        }; }));
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Hasil Ujian');
        XLSX.writeFile(wb, 'hasil-ujian.xlsx');
    });
});
</script>
@endpush