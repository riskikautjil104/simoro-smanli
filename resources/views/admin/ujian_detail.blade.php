@extends('layouts.master')

@section('title', 'Detail Ujian')

@push('styles')
<style>
/* ── Page header ── */
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}
.page-header::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    top: -60px; right: -60px;
    pointer-events: none;
}
.page-header-content { position: relative; z-index: 2; }
.page-header h4      { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p       { font-size: 0.85rem; opacity: 0.85; margin: 0; }

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.2);
    color: #fff !important;
    border: 1.5px solid rgba(255,255,255,0.4);
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    backdrop-filter: blur(8px);
    transition: var(--transition);
}
.btn-back:hover { background: rgba(255,255,255,0.32); transform: translateY(-1px); }

/* ── Info card ── */
.info-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 24px;
    margin-bottom: 24px;
}
.info-card h5 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-card h5 i { color: var(--primary); }

/* Info grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}
.info-item label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 4px;
}
.info-item span {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-main);
}

/* ── Stat pills ── */
.stat-pills { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
.stat-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(13,110,253,0.07);
    border: 1px solid rgba(13,110,253,0.12);
    border-radius: 50px;
    padding: 8px 16px;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--primary);
}
.stat-pill i { font-size: 1rem; }

/* ── Table card ── */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 24px;
}
.table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    background: #f0f4ff;
}
.table-card-header h6 {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 7px;
}
.table-card-header h6 i { color: var(--primary); }
.table-card .table     { margin: 0; font-size: 0.85rem; }
.table-card .table thead th {
    background: #f8faff;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.04);
    color: var(--text-main);
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr { transition: background 0.12s; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

/* ── Siswa avatar ── */
.siswa-avatar {
    width: 32px; height: 32px;
    background: linear-gradient(135deg, var(--secondary), #198754);
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.72rem;
    flex-shrink: 0;
}

/* ── Status badges ── */
.status-aktif   { display:inline-flex;align-items:center;gap:4px;background:rgba(32,201,151,.1);color:#198754;font-size:.72rem;font-weight:700;padding:4px 9px;border-radius:20px; }
.status-logout  { display:inline-flex;align-items:center;gap:4px;background:rgba(220,53,69,.1);color:#dc3545;font-size:.72rem;font-weight:700;padding:4px 9px;border-radius:20px; }
.status-waiting { display:inline-flex;align-items:center;gap:4px;background:rgba(255,193,7,.15);color:#856404;font-size:.72rem;font-weight:700;padding:4px 9px;border-radius:20px; }
.status-approve { display:inline-flex;align-items:center;gap:4px;background:rgba(32,201,151,.1);color:#198754;font-size:.72rem;font-weight:700;padding:4px 9px;border-radius:20px; }
.status-reject  { display:inline-flex;align-items:center;gap:4px;background:rgba(220,53,69,.1);color:#dc3545;font-size:.72rem;font-weight:700;padding:4px 9px;border-radius:20px; }

/* ── Ranking medal ── */
.rank-medal {
    width: 30px; height: 30px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.8rem;
}
.rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: #fff; box-shadow: 0 3px 10px rgba(255,165,0,.35); }
.rank-2 { background: linear-gradient(135deg, #C0C0C0, #A0A0A0); color: #fff; }
.rank-3 { background: linear-gradient(135deg, #CD7F32, #A0522D); color: #fff; }
.rank-n { background: #f0f4ff; color: var(--primary); }

/* ── Nilai badge ── */
.nilai-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 52px;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85rem;
}
.nilai-a  { background: rgba(32,201,151,.12); color: #198754; }
.nilai-b  { background: rgba(13,110,253,.1);  color: var(--primary); }
.nilai-c  { background: rgba(255,193,7,.15);  color: #856404; }
.nilai-d  { background: rgba(220,53,69,.1);   color: #dc3545; }
.nilai-na { background: #f0f4ff; color: #94a3b8; }

/* ── Action buttons ── */
.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 600;
    border: none; cursor: pointer; transition: var(--transition);
    font-family: 'Poppins', sans-serif; white-space: nowrap;
}
.btn-act-info    { background: rgba(13,202,240,.1); color: #0a9bba; }
.btn-act-info:hover    { background: var(--accent); color: #fff; transform: translateY(-1px); }
.btn-act-success { background: rgba(32,201,151,.1); color: #198754; }
.btn-act-success:hover { background: #198754; color: #fff; transform: translateY(-1px); }
.btn-act-danger  { background: rgba(220,53,69,.1); color: #dc3545; }
.btn-act-danger:hover  { background: #dc3545; color: #fff; transform: translateY(-1px); }

/* ── Modal ── */
.modal-header-brand {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff; padding: 16px 20px;
}
.modal-header-brand .modal-title { font-weight: 700; font-size: 1rem; }
.modal-header-brand .btn-close {
    filter: brightness(0) invert(1); opacity: .85; transition: transform .2s;
}
.modal-header-brand .btn-close:hover { transform: rotate(90deg); opacity: 1; }
.modal-content { border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(13,110,253,.2); }

/* ── Jawaban inside modal ── */
.jawaban-item {
    background: #f8faff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 12px;
}
.jawaban-item .q-num {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--primary);
    background: rgba(13,110,253,.08);
    padding: 2px 9px;
    border-radius: 20px;
    margin-bottom: 8px;
    display: inline-block;
}
.opsi-wrap { display: flex; flex-wrap: wrap; gap: 6px; margin: 8px 0; }
.opsi-chip {
    font-size: 0.78rem;
    padding: 4px 10px;
    border-radius: 8px;
    background: #f0f4ff;
    border: 1px solid var(--border-color);
    color: var(--text-main);
}
.opsi-chip.dipilih { background: rgba(13,110,253,.12); border-color: var(--primary); color: var(--primary); font-weight: 700; }
.opsi-chip.benar   { background: rgba(32,201,151,.12); border-color: #198754; color: #198754; font-weight: 700; }
.opsi-chip.salah   { background: rgba(220,53,69,.1);  border-color: #dc3545; color: #dc3545; font-weight: 700; }
.essay-answer { font-size: 0.85rem; color: var(--text-main); font-style: italic; background: #fff; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-color); margin: 8px 0; }
</style>
@endpush

@section('layoutContent')

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-file-earmark-text me-2"></i><span id="ujianTitleHeader">Detail Ujian</span></h4>
            <p id="ujianSubHeader">Memuat informasi ujian...</p>
        </div>
        <a href="{{ route('admin.ujian.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- ── INFO UJIAN ── --}}
<div class="info-card">
    <h5><i class="bi bi-info-circle"></i> Informasi Ujian</h5>
    <div class="info-grid" id="ujianInfo">
        {{-- Filled by JS --}}
        <div class="info-item"><label>Nama Ujian</label><span class="placeholder-glow"><span class="placeholder col-8"></span></span></div>
        <div class="info-item"><label>Mata Pelajaran</label><span class="placeholder-glow"><span class="placeholder col-6"></span></span></div>
        <div class="info-item"><label>Kelas</label><span class="placeholder-glow"><span class="placeholder col-5"></span></span></div>
        <div class="info-item"><label>Waktu Mulai</label><span class="placeholder-glow"><span class="placeholder col-7"></span></span></div>
        <div class="info-item"><label>Durasi</label><span class="placeholder-glow"><span class="placeholder col-4"></span></span></div>
    </div>
</div>

{{-- ── TABEL PESERTA ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6><i class="bi bi-people"></i> Daftar Peserta Ujian</h6>
        <span style="font-size:0.8rem;color:var(--text-muted);" id="peserta-count">—</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Durasi</th>
                    <th>Nilai</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="pesertaTableBody">
                <tr><td colspan="10">
                    <div style="text-align:center;padding:32px;color:var(--text-muted);font-size:.85rem;">
                        <i class="bi bi-hourglass-split me-2"></i>Memuat data peserta...
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ── TABEL RANKING ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h6><i class="bi bi-trophy"></i> Ranking Nilai Tertinggi</h6>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:80px;">Ranking</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody id="rankingTableBody">
                <tr><td colspan="4">
                    <div style="text-align:center;padding:32px;color:var(--text-muted);font-size:.85rem;">
                        <i class="bi bi-hourglass-split me-2"></i>Memuat ranking...
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ── MODAL: Periksa Jawaban ── --}}
<div class="modal fade" id="modalPriksaJawaban" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalPriksaJawabanLabel">
                    <i class="bi bi-clipboard-check me-2"></i>Periksa Jawaban Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3" id="priksaJawabanContent">
                <div style="text-align:center;padding:40px;color:var(--text-muted);">
                    <i class="bi bi-hourglass-split" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                    Memuat jawaban siswa...
                </div>
            </div>
            <div class="modal-footer border-0 pb-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanNilai">
                    <i class="bi bi-save me-1"></i> Simpan Penilaian
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var ujianId   = (window.location.pathname.match(/\/(\d+)(\/detail)?$/) || [])[1];
    if (!ujianId) return;

    var currentPesertaId = null;

    /* ── Helper: nilai badge ── */
    function nilaiBadge(nilai) {
        if (nilai === null || nilai === undefined || nilai === '') return '<span class="nilai-badge nilai-na">—</span>';
        var n = parseFloat(nilai);
        var cls = n >= 85 ? 'nilai-a' : n >= 70 ? 'nilai-b' : n >= 55 ? 'nilai-c' : 'nilai-d';
        return '<span class="nilai-badge ' + cls + '">' + nilai + '</span>';
    }

    /* ── Load info ujian ── */
    fetch('/admin/ujian/' + ujianId, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        document.getElementById('ujianTitleHeader').textContent  = data.nama || data.title || 'Detail Ujian';
        document.getElementById('ujianSubHeader').textContent    = (data.mapel ? data.mapel.nama : '') + ' · ' + (data.kelas ? data.kelas.nama : '');

        document.getElementById('ujianInfo').innerHTML =
            '<div class="info-item"><label>Nama Ujian</label><span>' + (data.nama || data.title || '-') + '</span></div>' +
            '<div class="info-item"><label>Mata Pelajaran</label><span>' + (data.mapel ? data.mapel.nama : '-') + '</span></div>' +
            '<div class="info-item"><label>Kelas</label><span>' + (data.kelas ? data.kelas.nama : '-') + '</span></div>' +
            '<div class="info-item"><label>Waktu Mulai</label><span>' + (data.start_time || '-') + '</span></div>' +
            '<div class="info-item"><label>Durasi</label><span>' + (data.duration ? data.duration + ' menit' : '-') + '</span></div>';
    })
    .catch(function() {
        document.getElementById('ujianSubHeader').textContent = 'Gagal memuat info ujian';
    });

    /* ── Load peserta ── */
    fetch('/admin/ujian/' + ujianId + '/peserta', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        document.getElementById('peserta-count').textContent = data.length + ' peserta';

        if (!data.length) {
            document.getElementById('pesertaTableBody').innerHTML =
                '<tr><td colspan="10"><div style="text-align:center;padding:40px;color:var(--text-muted);"><i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada peserta.</div></td></tr>';
            return;
        }

        var rows = '';
        data.forEach(function(s, i) {
            var inisial  = (s.nama || 'S').substring(0, 2).toUpperCase();
            var lokasi   = (s.lat && s.lng)
                ? '<a href="https://maps.google.com/?q=' + s.lat + ',' + s.lng + '" target="_blank" class="btn-act btn-act-info" style="font-size:.7rem;padding:4px 9px;">' +
                  '<i class="bi bi-geo-alt"></i> Maps</a>'
                : '<span style="color:#ccc;">—</span>';

            /* Status & reapply */
            var statusHtml = '';
            var aksiHtml   = '<button class="btn-act btn-act-info btn-priksa" data-peserta="' + s.id + '" data-nama="' + (s.nama || '') + '">' +
                             '<i class="bi bi-clipboard-check"></i> Periksa</button>';

            if (s.status_logout && Number(s.status_logout) === 1) {
                statusHtml = '<span class="status-logout"><i class="bi bi-door-open"></i> Logout</span>';
                if (s.logout_time) statusHtml += '<div style="font-size:.7rem;color:var(--text-muted);margin-top:3px;">' + s.logout_time + '</div>';
                if (s.reapply_status == 1) {
                    statusHtml += '<span class="status-waiting mt-1"><i class="bi bi-clock"></i> Menunggu</span>';
                    if (s.reapply_reason) statusHtml += '<div style="font-size:.7rem;color:var(--text-muted);margin-top:2px;">' + s.reapply_reason + '</div>';
                    aksiHtml += '<button class="btn-act btn-act-success btn-approve-reapply mt-1" data-peserta="' + s.id + '"><i class="bi bi-check-lg"></i> Approve</button>' +
                                '<button class="btn-act btn-act-danger btn-reject-reapply mt-1" data-peserta="' + s.id + '"><i class="bi bi-x-lg"></i> Tolak</button>';
                } else if (s.reapply_status == 2) {
                    statusHtml += '<span class="status-approve mt-1"><i class="bi bi-check-circle"></i> Diterima</span>';
                } else if (s.reapply_status == 3) {
                    statusHtml += '<span class="status-reject mt-1"><i class="bi bi-x-circle"></i> Ditolak</span>';
                }
            } else {
                statusHtml = '<span class="status-aktif"><i class="bi bi-circle-fill" style="font-size:.45rem;"></i> Aktif</span>';
            }

            rows += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<div class="siswa-avatar">' + inisial + '</div>' +
                        '<span style="font-weight:600;">' + (s.nama || '-') + '</span>' +
                    '</div>' +
                '</td>' +
                '<td>' + (s.kelas || '-') + '</td>' +
                '<td style="font-size:.8rem;">' + (s.mulai   || '-') + '</td>' +
                '<td style="font-size:.8rem;">' + (s.selesai || '-') + '</td>' +
                '<td style="font-size:.8rem;">' + (s.durasi  || '-') + '</td>' +
                '<td>' + nilaiBadge(s.nilai) + '</td>' +
                '<td>' + lokasi + '</td>' +
                '<td>' + statusHtml + '</td>' +
                '<td>' + aksiHtml + '</td>' +
            '</tr>';
        });

        document.getElementById('pesertaTableBody').innerHTML = rows;
        bindReapplyHandlers();
    })
    .catch(function() {
        document.getElementById('pesertaTableBody').innerHTML =
            '<tr><td colspan="10" style="text-align:center;padding:40px;color:#dc3545;">Gagal memuat data peserta.</td></tr>';
    });

    /* ── Reapply handlers ── */
    function bindReapplyHandlers() {
        document.querySelectorAll('.btn-approve-reapply').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var pid = btn.getAttribute('data-peserta');
                Swal.fire({ title: 'Approve reapply?', icon: 'question', showCancelButton: true,
                    confirmButtonColor: '#198754', confirmButtonText: 'Ya, approve' })
                .then(function(r) {
                    if (!r.isConfirmed) return;
                    fetch('/admin/ujian/' + ujianId + '/peserta/' + pid + '/reapply/approve', {
                        method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(function() { location.reload(); });
                });
            });
        });

        document.querySelectorAll('.btn-reject-reapply').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var pid = btn.getAttribute('data-peserta');
                Swal.fire({ title: 'Tolak reapply?', icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, tolak' })
                .then(function(r) {
                    if (!r.isConfirmed) return;
                    fetch('/admin/ujian/' + ujianId + '/peserta/' + pid + '/reapply/reject', {
                        method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(function() { location.reload(); });
                });
            });
        });
    }

    /* ── Load ranking ── */
    fetch('/admin/ujian/' + ujianId + '/ranking', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (!data.length) {
            document.getElementById('rankingTableBody').innerHTML =
                '<tr><td colspan="4"><div style="text-align:center;padding:40px;color:var(--text-muted);"><i class="bi bi-trophy" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada nilai.</div></td></tr>';
            return;
        }

        var rows = '';
        data.forEach(function(s, i) {
            var rankNum   = i + 1;
            var rankClass = rankNum === 1 ? 'rank-1' : rankNum === 2 ? 'rank-2' : rankNum === 3 ? 'rank-3' : 'rank-n';
            var inisial   = (s.nama || 'S').substring(0, 2).toUpperCase();

            rows += '<tr>' +
                '<td><span class="rank-medal ' + rankClass + '">' + rankNum + '</span></td>' +
                '<td>' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<div class="siswa-avatar">' + inisial + '</div>' +
                        '<span style="font-weight:600;">' + (s.nama || '-') + '</span>' +
                    '</div>' +
                '</td>' +
                '<td>' + (s.kelas || '-') + '</td>' +
                '<td>' + nilaiBadge(s.nilai) + '</td>' +
            '</tr>';
        });

        document.getElementById('rankingTableBody').innerHTML = rows;
    });

    /* ── Periksa jawaban ── */
    document.getElementById('pesertaTableBody').addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-priksa');
        if (!btn) return;

        currentPesertaId = btn.getAttribute('data-peserta');
        var namaSiswa    = btn.getAttribute('data-nama') || 'Siswa';

        document.getElementById('modalPriksaJawabanLabel').innerHTML =
            '<i class="bi bi-clipboard-check me-2"></i>Jawaban — ' + namaSiswa;

        document.getElementById('priksaJawabanContent').innerHTML =
            '<div style="text-align:center;padding:40px;color:var(--text-muted);">' +
            '<i class="bi bi-hourglass-split" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Memuat jawaban...</div>';

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPriksaJawaban')).show();

        fetch('/admin/ujian/' + ujianId + '/peserta/' + currentPesertaId + '/jawaban', {
            headers: { 'Accept': 'application/json' }, credentials: 'same-origin'
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.length) {
                document.getElementById('priksaJawabanContent').innerHTML =
                    '<div style="text-align:center;padding:40px;color:var(--text-muted);">' +
                    '<i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>Belum ada jawaban.</div>';
                return;
            }

            var essayCount = data.filter(function(j) { return j.tipe === 'essay'; }).length;
            var essayMax   = essayCount > 0 ? Math.floor(50 / essayCount) : 0;
            var html       = '';

            data.forEach(function(j, idx) {
                html += '<div class="jawaban-item"><span class="q-num">#' + (idx + 1) + '</span>';
                html += '<div style="font-size:.875rem;font-weight:600;margin-bottom:8px;">' + j.pertanyaan + '</div>';

                if (j.tipe === 'pg' || j.tipe === 'multiple_choice') {
                    /* Parse opsi */
                    var opsiA = j.opsi_a, opsiB = j.opsi_b, opsiC = j.opsi_c, opsiD = j.opsi_d;
                    if (!opsiA && !opsiB && j.options) {
                        var opts = (typeof j.options === 'string') ? JSON.parse(j.options) : j.options;
                        opsiA = opts.A || opts[0] || ''; opsiB = opts.B || opts[1] || '';
                        opsiC = opts.C || opts[2] || ''; opsiD = opts.D || opts[3] || '';
                    }
                    var pilihan = ['A','B','C','D'];
                    var opsiArr = [opsiA, opsiB, opsiC, opsiD];
                    var jawaban = j.jawaban_siswa;
                    var kunci   = j.jawaban_benar;

                    html += '<div class="opsi-wrap">';
                    pilihan.forEach(function(p, k) {
                        var cls = '';
                        if (p === kunci && p === jawaban) cls = 'benar';
                        else if (p === jawaban) cls = 'salah';
                        else if (p === kunci) cls = 'benar';
                        html += '<span class="opsi-chip ' + cls + '">' +
                            '<strong>' + p + '.</strong> ' + (opsiArr[k] || '') + '</span>';
                    });
                    html += '</div>';

                    var isBenar = jawaban === kunci;
                    html += '<div style="font-size:.78rem;margin-top:4px;">' +
                        'Jawaban: <strong>' + (jawaban || '-') + '</strong> · Kunci: <strong>' + (kunci || '-') + '</strong> · ' +
                        (isBenar
                            ? '<span style="color:#198754;font-weight:700;"><i class="bi bi-check-circle"></i> Benar</span>'
                            : '<span style="color:#dc3545;font-weight:700;"><i class="bi bi-x-circle"></i> Salah</span>') +
                    '</div>';

                } else if (j.tipe === 'essay') {
                    html += '<div class="essay-answer">' + (j.jawaban_siswa || '<em style="color:#ccc;">Belum dijawab</em>') + '</div>';
                    html += '<div class="d-flex align-items-center gap-2 mt-2">' +
                        '<label style="font-size:.78rem;font-weight:600;color:var(--text-muted);white-space:nowrap;">Nilai (max ' + essayMax + '):</label>' +
                        '<input type="number" class="form-control" style="width:90px;height:34px;font-size:.85rem;" name="nilai_essay[' + j.id + ']" ' +
                        'value="' + (j.nilai_essay || '') + '" min="0" max="' + essayMax + '" step="1">' +
                    '</div>';
                }

                html += '</div>';
            });

            document.getElementById('priksaJawabanContent').innerHTML = html;
        })
        .catch(function() {
            document.getElementById('priksaJawabanContent').innerHTML =
                '<div style="text-align:center;padding:40px;color:#dc3545;">Gagal memuat jawaban.</div>';
        });
    });

    /* ── Simpan penilaian essay ── */
    document.getElementById('btnSimpanNilai').addEventListener('click', function() {
        if (!currentPesertaId) return;

        var inputs    = document.querySelectorAll('#priksaJawabanContent input[name^="nilai_essay"]');
        var nilaiEssay = {};
        var essayMax   = inputs.length > 0 ? Math.floor(50 / inputs.length) : 0;

        inputs.forEach(function(inp) {
            var val = parseInt(inp.value) || 0;
            if (val > essayMax) { val = essayMax; inp.value = val; }
            var id  = inp.name.match(/\[(\d+)\]/)[1];
            nilaiEssay[id] = val;
        });

        var btn = document.getElementById('btnSimpanNilai');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch('/admin/ujian/' + ujianId + '/peserta/' + currentPesertaId + '/nilai', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ nilai_essay: nilaiEssay })
        })
        .then(function(r) { return r.json(); })
        .then(function() {
            bootstrap.Modal.getInstance(document.getElementById('modalPriksaJawaban')).hide();
            Swal.fire({ icon: 'success', title: 'Penilaian disimpan!', timer: 1500, showConfirmButton: false });
        })
        .catch(function() { Swal.fire('Error', 'Gagal menyimpan penilaian.', 'error'); })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Penilaian'; });
    });

});
</script>
@endpush