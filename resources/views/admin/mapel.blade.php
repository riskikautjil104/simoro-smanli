{{-- ============================================================
     mapel.blade.php
     Simpan file ini sebagai: resources/views/admin/mapel.blade.php
============================================================ --}}
@extends('layouts.master')
@section('title', 'Data Mapel')

@push('styles')
<style>
.page-header {
    background:linear-gradient(135deg,var(--primary),var(--accent));
    border-radius:16px; padding:24px 28px; color:#fff;
    position:relative; overflow:hidden; margin-bottom:24px;
}
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }
.btn-header { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,0.2); color:#fff !important; border:1.5px solid rgba(255,255,255,0.45); padding:9px 20px; border-radius:50px; font-size:0.875rem; font-weight:600; backdrop-filter:blur(8px); cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; }
.btn-header:hover { background:rgba(255,255,255,0.32); transform:translateY(-2px); color:#fff !important; }
.count-badge { display:inline-flex; align-items:center; background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.35); color:#fff; font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:20px; margin-left:10px; }
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
.mapel-avatar { width:36px; height:36px; background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.78rem; flex-shrink:0; box-shadow:0 2px 8px rgba(13,110,253,0.25); }
.badge-pill { display:inline-block; font-size:0.72rem; font-weight:600; padding:3px 9px; border-radius:20px; margin:2px 2px 0 0; }
.badge-kelas { background:rgba(32,201,151,0.1); color:#198754; }
.badge-guru  { background:rgba(13,110,253,0.08); color:var(--primary); }
.badge-kode  { background:rgba(255,193,7,0.12); color:#856404; }
.btn-act { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; white-space:nowrap; margin:2px 2px 0 0; }
.btn-act-edit   { background:rgba(13,110,253,0.1); color:var(--primary); }
.btn-act-edit:hover   { background:var(--primary); color:#fff; transform:translateY(-1px); }
.btn-act-delete { background:rgba(220,53,69,0.1); color:#dc3545; }
.btn-act-delete:hover { background:#dc3545; color:#fff; transform:translateY(-1px); }
.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(13,110,253,0.07); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--primary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; color:var(--text-main); margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
.modal-header-brand { background:linear-gradient(135deg,var(--primary),var(--accent)); color:#fff; padding:16px 20px; }
.modal-header-brand .modal-title { font-weight:700; font-size:1rem; }
.modal-header-brand .btn-close { filter:brightness(0) invert(1); opacity:.85; transition:transform .2s; }
.modal-header-brand .btn-close:hover { transform:rotate(90deg); opacity:1; }
.modal-content { border-radius:16px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(13,110,253,0.2); }
/* Multi-select kelas */
#kelasMapel { border-radius:10px; border:1.5px solid var(--border-color); padding:8px; min-height:100px; }
#kelasMapel:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }
#kelasMapel option { padding:6px 10px; border-radius:6px; margin:2px 0; }
#kelasMapel option:checked { background:rgba(13,110,253,0.12); color:var(--primary); }
</style>
@endpush

@section('layoutContent')
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-journal-bookmark me-2"></i>Data Mapel <span class="count-badge" id="mapel-count">0 mapel</span></h4>
            <p>Kelola mata pelajaran dan penugasan guru SMA Negeri 5 Morotai</p>
        </div>
        <button class="btn-header" data-bs-toggle="modal" data-bs-target="#modalMapel" id="btnTambahMapel">
            <i class="bi bi-plus-lg"></i> Tambah Mapel
        </button>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchMapel" class="form-control" placeholder="Cari nama mapel atau guru...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="mapel-shown">0</span> data</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="mapelTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Pengajar</th>
                    <th>Kelas</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="mapelTbody">
                <tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalMapel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalMapelLabel"><i class="bi bi-journal-bookmark me-2"></i>Tambah Mapel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formMapel">
                <div class="modal-body p-4">
                    <input type="hidden" id="mapelId">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Mapel</label>
                            <input type="text" class="form-control" id="namaMapel" name="nama" placeholder="Contoh: Matematika" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kodeMapel" name="code" placeholder="MTK">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select class="form-select" id="guruMapel" name="teacher_id" required>
                            <option value="">-- Pilih Guru --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas <small class="text-muted">(tahan Ctrl/Cmd untuk pilih lebih dari satu)</small></label>
                        <select id="kelasMapel" name="kelas_id[]" multiple required></select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanMapel"><i class="bi bi-save me-1"></i> Simpan</button>
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
    var allMapel  = [];

    /* ── Load selects ── */
    function loadSelects() {
        Promise.all([
            fetch('/admin/guru',  { headers:{'Accept':'application/json','X-CSRF-TOKEN':csrfToken} }).then(function(r){ return r.ok ? r.json() : []; }),
            fetch('/admin/kelas/list', { headers:{'Accept':'application/json'} }).then(function(r){ return r.ok ? r.json() : []; }),
        ])
        .then(function(results) {
            var gOpt = '<option value="">-- Pilih Guru --</option>';
            results[0].forEach(function(g) { gOpt += '<option value="' + g.id + '">' + (g.name||g.nama||'') + '</option>'; });
            document.getElementById('guruMapel').innerHTML = gOpt;

            var kOpt = '';
            results[1].forEach(function(k) { kOpt += '<option value="' + k.id + '">' + (k.nama||k.name||'') + '</option>'; });
            document.getElementById('kelasMapel').innerHTML = kOpt;
        });
    }

    /* ── Fetch & render ── */
    function fetchMapel() {
        fetch('/admin/mapel', { headers:{'Accept':'application/json','X-CSRF-TOKEN':csrfToken} })
        .then(function(r) { return r.ok ? r.json() : []; })
        .then(function(data) { allMapel = data; renderMapel(data); })
        .catch(function() {
            document.getElementById('mapelTbody').innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
        });
    }

    function renderMapel(data) {
        var tbody = document.getElementById('mapelTbody');
        document.getElementById('mapel-count').textContent = data.length + ' mapel';
        document.getElementById('mapel-shown').textContent = data.length;

        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-journal-bookmark"></i></div><h6>Belum ada data mapel</h6><p>Klik "Tambah Mapel" untuk menambahkan</p></div></td></tr>';
            return;
        }
        var rows = '';
        data.forEach(function(m, i) {
            var inisial  = (m.name||'M').substring(0,2).toUpperCase();
            var guruNama = m.teacher ? (m.teacher.name||m.teacher.nama||'-') : '-';
            var kelasList = m.classes ? m.classes.map(function(k) { return '<span class="badge-pill badge-kelas">' + (k.name||k.nama||'') + '</span>'; }).join('') : '-';

            rows += '<tr data-nama="' + (m.name||'').toLowerCase() + '" data-guru="' + guruNama.toLowerCase() + '">' +
                '<td>' + (i+1) + '</td>' +
                '<td>' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<div class="mapel-avatar">' + inisial + '</div>' +
                        '<div><div style="font-weight:600;">' + (m.name||'-') + '</div>' +
                        (m.code ? '<span class="badge-pill badge-kode">' + m.code + '</span>' : '') + '</div>' +
                    '</div>' +
                '</td>' +
                '<td><span class="badge-pill badge-guru"><i class="bi bi-person-badge me-1"></i>' + guruNama + '</span></td>' +
                '<td>' + (kelasList||'<span style="color:#ccc;">—</span>') + '</td>' +
                '<td>' +
                    '<button class="btn-act btn-act-edit" data-id="' + m.id + '"><i class="bi bi-pencil"></i> Edit</button>' +
                    '<button class="btn-act btn-act-delete" data-id="' + m.id + '" data-nama="' + (m.name||'') + '"><i class="bi bi-trash"></i></button>' +
                '</td>' +
            '</tr>';
        });
        tbody.innerHTML = rows;
    }

    /* ── Search ── */
    document.getElementById('searchMapel').addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#mapelTbody tr[data-nama]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-nama').includes(q) || row.getAttribute('data-guru').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('mapel-shown').textContent = shown;
    });

    /* ── Reset modal ── */
    document.getElementById('btnTambahMapel').addEventListener('click', function() {
        document.getElementById('formMapel').reset();
        document.getElementById('mapelId').value = '';
        document.getElementById('modalMapelLabel').innerHTML = '<i class="bi bi-journal-bookmark me-2"></i>Tambah Mapel';
    });

    /* ── Submit ── */
    document.getElementById('formMapel').addEventListener('submit', function(e) {
        e.preventDefault();
        var id       = document.getElementById('mapelId').value;
        var url      = id ? '/admin/mapel/' + id : '/admin/mapel';
        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        /* Rebuild kelas_id[] from multi-select */
        var kelasSelect = document.getElementById('kelasMapel');
        var selected    = Array.from(kelasSelect.selectedOptions).map(function(o){ return o.value; });
        formData.delete('kelas_id[]');
        selected.forEach(function(v) { formData.append('kelas_id[]', v); });

        var btn = document.getElementById('btnSimpanMapel');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(url, { method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}, body:formData })
        .then(function(r) { if (!r.ok) return r.json().then(function(e){ throw e; }); return r.json(); })
        .then(function() {
            fetchMapel();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMapel')).hide();
            Swal.fire({ icon:'success', title:'Berhasil!', text:'Data mapel berhasil disimpan.', timer:1500, showConfirmButton:false });
        })
        .catch(function(err) {
            var msg = 'Gagal menyimpan data mapel.';
            if (err && err.errors) msg = Object.values(err.errors).flat().join('<br>');
            else if (err && err.message) msg = err.message;
            Swal.fire({ icon:'error', title:'Gagal', html:msg });
        })
        .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save me-1"></i> Simpan'; });
    });

    /* ── Delegation ── */
    document.getElementById('mapelTbody').addEventListener('click', function(e) {
        var btnEdit   = e.target.closest('.btn-act-edit');
        var btnDelete = e.target.closest('.btn-act-delete');

        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            fetch('/admin/mapel/' + id, { headers:{'Accept':'application/json','X-CSRF-TOKEN':csrfToken} })
            .then(function(r){ return r.json(); })
            .then(function(m) {
                document.getElementById('mapelId').value    = m.id;
                document.getElementById('namaMapel').value  = m.name || '';
                document.getElementById('kodeMapel').value  = m.code || '';
                document.getElementById('guruMapel').value  = m.teacher_id || '';
                var kelasSelect = document.getElementById('kelasMapel');
                Array.from(kelasSelect.options).forEach(function(opt) {
                    opt.selected = m.classes && m.classes.some(function(k){ return k.id == opt.value; });
                });
                document.getElementById('modalMapelLabel').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Mapel';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMapel')).show();
            })
            .catch(function() { Swal.fire('Error','Gagal mengambil data mapel.','error'); });
        }

        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({ title:'Hapus "'+nama+'"?', text:'Data mapel akan dihapus permanen.', icon:'warning',
                showCancelButton:true, confirmButtonColor:'#dc3545', cancelButtonColor:'#6c757d',
                confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                fetch('/admin/mapel/' + id, { method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'} })
                .then(function() { fetchMapel(); Swal.fire({ icon:'success', title:'Terhapus!', timer:1400, showConfirmButton:false }); })
                .catch(function() { Swal.fire('Error','Gagal menghapus mapel.','error'); });
            });
        }
    });

    loadSelects();
    fetchMapel();
});
</script>
@endpush