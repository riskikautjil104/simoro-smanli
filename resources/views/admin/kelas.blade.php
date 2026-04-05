@extends('layouts.master')
@section('title', 'Data Kelas')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
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
.table-card .table tbody td { padding:14px 16px; vertical-align:middle; border-bottom:1px solid rgba(13,110,253,0.05); }
.table-card .table tbody tr:last-child td { border-bottom:none; }
.table-card .table tbody tr:hover { background:rgba(13,110,253,0.025); }
.kelas-avatar { width:42px; height:42px; background:linear-gradient(135deg,var(--secondary),#198754); border-radius:12px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:0.85rem; flex-shrink:0; box-shadow:0 2px 10px rgba(32,201,151,0.3); }
.stat-chip-sm { display:inline-flex; align-items:center; gap:5px; background:#f0f4ff; color:var(--primary); font-size:0.72rem; font-weight:600; padding:4px 10px; border-radius:20px; }
.stat-chip-sm.green { background:rgba(32,201,151,0.1); color:#198754; }
.mapel-tag { display:inline-block; background:rgba(13,110,253,0.07); color:var(--primary); font-size:0.7rem; font-weight:600; padding:2px 8px; border-radius:12px; margin:2px 2px 0 0; }
.btn-act { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:8px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; white-space:nowrap; margin:2px 2px 0 0; }
.btn-act-edit   { background:rgba(13,110,253,0.1); color:var(--primary); }
.btn-act-edit:hover   { background:var(--primary); color:#fff; transform:translateY(-1px); }
.btn-act-delete { background:rgba(220,53,69,0.1); color:#dc3545; }
.btn-act-delete:hover { background:#dc3545; color:#fff; transform:translateY(-1px); }
.empty-state { text-align:center; padding:56px 24px; }
.empty-state .empty-icon { width:72px; height:72px; background:rgba(32,201,151,0.08); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--secondary); margin-bottom:16px; }
.empty-state h6 { font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:0.85rem; color:var(--text-muted); margin:0; }
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
            <h4><i class="bi bi-building me-2"></i>Data Kelas <span class="count-badge" id="kelas-count">0 kelas</span></h4>
            <p>Kelola data kelas SMA Negeri 5 Morotai</p>
        </div>
        <button class="btn-header" data-bs-toggle="modal" data-bs-target="#modalKelas" id="btnTambahKelas">
            <i class="bi bi-plus-lg"></i> Tambah Kelas
        </button>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchKelas" class="form-control" placeholder="Cari nama kelas...">
    </div>
    <div style="font-size:0.82rem;color:var(--text-muted);">Menampilkan <span id="kelas-shown">0</span> data</div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="kelasTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Siswa</th>
                    <th>Guru</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="kelasTbody">
                <tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalKelasLabel"><i class="bi bi-building me-2"></i>Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKelas">
                <div class="modal-body p-4">
                    <input type="hidden" id="kelasId">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="namaKelas" name="nama"
                               placeholder="Contoh: X IPA 1" required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanKelas"><i class="bi bi-save me-1"></i> Simpan</button>
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

    function fetchKelas() {
        fetch('/admin/kelas/list', { headers:{'Accept':'application/json'} })
        .then(function(r){ return r.ok ? r.json() : []; })
        .then(function(data) {
            var tbody = document.getElementById('kelasTbody');
            document.getElementById('kelas-count').textContent = data.length + ' kelas';
            document.getElementById('kelas-shown').textContent = data.length;

            if (!data.length) {
                tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><div class="empty-icon"><i class="bi bi-building"></i></div><h6>Belum ada data kelas</h6><p>Klik "Tambah Kelas" untuk menambahkan</p></div></td></tr>';
                return;
            }
            var rows = '';
            data.forEach(function(k, i) {
                var nama       = k.nama || k.name || '-';
                var inisial    = nama.substring(0,2).toUpperCase();
                var siswaCount = Array.isArray(k.students) ? k.students.length : 0;
                var guruCount  = Array.isArray(k.subjects) ? k.subjects.map(function(s){ return s.teacher_id; }).filter(function(v,idx,arr){ return arr.indexOf(v)===idx; }).length : 0;
                var mapelList  = Array.isArray(k.subjects) ? k.subjects.map(function(s){ return '<span class="mapel-tag">' + (s.name||'') + '</span>'; }).join('') : '<span style="color:#ccc;">—</span>';

                rows += '<tr data-nama="' + nama.toLowerCase() + '">' +
                    '<td>' + (i+1) + '</td>' +
                    '<td><div class="d-flex align-items-center gap-2"><div class="kelas-avatar">' + inisial + '</div><span style="font-weight:700;">' + nama + '</span></div></td>' +
                    '<td>' + mapelList + '</td>' +
                    '<td><span class="stat-chip-sm green"><i class="bi bi-people"></i>' + siswaCount + ' siswa</span></td>' +
                    '<td><span class="stat-chip-sm"><i class="bi bi-person-badge"></i>' + guruCount + ' guru</span></td>' +
                    '<td>' +
                        '<button class="btn-act btn-act-edit" data-id="' + k.id + '"><i class="bi bi-pencil"></i> Edit</button>' +
                        '<button class="btn-act btn-act-delete" data-id="' + k.id + '" data-nama="' + nama + '"><i class="bi bi-trash"></i></button>' +
                    '</td>' +
                '</tr>';
            });
            tbody.innerHTML = rows;
        })
        .catch(function() { Swal.fire('Error','Gagal memuat data kelas.','error'); });
    }

    document.getElementById('searchKelas').addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#kelasTbody tr[data-nama]');
        var shown = 0;
        rows.forEach(function(row) {
            var match = !q || row.getAttribute('data-nama').includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('kelas-shown').textContent = shown;
    });

    document.getElementById('btnTambahKelas').addEventListener('click', function() {
        document.getElementById('formKelas').reset();
        document.getElementById('kelasId').value = '';
        document.getElementById('modalKelasLabel').innerHTML = '<i class="bi bi-building me-2"></i>Tambah Kelas';
    });

    document.getElementById('formKelas').addEventListener('submit', function(e) {
        e.preventDefault();
        var id       = document.getElementById('kelasId').value;
        var url      = id ? '/admin/kelas/' + id : '/admin/kelas';
        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        var btn = document.getElementById('btnSimpanKelas');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(url, { method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}, body:formData })
        .then(function(r){ return r.json(); })
        .then(function() {
            fetchKelas();
            bootstrap.Modal.getInstance(document.getElementById('modalKelas')).hide();
            Swal.fire({ icon:'success', title:'Berhasil!', text:'Data kelas berhasil disimpan.', timer:1500, showConfirmButton:false });
        })
        .catch(function() { Swal.fire('Error','Gagal menyimpan data kelas.','error'); })
        .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save me-1"></i> Simpan'; });
    });

    document.getElementById('kelasTbody').addEventListener('click', function(e) {
        var btnEdit   = e.target.closest('.btn-act-edit');
        var btnDelete = e.target.closest('.btn-act-delete');

        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            fetch('/admin/kelas/' + id, { headers:{'Accept':'application/json'} })
            .then(function(r){ return r.json(); })
            .then(function(data) {
                document.getElementById('kelasId').value    = data.id;
                document.getElementById('namaKelas').value  = data.nama || data.name || '';
                document.getElementById('modalKelasLabel').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Kelas';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalKelas')).show();
            });
        }

        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({ title:'Hapus "'+nama+'"?', text:'Kelas akan dihapus permanen.', icon:'warning',
                showCancelButton:true, confirmButtonColor:'#dc3545', cancelButtonColor:'#6c757d',
                confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                fetch('/admin/kelas/' + id, { method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'} })
                .then(function(){ fetchKelas(); Swal.fire({ icon:'success', title:'Terhapus!', timer:1400, showConfirmButton:false }); })
                .catch(function(){ Swal.fire('Error','Gagal menghapus kelas.','error'); });
            });
        }
    });

    fetchKelas();
});
</script>
@endpush