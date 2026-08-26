@extends('layouts.master')

@section('title', 'Arsip Ujian')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius:16px; padding:24px 28px; color:#fff;
    position:relative; overflow:hidden; margin-bottom:24px;
}
.page-header::before {
    content:''; position:absolute; width:220px; height:220px;
    background:rgba(255,255,255,0.07); border-radius:50%;
    top:-60px; right:-60px; pointer-events:none;
}
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.btn-header {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(255,255,255,0.2); color:#fff !important;
    border:1.5px solid rgba(255,255,255,0.45); padding:9px 20px;
    border-radius:50px; font-size:0.875rem; font-weight:600;
    backdrop-filter:blur(8px); cursor:pointer; transition:var(--transition);
    font-family:'Poppins',sans-serif; text-decoration:none;
}
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
.table-card .table tbody tr { transition:background 0.15s; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }

.ujian-avatar { width:36px; height:36px; background:linear-gradient(135deg,#6c757d,#495057); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.78rem; flex-shrink:0; box-shadow:0 2px 8px rgba(108,117,125,0.25); }
.badge-mapel { display:inline-flex; align-items:center; gap:4px; background:rgba(13,110,253,0.08); color:var(--primary); font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.badge-kelas { display:inline-flex; align-items:center; gap:4px; background:rgba(32,201,151,0.1); color:#198754; font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.badge-archived { display:inline-flex; align-items:center; gap:4px; background:rgba(108,117,125,0.12); color:#495057; font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }

.btn-act { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; white-space:nowrap; margin:2px 2px 0 0; text-decoration:none; }
.btn-act-restore { background:rgba(25,135,84,0.1); color:#198754; }
.btn-act-restore:hover { background:#198754; color:#fff; transform:translateY(-1px); }
.btn-act-delete { background:rgba(220,53,69,0.1); color:#dc3545; }
.btn-act-delete:hover { background:#dc3545; color:#fff; transform:translateY(-1px); }
.btn-act-detail { background:rgba(13,202,240,0.1); color:#0a9bba; }
.btn-act-detail:hover { background:var(--accent); color:#fff; transform:translateY(-1px); }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(108,117,125,0.08); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:#6c757d; margin-bottom:16px; }
.empty-state h6 { font-weight:700; color:var(--text-main); margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }

.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-archive me-2"></i>Arsip Ujian <span class="count-badge" id="arsip-count">0 ujian</span></h4>
            <p>Daftar ujian yang telah selesai dan diarsipkan dari sistem</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="/admin/ujian" class="btn-header">
                <i class="bi bi-file-earmark-text"></i> Data Ujian Aktif
            </a>
        </div>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchArsip" class="form-control" placeholder="Cari nama ujian, mapel...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="arsip-shown">0</span> data</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="arsipTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th>Tanggal Arsip</th>
                    <th>Peserta</th>
                    <th style="width:190px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="arsipTbody">
                <tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data arsip...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var allArsip  = [];

    /* ── Fetch & render ── */
    function fetchArsip() {
        fetch('/admin/ujian-arsip-list', { credentials: 'same-origin', headers:{'Accept':'application/json'} })
        .then(function(r) { return r.ok ? r.json() : []; })
        .then(function(data) { allArsip = data; renderArsip(data); })
        .catch(function() {
            document.getElementById('arsipTbody').innerHTML = '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data arsip</h6></div></td></tr>';
        });
    }

    function renderArsip(data) {
        var tbody = document.getElementById('arsipTbody');
        document.getElementById('arsip-count').textContent = data.length + ' ujian';
        document.getElementById('arsip-shown').textContent = data.length;

        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon"><i class="bi bi-archive"></i></div><h6>Belum ada ujian yang diarsipkan</h6><p>Ujian yang selesai dapat diarsipkan dari menu Data Ujian.</p></div></td></tr>';
            return;
        }

        var rows = '';
        data.forEach(function(u, i) {
            var inisial  = (u.nama || 'U').substring(0, 2).toUpperCase();
            var mapelNm  = u.mapel ? (u.mapel.nama || u.mapel.name || '-') : '-';
            var kelasNm  = u.kelas ? (u.kelas.nama || u.kelas.name || '-') : '-';
            var jadwal   = u.tanggal || '-';
            var tglArsip = u.archived_at || '-';
            var peserta  = u.total_peserta || 0;

            rows += '<tr data-nama="' + (u.nama||'').toLowerCase() + '" data-mapel="' + mapelNm.toLowerCase() + '">' +
                '<td>' + (i+1) + '</td>' +
                '<td><div class="d-flex align-items-center gap-2"><div class="ujian-avatar"><i class="bi bi-archive-fill"></i></div><div><span style="font-weight:600;">' + (u.nama||'-') + '</span><div style="font-size:0.75rem;color:var(--text-muted);"><i class="bi bi-clock me-1"></i>' + (u.duration || '-') + ' menit</div></div></div></td>' +
                '<td><span class="badge-mapel"><i class="bi bi-journal-bookmark"></i>' + mapelNm + '</span></td>' +
                '<td><span class="badge-kelas"><i class="bi bi-building"></i>' + kelasNm + '</span></td>' +
                '<td style="font-size:.8rem;">' + jadwal + '</td>' +
                '<td><span class="badge-archived"><i class="bi bi-calendar-check"></i>' + tglArsip + '</span></td>' +
                '<td><span class="badge bg-light text-dark border">' + peserta + ' siswa</span></td>' +
                '<td>' +
                    '<a class="btn-act btn-act-detail" href="/admin/ujian/' + u.id + '/detail" title="Lihat Hasil & Peserta"><i class="bi bi-eye"></i> Detail</a>' +
                    '<button class="btn-act btn-act-restore" data-id="' + u.id + '" data-nama="' + (u.nama||'') + '" title="Pulihkan ke Ujian Aktif"><i class="bi bi-arrow-counterclockwise"></i> Pulihkan</button>' +
                    '<button class="btn-act btn-act-delete" data-id="' + u.id + '" data-nama="' + (u.nama||'') + '" title="Hapus Permanen"><i class="bi bi-trash"></i></button>' +
                '</td>' +
            '</tr>';
        });
        tbody.innerHTML = rows;
    }

    /* ── Search ── */
    document.getElementById('searchArsip').addEventListener('input', function() {
        var q    = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#arsipTbody tr[data-nama]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-nama').includes(q) || row.getAttribute('data-mapel').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('arsip-shown').textContent = shown;
    });

    /* ── Delegation ── */
    document.getElementById('arsipTbody').addEventListener('click', function(e) {
        var btnRestore = e.target.closest('.btn-act-restore');
        var btnDelete  = e.target.closest('.btn-act-delete');

        if (btnRestore) {
            var id   = btnRestore.getAttribute('data-id');
            var nama = btnRestore.getAttribute('data-nama');

            Swal.fire({
                title: 'Pulihkan "' + nama + '"?',
                text: 'Ujian ini akan dikembalikan ke daftar ujian aktif.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-arrow-counterclockwise me-1"></i> Ya, Pulihkan!',
                cancelButtonText: 'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                fetch('/admin/ujian/' + id + '/unarchive', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(function(res) { if (!res.ok) throw new Error(); return res.json(); })
                .then(function(res) {
                    fetchArsip();
                    Swal.fire({ icon:'success', title:'Dipulihkan!', text: res.message || 'Ujian berhasil dikembalikan ke aktif.', timer:1500, showConfirmButton:false });
                })
                .catch(function() {
                    Swal.fire('Error', 'Gagal memulihkan ujian dari arsip.', 'error');
                });
            });
        }

        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({
                title: 'Hapus Permanen "' + nama + '"?',
                text: 'Semua data sesi, soal, dan jawaban siswa pada ujian ini akan terhapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                fetch('/admin/ujian/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(function(res) { if (!res.ok) throw new Error(); return res.json(); })
                .then(function() {
                    fetchArsip();
                    Swal.fire({ icon:'success', title:'Terhapus!', text:'Ujian berhasil dihapus permanen.', timer:1400, showConfirmButton:false });
                })
                .catch(function() {
                    Swal.fire('Error', 'Gagal menghapus ujian.', 'error');
                });
            });
        }
    });

    fetchArsip();
});
</script>
@endpush
