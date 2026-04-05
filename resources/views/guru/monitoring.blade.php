@extends('layouts.master')
@section('title', 'Monitoring Ujian')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }

/* Realtime indicator */
.live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(32,201,151,0.15); border:1px solid rgba(32,201,151,0.3);
    color:#198754; font-size:0.78rem; font-weight:700;
    padding:5px 14px; border-radius:50px;
}
.live-dot {
    width:8px; height:8px; background:#198754; border-radius:50%;
    animation:livePulse 1.5s ease-in-out infinite;
}
@keyframes livePulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(0.7); }
}
.last-updated { font-size:0.75rem; color:var(--text-muted); }

.table-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; }
.table-card .table { margin:0; font-size:0.875rem; }
.table-card .table thead th { background:#f0f4ff; color:var(--text-main); font-weight:600; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; padding:14px 16px; border-bottom:1px solid var(--border-color); white-space:nowrap; }
.table-card .table tbody td { padding:13px 16px; vertical-align:middle; border-bottom:1px solid rgba(13,110,253,0.05); color:var(--text-main); }
.table-card .table tbody tr:last-child td { border-bottom:none; }
.table-card .table tbody tr { transition:background 0.15s; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }

.ujian-avatar { width:36px; height:36px; background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.78rem; flex-shrink:0; box-shadow:0 2px 8px rgba(13,110,253,0.25); }

/* Progress bar */
.progress-wrap { min-width:120px; }
.progress-bar-custom { height:6px; background:#e9ecef; border-radius:10px; overflow:hidden; margin-top:4px; }
.progress-bar-fill   { height:100%; border-radius:10px; background:linear-gradient(90deg,var(--primary),var(--accent)); transition:width .4s ease; }

/* Status badges */
.status-badge { display:inline-flex; align-items:center; gap:5px; font-size:0.75rem; font-weight:700; padding:5px 12px; border-radius:20px; white-space:nowrap; }
.status-berlangsung { background:rgba(255,193,7,0.15); color:#856404; border:1px solid rgba(255,193,7,0.3); }
.status-selesai     { background:rgba(32,201,151,0.12); color:#198754; border:1px solid rgba(32,201,151,0.25); }
.status-belum       { background:rgba(108,117,125,0.1); color:#6c757d; border:1px solid rgba(108,117,125,0.2); }

.btn-act-detail { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; background:rgba(13,202,240,0.1); color:#0a9bba; text-decoration:none; }
.btn-act-detail:hover { background:var(--accent); color:#fff; transform:translateY(-1px); }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }

/* Search */
.search-wrap { position:relative; max-width:280px; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:38px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-tv me-2"></i>Monitoring Ujian <span class="count-badge" id="mon-count">0 ujian</span></h4>
            <p>Pantau keberjalanan ujian secara real-time</p>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="live-badge"><div class="live-dot"></div> Live Update</div>
            <span class="last-updated">Update: <span id="lastUpdated">—</span></span>
        </div>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchMonitoring" class="form-control" placeholder="Cari nama ujian atau kelas...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="mon-shown">0</span> data</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="monitoringTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Ujian</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Progress Peserta</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="monTbody">
                <tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    var allData = [];

    function statusHtml(status) {
        if (!status) return '<span class="status-badge status-belum"><i class="bi bi-clock"></i> Belum Mulai</span>';
        var s = status.toLowerCase();
        if (s.includes('berlangsung') || s.includes('aktif'))
            return '<span class="status-badge status-berlangsung"><i class="bi bi-play-circle"></i> ' + status + '</span>';
        if (s.includes('selesai'))
            return '<span class="status-badge status-selesai"><i class="bi bi-check-circle"></i> Selesai</span>';
        return '<span class="status-badge status-belum"><i class="bi bi-clock"></i> ' + status + '</span>';
    }

    function renderData(data) {
        var tbody = document.getElementById('monTbody');
        document.getElementById('mon-count').textContent = data.length + ' ujian';
        document.getElementById('mon-shown').textContent = data.length;

        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-tv"></i></div><h6>Tidak ada ujian aktif</h6><p>Belum ada ujian yang berjalan saat ini</p></div></td></tr>';
            return;
        }
        var rows = '';
        data.forEach(function(u, i) {
            var inisial  = (u.nama||'U').substring(0,2).toUpperCase();
            var total    = parseInt(u.jumlah_peserta) || 0;
            var selesai  = parseInt(u.peserta_selesai) || 0;
            var pct      = total > 0 ? Math.round((selesai / total) * 100) : 0;

            rows += '<tr data-nama="' + (u.nama||'').toLowerCase() + '" data-kelas="' + (u.kelas||'').toLowerCase() + '">' +
                '<td>' + (i+1) + '</td>' +
                '<td><div class="d-flex align-items-center gap-2"><div class="ujian-avatar">' + inisial + '</div><span style="font-weight:600;">' + (u.nama||'-') + '</span></div></td>' +
                '<td style="font-weight:600;">' + (u.kelas||'-') + '</td>' +
                '<td>' + (u.mapel||'-') + '</td>' +
                '<td>' +
                    '<div class="progress-wrap">' +
                        '<div style="font-size:.78rem;font-weight:600;">' + selesai + ' / ' + total + ' <span style="color:var(--text-muted);font-weight:400;">peserta selesai</span></div>' +
                        '<div class="progress-bar-custom"><div class="progress-bar-fill" style="width:' + pct + '%;"></div></div>' +
                        '<div style="font-size:.7rem;color:var(--text-muted);margin-top:2px;">' + pct + '%</div>' +
                    '</div>' +
                '</td>' +
                '<td>' + statusHtml(u.status) + '</td>' +
            '</tr>';
        });
        tbody.innerHTML = rows;
        applySearch();
    }

    function applySearch() {
        var q = (document.getElementById('searchMonitoring').value || '').toLowerCase().trim();
        var rows = document.querySelectorAll('#monTbody tr[data-nama]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-nama').includes(q) || row.getAttribute('data-kelas').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('mon-shown').textContent = shown;
    }

    document.getElementById('searchMonitoring').addEventListener('input', applySearch);

    function loadMonitoring() {
        fetch('/guru/monitoring/data', { headers:{'Accept':'application/json'}, credentials:'same-origin' })
        .then(function(r) { return r.ok ? r.json() : []; })
        .then(function(data) {
            allData = data;
            renderData(data);
            var now = new Date();
            document.getElementById('lastUpdated').textContent =
                now.getHours().toString().padStart(2,'0') + ':' +
                now.getMinutes().toString().padStart(2,'0') + ':' +
                now.getSeconds().toString().padStart(2,'0');
        })
        .catch(function() {
            document.getElementById('monTbody').innerHTML =
                '<tr><td colspan="6"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6><p>Cek koneksi atau backend</p></div></td></tr>';
        });
    }

    loadMonitoring();
    setInterval(loadMonitoring, 5000);
})();
</script>
@endpush
