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

/* Aksi buttons */
.btn-aksi { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; transition:all .18s; font-size:0.82rem; }
.btn-edit  { background:rgba(13,110,253,0.1); color:#0d6efd; }
.btn-edit:hover  { background:#0d6efd; color:#fff; }
.btn-hapus { background:rgba(220,53,69,0.1); color:#dc3545; }
.btn-hapus:hover { background:#dc3545; color:#fff; }

/* Modal overlay */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1050; align-items:center; justify-content:center; backdrop-filter:blur(3px); }
.modal-overlay.active { display:flex; }
.modal-box { background:#fff; border-radius:20px; width:100%; max-width:560px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2); animation:modalIn .22s ease; }
@keyframes modalIn { from{transform:translateY(24px);opacity:0} to{transform:translateY(0);opacity:1} }
.modal-head { padding:20px 24px 16px; border-bottom:1px solid var(--border-color,#e5e7eb); display:flex; align-items:center; justify-content:space-between; }
.modal-head h5 { font-weight:700; font-size:1rem; margin:0; }
.modal-close { background:none; border:none; font-size:1.3rem; color:#aaa; cursor:pointer; line-height:1; }
.modal-close:hover { color:#dc3545; }
.modal-body { padding:20px 24px; }
.modal-foot { padding:14px 24px 20px; display:flex; gap:10px; justify-content:flex-end; border-top:1px solid var(--border-color,#e5e7eb); }

/* Confirm delete dialog */
.confirm-box { background:#fff; border-radius:20px; width:100%; max-width:380px; box-shadow:0 20px 60px rgba(0,0,0,0.2); animation:modalIn .22s ease; text-align:center; padding:32px 28px 24px; }
.confirm-icon { width:64px; height:64px; background:rgba(220,53,69,0.1); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.7rem; color:#dc3545; margin-bottom:14px; }
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
                    <th style="width:80px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="soal-tbody">
                <tr><td colspan="12">
                    <div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat data...</h6></div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ===== MODAL EDIT ===== --}}
<div class="modal-overlay" id="modal-edit">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Soal</h5>
            <button class="modal-close" onclick="closeEdit()">&times;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="edit-id">
            <div class="mb-3">
                <label class="form-label fw-600">Pertanyaan <span class="text-danger">*</span></label>
                <textarea id="edit-pertanyaan" class="form-control" rows="3" placeholder="Tulis pertanyaan..."></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-600">Tipe Soal <span class="text-danger">*</span></label>
                    <select id="edit-type" class="form-select filter-select w-100" onchange="toggleOpsi(this.value)">
    <option value="multiple_choice">Pilihan Ganda</option>
    <option value="essay">Essay</option>
</select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600">Kunci Jawaban</label>
                    <input type="text" id="edit-jawaban_benar" class="form-control" style="border-radius:50px;" placeholder="A / B / C / D">
                </div>
            </div>
            <div id="opsi-wrapper">
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Opsi A</label>
                        <input type="text" id="edit-opsi_a" class="form-control" style="border-radius:10px;" placeholder="Opsi A">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Opsi B</label>
                        <input type="text" id="edit-opsi_b" class="form-control" style="border-radius:10px;" placeholder="Opsi B">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Opsi C</label>
                        <input type="text" id="edit-opsi_c" class="form-control" style="border-radius:10px;" placeholder="Opsi C">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Opsi D</label>
                        <input type="text" id="edit-opsi_d" class="form-control" style="border-radius:10px;" placeholder="Opsi D">
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label fw-600">Mata Pelajaran <span class="text-danger">*</span></label>
                    <select id="edit-subject_id" class="form-select filter-select w-100"></select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600">Ujian <span class="text-danger">*</span></label>
                    <select id="edit-exam_id" class="form-select filter-select w-100"></select>
                </div>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-outline-secondary" style="border-radius:50px;padding:8px 20px;" onclick="closeEdit()">Batal</button>
            <button class="btn btn-primary" style="border-radius:50px;padding:8px 22px;" id="btn-save-edit" onclick="saveEdit()">
                <i class="bi bi-check-lg me-1"></i> Simpan
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL HAPUS ===== --}}
<div class="modal-overlay" id="modal-hapus">
    <div class="confirm-box">
        <div class="confirm-icon"><i class="bi bi-trash3"></i></div>
        <h6 class="fw-700 mb-2">Hapus Soal?</h6>
        <p style="font-size:0.85rem;color:#6c757d;margin-bottom:20px;">Soal ini akan dihapus permanen dan tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-id">
        <div class="d-flex gap-2 justify-content-center">
            <button class="btn btn-outline-secondary" style="border-radius:50px;padding:8px 20px;" onclick="closeHapus()">Batal</button>
            <button class="btn btn-danger" style="border-radius:50px;padding:8px 22px;" id="btn-confirm-hapus" onclick="confirmHapus()">
                <i class="bi bi-trash me-1"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var soalData     = [];
var examsData    = [];
var subjectsData = [];
var kelasData    = [];

/* ─── helpers ─── */
function tipeBadge(type) {
    var t = (type||'').toLowerCase();
    if (t === 'essay') return '<span class="badge-tipe badge-essay"><i class="bi bi-pencil-square"></i> Esai</span>';
    return '<span class="badge-tipe badge-pg"><i class="bi bi-ui-radios"></i> PG</span>';
}


function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';
}

function toggleOpsi(type) {
    var wrap = document.getElementById('opsi-wrapper');
    if (!wrap) return;
    wrap.style.display = (type === 'essay') ? 'none' : '';
}

/* ─── render table ─── */
function renderTable(data) {
    var tbody = document.getElementById('soal-tbody');
    document.getElementById('soal-count').textContent = soalData.length + ' soal';
    document.getElementById('soal-shown').textContent = data.length;

    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="12"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Data tidak ditemukan</h6><p>Coba ubah filter atau tambah soal baru</p></div></td></tr>';
        return;
    }

    var rows = '';
    data.forEach(function(s, idx) {
        var ujian   = examsData.find(function(e){ return e.id === s.exam_id; });
        var kelasNm = ujian && ujian.school_class ? ujian.school_class.name : '-';
        var ujianNm = ujian ? ujian.title : '-';
        var mapelNm = s.subject ? s.subject.name : '-';
        var pertanyaan = s.pertanyaan || s.question_text || '-';
        var kunci   = s.jawaban_benar || s.answer_key || '';

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
            '<td>' +
                '<button class="btn-aksi btn-edit me-1" title="Edit" onclick="openEdit(' + s.id + ')"><i class="bi bi-pencil"></i></button>' +
                '<button class="btn-aksi btn-hapus" title="Hapus" onclick="openHapus(' + s.id + ')"><i class="bi bi-trash"></i></button>' +
            '</td>' +
        '</tr>';
    });
    tbody.innerHTML = rows;
}

/* ─── filter ─── */
function applyFilters() {
    var kelasId = document.getElementById('filter-kelas').value;
    var mapelId = document.getElementById('filter-mapel').value;
    var ujianId = document.getElementById('filter-ujian').value;
    var q       = document.getElementById('searchSoal').value.toLowerCase().trim();
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

/* ─── EDIT ─── */
function openEdit(id) {
    var s = soalData.find(function(x){ return x.id === id; });
    if (!s) return;

    document.getElementById('edit-id').value          = s.id;
    document.getElementById('edit-pertanyaan').value  = s.pertanyaan || s.question_text || '';
    document.getElementById('edit-type').value        = s.type || 'pg';
    document.getElementById('edit-jawaban_benar').value = s.jawaban_benar || s.answer_key || '';
    document.getElementById('edit-opsi_a').value      = s.opsi_a || '';
    document.getElementById('edit-opsi_b').value      = s.opsi_b || '';
    document.getElementById('edit-opsi_c').value      = s.opsi_c || '';
    document.getElementById('edit-opsi_d').value      = s.opsi_d || '';

    // Populate selects
    var mSel = document.getElementById('edit-subject_id');
    mSel.innerHTML = '';
    subjectsData.forEach(function(m){
        var opt = document.createElement('option');
        opt.value = m.id; opt.textContent = m.name;
        if (m.id == s.subject_id) opt.selected = true;
        mSel.appendChild(opt);
    });

    var uSel = document.getElementById('edit-exam_id');
    uSel.innerHTML = '';
    examsData.forEach(function(e){
        var opt = document.createElement('option');
        opt.value = e.id; opt.textContent = e.title || e.nama || '';
        if (e.id == s.exam_id) opt.selected = true;
        uSel.appendChild(opt);
    });

    toggleOpsi(s.type || 'pg');
    document.getElementById('modal-edit').classList.add('active');
}

function closeEdit() {
    document.getElementById('modal-edit').classList.remove('active');
}

function saveEdit() {
    var id  = document.getElementById('edit-id').value;
    var btn = document.getElementById('btn-save-edit');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

    var payload = {
        // ❌ hapus baris _method: 'PUT'
        pertanyaan:    document.getElementById('edit-pertanyaan').value,
        type:          document.getElementById('edit-type').value,
        jawaban_benar: document.getElementById('edit-jawaban_benar').value,
        opsi_a:        document.getElementById('edit-opsi_a').value,
        opsi_b:        document.getElementById('edit-opsi_b').value,
        opsi_c:        document.getElementById('edit-opsi_c').value,
        opsi_d:        document.getElementById('edit-opsi_d').value,
        subject_id:    document.getElementById('edit-subject_id').value,
        exam_id:       document.getElementById('edit-exam_id').value,
    };

    fetch('/guru/soal/' + id, {
        method: 'POST',  // tetap POST
        headers: {
            'Content-Type': 'application/json',
            'Accept':        'application/json',
            'X-CSRF-TOKEN':  csrfToken(),
        },
        body: JSON.stringify(payload),
    })

    .then(function(r){ return r.json(); })
    .then(function(res) {
        if (res.success) {
            // Update local data
            var idx = soalData.findIndex(function(x){ return x.id == id; });
            if (idx !== -1) soalData[idx] = res.data;
            applyFilters();
            closeEdit();
            showToast('Soal berhasil diperbarui!', 'success');
        } else {
            showToast('Gagal menyimpan. ' + (res.message||''), 'danger');
        }
    })
    .catch(function(){ showToast('Terjadi kesalahan server.', 'danger'); })
    .finally(function(){
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan';
    });
}

/* ─── HAPUS ─── */
function openHapus(id) {
    document.getElementById('hapus-id').value = id;
    document.getElementById('modal-hapus').classList.add('active');
}

function closeHapus() {
    document.getElementById('modal-hapus').classList.remove('active');
}

function confirmHapus() {
    var id  = document.getElementById('hapus-id').value;
    var btn = document.getElementById('btn-confirm-hapus');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';

    fetch('/guru/soal/' + id, {
        method: 'DELETE',
        headers: {
            'Accept':       'application/json',
            'X-CSRF-TOKEN': csrfToken(),
        },
    })
    .then(function(r){ return r.json(); })
    .then(function(res) {
        if (res.success) {
            soalData = soalData.filter(function(x){ return x.id != id; });
            applyFilters();
            closeHapus();
            showToast('Soal berhasil dihapus.', 'success');
        } else {
            showToast('Gagal menghapus. ' + (res.message||''), 'danger');
        }
    })
    .catch(function(){ showToast('Terjadi kesalahan server.', 'danger'); })
    .finally(function(){
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-trash me-1"></i> Ya, Hapus';
    });
}

/* ─── Toast notifikasi ─── */
function showToast(msg, type) {
    var id = 'toast-' + Date.now();
    var color = type === 'success' ? '#198754' : '#dc3545';
    var icon  = type === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
    var el = document.createElement('div');
    el.id = id;
    el.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;background:#fff;border-radius:12px;padding:12px 18px;box-shadow:0 8px 32px rgba(0,0,0,0.15);display:flex;align-items:center;gap:10px;font-size:0.875rem;font-weight:600;border-left:4px solid ' + color + ';animation:modalIn .22s ease;min-width:260px;';
    el.innerHTML = '<i class="bi ' + icon + '" style="color:' + color + ';font-size:1.1rem;"></i>' + msg;
    document.body.appendChild(el);
    setTimeout(function(){ var t = document.getElementById(id); if(t) t.remove(); }, 3500);
}

/* ─── close modal on overlay click ─── */
['modal-edit','modal-hapus'].forEach(function(mid) {
    document.getElementById(mid).addEventListener('click', function(e){
        if (e.target === this) { this.classList.remove('active'); }
    });
});

/* ─── DOMContentLoaded ─── */
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

        return fetch('/guru/soal/list', { headers:{'Accept':'application/json'} });
    })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) { soalData = data; renderTable(data); })
    .catch(function() {
        document.getElementById('soal-tbody').innerHTML = '<tr><td colspan="12"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data</h6></div></td></tr>';
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

    document.getElementById('edit-type').addEventListener('change', function(){
        toggleOpsi(this.value);
    });
});
</script>
@endpush
