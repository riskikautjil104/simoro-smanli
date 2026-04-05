@extends('layouts.master')
@section('title', 'Dashboard Guru')

@push('styles')
<style>
/* ── Welcome banner ── */
.guru-welcome {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    border-radius: 16px; padding: 28px 32px;
    color: #fff; position: relative; overflow: hidden; margin-bottom: 24px;
}
.guru-welcome::before {
    content: ''; position: absolute;
    width: 260px; height: 260px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%; top: -80px; right: -60px; pointer-events: none;
}
.guru-welcome::after {
    content: ''; position: absolute;
    width: 140px; height: 140px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%; bottom: -40px; left: 120px; pointer-events: none;
}
.guru-welcome-content { position: relative; z-index: 2; }
.guru-welcome h5 { font-size: 1.35rem; font-weight: 700; margin: 0 0 8px; }
.guru-welcome p  { font-size: 0.875rem; opacity: 0.88; margin: 0; line-height: 1.6; }
.guru-welcome-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: 0.75rem; font-weight: 600; color: #fff;
    margin-bottom: 12px; backdrop-filter: blur(6px);
}

/* ── Stat cards ── */
.stat-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
@media (max-width: 991px) { .stat-cards { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 480px)  { .stat-cards { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: #fff; border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 20px 18px;
    display: flex; flex-direction: column; gap: 12px;
    transition: var(--transition); position: relative; overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(13,110,253,0.12); }
.stat-card::before {
    content: ''; position: absolute;
    width: 90px; height: 90px; border-radius: 50%;
    top: -25px; right: -20px; opacity: 0.08;
}
.stat-card.green::before  { background: #198754; }
.stat-card.blue::before   { background: #0d6efd; }
.stat-card.yellow::before { background: #ffc107; }
.stat-card.red::before    { background: #dc3545; }

.stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.stat-icon.green  { background: rgba(32,201,151,0.12); color: #198754; }
.stat-icon.blue   { background: rgba(13,110,253,0.1);  color: #0d6efd; }
.stat-icon.yellow { background: rgba(255,193,7,0.15);  color: #856404; }
.stat-icon.red    { background: rgba(220,53,69,0.1);   color: #dc3545; }

.stat-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.4px; }
.stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-top: 2px; }
.stat-value.green  { color: #198754; }
.stat-value.blue   { color: #0d6efd; }
.stat-value.yellow { color: #856404; }
.stat-value.red    { color: #dc3545; }

/* skeleton shimmer */
.skeleton {
    background: linear-gradient(90deg,#f0f4ff 25%,#e2e8f7 50%,#f0f4ff 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 6px; display: inline-block; color: transparent;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* ── Quick links ── */
.quick-links { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
@media (max-width: 767px) { .quick-links { grid-template-columns: repeat(2,1fr); } }

.quick-link-card {
    background: #fff; border-radius: 14px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 16px 14px;
    display: flex; align-items: center; gap: 12px;
    text-decoration: none; color: var(--text-main);
    transition: var(--transition);
}
.quick-link-card:hover {
    border-color: rgba(13,110,253,0.25);
    background: rgba(13,110,253,0.025);
    transform: translateY(-2px);
    color: var(--primary);
}
.quick-link-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.quick-link-label { font-size: 0.82rem; font-weight: 600; }

.panel-card { background: #fff; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 24px; }
.panel-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border-color); background: #f0f4ff; display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.9rem; color: var(--text-main); }
.panel-card-header i { color: var(--primary); }
.panel-card-body { padding: 20px; }
</style>
@endpush

@section('layoutContent')

{{-- ── WELCOME BANNER ── --}}
<div class="guru-welcome">
    <div class="guru-welcome-content">
        <div class="guru-welcome-chip">
            <i class="bi bi-person-badge"></i> Panel Guru
        </div>
        <h5>Selamat datang, {{ auth()->user()->name }}! 👋</h5>
        <p>Panel guru SMA Negeri 5 Morotai.<br>Kelola mata pelajaran, soal, ujian, monitoring, dan hasil ujian Anda di sini.</p>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stat-cards">
    <div class="stat-card green">
        <div class="stat-icon green"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
            <div class="stat-label">Mapel Saya</div>
            <div class="stat-value green skeleton" id="statMapel" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="bi bi-archive"></i></div>
        <div>
            <div class="stat-label">Bank Soal</div>
            <div class="stat-value blue skeleton" id="statSoal" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon yellow"><i class="bi bi-clipboard-plus"></i></div>
        <div>
            <div class="stat-label">Ujian Dibuat</div>
            <div class="stat-value yellow skeleton" id="statUjian" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="bi bi-bar-chart-line-fill"></i></div>
        <div>
            <div class="stat-label">Hasil Ujian</div>
            <div class="stat-value red skeleton" id="statHasil" style="min-width:40px;">0</div>
        </div>
    </div>
</div>

{{-- ── QUICK LINKS ── --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-grid-3x3-gap"></i> Akses Cepat</div>
    <div class="panel-card-body">
        <div class="quick-links">
            <a class="quick-link-card" href="{{ route('guru.soal.create') }}">
                <div class="quick-link-icon" style="background:rgba(13,110,253,0.1);color:#0d6efd;"><i class="bi bi-plus-circle"></i></div>
                <span class="quick-link-label">Tambah Soal</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.soal.batch') }}">
                <div class="quick-link-icon" style="background:rgba(32,201,151,0.1);color:#198754;"><i class="bi bi-list-ol"></i></div>
                <span class="quick-link-label">Soal Batch</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.ujian.create') }}">
                <div class="quick-link-icon" style="background:rgba(255,193,7,0.12);color:#856404;"><i class="bi bi-file-earmark-plus"></i></div>
                <span class="quick-link-label">Buat Ujian</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.monitoring') }}">
                <div class="quick-link-icon" style="background:rgba(13,202,240,0.1);color:#0a9bba;"><i class="bi bi-tv"></i></div>
                <span class="quick-link-label">Monitoring</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.periksa') }}">
                <div class="quick-link-icon" style="background:rgba(111,66,193,0.1);color:#6f42c1;"><i class="bi bi-check2-square"></i></div>
                <span class="quick-link-label">Periksa Jawaban</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.hasil') }}">
                <div class="quick-link-icon" style="background:rgba(220,53,69,0.1);color:#dc3545;"><i class="bi bi-bar-chart-line"></i></div>
                <span class="quick-link-label">Hasil Ujian</span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/guru/dashboard/stats', { headers:{'Accept':'application/json'}, credentials:'same-origin' })
    .then(function(r) { return r.ok ? r.json() : {}; })
    .then(function(data) {
        ['statMapel','statSoal','statUjian','statHasil'].forEach(function(id) {
            var el = document.getElementById(id);
            el.classList.remove('skeleton');
        });
        document.getElementById('statMapel').textContent = data.mapel  ?? 0;
        document.getElementById('statSoal').textContent  = data.soal   ?? 0;
        document.getElementById('statUjian').textContent = data.ujian  ?? 0;
        document.getElementById('statHasil').textContent = data.hasil  ?? 0;
    })
    .catch(function() {
        ['statMapel','statSoal','statUjian','statHasil'].forEach(function(id) {
            var el = document.getElementById(id);
            el.classList.remove('skeleton');
            el.textContent = '—';
        });
    });
});
</script>
@endpush