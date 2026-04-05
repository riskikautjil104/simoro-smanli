@extends('layouts.master')
@section('title', 'Pengaturan Mobile')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p { font-size:0.85rem; opacity:0.85; margin:0; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:24px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color); background:#f0f4ff; display:flex; align-items:center; gap:8px; font-weight:700; font-size:0.9rem; color:var(--text-main); }
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:20px; }

.form-label { font-size:0.85rem; font-weight:600; color:var(--text-main); margin-bottom:6px; }
.form-control { border-radius:10px; border:1.5px solid var(--border-color); padding:10px 14px; font-size:0.9rem; transition:var(--transition); }
.form-control:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(13,110,253,0.1); }

.color-input-wrap { display:flex; align-items:center; gap:10px; }
.color-preview { width:40px; height:40px; border-radius:10px; border:2px solid var(--border-color); cursor:pointer; }
.color-input { width:0; height:0; opacity:0; position:absolute; }

.btn-save { background:var(--primary); color:#fff; border:none; padding:10px 24px; border-radius:10px; font-weight:600; font-size:0.9rem; transition:var(--transition); }
.btn-save:hover { background:var(--accent); transform:translateY(-1px); }

.toggle-wrap { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border-color); }
.toggle-wrap:last-child { border-bottom:none; }
.toggle-label { font-weight:600; font-size:0.9rem; }
.toggle-desc { font-size:0.8rem; color:var(--text-muted); margin-top:2px; }
.toggle-switch { position:relative; width:50px; height:26px; }
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#ccc; transition:0.3s; border-radius:26px; }
.toggle-slider:before { position:absolute; content:""; height:20px; width:20px; left:3px; bottom:3px; background:#fff; transition:0.3s; border-radius:50%; }
.toggle-switch input:checked + .toggle-slider { background:var(--primary); }
.toggle-switch input:checked + .toggle-slider:before { transform:translateX(24px); }

.success-msg { background:rgba(25,135,84,0.1); border:1px solid rgba(25,135,84,0.3); color:#198754; padding:12px 16px; border-radius:10px; font-weight:600; margin-bottom:16px; display:none; }
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-phone me-2"></i>Pengaturan Mobile</h4>
        <p>Kelola konfigurasi aplikasi mobile</p>
    </div>
</div>

<div id="successMessage" class="success-msg">
    <i class="bi bi-check-circle me-2"></i> Konfigurasi berhasil disimpan!
</div>

{{-- App Info --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-info-circle"></i> Informasi Aplikasi</div>
    <div class="panel-card-body">
        <form id="appForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" class="form-control" name="app_name" id="app_name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text" class="form-control" name="school_name" id="school_name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tagline</label>
                    <input type="text" class="form-control" name="tagline" id="tagline">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi</label>
                    <input type="text" class="form-control" name="location" id="location">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Versi</label>
                    <input type="text" class="form-control" name="version" id="version">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pesan Maintenance</label>
                    <input type="text" class="form-control" name="maintenance_message" id="maintenance_message">
                </div>
            </div>
            <button type="submit" class="btn-save mt-4">Simpan App Info</button>
        </form>
    </div>
</div>

{{-- Theme --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-palette"></i> Tema Aplikasi</div>
    <div class="panel-card-body">
        <form id="themeForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Warna Utama</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_primary" value="#0d6efd">
                        <input type="text" class="form-control" name="primary" id="primary">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Warna Sekunder</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_secondary" value="#6c757d">
                        <input type="text" class="form-control" name="secondary" id="secondary">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Background</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_background" value="#ffffff">
                        <input type="text" class="form-control" name="background" id="background">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Surface</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_surface" value="#f8f9fa">
                        <input type="text" class="form-control" name="surface" id="surface">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Error</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_error" value="#dc3545">
                        <input type="text" class="form-control" name="error" id="error">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Success</label>
                    <div class="color-input-wrap">
                        <input type="color" class="color-preview" id="color_success" value="#198754">
                        <input type="text" class="form-control" name="success" id="success">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save mt-4">Simpan Tema</button>
        </form>
    </div>
</div>

{{-- Features --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-toggle-on"></i> Fitur</div>
    <div class="panel-card-body">
        <form id="featuresForm">
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Tampilkan Onboarding</div>
                    <div class="toggle-desc">Tampilkan halaman pengenalan saat pertama kali membuka app</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="show_onboarding" id="show_onboarding">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Tampilkan Notifikasi</div>
                    <div class="toggle-desc">Aktifkan tombol notifikasi di mobile app</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="show_notifications" id="show_notifications">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-wrap">
                <div>
                    <div class="toggle-label">Tracking Lokasi Ujian</div>
                    <div class="toggle-desc">Aktifkan pelacakan lokasi saat siswa mengikuti ujian</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="enable_location_tracking" id="enable_location_tracking">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <button type="submit" class="btn-save mt-4">Simpan Fitur</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Load current config
fetch('/mobile/config', { headers: { 'Accept': 'application/json' } })
.then(r => r.ok ? r.json() : {})
.then(data => {
    if (data.app) {
        document.getElementById('app_name').value = data.app.app_name || '';
        document.getElementById('school_name').value = data.app.school_name || '';
        document.getElementById('tagline').value = data.app.tagline || '';
        document.getElementById('location').value = data.app.location || '';
        document.getElementById('version').value = data.app.version || '';
        document.getElementById('maintenance_message').value = data.app.maintenance_message || '';
    }
    if (data.theme) {
        ['primary','secondary','background','surface','error','success'].forEach(c => {
            document.getElementById(c).value = data.theme[c] || '';
            document.getElementById('color_'+c).value = data.theme[c] || '#000000';
        });
    }
    if (data.features) {
        document.getElementById('show_onboarding').checked = data.features.show_onboarding;
        document.getElementById('show_notifications').checked = data.features.show_notifications;
        document.getElementById('enable_location_tracking').checked = data.features.enable_location_tracking;
    }
});

// Color picker sync
document.querySelectorAll('.color-preview').forEach(picker => {
    picker.addEventListener('input', function() {
        var name = this.id.replace('color_', '');
        document.getElementById(name).value = this.value;
    });
});

function showSuccess() {
    var msg = document.getElementById('successMessage');
    msg.style.display = 'block';
    setTimeout(() => msg.style.display = 'none', 3000);
}

// App Form
document.getElementById('appForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    fetch('/mobile/config/app', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    }).then(r => r.json()).then(d => { if(d.success) showSuccess(); });
});

// Theme Form
document.getElementById('themeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    fetch('/mobile/config/theme', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    }).then(r => r.json()).then(d => { if(d.success) showSuccess(); });
});

// Features Form
document.getElementById('featuresForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    fetch('/mobile/config/features', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    }).then(r => r.json()).then(d => { if(d.success) showSuccess(); });
});
</script>
@endpush

