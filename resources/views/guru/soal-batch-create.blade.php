@extends('layouts.master')
@section('title', 'Tambah Soal Batch')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:20px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color); background:#f0f4ff; display:flex; align-items:center; gap:8px; font-weight:700; font-size:0.9rem; color:var(--text-main); }
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:24px; }

.form-control, .form-select { border-radius:10px; border:1.5px solid var(--border-color); font-size:0.875rem; transition:var(--transition); }
.form-control:focus, .form-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }
textarea.form-control { border-radius:12px; resize:vertical; min-height:80px; }

/* Jumlah soal counter */
.counter-wrap { display:flex; align-items:center; gap:0; border:1.5px solid var(--border-color); border-radius:12px; overflow:hidden; width:fit-content; }
.counter-btn { width:38px; height:40px; border:none; background:#f0f4ff; font-size:1.1rem; font-weight:700; color:var(--primary); cursor:pointer; transition:var(--transition); display:flex; align-items:center; justify-content:center; }
.counter-btn:hover { background:var(--primary); color:#fff; }
.counter-input { width:60px; height:40px; border:none; border-left:1.5px solid var(--border-color); border-right:1.5px solid var(--border-color); text-align:center; font-weight:700; font-size:0.95rem; color:var(--text-main); outline:none; }

/* Generated soal cards */
.soal-gen-card {
    background:#fff; border-radius:14px;
    border:1px solid var(--border-color); padding:20px;
    margin-bottom:14px; position:relative; overflow:hidden;
}
.soal-gen-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
.soal-gen-card.pg-card::before   { background:linear-gradient(90deg,#0d6efd,#0dcaf0); }
.soal-gen-card.esai-card::before { background:linear-gradient(90deg,#6f42c1,#9c27b0); }

.soal-gen-badge { display:inline-flex; align-items:center; gap:5px; font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:20px; margin-bottom:12px; }
.badge-pg   { background:rgba(13,110,253,0.1); color:#0d6efd; }
.badge-esai { background:rgba(111,66,193,0.1); color:#6f42c1; }

.opsi-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; }
@media (max-width:576px) { .opsi-grid { grid-template-columns:1fr; } }

.opsi-input-wrap { position:relative; }
.opsi-label-badge { position:absolute; left:0; top:0; bottom:0; width:36px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; font-weight:800; font-size:0.78rem; border-radius:10px 0 0 10px; pointer-events:none; }
.opsi-input-wrap input { padding-left:48px; border-radius:10px; border:1.5px solid var(--border-color); font-size:0.85rem; transition:var(--transition); height:40px; }
.opsi-input-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.jawaban-select { border-radius:50px; border:1.5px solid var(--border-color); height:40px; padding:0 16px; font-size:0.85rem; transition:var(--transition); max-width:200px; }
.jawaban-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.btn-generate { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; border:none; border-radius:50px; font-size:0.875rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; box-shadow:0 4px 14px rgba(13,110,253,0.25); }
.btn-generate:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(13,110,253,0.35); }
.btn-submit-all { display:inline-flex; align-items:center; gap:8px; padding:11px 28px; background:linear-gradient(135deg,#198754,#20c997); color:#fff; border:none; border-radius:50px; font-size:0.9rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; box-shadow:0 4px 14px rgba(32,201,151,0.25); }
.btn-submit-all:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(32,201,151,0.35); }
.btn-submit-all:disabled { opacity:.6; pointer-events:none; }

.alert-success-custom { background:rgba(32,201,151,0.1); border:1px solid rgba(32,201,151,0.3); color:#198754; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }
.alert-danger-custom  { background:rgba(220,53,69,0.08); border:1px solid rgba(220,53,69,0.2);  color:#dc3545; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-list-ol me-2"></i>Tambah Soal Batch</h4>
        <p>Generate dan simpan banyak soal sekaligus ke ujian</p>
    </div>
</div>

<form id="form-batch-soal">

{{-- Step 1: Konfigurasi --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-gear"></i> Konfigurasi Ujian & Jumlah Soal</div>
    <div class="panel-card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Ujian</label>
                <select name="exam_id" id="exam_id" class="form-select" required>
                    <option value="">-- Pilih Ujian --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">-- Pilih Mapel --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                </select>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label">Jumlah Soal Pilihan Ganda</label>
                <div class="d-flex align-items-center gap-3">
                    <div class="counter-wrap">
                        <button type="button" class="counter-btn" data-target="jumlah_pg" data-op="-">−</button>
                        <input type="number" name="jumlah_pg" id="jumlah_pg" class="counter-input" min="0" value="0">
                        <button type="button" class="counter-btn" data-target="jumlah_pg" data-op="+">+</button>
                    </div>
                    <span style="font-size:.82rem;color:var(--text-muted);">soal PG</span>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Jumlah Soal Esai</label>
                <div class="d-flex align-items-center gap-3">
                    <div class="counter-wrap">
                        <button type="button" class="counter-btn" data-target="jumlah_esai" data-op="-">−</button>
                        <input type="number" name="jumlah_esai" id="jumlah_esai" class="counter-input" min="0" value="0">
                        <button type="button" class="counter-btn" data-target="jumlah_esai" data-op="+">+</button>
                    </div>
                    <span style="font-size:.82rem;color:var(--text-muted);">soal Esai</span>
                </div>
            </div>
        </div>
        <button type="button" class="btn-generate" id="btn-generate">
            <i class="bi bi-lightning-charge"></i> Generate Form Soal
        </button>
    </div>
</div>

{{-- Step 2: Generated soal --}}
<div id="generated-soal-container" style="display:none;">
    <div class="panel-card">
        <div class="panel-card-header"><i class="bi bi-card-list"></i> Form Soal <span id="soal-count-label" style="font-weight:400;font-size:0.82rem;color:var(--text-muted);margin-left:6px;"></span></div>
        <div class="panel-card-body">
            <div id="generated-soal"></div>
        </div>
    </div>

    <div id="soal-alert" class="mb-3"></div>

    <button type="submit" class="btn-submit-all" id="btn-submit">
        <i class="bi bi-save"></i> Simpan Semua Soal
    </button>
</div>

</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var subjectsData = [];
var examsData    = [];
var csrfToken    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/* ── Counter buttons ── */
document.querySelectorAll('.counter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var input = document.getElementById(this.getAttribute('data-target'));
        var val   = parseInt(input.value) || 0;
        if (this.getAttribute('data-op') === '+') input.value = val + 1;
        else if (val > 0) input.value = val - 1;
    });
});

/* ── Load filters ── */
fetch('/guru/soal/filters', { headers:{'Accept':'application/json'} })
.then(function(r){ return r.ok ? r.json() : {}; })
.then(function(data) {
    subjectsData = data.subjects || [];
    examsData    = data.exams    || [];

    var kelasSet = new Map();
    subjectsData.forEach(function(m){ (m.classes||[]).forEach(function(k){ kelasSet.set(k.id, k.name); }); });
    examsData.forEach(function(e){ if(e.school_class) kelasSet.set(e.school_class.id, e.school_class.name); });

    var mSel = document.getElementById('subject_id');
    subjectsData.forEach(function(m){ mSel.innerHTML += '<option value="'+m.id+'">'+m.name+'</option>'; });

    var kSel = document.getElementById('class_id');
    kelasSet.forEach(function(name, id){ kSel.innerHTML += '<option value="'+id+'">'+name+'</option>'; });

    var uSel = document.getElementById('exam_id');
    examsData.forEach(function(u){ uSel.innerHTML += '<option value="'+u.id+'">'+(u.title||u.nama||'')+'</option>'; });

    /* Auto-fill mapel & kelas saat ujian dipilih */
    uSel.addEventListener('change', function() {
        var sel = examsData.find(function(e){ return e.id == uSel.value; });
        if (sel) {
            mSel.value = sel.subject_id || '';
            kSel.value = sel.class_id   || '';
        }
    });
});

/* ── Generate form ── */
document.getElementById('btn-generate').addEventListener('click', function() {
    var pgCount   = parseInt(document.getElementById('jumlah_pg').value)   || 0;
    var esaiCount = parseInt(document.getElementById('jumlah_esai').value) || 0;

    if (pgCount + esaiCount === 0) {
        Swal.fire({ icon:'warning', title:'Oops!', text:'Masukkan jumlah soal minimal 1.', timer:2000, showConfirmButton:false });
        return;
    }

    var html = '';

    for (var i = 1; i <= pgCount; i++) {
        html += '<div class="soal-gen-card pg-card">' +
            '<span class="soal-gen-badge badge-pg"><i class="bi bi-ui-radios"></i> Pilihan Ganda #' + i + '</span>' +
            '<div class="mb-3"><label class="form-label">Pertanyaan</label>' +
                '<textarea name="pg_pertanyaan_' + i + '" class="form-control" placeholder="Tulis pertanyaan..." required></textarea>' +
            '</div>' +
            '<label class="form-label">Opsi Jawaban</label>' +
            '<div class="opsi-grid mb-3">' +
                ['A','B','C','D'].map(function(o){
                    return '<div class="opsi-input-wrap">' +
                        '<div class="opsi-label-badge">' + o + '</div>' +
                        '<input type="text" name="pg_opsi_' + o.toLowerCase() + '_' + i + '" class="form-control" placeholder="Opsi ' + o + '" required>' +
                    '</div>';
                }).join('') +
            '</div>' +
            '<div style="max-width:200px;"><label class="form-label">Jawaban Benar</label>' +
                '<select name="pg_jawaban_benar_' + i + '" class="form-select jawaban-select" required>' +
                    '<option value="">Pilih</option>' +
                    ['A','B','C','D'].map(function(o){ return '<option value="'+o+'">'+o+'</option>'; }).join('') +
                '</select>' +
            '</div>' +
        '</div>';
    }

    for (var j = 1; j <= esaiCount; j++) {
        html += '<div class="soal-gen-card esai-card">' +
            '<span class="soal-gen-badge badge-esai"><i class="bi bi-pencil-square"></i> Esai #' + j + '</span>' +
            '<div><label class="form-label">Pertanyaan</label>' +
                '<textarea name="esai_pertanyaan_' + j + '" class="form-control" placeholder="Tulis pertanyaan..." required></textarea>' +
            '</div>' +
        '</div>';
    }

    document.getElementById('generated-soal').innerHTML = html;
    document.getElementById('soal-count-label').textContent = '— ' + (pgCount+esaiCount) + ' soal dibuat';
    document.getElementById('generated-soal-container').style.display = '';
    document.getElementById('soal-alert').innerHTML = '';

    /* Smooth scroll */
    setTimeout(function() {
        document.getElementById('generated-soal-container').scrollIntoView({ behavior:'smooth', block:'start' });
    }, 100);
});

/* ── Submit ── */
document.getElementById('form-batch-soal').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn  = document.getElementById('btn-submit');
    var data = Object.fromEntries(new FormData(this));

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

    fetch('/guru/soal/batch', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrfToken, 'Accept':'application/json' },
        body: JSON.stringify(data)
    })
    .then(function(r){ return r.json(); })
    .then(function(res) {
        if (res.success || res.message) {
            document.getElementById('soal-alert').innerHTML =
                '<div class="alert-success-custom"><i class="bi bi-check-circle-fill"></i> Semua soal berhasil ditambahkan!</div>';
            document.getElementById('form-batch-soal').reset();
            document.getElementById('generated-soal').innerHTML = '';
            document.getElementById('generated-soal-container').style.display = 'none';
            window.scrollTo({ top:0, behavior:'smooth' });
        } else {
            document.getElementById('soal-alert').innerHTML =
                '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Gagal menambah soal.</div>';
        }
    })
    .catch(function() {
        document.getElementById('soal-alert').innerHTML =
            '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Terjadi kesalahan server.</div>';
    })
    .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save"></i> Simpan Semua Soal'; });
});
</script>
@endpush