@extends('layouts.master')

@section('title', 'Laporan Hasil Ujian')

@push('styles')
<style>
/* ── Page header ── */
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px; padding: 24px 28px; color: #fff;
    position: relative; overflow: hidden; margin-bottom: 24px;
}
.page-header::before {
    content:''; position:absolute; width:220px; height:220px;
    background:rgba(255,255,255,0.07); border-radius:50%;
    top:-60px; right:-60px; pointer-events:none;
}
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }

/* ── Panel cards ── */
.panel-card {
    background:#fff; border-radius:16px;
    border:1px solid var(--border-color);
    box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:24px;
}
.panel-card-header {
    padding:16px 20px; border-bottom:1px solid var(--border-color);
    background:#f0f4ff; display:flex; align-items:center; gap:8px;
    font-weight:700; font-size:0.9rem; color:var(--text-main);
}
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:20px; }

/* ── Stat chips ── */
.stat-chips { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:4px; }
.stat-chip {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(13,110,253,0.07); border:1px solid rgba(13,110,253,0.12);
    border-radius:50px; padding:10px 18px; font-size:0.82rem; font-weight:600; color:var(--primary);
}
.stat-chip .stat-val { font-size:1.1rem; font-weight:800; color:var(--text-main); }
.stat-chip.green { background:rgba(32,201,151,0.08); border-color:rgba(32,201,151,0.15); color:#198754; }
.stat-chip.red   { background:rgba(220,53,69,0.08);  border-color:rgba(220,53,69,0.12);  color:#dc3545; }
.stat-chip.yellow{ background:rgba(255,193,7,0.1);   border-color:rgba(255,193,7,0.2);   color:#856404; }

/* ── TTD area ── */
.ttd-wrap {
    background:#f8faff; border:1px solid var(--border-color);
    border-radius:12px; padding:16px; display:inline-flex;
    flex-direction:column; gap:10px; align-items:flex-start;
}
.ttd-wrap label { font-size:0.78rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; }
#ttdCanvas {
    border:1.5px solid rgba(13,110,253,0.2); border-radius:10px;
    background:#fff; cursor:crosshair; display:block;
    box-shadow:0 2px 8px rgba(13,110,253,0.08);
}

/* ── Export buttons ── */
.export-bar { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px; }
.btn-export {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:50px; font-size:0.8rem; font-weight:600;
    border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif;
}
.btn-export-excel { background:rgba(32,201,151,0.12); color:#198754; border:1px solid rgba(32,201,151,0.25); }
.btn-export-excel:hover { background:#198754; color:#fff; transform:translateY(-1px); }
.btn-export-pdf   { background:rgba(220,53,69,0.1);  color:#dc3545; border:1px solid rgba(220,53,69,0.2); }
.btn-export-pdf:hover   { background:#dc3545; color:#fff; transform:translateY(-1px); }
.btn-export-prev  { background:rgba(13,110,253,0.08); color:var(--primary); border:1px solid rgba(13,110,253,0.15); }
.btn-export-prev:hover  { background:var(--primary); color:#fff; transform:translateY(-1px); }
.btn-export-ttd   { background:rgba(255,193,7,0.12); color:#856404; border:1px solid rgba(255,193,7,0.25); }
.btn-export-ttd:hover   { background:#ffc107; color:#000; transform:translateY(-1px); }

/* ── Filter selects ── */
.filter-select {
    height:40px; border-radius:50px; border:1.5px solid var(--border-color);
    font-size:0.875rem; padding:0 16px; transition:var(--transition); cursor:pointer;
}
.filter-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

/* ── Tabs ── */
.laporan-tabs { display:flex; gap:4px; margin-bottom:16px; background:#f0f4ff; border-radius:50px; padding:4px; width:fit-content; }
.laporan-tab {
    padding:8px 20px; border-radius:50px; font-size:0.82rem; font-weight:600;
    cursor:pointer; border:none; background:transparent; color:var(--text-muted);
    transition:var(--transition); font-family:'Poppins',sans-serif;
}
.laporan-tab.active { background:#fff; color:var(--primary); box-shadow:0 2px 8px rgba(13,110,253,0.12); }

/* ── Table ── */
.table-wrap { background:#fff; border-radius:12px; overflow:hidden; border:1px solid var(--border-color); }
.table-wrap .table { margin:0; font-size:0.85rem; }
.table-wrap .table thead th {
    background:#f0f4ff; font-weight:600; font-size:0.75rem; text-transform:uppercase;
    letter-spacing:0.4px; padding:12px 16px; border-bottom:1px solid var(--border-color);
    color:var(--text-main); white-space:nowrap;
}
.table-wrap .table tbody td {
    padding:12px 16px; vertical-align:middle;
    border-bottom:1px solid rgba(13,110,253,0.04); color:var(--text-main);
}
.table-wrap .table tbody tr:last-child td { border-bottom:none; }
.table-wrap .table tbody tr:hover { background:rgba(13,110,253,0.025); }

/* ── Nilai badge ── */
.nilai-badge { display:inline-flex; align-items:center; justify-content:center; min-width:50px; padding:4px 10px; border-radius:20px; font-weight:700; font-size:0.82rem; }
.nilai-a { background:rgba(32,201,151,.12); color:#198754; }
.nilai-b { background:rgba(13,110,253,.1);  color:var(--primary); }
.nilai-c { background:rgba(255,193,7,.15);  color:#856404; }
.nilai-d { background:rgba(220,53,69,.1);   color:#dc3545; }
.nilai-na{ background:#f0f4ff; color:#94a3b8; }

/* ── Empty state ── */
.empty-state { text-align:center; padding:48px 24px; }
.empty-state .empty-icon {
    width:68px; height:68px; background:rgba(13,110,253,0.07);
    border-radius:50%; display:inline-flex; align-items:center;
    justify-content:center; font-size:1.7rem; color:var(--primary); margin-bottom:14px;
}
.empty-state h6 { font-weight:700; color:var(--text-main); margin-bottom:5px; }
.empty-state p  { font-size:0.83rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-bar-chart me-2"></i>Laporan Hasil Ujian</h4>
        <p>Rekap dan analisis nilai siswa berdasarkan ujian dan kelas</p>
    </div>
</div>

{{-- ── FILTER ── --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-funnel"></i> Filter Laporan</div>
    <div class="panel-card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Ujian</label>
                <select class="form-select filter-select w-100" id="ujianSelect">
                    <option value="">Semua Ujian</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas</label>
                <select class="form-select filter-select w-100" id="kelasSelect">
                    <option value="">Semua Kelas</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary w-100" id="btnFilter" style="border-radius:50px;height:40px;">
                    <i class="bi bi-search me-1"></i> Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── STATISTIK + EXPORT + TTD + TABS ── --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-graph-up"></i> Hasil Laporan</div>
    <div class="panel-card-body">

        {{-- Statistik --}}
        <div id="statistikBox" class="stat-chips mb-4" style="display:none;">
            <div class="stat-chip"><i class="bi bi-people"></i><div><div style="font-size:.68rem;">Peserta</div><div class="stat-val" id="statPeserta">—</div></div></div>
            <div class="stat-chip"><i class="bi bi-calculator"></i><div><div style="font-size:.68rem;">Rata-rata</div><div class="stat-val" id="statRata">—</div></div></div>
            <div class="stat-chip green"><i class="bi bi-arrow-up-circle"></i><div><div style="font-size:.68rem;">Tertinggi</div><div class="stat-val" id="statTinggi">—</div></div></div>
            <div class="stat-chip red"><i class="bi bi-arrow-down-circle"></i><div><div style="font-size:.68rem;">Terendah</div><div class="stat-val" id="statRendah">—</div></div></div>
        </div>

        {{-- Export bar --}}
        <div class="export-bar">
            <button class="btn-export btn-export-excel" id="btnExportExcel"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
            <button class="btn-export btn-export-pdf"   id="btnExportPdf"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
            <button class="btn-export btn-export-prev"  id="btnPreviewPdf"><i class="bi bi-eye"></i> Preview PDF</button>
        </div>

        {{-- TTD --}}
        <div class="ttd-wrap mb-4">
            <label><i class="bi bi-pen me-1"></i>Tanda Tangan Digital (TTD)</label>
            <canvas id="ttdCanvas" width="300" height="100"></canvas>
            <button type="button" class="btn-export btn-export-ttd" id="clearTtd" style="border-radius:8px;">
                <i class="bi bi-eraser"></i> Bersihkan
            </button>
            <input type="hidden" id="ttdInput">
        </div>

        {{-- Tabs --}}
        <div class="laporan-tabs">
            <button class="laporan-tab active" id="tab-detail" data-target="tabDetail">Detail Ujian</button>
            <button class="laporan-tab"        id="tab-rekap"  data-target="tabRekap">Rekap Per Siswa</button>
        </div>

        {{-- Tab: Detail --}}
        <div id="tabDetail">
            <div class="table-wrap">
                <div class="table-responsive">
                    <table class="table" id="laporanTable">
                        <thead>
                            <tr>
                                <th style="width:48px;">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Ujian</th>
                                <th>Nilai</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi</th>
                            </tr>
                        </thead>
                        <tbody id="laporanTbody">
                            <tr><td colspan="8">
                                <div class="empty-state"><div class="empty-icon"><i class="bi bi-funnel"></i></div>
                                <h6>Pilih filter untuk melihat data</h6><p>Atur ujian dan kelas lalu klik Tampilkan</p></div>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tab: Rekap --}}
        <div id="tabRekap" style="display:none;">
            <div class="table-wrap">
                <div class="table-responsive">
                    <table class="table" id="rekapTable">
                        <thead>
                            <tr>
                                <th style="width:48px;">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Rata-rata Nilai</th>
                                <th>Ujian Diikuti</th>
                            </tr>
                        </thead>
                        <tbody id="rekapTbody">
                            <tr><td colspan="5">
                                <div class="empty-state"><div class="empty-icon"><i class="bi bi-funnel"></i></div>
                                <h6>Pilih ujian dan kelas</h6><p>Rekap per siswa akan muncul di sini</p></div>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ── TTD canvas ── */
    var ttdCanvas = document.getElementById('ttdCanvas');
    var ttdInput  = document.getElementById('ttdInput');
    var ctx       = ttdCanvas.getContext('2d');
    var drawing   = false;

    fetch('/admin/ttd/json')
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (!data.ttd_signature) return;
        var img = new Image();
        img.onload = function() { ctx.drawImage(img, 0, 0, 300, 100); saveTtd(); };
        img.src = data.ttd_signature;
    });

    ttdCanvas.addEventListener('mousedown', function(e) { drawing=true; ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY); });
    ttdCanvas.addEventListener('mousemove', function(e) { if(drawing){ ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke(); } });
    ttdCanvas.addEventListener('mouseup',   function()  { drawing=false; saveTtd(); });
    ttdCanvas.addEventListener('mouseleave',function()  { drawing=false; });
    document.getElementById('clearTtd').addEventListener('click', function() { ctx.clearRect(0,0,300,100); saveTtd(); });
    function saveTtd() { ttdInput.value = ttdCanvas.toDataURL('image/png'); }

    /* ── Tabs ── */
    document.querySelectorAll('.laporan-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.laporan-tab').forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            document.getElementById('tabDetail').style.display = this.getAttribute('data-target') === 'tabDetail' ? '' : 'none';
            document.getElementById('tabRekap').style.display  = this.getAttribute('data-target') === 'tabRekap'  ? '' : 'none';
            if (this.getAttribute('data-target') === 'tabRekap') loadRekap();
        });
    });

    /* ── Helper: nilai badge ── */
    function nilaiBadge(nilai) {
        if (nilai === null || nilai === undefined || nilai === '') return '<span class="nilai-badge nilai-na">—</span>';
        var n = parseFloat(nilai);
        var cls = n >= 85 ? 'nilai-a' : n >= 70 ? 'nilai-b' : n >= 55 ? 'nilai-c' : 'nilai-d';
        return '<span class="nilai-badge ' + cls + '">' + Number(nilai).toFixed(1) + '</span>';
    }

    /* ── Load filter options ── */
    function loadFilterOptions() {
        Promise.all([
            fetch('/admin/ujian/list', { headers:{'Accept':'application/json'} }).then(function(r){ return r.ok ? r.json() : []; }),
            fetch('/admin/kelas/list', { headers:{'Accept':'application/json'} }).then(function(r){ return r.ok ? r.json() : []; }),
        ])
        .then(function(results) {
            var ujianOpt = '<option value="">Semua Ujian</option>';
            results[0].forEach(function(u) { ujianOpt += '<option value="' + u.id + '">' + (u.nama || '') + '</option>'; });
            document.getElementById('ujianSelect').innerHTML = ujianOpt;

            var kelasOpt = '<option value="">Semua Kelas</option>';
            results[1].forEach(function(k) { kelasOpt += '<option value="' + k.id + '">' + (k.nama || k.name || '') + '</option>'; });
            document.getElementById('kelasSelect').innerHTML = kelasOpt;

            loadLaporan();
        });
    }

    /* ── Load laporan detail ── */
    function loadLaporan() {
        var ujianId = document.getElementById('ujianSelect').value;
        var kelasId = document.getElementById('kelasSelect').value;
        var tbody   = document.getElementById('laporanTbody');

        tbody.innerHTML = '<tr><td colspan="8"><div style="text-align:center;padding:32px;color:var(--text-muted);"><i class="bi bi-hourglass-split me-2"></i>Memuat data...</div></td></tr>';

        fetch('/admin/laporan/data?ujian_id=' + ujianId + '&kelas_id=' + kelasId, { headers:{'Accept':'application/json'} })
        .then(function(r) { return r.json(); })
        .then(function(resp) {
            /* Statistik */
            if (resp.statistik) {
                document.getElementById('statistikBox').style.display = 'flex';
                document.getElementById('statPeserta').textContent = resp.statistik.jumlah_peserta ?? '—';
                document.getElementById('statRata').textContent    = resp.statistik.rata_rata !== null ? Number(resp.statistik.rata_rata).toFixed(1) : '—';
                document.getElementById('statTinggi').textContent  = resp.statistik.nilai_tertinggi ?? '—';
                document.getElementById('statRendah').textContent  = resp.statistik.nilai_terendah  ?? '—';
            }

            if (!resp.data || !resp.data.length) {
                tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Data tidak ditemukan</h6><p>Coba ubah filter ujian atau kelas</p></div></td></tr>';
                return;
            }

            var rows = '';
            resp.data.forEach(function(d, i) {
                rows += '<tr>' +
                    '<td>' + (i+1) + '</td>' +
                    '<td style="font-weight:600;">' + (d.nama  || '-') + '</td>' +
                    '<td>' + (d.kelas || '-') + '</td>' +
                    '<td>' + (d.ujian || '-') + '</td>' +
                    '<td>' + nilaiBadge(d.nilai) + '</td>' +
                    '<td style="font-size:.8rem;">' + (d.mulai   || '-') + '</td>' +
                    '<td style="font-size:.8rem;">' + (d.selesai || '-') + '</td>' +
                    '<td style="font-size:.8rem;">' + (d.durasi  || '-') + '</td>' +
                '</tr>';
            });
            tbody.innerHTML = rows;
        })
        .catch(function() {
            tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6><p>Cek koneksi atau backend</p></div></td></tr>';
        });
    }

    /* ── Load rekap per siswa ── */
    function loadRekap() {
        var ujianId = document.getElementById('ujianSelect').value;
        var kelasId = document.getElementById('kelasSelect').value;
        var tbody   = document.getElementById('rekapTbody');

        if (!ujianId || !kelasId) {
            tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-funnel"></i></div><h6>Pilih ujian dan kelas</h6></div></td></tr>';
            return;
        }

        tbody.innerHTML = '<tr><td colspan="5"><div style="text-align:center;padding:32px;color:var(--text-muted);"><i class="bi bi-hourglass-split me-2"></i>Memuat rekap...</div></td></tr>';

        fetch('/admin/laporan/rekap-siswa?ujian_id=' + ujianId + '&kelas_id=' + kelasId, { headers:{'Accept':'application/json'} })
        .then(function(r) { return r.json(); })
        .then(function(resp) {
            if (!resp.data || !resp.data.length) {
                tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Data tidak ditemukan</h6></div></td></tr>';
                return;
            }
            var rows = '';
            resp.data.forEach(function(d, i) {
                var nilai = d.rata_rata !== undefined ? d.rata_rata : d.nilai;
                rows += '<tr>' +
                    '<td>' + (i+1) + '</td>' +
                    '<td style="font-weight:600;">' + (d.nama  || '-') + '</td>' +
                    '<td>' + (d.kelas || '-') + '</td>' +
                    '<td>' + nilaiBadge(nilai) + '</td>' +
                    '<td>' + (d.ujian || '-') + '</td>' +
                '</tr>';
            });
            tbody.innerHTML = rows;
        })
        .catch(function() {
            tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat rekap</h6></div></td></tr>';
        });
    }

    /* ── Helper: get TTD value (fallback to backend) ── */
    function getTtd(callback) {
        var ttd = document.getElementById('ttdInput').value;
        if (ttd && !ttd.endsWith('base64,iVBORw0KGgoAAAANSUhEUgAAASwAAABkCAYAAAB')) {
            callback(ttd); return;
        }
        fetch('/admin/ttd/json').then(function(r){return r.json();}).then(function(data){
            callback(data.ttd_signature || '');
        });
    }

    /* ── Button events ── */
    document.getElementById('btnFilter').addEventListener('click', loadLaporan);
    document.getElementById('ujianSelect').addEventListener('change', function() { loadLaporan(); });
    document.getElementById('kelasSelect').addEventListener('change', function() { loadLaporan(); });

    document.getElementById('btnExportExcel').addEventListener('click', function() {
        var u = document.getElementById('ujianSelect').value;
        var k = document.getElementById('kelasSelect').value;
        window.open('/admin/laporan/export-excel?ujian_id=' + u + '&kelas_id=' + k);
    });

    document.getElementById('btnExportPdf').addEventListener('click', function() {
        var u = document.getElementById('ujianSelect').value;
        var k = document.getElementById('kelasSelect').value;
        getTtd(function(ttd) {
            window.open('/admin/laporan/export-pdf?ujian_id=' + u + '&kelas_id=' + k + '&ttd=' + encodeURIComponent(ttd));
        });
    });

    document.getElementById('btnPreviewPdf').addEventListener('click', function() {
        var u = document.getElementById('ujianSelect').value;
        var k = document.getElementById('kelasSelect').value;
        getTtd(function(ttd) {
            window.open('/admin/laporan/preview-pdf?ujian_id=' + u + '&kelas_id=' + k + '&ttd=' + encodeURIComponent(ttd));
        });
    });

    /* ── Init ── */
    loadFilterOptions();
});
</script>
@endpush