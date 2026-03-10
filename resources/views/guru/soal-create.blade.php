@extends('layouts.master')
@section('title', 'Tambah Soal')

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

/* Tipe toggle */
.tipe-toggle { display:flex; gap:8px; }
.tipe-btn {
    flex:1; display:flex; flex-direction:column; align-items:center; gap:6px;
    padding:14px 10px; border-radius:12px;
    border:1.5px solid var(--border-color); background:#fff;
    cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif;
}
.tipe-btn i { font-size:1.4rem; color:#aaa; transition:var(--transition); }
.tipe-btn span { font-size:0.8rem; font-weight:600; color:var(--text-muted); transition:var(--transition); }
.tipe-btn.active { border-color:var(--primary); background:rgba(13,110,253,0.07); }
.tipe-btn.active i { color:var(--primary); }
.tipe-btn.active span { color:var(--primary); }
.tipe-btn:hover:not(.active) { border-color:rgba(13,110,253,0.2); background:rgba(13,110,253,0.025); }

.opsi-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }
@media (max-width:576px) { .opsi-grid { grid-template-columns:1fr; } }

.opsi-input-wrap { position:relative; }
.opsi-label-badge {
    position:absolute; left:0; top:0; bottom:0;
    width:38px; display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg,#0d6efd,#0dcaf0);
    color:#fff; font-weight:800; font-size:0.82rem;
    border-radius:10px 0 0 10px; pointer-events:none;
}
.opsi-input-wrap input { padding-left:50px; border-radius:10px; border:1.5px solid var(--border-color); transition:var(--transition); }
.opsi-input-wrap input:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.jawaban-select { border-radius:50px; border:1.5px solid var(--border-color); height:44px; padding:0 16px; font-size:0.875rem; transition:var(--transition); }
.jawaban-select:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); outline:none; }

.form-control, .form-select {
    border-radius:10px; border:1.5px solid var(--border-color);
    font-size:0.875rem; transition:var(--transition);
}
.form-control:focus, .form-select:focus {
    border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1);
}
textarea.form-control { border-radius:12px; resize:vertical; min-height:100px; }

.btn-simpan { display:inline-flex; align-items:center; gap:8px; padding:11px 28px; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; border:none; border-radius:50px; font-size:0.9rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; box-shadow:0 4px 16px rgba(13,110,253,0.25); }
.btn-simpan:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(13,110,253,0.35); }
.btn-simpan:disabled { opacity:.6; pointer-events:none; }

.alert-success-custom { background:rgba(32,201,151,0.1); border:1px solid rgba(32,201,151,0.3); color:#198754; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }
.alert-danger-custom  { background:rgba(220,53,69,0.08); border:1px solid rgba(220,53,69,0.2);  color:#dc3545; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-plus-circle me-2"></i>Tambah Soal</h4>
        <p>Buat soal baru untuk bank soal Anda</p>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-pencil-square"></i> Form Soal</div>
    <div class="panel-card-body">
        <form id="form-soal">

            {{-- Mapel + Tipe --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id" class="form-select" required>
                        <option value="">-- Pilih Mapel --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipe Soal</label>
                    <div class="tipe-toggle">
                        <button type="button" class="tipe-btn active" data-tipe="PG" id="tipe-pg">
                            <i class="bi bi-ui-radios"></i>
                            <span>Pilihan Ganda</span>
                        </button>
                        <button type="button" class="tipe-btn" data-tipe="ESAI" id="tipe-esai">
                            <i class="bi bi-pencil-square"></i>
                            <span>Esai</span>
                        </button>
                    </div>
                    <input type="hidden" name="type" id="type-hidden" value="PG">
                </div>
            </div>

            {{-- Pertanyaan --}}
            <div class="mb-4">
                <label class="form-label">Pertanyaan</label>
                <textarea name="pertanyaan" class="form-control" placeholder="Tulis pertanyaan di sini..." required></textarea>
            </div>

            {{-- Opsi (hanya PG) --}}
            <div id="pg-section">
                <label class="form-label">Opsi Jawaban</label>
                <div class="opsi-grid mb-4">
                    <div class="opsi-input-wrap">
                        <div class="opsi-label-badge">A</div>
                        <input type="text" name="opsi_a" class="form-control" placeholder="Opsi A">
                    </div>
                    <div class="opsi-input-wrap">
                        <div class="opsi-label-badge">B</div>
                        <input type="text" name="opsi_b" class="form-control" placeholder="Opsi B">
                    </div>
                    <div class="opsi-input-wrap">
                        <div class="opsi-label-badge">C</div>
                        <input type="text" name="opsi_c" class="form-control" placeholder="Opsi C">
                    </div>
                    <div class="opsi-input-wrap">
                        <div class="opsi-label-badge">D</div>
                        <input type="text" name="opsi_d" class="form-control" placeholder="Opsi D">
                    </div>
                </div>
                <div class="mb-4" style="max-width:240px;">
                    <label class="form-label">Jawaban Benar</label>
                    <select name="jawaban_benar" class="form-select jawaban-select">
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>

            <div id="soal-alert" class="mb-4"></div>

            <button type="submit" class="btn-simpan" id="btn-simpan">
                <i class="bi bi-save"></i> Simpan Soal
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var currentTipe = 'PG';

    /* ── Load mapel ── */
    fetch('/guru/soal/filters', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(data) {
        var sel = document.getElementById('subject_id');
        (data.subjects||[]).forEach(function(m) {
            sel.innerHTML += '<option value="'+m.id+'">'+m.name+'</option>';
        });
    });

    /* ── Tipe toggle ── */
    document.querySelectorAll('.tipe-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tipe-btn').forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            currentTipe = this.getAttribute('data-tipe');
            document.getElementById('type-hidden').value = currentTipe;
            var pgSection = document.getElementById('pg-section');
            pgSection.style.display = currentTipe === 'PG' ? '' : 'none';
            /* toggle required on opsi */
            pgSection.querySelectorAll('input[name^="opsi"], select[name="jawaban_benar"]').forEach(function(el) {
                el.required = currentTipe === 'PG';
            });
        });
    });

    /* ── Submit ── */
    document.getElementById('form-soal').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn  = document.getElementById('btn-simpan');
        var data = Object.fromEntries(new FormData(this));

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

        fetch('/guru/soal/store', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrfToken, 'Accept':'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(r){ return r.json(); })
        .then(function(res) {
            if (res.success || res.message) {
                document.getElementById('soal-alert').innerHTML =
                    '<div class="alert-success-custom"><i class="bi bi-check-circle-fill"></i> Soal berhasil ditambahkan!</div>';
                document.getElementById('form-soal').reset();
                document.querySelectorAll('.tipe-btn').forEach(function(b){ b.classList.remove('active'); });
                document.getElementById('tipe-pg').classList.add('active');
                document.getElementById('type-hidden').value = 'PG';
                document.getElementById('pg-section').style.display = '';
                setTimeout(function(){ document.getElementById('soal-alert').innerHTML = ''; }, 3000);
            } else {
                document.getElementById('soal-alert').innerHTML =
                    '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Gagal menambah soal.</div>';
            }
        })
        .catch(function() {
            document.getElementById('soal-alert').innerHTML =
                '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Terjadi kesalahan server.</div>';
        })
        .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save"></i> Simpan Soal'; });
    });
});
</script>
@endpush