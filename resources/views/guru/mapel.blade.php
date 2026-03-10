@extends('layouts.master')
@section('title', 'Mata Pelajaran Saya')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }

.mapel-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }

.mapel-item {
    background:#fff; border-radius:16px;
    border:1px solid var(--border-color); box-shadow:var(--shadow-sm);
    padding:20px; transition:var(--transition); position:relative; overflow:hidden;
}
.mapel-item:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(13,110,253,0.12); border-color:rgba(13,110,253,0.2); }
.mapel-item::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#0d6efd,#0dcaf0); }

.mapel-avatar { width:46px; height:46px; background:linear-gradient(135deg,#0d6efd,#0dcaf0); border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:0.9rem; flex-shrink:0; box-shadow:0 3px 10px rgba(13,110,253,0.25); }

.mapel-name  { font-size:0.95rem; font-weight:700; color:var(--text-main); margin-bottom:4px; }
.kelas-tag   { display:inline-block; background:rgba(32,201,151,0.1); color:#198754; font-size:0.7rem; font-weight:600; padding:2px 8px; border-radius:12px; margin:2px 2px 0 0; }

.mapel-stats { display:flex; gap:12px; margin-top:14px; padding-top:12px; border-top:1px solid var(--border-color); }
.mapel-stat  { display:flex; align-items:center; gap:6px; font-size:0.78rem; font-weight:600; color:var(--text-muted); }
.mapel-stat i { font-size:0.9rem; color:var(--primary); }
.mapel-stat span { font-weight:800; color:var(--text-main); }

.mapel-actions { display:flex; gap:8px; margin-top:14px; }
.btn-mapel-action { display:inline-flex; align-items:center; gap:5px; padding:6px 14px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; }
.btn-soal  { background:rgba(13,110,253,0.1); color:#0d6efd; }
.btn-soal:hover  { background:#0d6efd; color:#fff; transform:translateY(-1px); }
.btn-ujian { background:rgba(255,193,7,0.12); color:#856404; }
.btn-ujian:hover { background:#ffc107; color:#000; transform:translateY(-1px); }

.search-wrap { position:relative; max-width:280px; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:38px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-journal-bookmark me-2"></i>Mata Pelajaran Saya <span class="count-badge" id="mapel-count">0 mapel</span></h4>
        <p>Mata pelajaran yang Anda ampu di SMA Negeri 5 Morotai</p>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchMapel" class="form-control" placeholder="Cari nama mapel...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="mapel-shown">0</span> mapel</div>
</div>

<div id="mapelGrid" class="mapel-grid">
    {{-- skeleton --}}
    @for ($i = 0; $i < 3; $i++)
    <div class="mapel-item" style="opacity:.5;">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:46px;height:46px;border-radius:12px;background:#e2e8f7;"></div>
            <div>
                <div style="width:120px;height:14px;border-radius:6px;background:#e2e8f7;margin-bottom:6px;"></div>
                <div style="width:80px;height:10px;border-radius:6px;background:#e9ecef;"></div>
            </div>
        </div>
        <div style="width:100%;height:40px;border-radius:8px;background:#f0f4ff;"></div>
    </div>
    @endfor
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var allMapel = [];

    fetch('/guru/mapel/list', { headers:{'Accept':'application/json'}, credentials:'same-origin' })
    .then(function(r) { return r.ok ? r.json() : []; })
    .then(function(data) {
        allMapel = data;
        renderMapel(data);
    })
    .catch(function() {
        document.getElementById('mapelGrid').innerHTML =
            '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6><p>Cek koneksi atau backend</p></div>';
    });

    function renderMapel(data) {
        var grid = document.getElementById('mapelGrid');
        document.getElementById('mapel-count').textContent = data.length + ' mapel';
        document.getElementById('mapel-shown').textContent = data.length;

        if (!data.length) {
            grid.innerHTML = '<div class="empty-state"><div class="empty-icon"><i class="bi bi-journal-bookmark"></i></div><h6>Belum ada mata pelajaran</h6><p>Hubungi admin untuk penugasan mapel</p></div>';
            return;
        }

        var html = '';
        data.forEach(function(m) {
            var inisial  = (m.name||'M').substring(0,2).toUpperCase();
            var kelasList = Array.isArray(m.classes) ? m.classes.map(function(k){ return '<span class="kelas-tag">' + (k.name||'') + '</span>'; }).join('') : '<span style="color:#ccc;font-size:.75rem;">—</span>';
            var jumlahSoal  = m.questions ? m.questions.length : (m.questions_count || 0);
            var jumlahUjian = m.exams     ? m.exams.length     : (m.exams_count     || 0);

            html += '<div class="mapel-item" data-nama="' + (m.name||'').toLowerCase() + '">' +
                '<div class="d-flex align-items-center gap-3 mb-2">' +
                    '<div class="mapel-avatar">' + inisial + '</div>' +
                    '<div><div class="mapel-name">' + (m.name||'-') + '</div>' +
                    (m.code ? '<span style="font-size:.72rem;color:var(--text-muted);">Kode: ' + m.code + '</span>' : '') +
                    '</div>' +
                '</div>' +
                '<div>' + kelasList + '</div>' +
                '<div class="mapel-stats">' +
                    '<div class="mapel-stat"><i class="bi bi-question-circle"></i>Soal: <span>' + jumlahSoal + '</span></div>' +
                    '<div class="mapel-stat"><i class="bi bi-clipboard-plus"></i>Ujian: <span>' + jumlahUjian + '</span></div>' +
                '</div>' +
                '<div class="mapel-actions">' +
                    '<a class="btn-mapel-action btn-soal" href="{{ route("guru.soal") }}"><i class="bi bi-archive"></i> Bank Soal</a>' +
                    '<a class="btn-mapel-action btn-ujian" href="{{ route("guru.ujian") }}"><i class="bi bi-clipboard-plus"></i> Ujian</a>' +
                '</div>' +
            '</div>';
        });
        grid.innerHTML = html;
    }

    document.getElementById('searchMapel').addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var items = document.querySelectorAll('#mapelGrid .mapel-item[data-nama]');
        var shown = 0;
        items.forEach(function(item) {
            var match = !q || item.getAttribute('data-nama').includes(q);
            item.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('mapel-shown').textContent = shown;
    });
});
</script>
@endpush