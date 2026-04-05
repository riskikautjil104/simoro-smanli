@extends('layouts.master')

@section('title', 'Data Ujian')

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

.ujian-avatar { width:36px; height:36px; background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.78rem; flex-shrink:0; box-shadow:0 2px 8px rgba(13,110,253,0.25); }
.badge-mapel { display:inline-flex; align-items:center; gap:4px; background:rgba(13,110,253,0.08); color:var(--primary); font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }
.badge-kelas { display:inline-flex; align-items:center; gap:4px; background:rgba(32,201,151,0.1); color:#198754; font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; }

.btn-act { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; white-space:nowrap; margin:2px 2px 0 0; }
.btn-act-edit   { background:rgba(13,110,253,0.1); color:var(--primary); }
.btn-act-edit:hover   { background:var(--primary); color:#fff; transform:translateY(-1px); }
.btn-act-delete { background:rgba(220,53,69,0.1); color:#dc3545; }
.btn-act-delete:hover { background:#dc3545; color:#fff; transform:translateY(-1px); }
.btn-act-detail { background:rgba(13,202,240,0.1); color:#0a9bba; }
.btn-act-detail:hover { background:var(--accent); color:#fff; transform:translateY(-1px); }

.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; color:var(--text-main); margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }

.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }

.modal-header-brand { background:linear-gradient(135deg,var(--primary),var(--accent)); color:#fff; padding:16px 20px; }
.modal-header-brand .modal-title { font-weight:700; font-size:1rem; }
.modal-header-brand .btn-close { filter:brightness(0) invert(1); opacity:.85; transition:transform .2s; }
.modal-header-brand .btn-close:hover { transform:rotate(90deg); opacity:1; }
.modal-content { border-radius:16px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(13,110,253,0.2); }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-file-earmark-text me-2"></i>Data Ujian <span class="count-badge" id="ujian-count">0 ujian</span></h4>
            <p>Kelola jadwal dan data ujian SMA Negeri 5 Morotai</p>
        </div>
        <button class="btn-header" data-bs-toggle="modal" data-bs-target="#modalUjian" id="btnTambahUjian">
            <i class="bi bi-plus-lg"></i> Tambah Ujian
        </button>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchUjian" class="form-control" placeholder="Cari nama ujian, mapel...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="ujian-shown">0</span> data</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="ujianTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Jadwal</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="ujianTbody">
                <tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modalUjian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalUjianLabel"><i class="bi bi-file-earmark-text me-2"></i>Tambah Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUjian">
                <div class="modal-body p-4">
                    <input type="hidden" id="ujianId">
                    <div class="mb-3">
                        <label class="form-label">Nama Ujian</label>
                        <input type="text" class="form-control" id="namaUjian" name="nama" placeholder="Contoh: UTS Matematika Kelas X" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mapelUjian" name="mapel_id" required>
                                <option value="">-- Pilih Mapel --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" id="kelasUjian" name="kelas_id" required>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control" id="startTimeUjian" name="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Berakhir</label>
                            <input type="datetime-local" class="form-control" id="endTimeUjian" name="end_time" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Durasi (menit)</label>
                        <input type="number" class="form-control" id="durasiUjian" name="duration" min="1" placeholder="Contoh: 90" required>
                        <div class="form-text">Durasi dipakai untuk timer ujian siswa (web & mobile).</div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanUjian"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var allUjian  = [];

    /* ── Load selects ── */
    function loadSelects() {
        Promise.all([
            fetch('/admin/mapel', { headers:{'Accept':'application/json'} }).then(function(r){ return r.ok ? r.json() : []; }),
            fetch('/admin/kelas', { headers:{'Accept':'application/json'} }).then(function(r){ return r.ok ? r.json() : []; }),
        ])
        .then(function(results) {
            var mOpt = '<option value="">-- Pilih Mapel --</option>';
            results[0].forEach(function(m) { mOpt += '<option value="' + m.id + '">' + (m.name||'') + '</option>'; });
            document.getElementById('mapelUjian').innerHTML = mOpt;

            var kOpt = '<option value="">-- Pilih Kelas --</option>';
            results[1].forEach(function(k) { kOpt += '<option value="' + k.id + '">' + (k.name||'') + '</option>'; });
            document.getElementById('kelasUjian').innerHTML = kOpt;
        });
    }

    /* ── Fetch & render ── */
    function fetchUjian() {
        fetch('/admin/ujian-list', { headers:{'Accept':'application/json'} })
        .then(function(r) { return r.ok ? r.json() : []; })
        .then(function(data) { allUjian = data; renderUjian(data); })
        .catch(function() {
            document.getElementById('ujianTbody').innerHTML = '<tr><td colspan="6"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
        });
    }

    function renderUjian(data) {
        var tbody = document.getElementById('ujianTbody');
        document.getElementById('ujian-count').textContent = data.length + ' ujian';
        document.getElementById('ujian-shown').textContent = data.length;

        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-file-earmark-text"></i></div><h6>Belum ada data ujian</h6><p>Klik "Tambah Ujian" untuk menambahkan</p></div></td></tr>';
            return;
        }

        var rows = '';
        data.forEach(function(u, i) {
            var inisial  = (u.nama || 'U').substring(0, 2).toUpperCase();
            var mapelNm  = u.mapel ? (u.mapel.nama || u.mapel.name || '-') : '-';
            var kelasNm  = u.kelas ? (u.kelas.nama || u.kelas.name || '-') : '-';
            var tanggal  = u.tanggal || u.start_time || '-';

            rows += '<tr data-nama="' + (u.nama||'').toLowerCase() + '" data-mapel="' + mapelNm.toLowerCase() + '">' +
                '<td>' + (i+1) + '</td>' +
                '<td><div class="d-flex align-items-center gap-2"><div class="ujian-avatar">' + inisial + '</div><span style="font-weight:600;">' + (u.nama||'-') + '</span></div></td>' +
                '<td><span class="badge-mapel"><i class="bi bi-journal-bookmark"></i>' + mapelNm + '</span></td>' +
                '<td><span class="badge-kelas"><i class="bi bi-building"></i>' + kelasNm + '</span></td>' +
                '<td style="font-size:.8rem;">' + tanggal + '</td>' +
                '<td>' +
                    '<button class="btn-act btn-act-edit" data-id="' + u.id + '"><i class="bi bi-pencil"></i> Edit</button>' +
                    '<a class="btn-act btn-act-detail" href="/admin/ujian/' + u.id + '/detail"><i class="bi bi-eye"></i> Detail</a>' +
                    '<button class="btn-act btn-act-delete" data-id="' + u.id + '" data-nama="' + (u.nama||'') + '"><i class="bi bi-trash"></i></button>' +
                '</td>' +
            '</tr>';
        });
        tbody.innerHTML = rows;
    }

    /* ── Search ── */
    document.getElementById('searchUjian').addEventListener('input', function() {
        var q    = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#ujianTbody tr[data-nama]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-nama').includes(q) || row.getAttribute('data-mapel').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('ujian-shown').textContent = shown;
    });

    /* ── Reset modal ── */
    document.getElementById('btnTambahUjian').addEventListener('click', function() {
        document.getElementById('formUjian').reset();
        document.getElementById('ujianId').value = '';
        document.getElementById('modalUjianLabel').innerHTML = '<i class="bi bi-file-earmark-text me-2"></i>Tambah Ujian';
    });

    /* ── Submit ── */
    document.getElementById('formUjian').addEventListener('submit', function(e) {
        e.preventDefault();
        var id     = document.getElementById('ujianId').value;
        var url    = id ? '/admin/ujian/' + id : '/admin/ujian';
        var method = id ? 'PUT' : 'POST';
        var payload = {
            nama:       document.getElementById('namaUjian').value,
            mapel_id:   document.getElementById('mapelUjian').value,
            kelas_id:   document.getElementById('kelasUjian').value,
            start_time: document.getElementById('startTimeUjian').value,
            end_time:   document.getElementById('endTimeUjian').value,
            duration:   document.getElementById('durasiUjian').value,
        };

        var btn = document.getElementById('btnSimpanUjian');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(url, {
            method: method,
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function(r) { if (!r.ok) return r.json().then(function(e){ throw e; }); return r.json(); })
        .then(function() {
            fetchUjian();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUjian')).hide();
            Swal.fire({ icon:'success', title:'Berhasil!', text:'Data ujian berhasil disimpan.', timer:1500, showConfirmButton:false });
        })
        .catch(function(err) {
            var msg = 'Gagal menyimpan data ujian.';
            if (err && err.errors) msg = Object.values(err.errors).flat().join('<br>');
            else if (err && err.message) msg = err.message;
            Swal.fire({ icon:'error', title:'Gagal', html:msg });
        })
        .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save me-1"></i> Simpan'; });
    });

    /* ── Delegation ── */
    document.getElementById('ujianTbody').addEventListener('click', function(e) {
        var btnEdit   = e.target.closest('.btn-act-edit');
        var btnDelete = e.target.closest('.btn-act-delete');

        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            fetch('/admin/ujian/' + id, { headers:{'Accept':'application/json'} })
            .then(function(r){ return r.json(); })
            .then(function(u) {
                document.getElementById('ujianId').value         = u.id;
                document.getElementById('namaUjian').value       = u.title || u.nama || '';
                document.getElementById('mapelUjian').value      = u.subject_id || u.mapel_id || '';
                document.getElementById('kelasUjian').value      = u.class_id   || u.kelas_id || '';
                document.getElementById('startTimeUjian').value  = (u.start_time||'').replace(' ','T').substring(0,16);
                document.getElementById('endTimeUjian').value    = (u.end_time  ||'').replace(' ','T').substring(0,16);
                document.getElementById('durasiUjian').value     = u.duration || '';
                document.getElementById('modalUjianLabel').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Ujian';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUjian')).show();
            });
        }

        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({ title:'Hapus "'+nama+'"?', text:'Data ujian akan dihapus permanen.', icon:'warning',
                showCancelButton:true, confirmButtonColor:'#dc3545', cancelButtonColor:'#6c757d',
                confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                fetch('/admin/ujian/' + id, { method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'} })
                .then(function() { fetchUjian(); Swal.fire({ icon:'success', title:'Terhapus!', timer:1400, showConfirmButton:false }); })
                .catch(function() { Swal.fire('Error','Gagal menghapus ujian.','error'); });
            });
        }
    });

    loadSelects();
    fetchUjian();
});
</script>
@endpush