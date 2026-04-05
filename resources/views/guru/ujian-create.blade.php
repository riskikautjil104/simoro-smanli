@extends('layouts.master')
@section('title', 'Buat Ujian Baru')

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

.form-section-title { font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:14px; padding-bottom:8px; border-bottom:1px solid var(--border-color); }

.duration-wrap { position:relative; }
.duration-suffix { position:absolute; right:14px; top:50%; transform:translateY(-50%); font-size:0.8rem; font-weight:600; color:var(--text-muted); pointer-events:none; }
.duration-wrap input { padding-right:52px; }

.btn-simpan { display:inline-flex; align-items:center; gap:8px; padding:11px 28px; background:linear-gradient(135deg,#0d6efd,#0dcaf0); color:#fff; border:none; border-radius:50px; font-size:0.9rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; box-shadow:0 4px 16px rgba(13,110,253,0.25); }
.btn-simpan:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(13,110,253,0.35); }
.btn-simpan:disabled { opacity:.6; pointer-events:none; }
.btn-batal { display:inline-flex; align-items:center; gap:6px; padding:10px 22px; background:transparent; color:var(--text-muted); border:1.5px solid var(--border-color); border-radius:50px; font-size:0.875rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; }
.btn-batal:hover { border-color:rgba(13,110,253,0.3); color:var(--primary); }

.alert-success-custom { background:rgba(32,201,151,0.1); border:1px solid rgba(32,201,151,0.3); color:#198754; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }
.alert-danger-custom  { background:rgba(220,53,69,0.08); border:1px solid rgba(220,53,69,0.2);  color:#dc3545; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:0.875rem; }

/* Kelas select dynamic */
#class_id:disabled { opacity:.5; cursor:not-allowed; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-file-earmark-plus me-2"></i>Buat Ujian Baru</h4>
        <p>Isi informasi ujian yang akan Anda buat</p>
    </div>
</div>

<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-clipboard-plus"></i> Form Ujian</div>
    <div class="panel-card-body">
        <form id="form-ujian">

            {{-- Info dasar --}}
            <div class="form-section-title"><i class="bi bi-info-circle me-1"></i> Informasi Dasar</div>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Judul Ujian</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: UTS Matematika Semester Ganjil" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mata Pelajaran</label>
                    <select name="subject_id" id="subject_id" class="form-select" required>
                        <option value="">-- Pilih Mapel --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kelas</label>
                    <select name="class_id" id="class_id" class="form-select" required disabled>
                        <option value="">-- Pilih Mapel dulu --</option>
                    </select>
                </div>
            </div>

            {{-- Jadwal --}}
            <div class="form-section-title"><i class="bi bi-calendar-event me-1"></i> Jadwal & Durasi</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="datetime-local" name="end_time" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Durasi</label>
                    <div class="duration-wrap">
                        <input type="number" name="duration" class="form-control" min="1" placeholder="60" required>
                        <span class="duration-suffix">menit</span>
                    </div>
                </div>
            </div>

            <div id="ujian-alert" class="mb-4"></div>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                <button type="submit" class="btn-simpan" id="btn-simpan">
                    <i class="bi bi-save"></i> Simpan Ujian
                </button>
                <a href="{{ route('guru.ujian') }}" class="btn-batal">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var subjectsData = [];

    fetch('/guru/soal/filters', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(data) {
        subjectsData = data.subjects || [];
        var mSel = document.getElementById('subject_id');
        subjectsData.forEach(function(m) {
            mSel.innerHTML += '<option value="' + m.id + '">' + m.name + '</option>';
        });
    });

    /* Auto-load kelas saat mapel dipilih */
    document.getElementById('subject_id').addEventListener('change', function() {
        var selected = subjectsData.find(function(m){ return m.id == this.value; }, this);
        var kSel = document.getElementById('class_id');
        kSel.innerHTML = '<option value="">-- Pilih Kelas --</option>';
        kSel.disabled  = true;
        if (selected && selected.classes && selected.classes.length) {
            selected.classes.forEach(function(k) {
                kSel.innerHTML += '<option value="' + k.id + '">' + k.name + '</option>';
            });
            kSel.disabled = false;
        }
    });

    /* Submit */
    document.getElementById('form-ujian').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn  = document.getElementById('btn-simpan');
        var data = Object.fromEntries(new FormData(this));

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

        fetch('/guru/ujian/store', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrfToken, 'Accept':'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(r){ if(!r.ok) return r.json().then(function(e){ throw e; }); return r.json(); })
        .then(function(res) {
            if (res.success || res.id || res.message) {
                document.getElementById('ujian-alert').innerHTML =
                    '<div class="alert-success-custom"><i class="bi bi-check-circle-fill"></i> Ujian berhasil dibuat!</div>';
                document.getElementById('form-ujian').reset();
                document.getElementById('class_id').disabled = true;
                document.getElementById('class_id').innerHTML = '<option value="">-- Pilih Mapel dulu --</option>';
                setTimeout(function() {
                    window.location.href = '{{ route("guru.ujian") }}';
                }, 1500);
            } else {
                document.getElementById('ujian-alert').innerHTML =
                    '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Gagal membuat ujian.</div>';
            }
        })
        .catch(function(err) {
            var msg = 'Gagal membuat ujian.';
            if (err && err.errors) msg = Object.values(err.errors).flat().join('<br>');
            else if (err && err.message) msg = err.message;
            document.getElementById('ujian-alert').innerHTML =
                '<div class="alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> ' + msg + '</div>';
        })
        .finally(function() { btn.disabled=false; btn.innerHTML='<i class="bi bi-save"></i> Simpan Ujian'; });
    });
});
</script>
@endpush