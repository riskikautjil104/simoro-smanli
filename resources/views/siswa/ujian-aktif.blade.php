@extends('layouts.master')
@section('title', 'Ujian Aktif')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }

.ujian-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px; }

.ujian-card {
    background:#fff; border-radius:16px;
    border:1px solid var(--border-color); box-shadow:var(--shadow-sm);
    overflow:hidden; transition:var(--transition); position:relative;
}
.ujian-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(13,110,253,0.12); border-color:rgba(13,110,253,0.2); }
.ujian-card-top { background:linear-gradient(135deg,#0d6efd,#0dcaf0); padding:18px 18px 14px; position:relative; overflow:hidden; }
.ujian-card-top::before { content:''; position:absolute; width:100px; height:100px; background:rgba(255,255,255,0.08); border-radius:50%; top:-30px; right:-20px; }
.ujian-card-avatar { width:44px; height:44px; background:rgba(255,255,255,0.22); border:2px solid rgba(255,255,255,0.35); border-radius:11px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:0.9rem; margin-bottom:10px; position:relative; z-index:1; }
.ujian-card-title { font-size:0.95rem; font-weight:700; color:#fff; position:relative; z-index:1; margin-bottom:4px; line-height:1.4; }
.ujian-card-mapel { font-size:0.72rem; color:rgba(255,255,255,0.75); position:relative; z-index:1; }

/* Status pill on card */
.ujian-card-status { position:absolute; top:12px; right:12px; z-index:2; }
.status-pill { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:0.68rem; font-weight:700; backdrop-filter:blur(6px); }
.status-aktif   { background:rgba(32,201,151,0.25); color:#a7ffcd; border:1px solid rgba(255,255,255,0.2); }
.status-ajukan  { background:rgba(255,193,7,0.3); color:#fff3cd; border:1px solid rgba(255,255,255,0.2); }
.status-ditolak { background:rgba(220,53,69,0.3);  color:#ffcdd2; border:1px solid rgba(255,255,255,0.2); }

.ujian-card-body { padding:14px 18px 18px; }
.ujian-card-meta { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:14px; }
.meta-tag { display:inline-flex; align-items:center; gap:4px; font-size:0.68rem; font-weight:600; padding:3px 9px; border-radius:12px; }
.tag-date  { background:rgba(108,117,125,0.08); color:#6c757d; }
.tag-durasi{ background:rgba(13,202,240,0.1); color:#0a9bba; }

.btn-kerjakan { display:flex; align-items:center; justify-content:center; gap:7px; width:100%; padding:10px; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; border:none; border-radius:10px; font-size:0.85rem; font-weight:700; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; box-shadow:0 3px 12px rgba(13,110,253,0.25); }
.btn-kerjakan:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(13,110,253,0.35); color:#fff; }
.btn-ajukan { display:flex; align-items:center; justify-content:center; gap:7px; width:100%; padding:10px; background:linear-gradient(135deg,#ffc107,#fd7e14); color:#fff; border:none; border-radius:10px; font-size:0.85rem; font-weight:700; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; box-shadow:0 3px 12px rgba(255,193,7,0.25); }
.btn-ajukan:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(255,193,7,0.35); color:#fff; }
.btn-menunggu { display:flex; align-items:center; justify-content:center; gap:7px; width:100%; padding:10px; background:#f0f4ff; color:#94a3b8; border:1.5px solid var(--border-color); border-radius:10px; font-size:0.85rem; font-weight:600; font-family:'Poppins',sans-serif; cursor:not-allowed; }

.search-wrap { position:relative; max-width:280px; }
.search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#aaa; font-size:0.9rem; pointer-events:none; }
.search-wrap input { padding-left:36px; border-radius:50px; border:1.5px solid var(--border-color); font-size:0.875rem; height:38px; transition:var(--transition); }
.search-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.pulse-dot { width:7px; height:7px; background:#a7ffcd; border-radius:50%; display:inline-block; animation:pulse-anim 1.4s infinite; }
@keyframes pulse-anim { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-clipboard-check me-2"></i>Ujian Aktif <span class="count-badge" id="ujian-count">0 ujian</span></h4>
        <p>Daftar ujian yang sedang berlangsung dan tersedia untuk Anda</p>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchUjian" class="form-control" placeholder="Cari nama ujian...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="ujian-shown">0</span> ujian</div>
</div>

<div id="ujianAktifContent">
    <div class="ujian-grid" id="ujianGrid">
        {{-- skeleton --}}
        @for($i = 0; $i < 3; $i++)
        <div class="ujian-card" style="opacity:.4;">
            <div class="ujian-card-top" style="background:#e2e8f7;min-height:90px;"></div>
            <div class="ujian-card-body">
                <div style="height:12px;border-radius:6px;background:#f0f4ff;margin-bottom:8px;width:80%;"></div>
                <div style="height:36px;border-radius:10px;background:#f0f4ff;"></div>
            </div>
        </div>
        @endfor
    </div>
</div>

@endsection

@push('scripts')
<script>
var allUjian = [];

function renderUjian(data) {
    var grid = document.getElementById('ujianGrid');
    document.getElementById('ujian-count').textContent = allUjian.length + ' ujian';
    document.getElementById('ujian-shown').textContent = data.length;

    if (!data.length) {
        document.getElementById('ujianAktifContent').innerHTML =
            '<div class="empty-state"><div class="empty-icon"><i class="bi bi-clipboard-x"></i></div><h6>Tidak ada ujian aktif</h6><p>Ujian aktif akan muncul di sini saat guru mengaktifkannya</p></div>';
        return;
    }

    var html = '';
    data.forEach(function(u) {
        var nama    = u.nama || u.title || '-';
        var inisial = nama.substring(0,2).toUpperCase();
        var mapel   = u.mapel || '-';
        var tanggal = u.tanggal || '-';
        var durasi  = u.durasi ? u.durasi + ' menit' : '';

        /* Status & tombol */
        var statusPill = '<span class="status-pill status-aktif"><span class="pulse-dot"></span> Aktif</span>';
        var tombol = '<a href="/siswa/ujian/' + u.id + '" class="btn-kerjakan"><i class="bi bi-play-fill"></i> Kerjakan Sekarang</a>';

        if (u.is_completed) {
            statusPill = '<span class="status-pill" style="background:rgba(108,117,125,0.3);color:#adb5bd;border:1px solid rgba(255,255,255,0.2);"><i class="bi bi-check-circle"></i> Selesai</span>';
            // Route hasil web memakai ID exam_session (bukan exam_id)
            var hasilId = u.exam_session_id || u.session_id || u.id;
            tombol = '<a href="/siswa/ujian/' + hasilId + '/hasil" class="btn-kerjakan" style="background:linear-gradient(135deg,#6c757d,#adb5bd);"><i class="bi bi-eye"></i> Lihat Hasil</a>';
        } else if (u.is_detected_blocked) {
            statusPill = '<span class="status-pill status-ditolak"><i class="bi bi-shield-exclamation"></i> Diawasi</span>';
            tombol = '<div class="btn-menunggu"><i class="bi bi-shield-exclamation"></i> Sesi Dalam Pengawasan</div>';
        } else if (u.status_logout == 1) {
            // reapply_status: 1=menunggu, 2=diterima, 3=ditolak
            if (u.reapply_status == 1) {
                statusPill = '<span class="status-pill status-ajukan"><i class="bi bi-hourglass-split"></i> Menunggu</span>';
                tombol = '<div class="btn-menunggu"><i class="bi bi-hourglass-split"></i> Menunggu Persetujuan</div>';
            } else if (u.reapply_status == 2) {
                statusPill = '<span class="status-pill status-aktif"><span class="pulse-dot"></span> Diizinkan</span>';
                tombol = '<a href="/siswa/ujian/' + u.id + '" class="btn-kerjakan"><i class="bi bi-play-fill"></i> Lanjutkan Ujian</a>';
            } else if (u.reapply_status == 3) {
                statusPill = '<span class="status-pill status-ditolak"><i class="bi bi-x-circle"></i> Ditolak</span>';
                tombol = '<div class="btn-menunggu"><i class="bi bi-x-circle"></i> Pengajuan Ditolak</div>';
            } else {
                statusPill = '<span class="status-pill status-ditolak"><i class="bi bi-exclamation-triangle"></i> Logout</span>';
                tombol = '<a href="/siswa/ujian/' + u.id + '" class="btn-ajukan"><i class="bi bi-arrow-repeat"></i> Ajukan Masuk Ulang</a>';
            }
        }

        html += '<div class="ujian-card" data-nama="' + nama.toLowerCase() + '">' +
            '<div class="ujian-card-top">' +
                '<div class="ujian-card-status">' + statusPill + '</div>' +
                '<div class="ujian-card-avatar">' + inisial + '</div>' +
                '<div class="ujian-card-title">' + nama + '</div>' +
                '<div class="ujian-card-mapel"><i class="bi bi-journal me-1"></i>' + mapel + '</div>' +
            '</div>' +
            '<div class="ujian-card-body">' +
                '<div class="ujian-card-meta">' +
                    '<span class="meta-tag tag-date"><i class="bi bi-calendar"></i> ' + tanggal + '</span>' +
                    (durasi ? '<span class="meta-tag tag-durasi"><i class="bi bi-clock"></i> ' + durasi + '</span>' : '') +
                '</div>' +
                tombol +
            '</div>' +
        '</div>';
    });

    document.getElementById('ujianAktifContent').innerHTML = '<div class="ujian-grid" id="ujianGrid">' + html + '</div>';
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/siswa/ujian/aktif/json', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) {
        allUjian = Array.isArray(data) ? data : (data.data || []);
        renderUjian(allUjian);
    })
    .catch(function() {
        document.getElementById('ujianAktifContent').innerHTML =
            '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6><p>Cek koneksi atau hubungi admin</p></div>';
    });

    document.getElementById('searchUjian').addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var filtered = !q ? allUjian : allUjian.filter(function(u) {
            return (u.nama||u.title||'').toLowerCase().includes(q);
        });
        renderUjian(filtered);
    });
});
</script>
@endpush