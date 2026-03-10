@extends('layouts.master')
@section('title', 'Dashboard Siswa')

@push('styles')
<style>
/* ── Welcome banner ── */
.siswa-welcome {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    border-radius: 16px; padding: 28px 32px;
    color: #fff; position: relative; overflow: hidden; margin-bottom: 24px;
}
.siswa-welcome::before {
    content: ''; position: absolute;
    width: 260px; height: 260px; background: rgba(255,255,255,0.07);
    border-radius: 50%; top: -80px; right: -60px; pointer-events: none;
}
.siswa-welcome::after {
    content: ''; position: absolute;
    width: 140px; height: 140px; background: rgba(255,255,255,0.05);
    border-radius: 50%; bottom: -40px; left: 120px; pointer-events: none;
}
.siswa-welcome-content { position: relative; z-index: 2; }
.siswa-welcome h5 { font-size: 1.35rem; font-weight: 700; margin: 0 0 8px; }
.siswa-welcome p  { font-size: 0.875rem; opacity: 0.88; margin: 0; line-height: 1.6; }
.siswa-welcome-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: 0.75rem; font-weight: 600; color: #fff;
    margin-bottom: 12px;
}

/* ── Stat cards ── */
.stat-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 24px; }
@media (max-width: 767px) { .stat-cards { grid-template-columns: 1fr 1fr; } }
@media (max-width: 480px)  { .stat-cards { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff; border-radius: 16px;
    border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
    padding: 20px 18px; display: flex; flex-direction: column; gap: 12px;
    transition: var(--transition); position: relative; overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(13,110,253,0.12); }
.stat-card::before { content: ''; position: absolute; width: 90px; height: 90px; border-radius: 50%; top: -25px; right: -20px; opacity: 0.08; }
.stat-card.blue::before   { background: #0d6efd; }
.stat-card.green::before  { background: #198754; }
.stat-card.purple::before { background: #6f42c1; }

.stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.stat-icon.blue   { background: rgba(13,110,253,0.1);  color: #0d6efd; }
.stat-icon.green  { background: rgba(32,201,151,0.12); color: #198754; }
.stat-icon.purple { background: rgba(111,66,193,0.1);  color: #6f42c1; }

.stat-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.4px; }
.stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-top: 2px; }
.stat-value.blue   { color: #0d6efd; }
.stat-value.green  { color: #198754; }
.stat-value.purple { color: #6f42c1; }

/* ── Panel card ── */
.panel-card { background: #fff; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 20px; }
.panel-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border-color); background: #f0f4ff; display: flex; align-items: center; justify-content: space-between; }
.panel-card-header-left { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.9rem; color: var(--text-main); }
.panel-card-header-left i { color: var(--primary); }
.panel-card-body { padding: 16px 20px; }

/* ── Ujian list item ── */
.ujian-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 0; border-bottom: 1px solid rgba(13,110,253,0.05);
}
.ujian-item:last-child { border-bottom: none; }
.ujian-avatar { width: 42px; height: 42px; background: linear-gradient(135deg,#0d6efd,#0dcaf0); border-radius: 11px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; box-shadow: 0 2px 8px rgba(13,110,253,0.25); }
.ujian-avatar.riwayat { background: linear-gradient(135deg,#198754,#20c997); box-shadow: 0 2px 8px rgba(32,201,151,0.25); }
.ujian-info { flex: 1; min-width: 0; }
.ujian-name { font-size: 0.875rem; font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ujian-meta { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px; }
.ujian-tag { display: inline-flex; align-items: center; font-size: 0.68rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
.tag-mapel  { background: rgba(13,110,253,0.08); color: #0d6efd; }
.tag-date   { background: rgba(32,201,151,0.1);  color: #198754; }
.tag-nilai  { background: rgba(111,66,193,0.1);  color: #6f42c1; }

.btn-ikuti { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; background: linear-gradient(135deg,#0d6efd,#0dcaf0); color: #fff; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: var(--transition); font-family: 'Poppins',sans-serif; white-space: nowrap; text-decoration: none; flex-shrink: 0; }
.btn-ikuti:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(13,110,253,0.3); color: #fff; }

/* ── Profil card ── */
.profil-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(13,110,253,0.05); font-size: 0.85rem; }
.profil-row:last-child { border-bottom: none; }
.profil-row .profil-key { font-weight: 600; color: var(--text-muted); font-size: 0.78rem; min-width: 80px; }
.profil-row .profil-val { font-weight: 600; color: var(--text-main); }

.profil-avatar-wrap { display: flex; align-items: center; gap: 14px; padding: 4px 0 16px; border-bottom: 1px solid var(--border-color); margin-bottom: 8px; }
.profil-avatar-big { width: 56px; height: 56px; background: linear-gradient(135deg,#0d6efd,#0dcaf0); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.3rem; box-shadow: 0 4px 14px rgba(13,110,253,0.3); flex-shrink: 0; }
.profil-nama-big { font-size: 0.95rem; font-weight: 800; color: var(--text-main); }
.profil-kelas-big { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }

.empty-state { text-align: center; padding: 32px 16px; }
.empty-state .empty-icon { width: 56px; height: 56px; background: rgba(13,110,253,0.07); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--primary); margin-bottom: 12px; }
.empty-state p { font-size: 0.83rem; color: var(--text-muted); margin: 0; }

/* skeleton */
.skeleton { background: linear-gradient(90deg,#f0f4ff 25%,#e2e8f7 50%,#f0f4ff 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; border-radius: 6px; display: inline-block; color: transparent; }
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
@endpush

@section('layoutContent')

{{-- Welcome --}}
<div class="siswa-welcome">
    <div class="siswa-welcome-content">
        <div class="siswa-welcome-chip"><i class="bi bi-person-badge"></i> Panel Siswa</div>
        <h5>Selamat datang, {{ auth()->user()->name }}! 👋</h5>
        <p>Selamat belajar di SMA Negeri 5 Morotai.<br>Cek ujian aktif dan pantau hasil ujian Anda di sini.</p>
    </div>
</div>

{{-- Stat cards --}}
<div class="stat-cards">
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="bi bi-clipboard-check"></i></div>
        <div>
            <div class="stat-label">Ujian Aktif</div>
            <div class="stat-value blue skeleton" id="statAktif" style="min-width:36px;">0</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green"><i class="bi bi-clock-history"></i></div>
        <div>
            <div class="stat-label">Riwayat Ujian</div>
            <div class="stat-value green skeleton" id="statRiwayat" style="min-width:36px;">0</div>
        </div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon purple"><i class="bi bi-bar-chart-line"></i></div>
        <div>
            <div class="stat-label">Rata-rata Nilai</div>
            <div class="stat-value purple skeleton" id="statNilai" style="min-width:48px;">—</div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Ujian Aktif --}}
    <div class="col-lg-6">
        <div class="panel-card">
            <div class="panel-card-header">
                <div class="panel-card-header-left"><i class="bi bi-clipboard-check"></i> Ujian Aktif</div>
                <a href="/siswa/ujian/aktif" style="font-size:.78rem;color:var(--primary);text-decoration:none;font-weight:600;">Lihat semua →</a>
            </div>
            <div class="panel-card-body" id="ujianAktifContent">
                <div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><p>Memuat ujian...</p></div>
            </div>
        </div>
    </div>

    {{-- Riwayat Ujian --}}
    <div class="col-lg-6">
        <div class="panel-card">
            <div class="panel-card-header">
                <div class="panel-card-header-left"><i class="bi bi-clock-history"></i> Riwayat Ujian</div>
                <a href="/siswa/ujian/riwayat" style="font-size:.78rem;color:var(--primary);text-decoration:none;font-weight:600;">Lihat semua →</a>
            </div>
            <div class="panel-card-body" id="riwayatUjianContent">
                <div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><p>Memuat riwayat...</p></div>
            </div>
        </div>
    </div>

    {{-- Profil --}}
    <div class="col-12">
        <div class="panel-card">
            <div class="panel-card-header">
                <div class="panel-card-header-left"><i class="bi bi-person-circle"></i> Profil Saya</div>
                <a href="/profile" style="font-size:.78rem;color:var(--primary);text-decoration:none;font-weight:600;">Edit profil →</a>
            </div>
            <div class="panel-card-body">
                <div class="profil-avatar-wrap">
                    <div class="profil-avatar-big">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div class="profil-nama-big">{{ auth()->user()->name }}</div>
                        <div class="profil-kelas-big">{{ auth()->user()->school_class->name ?? (auth()->user()->class->name ?? '-') }}</div>
                    </div>
                </div>
                <div class="profil-row"><span class="profil-key">NIS</span><span class="profil-val">{{ auth()->user()->nis ?? '-' }}</span></div>
                <div class="profil-row"><span class="profil-key">Email</span><span class="profil-val">{{ auth()->user()->email }}</span></div>
                <div class="profil-row"><span class="profil-key">Kelas</span><span class="profil-val">{{ auth()->user()->school_class->name ?? (auth()->user()->class->name ?? '-') }}</span></div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Ujian Aktif ── */
    fetch('/siswa/ujian/aktif/json', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) {
        document.getElementById('statAktif').classList.remove('skeleton');
        document.getElementById('statAktif').textContent = data.length;

        if (!data.length) {
            document.getElementById('ujianAktifContent').innerHTML =
                '<div class="empty-state"><div class="empty-icon"><i class="bi bi-clipboard-x"></i></div><p>Tidak ada ujian aktif saat ini</p></div>';
            return;
        }
        var html = '';
        data.forEach(function(u) {
            var inisial = (u.nama||u.title||'U').substring(0,2).toUpperCase();
            html += '<div class="ujian-item">' +
                '<div class="ujian-avatar">' + inisial + '</div>' +
                '<div class="ujian-info">' +
                    '<div class="ujian-name">' + (u.nama||u.title||'-') + '</div>' +
                    '<div class="ujian-meta">' +
                        '<span class="ujian-tag tag-mapel"><i class="bi bi-journal me-1"></i>' + (u.mapel||'-') + '</span>' +
                        '<span class="ujian-tag tag-date"><i class="bi bi-calendar me-1"></i>' + (u.tanggal||'-') + '</span>' +
                    '</div>' +
                '</div>' +
                '<a href="/siswa/ujian/' + u.id + '" class="btn-ikuti"><i class="bi bi-play-fill"></i> Ikuti</a>' +
            '</div>';
        });
        document.getElementById('ujianAktifContent').innerHTML = html;
    })
    .catch(function() {
        document.getElementById('statAktif').classList.remove('skeleton');
        document.getElementById('statAktif').textContent = '—';
        document.getElementById('ujianAktifContent').innerHTML =
            '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><p>Gagal memuat data</p></div>';
    });

    /* ── Riwayat Ujian ── */
    fetch('/siswa/ujian/riwayat/json', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) {
        document.getElementById('statRiwayat').classList.remove('skeleton');
        document.getElementById('statRiwayat').textContent = data.length;

        /* Rata-rata nilai */
        var nilaiArr = data.filter(function(d){ return d.nilai != null && !isNaN(d.nilai); });
        var rata = nilaiArr.length
            ? (nilaiArr.reduce(function(s,d){ return s + parseFloat(d.nilai); }, 0) / nilaiArr.length).toFixed(1)
            : '—';
        document.getElementById('statNilai').classList.remove('skeleton');
        document.getElementById('statNilai').textContent = rata;

        if (!data.length) {
            document.getElementById('riwayatUjianContent').innerHTML =
                '<div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><p>Belum ada riwayat ujian</p></div>';
            return;
        }
        var html = '';
        data.slice(0,5).forEach(function(r) {
            var inisial = (r.nama||r.title||'U').substring(0,2).toUpperCase();
            var nilaiVal = r.nilai != null ? r.nilai : '—';
            html += '<div class="ujian-item">' +
                '<div class="ujian-avatar riwayat">' + inisial + '</div>' +
                '<div class="ujian-info">' +
                    '<div class="ujian-name">' + (r.nama||r.title||'-') + '</div>' +
                    '<div class="ujian-meta">' +
                        '<span class="ujian-tag tag-mapel"><i class="bi bi-journal me-1"></i>' + (r.mapel||'-') + '</span>' +
                        '<span class="ujian-tag tag-nilai"><i class="bi bi-star me-1"></i>Nilai: ' + nilaiVal + '</span>' +
                        '<span class="ujian-tag tag-date"><i class="bi bi-calendar me-1"></i>' + (r.tanggal||'-') + '</span>' +
                    '</div>' +
                '</div>' +
            '</div>';
        });
        document.getElementById('riwayatUjianContent').innerHTML = html;
    })
    .catch(function() {
        document.getElementById('statRiwayat').classList.remove('skeleton');
        document.getElementById('statRiwayat').textContent = '—';
        document.getElementById('statNilai').classList.remove('skeleton');
        document.getElementById('riwayatUjianContent').innerHTML =
            '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><p>Gagal memuat data</p></div>';
    });
});
</script>
@endpush