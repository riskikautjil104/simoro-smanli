@extends('layouts.master')

@section('title', 'Data Soal')

@push('styles')
<style>
/* ── Page Header ── */
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
.page-header::after {
    content: '';
    position: absolute;
    width: 130px; height: 130px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    bottom: -40px; left: 40px;
    pointer-events: none;
}
.page-header-content { position: relative; z-index: 2; }
.page-header h4      { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p       { font-size: 0.85rem; opacity: 0.85; margin: 0; }

/* ── Table card ── */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.875rem; }
.table-card .table thead th {
    background: #f0f4ff;
    color: var(--text-main);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
    color: var(--text-main);
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr { transition: background 0.15s ease; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

/* ── Guru avatar ── */
.guru-avatar {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.78rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(13,110,253,0.25);
}

/* ── Mapel badge ── */
.badge-mapel {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(13,110,253,0.08);
    color: var(--primary);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

/* ── Ujian list links ── */
.ujian-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(13,202,240,0.1);
    color: #0a9bba;
    border: 1px solid rgba(13,202,240,0.25);
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    text-decoration: none;
    margin: 2px 2px 0 0;
    transition: var(--transition);
    cursor: pointer;
}
.ujian-pill:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    transform: translateY(-1px);
}

/* ── Action buttons ── */
.btn-act {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 11px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
    margin: 2px 2px 0 0;
}
.btn-act-import  { background: rgba(32,201,151,0.12); color: #198754; }
.btn-act-import:hover  { background: #198754; color: #fff; transform: translateY(-1px); }
.btn-act-manual  { background: rgba(13,110,253,0.1); color: var(--primary); }
.btn-act-manual:hover  { background: var(--primary); color: #fff; transform: translateY(-1px); }
.btn-act-batch   { background: rgba(255,193,7,0.15); color: #856404; }
.btn-act-batch:hover   { background: #ffc107; color: #000; transform: translateY(-1px); }
.btn-act-detail  { background: rgba(13,202,240,0.1); color: #0a9bba; }
.btn-act-detail:hover  { background: var(--accent); color: #fff; transform: translateY(-1px); }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 56px 24px;
}
.empty-state .empty-icon {
    width: 72px; height: 72px;
    background: rgba(13,110,253,0.07);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: var(--primary);
    margin-bottom: 16px;
}
.empty-state h6 { font-weight: 700; color: var(--text-main); margin-bottom: 6px; }
.empty-state p  { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

/* ── Modal ── */
.modal-header-brand {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff;
    padding: 16px 20px;
}
.modal-header-brand .modal-title { font-weight: 700; font-size: 1rem; }
.modal-header-brand .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.85;
    transition: transform 0.2s;
}
.modal-header-brand .btn-close:hover { transform: rotate(90deg); opacity: 1; }
.modal-content {
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: 0 20px 60px rgba(13,110,253,0.2);
}

/* ── Soal detail table (inside modal) ── */
.soal-table thead th {
    background: #f0f4ff;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--text-main);
    padding: 12px 14px;
}
.soal-table tbody td {
    padding: 12px 14px;
    font-size: 0.85rem;
    vertical-align: middle;
}
.soal-table tbody tr:hover { background: rgba(13,110,253,0.03); }

/* Tipe badge */
.badge-pg    { background: rgba(13,110,253,0.1); color: var(--primary); font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.badge-essay { background: rgba(13,202,240,0.12); color: #0a9bba; font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.badge-ans   { background: rgba(32,201,151,0.12); color: #198754; font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; min-width: 30px; text-align: center; display: inline-block; }

/* ── Batch soal card ── */
.batch-soal-card {
    background: #f8faff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
}
.batch-soal-card .batch-no {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--primary);
    background: rgba(13,110,253,0.08);
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 10px;
    display: inline-block;
}

/* ── Count badge in header ── */
.count-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 10px;
}

/* ── Search bar ── */
.search-wrap { position: relative; max-width: 280px; }
.search-wrap i {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #aaa; font-size: 0.9rem; pointer-events: none;
}
.search-wrap input {
    padding-left: 36px;
    border-radius: 50px;
    border: 1.5px solid var(--border-color);
    font-size: 0.875rem;
    height: 38px;
    transition: var(--transition);
}
.search-wrap input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
}
</style>
@endpush

@section('layoutContent')

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div class="page-header-content">
        <h4>
            <i class="bi bi-question-circle me-2"></i>Manajemen Soal Ujian
            <span class="count-badge" id="soal-count">0 mapel</span>
        </h4>
        <p>Tambah, import, dan kelola soal ujian per guru dan mata pelajaran</p>
    </div>
</div>

{{-- ── TOOLBAR ── --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchSoal" class="form-control" placeholder="Cari guru atau mata pelajaran...">
    </div>
    <div style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan <span id="soal-shown">0</span> baris
    </div>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="guruMapelUjianTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Daftar Ujian</th>
                    <th style="width:260px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="soalTbody">
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-hourglass-split"></i></div>
                            <h6>Memuat data...</h6>
                            <p>Mohon tunggu sebentar</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ─────────────────────────────────────────
     MODAL: Detail Soal per Ujian
──────────────────────────────────────────── --}}
<div class="modal fade" id="modalDetailSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalDetailSoalLabel">
                    <i class="bi bi-list-ul me-2"></i>Detail Soal Ujian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="detailSoalContent" class="p-3">
                    <div class="empty-state">
                        <div class="empty-icon"><i class="bi bi-hourglass-split"></i></div>
                        <h6>Memuat data soal...</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────
     MODAL: Import Soal
──────────────────────────────────────────── --}}
<div class="modal fade" id="modalImportSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Import Soal Excel/CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formImportSoal" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" id="importGuruId"   name="guru_id">
                    <input type="hidden" id="importMapelId"  name="mapel_id">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Guru</label>
                            <input type="text" class="form-control" id="importGuruName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="importMapelName" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ujian</label>
                        <select class="form-select" id="importUjianSelect" required>
                            <option value="">-- Pilih Ujian --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fileSoal" class="form-label">File Excel / CSV</label>
                        <input type="file" class="form-control" id="fileSoal" name="file"
                               accept=".xlsx,.xls,.csv" required>
                        <div class="form-text mt-1">
                            <i class="bi bi-download me-1"></i>
                            Download template:
                            <a href="/template-import-soal.xlsx" class="text-primary fw-semibold">template-import-soal.xlsx</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnImportSoal">
                        <i class="bi bi-upload me-1"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────
     MODAL: Tambah Soal Manual
──────────────────────────────────────────── --}}
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>Tambah Soal Manual
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahSoal">
                <div class="modal-body p-4">
                    <input type="hidden" id="manualGuruId"  name="guru_id">
                    <input type="hidden" id="manualMapelId" name="mapel_id">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Guru</label>
                            <input type="text" class="form-control" id="manualGuruName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="manualMapelName" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ujian</label>
                        <select class="form-select" id="manualUjianSelect" name="exam_id" required>
                            <option value="">-- Pilih Ujian --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="pertanyaanSoal" name="pertanyaan"
                                  rows="3" placeholder="Tulis pertanyaan di sini..." required></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Opsi A</label>
                            <input type="text" class="form-control" id="opsiA" name="opsi_a" placeholder="Jawaban A" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Opsi B</label>
                            <input type="text" class="form-control" id="opsiB" name="opsi_b" placeholder="Jawaban B" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Opsi C</label>
                            <input type="text" class="form-control" id="opsiC" name="opsi_c" placeholder="Jawaban C" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Opsi D</label>
                            <input type="text" class="form-control" id="opsiD" name="opsi_d" placeholder="Jawaban D" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar</label>
                        <select class="form-select" id="jawabanBenar" name="jawaban_benar" required>
                            <option value="">-- Pilih Jawaban --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanManual">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────
     MODAL: Batch Input Soal
──────────────────────────────────────────── --}}
<div class="modal fade" id="modalBatchSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title">
                    <i class="bi bi-layers me-2"></i>Input Soal Batch (PG & Essay)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBatchSoal">
                <div class="modal-body p-4">
                    <input type="hidden" id="batchGuruId"  name="guru_id">
                    <input type="hidden" id="batchMapelId" name="mapel_id">

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Ujian</label>
                            <select class="form-select" id="batchUjianSelect" name="exam_id" required>
                                <option value="">-- Pilih Ujian --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Soal PG</label>
                            <input type="number" min="0" max="100" class="form-control"
                                   id="jumlahPG" value="20">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Soal Essay</label>
                            <input type="number" min="0" max="100" class="form-control"
                                   id="jumlahEssay" value="5">
                        </div>
                    </div>

                    <div id="batchInputContainer"></div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanBatch">
                        <i class="bi bi-save me-1"></i> Simpan Semua Soal
                    </button>
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

    var csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var allGurus   = [];
    var allMapels  = [];
    var allUjians  = [];
    var allRows    = []; /* cache rows for search */

    /* ── Load all data in parallel ── */
    Promise.all([
        fetch('/admin/guru',       { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' }).then(function(r){ return r.ok ? r.json() : []; }),
        fetch('/admin/mapel',      { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' }).then(function(r){ return r.ok ? r.json() : []; }),
        fetch('/admin/ujian-list', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' }).then(function(r){ return r.ok ? r.json() : []; }),
    ])
    .then(function(results) {
        allGurus  = results[0];
        allMapels = results[1];
        allUjians = results[2];
        renderTable();
    })
    .catch(function() {
        document.getElementById('soalTbody').innerHTML =
            '<tr><td colspan="5"><div class="empty-state">' +
            '<div class="empty-icon"><i class="bi bi-exclamation-circle"></i></div>' +
            '<h6>Gagal memuat data</h6><p>Cek koneksi atau backend</p></div></td></tr>';
    });

    /* ── Render main table ── */
    function renderTable() {
        var tbody = document.getElementById('soalTbody');
        var rows  = '';
        var no    = 1;
        allRows   = [];

        if (!Array.isArray(allGurus) || !Array.isArray(allMapels)) {
            tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-exclamation-triangle"></i></div><h6>Data tidak valid</h6></div></td></tr>';
            return;
        }

        allGurus.forEach(function(guru) {
            var guruMapels = allMapels.filter(function(m) { return m.teacher && m.teacher.id === guru.id; });
            if (!guruMapels.length) return;

            guruMapels.forEach(function(mapel) {
                var mapelUjians = allUjians.filter(function(u) { return u.mapel && u.mapel.id === mapel.id; });
                var inisial     = (guru.name || 'G').substring(0, 2).toUpperCase();

                /* Ujian pills */
                var ujianHtml = '<span style="color:#ccc;font-size:0.8rem;">Belum ada ujian</span>';
                if (mapelUjians.length > 0) {
                    ujianHtml = mapelUjians.map(function(u) {
                        return '<span class="ujian-pill link-ujian" data-ujian="' + u.id + '" data-ujian-nama="' + (u.nama || '') + '">' +
                               '<i class="bi bi-file-earmark-text"></i>' + (u.nama || '-') + '</span>';
                    }).join('');
                }

                /* Detail ujian buttons */
                var detailBtns = '';
                if (mapelUjians.length > 0) {
                    detailBtns = mapelUjians.map(function(u) {
                        return '<a class="btn-act btn-act-detail" href="/admin/ujian/' + u.id + '/detail">' +
                               '<i class="bi bi-eye"></i> ' + (u.nama || 'Detail') + '</a>';
                    }).join('');
                }

                var rowData = { guruName: guru.name || '', mapelName: mapel.name || '' };
                allRows.push(rowData);

                rows += '<tr data-guru="' + (guru.name || '').toLowerCase() + '" data-mapel="' + (mapel.name || '').toLowerCase() + '">' +
                    '<td>' + (no++) + '</td>' +
                    '<td>' +
                        '<div class="d-flex align-items-center gap-2">' +
                            '<div class="guru-avatar">' + inisial + '</div>' +
                            '<div style="font-weight:600;">' + (guru.name || '-') + '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td><span class="badge-mapel"><i class="bi bi-journal-bookmark"></i>' + (mapel.name || '-') + '</span></td>' +
                    '<td>' + ujianHtml + '</td>' +
                    '<td>' +
                        '<button class="btn-act btn-act-import btn-import" ' +
                            'data-guru="' + guru.id + '" data-guru-name="' + (guru.name || '') + '" ' +
                            'data-mapel="' + mapel.id + '" data-mapel-name="' + (mapel.name || '') + '">' +
                            '<i class="bi bi-upload"></i> Import' +
                        '</button>' +
                        '<button class="btn-act btn-act-manual btn-tambah-manual" ' +
                            'data-guru="' + guru.id + '" data-guru-name="' + (guru.name || '') + '" ' +
                            'data-mapel="' + mapel.id + '" data-mapel-name="' + (mapel.name || '') + '">' +
                            '<i class="bi bi-plus-lg"></i> Manual' +
                        '</button>' +
                        '<button class="btn-act btn-act-batch btn-batch-input" ' +
                            'data-guru="' + guru.id + '" data-guru-name="' + (guru.name || '') + '" ' +
                            'data-mapel="' + mapel.id + '" data-mapel-name="' + (mapel.name || '') + '">' +
                            '<i class="bi bi-layers"></i> Batch' +
                        '</button>' +
                        (detailBtns ? '<div class="mt-1">' + detailBtns + '</div>' : '') +
                    '</td>' +
                '</tr>';
            });
        });

        if (!rows) {
            tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state">' +
                '<div class="empty-icon"><i class="bi bi-question-circle"></i></div>' +
                '<h6>Belum ada data</h6><p>Belum ada guru / mata pelajaran / ujian yang terdaftar.</p>' +
                '</div></td></tr>';
        } else {
            tbody.innerHTML = rows;
        }

        document.getElementById('soal-count').textContent = allRows.length + ' mapel';
        document.getElementById('soal-shown').textContent = allRows.length;
    }

    /* ── Search ── */
    document.getElementById('searchSoal').addEventListener('input', function() {
        var q    = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#soalTbody tr[data-guru]');
        var shown = 0;
        rows.forEach(function(row) {
            var guru  = row.getAttribute('data-guru')  || '';
            var mapel = row.getAttribute('data-mapel') || '';
            var match = !q || guru.includes(q) || mapel.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        document.getElementById('soal-shown').textContent = shown;
    });

    /* ── Helper: filter ujian options ── */
    function ujianOptions(mapelId) {
        return '<option value="">-- Pilih Ujian --</option>' +
            allUjians.filter(function(u) { return u.mapel && u.mapel.id == mapelId; })
                     .map(function(u) { return '<option value="' + u.id + '">' + (u.nama || '') + '</option>'; })
                     .join('');
    }

    /* ── Click delegation on tbody ── */
    document.getElementById('soalTbody').addEventListener('click', function(e) {

        /* Detail soal via ujian pill */
        var pill = e.target.closest('.link-ujian');
        if (pill) {
            var ujianId   = pill.getAttribute('data-ujian');
            var ujianNama = pill.getAttribute('data-ujian-nama');
            openDetailSoal(ujianId, ujianNama);
            return;
        }

        /* Import */
        var btnImport = e.target.closest('.btn-import');
        if (btnImport) {
            document.getElementById('importGuruId').value    = btnImport.getAttribute('data-guru');
            document.getElementById('importMapelId').value   = btnImport.getAttribute('data-mapel');
            document.getElementById('importGuruName').value  = btnImport.getAttribute('data-guru-name');
            document.getElementById('importMapelName').value = btnImport.getAttribute('data-mapel-name');
            document.getElementById('importUjianSelect').innerHTML = ujianOptions(btnImport.getAttribute('data-mapel'));
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalImportSoal')).show();
            return;
        }

        /* Manual */
        var btnManual = e.target.closest('.btn-tambah-manual');
        if (btnManual) {
            document.getElementById('manualGuruId').value    = btnManual.getAttribute('data-guru');
            document.getElementById('manualMapelId').value   = btnManual.getAttribute('data-mapel');
            document.getElementById('manualGuruName').value  = btnManual.getAttribute('data-guru-name');
            document.getElementById('manualMapelName').value = btnManual.getAttribute('data-mapel-name');
            document.getElementById('manualUjianSelect').innerHTML = ujianOptions(btnManual.getAttribute('data-mapel'));
            document.getElementById('formTambahSoal').reset();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahSoal')).show();
            return;
        }

        /* Batch */
        var btnBatch = e.target.closest('.btn-batch-input');
        if (btnBatch) {
            document.getElementById('batchGuruId').value  = btnBatch.getAttribute('data-guru');
            document.getElementById('batchMapelId').value = btnBatch.getAttribute('data-mapel');
            document.getElementById('batchUjianSelect').innerHTML = ujianOptions(btnBatch.getAttribute('data-mapel'));
            document.getElementById('jumlahPG').value    = 20;
            document.getElementById('jumlahEssay').value = 5;
            renderBatchFields();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBatchSoal')).show();
            return;
        }
    });

    /* ── Detail Soal modal ── */
    function openDetailSoal(ujianId, ujianNama) {
        var content = document.getElementById('detailSoalContent');
        document.getElementById('modalDetailSoalLabel').innerHTML =
            '<i class="bi bi-list-ul me-2"></i>' + ujianNama;
        content.innerHTML = '<div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat soal...</h6></div>';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetailSoal')).show();

        fetch('/admin/soal?exam_id=' + ujianId, { headers: { 'Accept': 'application/json' } })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data || !data.length) {
                content.innerHTML = '<div class="empty-state"><div class="empty-icon" style="background:rgba(255,193,7,.1);color:#856404;"><i class="bi bi-inbox"></i></div>' +
                    '<h6>Belum ada soal</h6><p>Belum ada soal yang ditambahkan untuk ujian ini.</p></div>';
                return;
            }
            var html = '<div class="table-responsive"><table class="table soal-table">' +
                '<thead><tr><th style="width:48px;">No</th><th>Pertanyaan</th><th style="width:80px;">Tipe</th><th style="width:90px; text-align:center;">Jawaban</th><th style="width:70px; text-align:center;">Hapus</th></tr></thead><tbody>';
            data.forEach(function(soal, i) {
                var tipe    = soal.opsi_a ? 'PG' : 'Essay';
                var tipeBadge = tipe === 'PG'
                    ? '<span class="badge-pg">PG</span>'
                    : '<span class="badge-essay">Essay</span>';
                var jawaban = soal.jawaban_benar
                    ? '<span class="badge-ans">' + soal.jawaban_benar + '</span>'
                    : '<span style="color:#ccc;">—</span>';
                html += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td style="max-width:320px;word-break:break-word;">' + soal.pertanyaan + '</td>' +
                    '<td>' + tipeBadge + '</td>' +
                    '<td style="text-align:center;">' + jawaban + '</td>' +
                    '<td style="text-align:center;">' +
                        '<button class="btn-act btn-act-batch btn-delete-soal" data-id="' + soal.id + '" data-ujian="' + ujianId + '" data-ujian-nama="' + ujianNama + '" style="background:rgba(220,53,69,.1);color:#dc3545;padding:5px 9px;">' +
                            '<i class="bi bi-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>';
            });
            html += '</tbody></table></div>';
            content.innerHTML = html;
        })
        .catch(function() {
            content.innerHTML = '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.1);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat soal</h6></div>';
        });
    }

    /* ── Delete soal inside modal ── */
    document.getElementById('detailSoalContent').addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-delete-soal');
        if (!btn) return;

        var soalId   = btn.getAttribute('data-id');
        var ujianId  = btn.getAttribute('data-ujian');
        var ujianNama = btn.getAttribute('data-ujian-nama');

        Swal.fire({
            title: 'Hapus soal ini?',
            text: 'Soal akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            fetch('/admin/soal/' + soalId, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
            .then(function(r) { if (!r.ok) throw new Error(); return r.json(); })
            .then(function() {
                Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1200, showConfirmButton: false });
                openDetailSoal(ujianId, ujianNama); /* reload modal */
            })
            .catch(function() { Swal.fire('Error', 'Gagal menghapus soal.', 'error'); });
        });
    });

    /* ── Batch input fields render ── */
    function renderBatchFields() {
        var pg    = parseInt(document.getElementById('jumlahPG').value)    || 0;
        var essay = parseInt(document.getElementById('jumlahEssay').value) || 0;
        var html  = '';

        if (pg > 0) {
            html += '<h6 class="mb-3 fw-bold" style="color:var(--primary);"><i class="bi bi-list-check me-2"></i>Soal Pilihan Ganda (' + pg + ' soal)</h6>';
            for (var i = 0; i < pg; i++) {
                html += '<div class="batch-soal-card">' +
                    '<span class="batch-no">PG #' + (i + 1) + '</span>' +
                    '<input type="hidden" name="soal[' + i + '][tipe]" value="pg">' +
                    '<div class="mb-2"><textarea class="form-control" name="soal[' + i + '][pertanyaan]" placeholder="Pertanyaan" rows="2" required></textarea></div>' +
                    '<div class="row g-2 mb-2">' +
                        '<div class="col-6"><input type="text" class="form-control" name="soal[' + i + '][opsi_a]" placeholder="A." required></div>' +
                        '<div class="col-6"><input type="text" class="form-control" name="soal[' + i + '][opsi_b]" placeholder="B." required></div>' +
                        '<div class="col-6"><input type="text" class="form-control" name="soal[' + i + '][opsi_c]" placeholder="C." required></div>' +
                        '<div class="col-6"><input type="text" class="form-control" name="soal[' + i + '][opsi_d]" placeholder="D." required></div>' +
                    '</div>' +
                    '<select class="form-select" name="soal[' + i + '][jawaban_benar]" required>' +
                        '<option value="">-- Jawaban Benar --</option>' +
                        '<option>A</option><option>B</option><option>C</option><option>D</option>' +
                    '</select>' +
                '</div>';
            }
        }

        if (essay > 0) {
            html += '<h6 class="mt-4 mb-3 fw-bold" style="color:#0a9bba;"><i class="bi bi-pencil-square me-2"></i>Soal Essay (' + essay + ' soal)</h6>';
            for (var j = pg; j < pg + essay; j++) {
                html += '<div class="batch-soal-card" style="border-color:rgba(13,202,240,.2);background:#f0fbff;">' +
                    '<span class="batch-no" style="background:rgba(13,202,240,.1);color:#0a9bba;">Essay #' + (j - pg + 1) + '</span>' +
                    '<input type="hidden" name="soal[' + j + '][tipe]" value="essay">' +
                    '<textarea class="form-control" name="soal[' + j + '][pertanyaan]" placeholder="Pertanyaan Essay" rows="3" required></textarea>' +
                '</div>';
            }
        }

        document.getElementById('batchInputContainer').innerHTML = html || '<div class="text-muted text-center py-3">Set jumlah soal PG atau Essay di atas untuk mulai input.</div>';
    }

    document.getElementById('jumlahPG').addEventListener('input',    renderBatchFields);
    document.getElementById('jumlahEssay').addEventListener('input', renderBatchFields);

    /* ── Submit: Import ── */
    document.getElementById('formImportSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        var ujianId = document.getElementById('importUjianSelect').value;
        if (!ujianId) { Swal.fire('Perhatian', 'Pilih ujian terlebih dahulu!', 'warning'); return; }

        var formData = new FormData(this);
        formData.append('exam_id', ujianId);

        var btn = document.getElementById('btnImportSoal');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengimport...';

        fetch('/admin/soal/import', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(function(r) { if (!r.ok) throw new Error(); return r.json(); })
        .then(function() {
            bootstrap.Modal.getInstance(document.getElementById('modalImportSoal')).hide();
            this.reset();
            Swal.fire({ icon: 'success', title: 'Import berhasil!', timer: 1500, showConfirmButton: false });
        }.bind(this))
        .catch(function() { Swal.fire('Error', 'Gagal import soal. Cek format file!', 'error'); })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="bi bi-upload me-1"></i> Import'; });
    });

    /* ── Submit: Manual ── */
    document.getElementById('formTambahSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var payload  = {
            exam_id:      formData.get('exam_id'),
            pertanyaan:   formData.get('pertanyaan'),
            opsi_a:       formData.get('opsi_a'),
            opsi_b:       formData.get('opsi_b'),
            opsi_c:       formData.get('opsi_c'),
            opsi_d:       formData.get('opsi_d'),
            jawaban_benar: formData.get('jawaban_benar')
        };
        if (!payload.exam_id) { Swal.fire('Perhatian', 'Pilih ujian terlebih dahulu!', 'warning'); return; }

        var btn = document.getElementById('btnSimpanManual');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch('/admin/soal', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function(r) { if (!r.ok) return r.json().then(function(e) { throw e; }); return r.json(); })
        .then(function() {
            bootstrap.Modal.getInstance(document.getElementById('modalTambahSoal')).hide();
            this.reset();
            Swal.fire({ icon: 'success', title: 'Soal ditambahkan!', timer: 1500, showConfirmButton: false });
        }.bind(this))
        .catch(function(err) {
            var msg = 'Gagal menambah soal.';
            if (err && err.errors) msg = Object.values(err.errors).flat().join('<br>');
            Swal.fire({ icon: 'error', title: 'Gagal', html: msg });
        })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan'; });
    });

    /* ── Submit: Batch ── */
    document.getElementById('formBatchSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        var ujianId = document.getElementById('batchUjianSelect').value;
        if (!ujianId) { Swal.fire('Perhatian', 'Pilih ujian terlebih dahulu!', 'warning'); return; }

        var formData = new FormData(this);
        formData.append('exam_id', ujianId);

        var btn = document.getElementById('btnSimpanBatch');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch('/admin/soal/batch', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(function(r) { if (!r.ok) throw new Error(); return r.json(); })
        .then(function(data) {
            bootstrap.Modal.getInstance(document.getElementById('modalBatchSoal')).hide();
            this.reset();
            document.getElementById('batchInputContainer').innerHTML = '';
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Tersimpan ' + (data.count || 'semua') + ' soal.', timer: 1600, showConfirmButton: false });
        }.bind(this))
        .catch(function() { Swal.fire('Error', 'Gagal simpan batch soal!', 'error'); })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Semua Soal'; });
    });

});
</script>
@endpush