@extends('layouts.master')
@section('title', 'Bank Soal')

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
    margin-bottom: 20px;
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
.page-header h4 { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p  { font-size: 0.85rem; opacity: 0.85; margin: 0; }
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
.btn-header {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.2);
    color: #fff !important;
    border: 1.5px solid rgba(255,255,255,0.45);
    padding: 9px 18px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    backdrop-filter: blur(8px);
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
}
.btn-header:hover {
    background: rgba(255,255,255,0.35);
    transform: translateY(-2px);
    color: #fff !important;
}

/* ── Focus Ujian Banner Card ── */
.exam-focus-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 18px 22px;
    margin-bottom: 20px;
    transition: all 0.2s ease;
}
.exam-select-hero {
    height: 44px;
    border-radius: 12px;
    border: 1.5px solid #0d6efd;
    font-size: 0.95rem;
    font-weight: 600;
    color: #0d6efd;
    background-color: #f8faff;
    cursor: pointer;
}
.exam-select-hero:focus {
    box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    border-color: #0d6efd;
}
.exam-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
}

/* ── Filter Toolbar ── */
.filter-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid var(--border-color);
    padding: 14px 18px;
    margin-bottom: 18px;
}
.filter-input {
    height: 38px;
    border-radius: 50px;
    border: 1.5px solid var(--border-color);
    font-size: 0.84rem;
    padding: 0 14px;
}
.search-wrap { position: relative; }
.search-wrap i {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.88rem;
    pointer-events: none;
}
.search-wrap input { padding-left: 36px; }

/* ── Table Card ── */
.table-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}
.table-card .table { margin: 0; font-size: 0.84rem; }
.table-card .table thead th {
    background: #f8faff;
    font-weight: 700;
    font-size: 0.74rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 13px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.04);
    color: var(--text-main);
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

/* ── Soal Item Formatting ── */
.soal-pertanyaan-box {
    font-size: 0.88rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.45;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.soal-opsi-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.opsi-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.76rem;
    padding: 3px 9px;
    border-radius: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    max-width: 220px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.opsi-chip.is-correct {
    background: rgba(25,135,84,0.1);
    border-color: rgba(25,135,84,0.35);
    color: #198754;
    font-weight: 700;
}
.opsi-chip-key {
    font-weight: 800;
    font-size: 0.72rem;
    width: 17px; height: 17px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #cbd5e1;
    color: #1e293b;
}
.opsi-chip.is-correct .opsi-chip-key {
    background: #198754;
    color: #fff;
}

/* ── Badges ── */
.badge-tipe {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
}
.badge-pg    { background: rgba(13,110,253,0.1); color: #0d6efd; }
.badge-essay { background: rgba(111,66,193,0.1); color: #6f42c1; }
.badge-mapel { background: rgba(13,110,253,0.08); color: #0d6efd; font-size: 0.72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
.badge-kelas { background: rgba(32,201,151,0.1); color: #198754; font-size: 0.72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
.badge-ujian { background: rgba(13,202,240,0.1); color: #0a9bba; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(13,202,240,0.25); }

/* ── Action buttons ── */
.btn-act {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px; height: 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.18s ease;
    font-size: 0.85rem;
}
.btn-act-preview { background: rgba(13,202,240,0.12); color: #0a9bba; }
.btn-act-preview:hover { background: #0dcaf0; color: #fff; transform: translateY(-1px); }
.btn-act-edit    { background: rgba(13,110,253,0.1);  color: #0d6efd; }
.btn-act-edit:hover    { background: #0d6efd; color: #fff; transform: translateY(-1px); }
.btn-act-delete  { background: rgba(220,53,69,0.1);   color: #dc3545; }
.btn-act-delete:hover  { background: #dc3545; color: #fff; transform: translateY(-1px); }

/* ── Empty State ── */
.empty-state { text-align: center; padding: 50px 24px; }
.empty-state .empty-icon {
    width: 68px; height: 68px;
    background: rgba(13,110,253,0.07);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: var(--primary);
    margin-bottom: 14px;
}
.empty-state h6 { font-weight: 700; margin-bottom: 6px; }
.empty-state p  { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

/* ── Modal Design ── */
.modal-header-brand {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff;
    padding: 16px 22px;
}
.modal-header-brand .modal-title { font-weight: 700; font-size: 1rem; }
.modal-header-brand .btn-close { filter: brightness(0) invert(1); opacity: 0.85; }
.modal-content {
    border-radius: 18px;
    overflow: hidden;
    border: none;
    box-shadow: 0 20px 60px rgba(13,110,253,0.2);
}

/* Opsi inputs in modal */
.opsi-input-wrap { position: relative; margin-bottom: 10px; }
.opsi-label-badge {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0d6efd, #0dcaf0);
    color: #fff;
    font-weight: 800;
    font-size: 0.82rem;
    border-radius: 10px 0 0 10px;
    pointer-events: none;
}
.opsi-input-wrap .form-control {
    padding-left: 48px;
    border-radius: 10px;
    border: 1.5px solid var(--border-color);
    font-size: 0.85rem;
    height: 42px;
}
.opsi-input-wrap .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
}

/* CKEditor in Modal */
.ck-editor__editable { min-height: 130px; }
.ck.ck-editor { border-radius: 10px; overflow: hidden; }

/* Preview Modal Card */
.preview-question-card {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 18px;
}
.preview-option-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    margin-bottom: 8px;
    transition: all 0.15s ease;
}
.preview-option-item.is-answer {
    background: rgba(25,135,84,0.07);
    border-color: #198754;
    font-weight: 600;
    color: #198754;
}
.preview-opt-circle {
    width: 26px; height: 26px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.8rem;
    background: #e2e8f0;
    color: #334155;
    flex-shrink: 0;
}
.preview-option-item.is-answer .preview-opt-circle {
    background: #198754;
    color: #fff;
}
</style>
@endpush

@section('layoutContent')

{{-- ── 1. Page Header ── --}}
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-collection me-2"></i>Bank Soal Guru <span class="count-badge" id="soal-count">0 soal</span></h4>
            <p>Kelola dan susun butir soal ujian dengan mudah dan terstruktur</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn-header" id="btnTambahSoalModal">
                <i class="bi bi-plus-lg"></i> Tambah Soal Satuan
            </button>
            <a href="{{ route('guru.soal.batch') }}" class="btn-header">
                <i class="bi bi-lightning-charge"></i> Tambah Soal Batch
            </a>
        </div>
    </div>
</div>

{{-- ── 2. Exam Focus Selector Card ── --}}
<div class="exam-focus-card">
    <div class="row align-items-center g-3">
        <div class="col-lg-5 col-md-6">
            <label class="form-label text-muted small fw-bold text-uppercase mb-1">
                <i class="bi bi-folder2-open me-1 text-primary"></i> Pilih Ujian yang Ingin Dikelola:
            </label>
            <select id="examFocusSelect" class="form-select exam-select-hero">
                <option value="">-- Tampilkan Semua Ujian --</option>
            </select>
        </div>
        <div class="col-lg-7 col-md-6">
            <div id="examInfoBox" class="d-flex flex-wrap align-items-center gap-2 pt-md-3">
                <span class="exam-meta-pill"><i class="bi bi-collection text-primary"></i> Total: <strong id="infoTotalSoal">0</strong> Soal</span>
                <span class="exam-meta-pill"><i class="bi bi-ui-radios text-info"></i> <strong id="infoTotalPg">0</strong> PG</span>
                <span class="exam-meta-pill"><i class="bi bi-pencil-square text-purple" style="color:#6f42c1;"></i> <strong id="infoTotalEsai">0</strong> Esai</span>
                <span class="exam-meta-pill" id="infoKelasPill" style="display:none;"><i class="bi bi-building text-success"></i> <span id="infoKelasText">-</span></span>
                <span class="exam-meta-pill" id="infoMapelPill" style="display:none;"><i class="bi bi-journal-bookmark text-primary"></i> <span id="infoMapelText">-</span></span>
            </div>
        </div>
    </div>
</div>

{{-- ── 3. Filter & Search Toolbar ── --}}
<div class="filter-card">
    <div class="row g-2 align-items-center">
        <div class="col-md-4 col-sm-6">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="searchSoal" class="form-control filter-input" placeholder="Cari teks soal atau pilihan jawaban...">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <select id="filterTipe" class="form-select filter-input">
                <option value="">Semua Tipe (PG & Esai)</option>
                <option value="multiple_choice">Pilihan Ganda (PG)</option>
                <option value="essay">Esai</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select id="filterMapel" class="form-select filter-input">
                <option value="">Semua Mata Pelajaran</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-6 text-end">
            <button id="btnResetFilter" class="btn btn-outline-secondary btn-sm w-100" style="border-radius:50px;height:38px;">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
        </div>
    </div>
</div>

{{-- ── 4. Main Soal Table ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle" id="soalTable">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Butir Pertanyaan & Pilihan Jawaban</th>
                    <th style="width:160px;">Ujian & Kelas</th>
                    <th style="width:140px;">Mata Pelajaran</th>
                    <th style="width:110px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="soalTbody">
                <tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-hourglass-split"></i></div><h6>Memuat bank soal...</h6></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ===== MODAL TAMBAH SOAL SATUAN ===== --}}
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Soal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahSoal">
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ujian Tujuan <span class="text-danger">*</span></label>
                            <select id="tambah-exam_id" name="exam_id" class="form-select" required onchange="onTambahExamChange(this.value)">
                                <option value="">-- Pilih Ujian --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select id="tambah-subject_id" name="subject_id" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Soal <span class="text-danger">*</span></label>
                        <select id="tambah-type" name="type" class="form-select" onchange="toggleOpsiForm('tambah', this.value)">
                            <option value="multiple_choice">Pilihan Ganda (PG)</option>
                            <option value="essay">Esai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Teks Pertanyaan <span class="text-danger">*</span></label>
                        <div id="tambah-ck-container"></div>
                    </div>

                    {{-- Opsi untuk Pilihan Ganda --}}
                    <div id="tambah-opsi-section">
                        <label class="form-label fw-bold mb-2">Pilihan Jawaban (Opsi A - D)</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">A</div>
                                    <input type="text" id="tambah-opsi_a" name="opsi_a" class="form-control" placeholder="Pilihan A">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">B</div>
                                    <input type="text" id="tambah-opsi_b" name="opsi_b" class="form-control" placeholder="Pilihan B">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">C</div>
                                    <input type="text" id="tambah-opsi_c" name="opsi_c" class="form-control" placeholder="Pilihan C">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">D</div>
                                    <input type="text" id="tambah-opsi_d" name="opsi_d" class="form-control" placeholder="Pilihan D">
                                </div>
                            </div>
                        </div>

                        <div class="mt-2" style="max-width:240px;">
                            <label class="form-label fw-bold">Kunci Jawaban Benar <span class="text-danger">*</span></label>
                            <select id="tambah-jawaban_benar" name="jawaban_benar" class="form-select" style="border-radius:50px;">
                                <option value="">-- Pilih Kunci --</option>
                                <option value="A">Opsi A</option>
                                <option value="B">Opsi B</option>
                                <option value="C">Opsi C</option>
                                <option value="D">Opsi D</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSimpanTambah">
                        <i class="bi bi-save me-1"></i> Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT SOAL ===== --}}
<div class="modal fade" id="modalEditSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Soal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditSoal">
                <div class="modal-body p-4">
                    <input type="hidden" id="edit-id">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ujian Tujuan <span class="text-danger">*</span></label>
                            <select id="edit-exam_id" name="exam_id" class="form-select" required onchange="onEditExamChange(this.value)">
                                <option value="">-- Pilih Ujian --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select id="edit-subject_id" name="subject_id" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Soal <span class="text-danger">*</span></label>
                        <select id="edit-type" name="type" class="form-select" onchange="toggleOpsiForm('edit', this.value)">
                            <option value="multiple_choice">Pilihan Ganda (PG)</option>
                            <option value="essay">Esai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Teks Pertanyaan <span class="text-danger">*</span></label>
                        <div id="edit-ck-container"></div>
                    </div>

                    {{-- Opsi untuk Pilihan Ganda --}}
                    <div id="edit-opsi-section">
                        <label class="form-label fw-bold mb-2">Pilihan Jawaban (Opsi A - D)</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">A</div>
                                    <input type="text" id="edit-opsi_a" name="opsi_a" class="form-control" placeholder="Pilihan A">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">B</div>
                                    <input type="text" id="edit-opsi_b" name="opsi_b" class="form-control" placeholder="Pilihan B">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">C</div>
                                    <input type="text" id="edit-opsi_c" name="opsi_c" class="form-control" placeholder="Pilihan C">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="opsi-input-wrap">
                                    <div class="opsi-label-badge">D</div>
                                    <input type="text" id="edit-opsi_d" name="opsi_d" class="form-control" placeholder="Pilihan D">
                                </div>
                            </div>
                        </div>

                        <div class="mt-2" style="max-width:240px;">
                            <label class="form-label fw-bold">Kunci Jawaban Benar <span class="text-danger">*</span></label>
                            <select id="edit-jawaban_benar" name="jawaban_benar" class="form-select" style="border-radius:50px;">
                                <option value="">-- Pilih Kunci --</option>
                                <option value="A">Opsi A</option>
                                <option value="B">Opsi B</option>
                                <option value="C">Opsi C</option>
                                <option value="D">Opsi D</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSimpanEdit">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL PREVIEW SOAL ===== --}}
<div class="modal fade" id="modalPreviewSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Preview Soal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div id="previewMetaBadges" class="d-flex gap-2"></div>
                    <span class="badge bg-light text-dark border" id="previewUjianText"></span>
                </div>
                <div class="preview-question-card" id="previewQuestionText"></div>
                <div id="previewOptionsWrapper"></div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnPreviewToEdit">
                    <i class="bi bi-pencil me-1"></i> Edit Soal Ini
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
var allSoal      = [];
var allExams     = [];
var allSubjects  = [];
var tambahEditor = null;
var editEditor   = null;
var currentPreviewSoalId = null;

function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* ─── CKEditor Upload Adapter ─── */
class CustomUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const fd = new FormData();
            fd.append('upload', file);
            fetch('/guru/upload-image', { method:'POST', headers:{'X-CSRF-TOKEN': getCsrfToken()}, body:fd })
            .then(r => r.json())
            .then(d => d.url ? resolve({ default: d.url }) : reject('Upload failed'))
            .catch(reject);
        }));
    }
    abort() {}
}
function UploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = loader => new CustomUploadAdapter(loader);
}
var CK_CONFIG = {
    language: 'id',
    toolbar: { items:['bold','italic','|','numberedList','bulletedList','|','link','imageUpload','insertTable','|','undo','redo'], shouldNotGroupWhenFull:true },
    extraPlugins: [UploadAdapterPlugin]
};

/* ─── Helper UI ─── */
function toggleOpsiForm(mode, type) {
    var section = document.getElementById(mode + '-opsi-section');
    if (section) {
        section.style.display = (type === 'essay') ? 'none' : 'block';
    }
}

function onTambahExamChange(examId) {
    var exam = allExams.find(function(e){ return e.id == examId; });
    if (exam && exam.subject) {
        document.getElementById('tambah-subject_id').value = exam.subject.id || exam.subject_id;
    }
}

function onEditExamChange(examId) {
    var exam = allExams.find(function(e){ return e.id == examId; });
    if (exam && exam.subject) {
        document.getElementById('edit-subject_id').value = exam.subject.id || exam.subject_id;
    }
}

/* ─── Render Table ─── */
function renderSoal(data) {
    var tbody = document.getElementById('soalTbody');
    var count = document.getElementById('soal-count');
    
    count.textContent = allSoal.length + ' soal';
    
    // Hitung statistik Ujian Terfokus
    var focusedExamId = document.getElementById('examFocusSelect').value;
    var scopeData     = focusedExamId ? allSoal.filter(function(s){ return s.exam_id == focusedExamId; }) : allSoal;
    
    var totalPg   = scopeData.filter(function(s){ return s.type === 'multiple_choice' || s.type === 'pg'; }).length;
    var totalEsai = scopeData.filter(function(s){ return s.type === 'essay'; }).length;
    
    document.getElementById('infoTotalSoal').textContent = scopeData.length;
    document.getElementById('infoTotalPg').textContent   = totalPg;
    document.getElementById('infoTotalEsai').textContent = totalEsai;

    if (focusedExamId) {
        var u = allExams.find(function(x){ return x.id == focusedExamId; });
        if (u) {
            document.getElementById('infoKelasPill').style.display = 'inline-flex';
            document.getElementById('infoKelasText').textContent   = u.school_class ? u.school_class.name : '-';
            document.getElementById('infoMapelPill').style.display = 'inline-flex';
            document.getElementById('infoMapelText').textContent   = u.subject ? u.subject.name : '-';
        }
    } else {
        document.getElementById('infoKelasPill').style.display = 'none';
        document.getElementById('infoMapelPill').style.display = 'none';
    }

    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><h6>Belum ada butir soal</h6><p>Coba ubah filter atau klik tombol "Tambah Soal" untuk mulai membuat soal.</p></div></td></tr>';
        return;
    }

    var rows = '';
    data.forEach(function(s, idx) {
        var isEssay   = (s.type === 'essay');
        var tipeBadge = isEssay
            ? '<span class="badge-tipe badge-essay"><i class="bi bi-pencil-square"></i> Esai</span>'
            : '<span class="badge-tipe badge-pg"><i class="bi bi-ui-radios"></i> Pilihan Ganda</span>';
        
        var cleanText = (s.pertanyaan || s.question_text || '-').replace(/<[^>]*>/g, '').trim();
        var ujian     = allExams.find(function(e){ return e.id === s.exam_id; });
        var ujianNm   = ujian ? (ujian.title || ujian.nama || '-') : '-';
        var kelasNm   = ujian && ujian.school_class ? ujian.school_class.name : '-';
        var mapelNm   = s.subject ? s.subject.name : '-';

        // Opsi preview
        var opsiHtml = '';
        if (!isEssay) {
            var kunci = (s.jawaban_benar || s.answer_key || '').toUpperCase();
            var optA = s.opsi_a || (s.options && s.options['A']) || '';
            var optB = s.opsi_b || (s.options && s.options['B']) || '';
            var optC = s.opsi_c || (s.options && s.options['C']) || '';
            var optD = s.opsi_d || (s.options && s.options['D']) || '';

            opsiHtml = '<div class="soal-opsi-chips mt-2">' +
                (optA ? '<span class="opsi-chip ' + (kunci==='A'?'is-correct':'') + '"><span class="opsi-chip-key">A</span> ' + optA + '</span>' : '') +
                (optB ? '<span class="opsi-chip ' + (kunci==='B'?'is-correct':'') + '"><span class="opsi-chip-key">B</span> ' + optB + '</span>' : '') +
                (optC ? '<span class="opsi-chip ' + (kunci==='C'?'is-correct':'') + '"><span class="opsi-chip-key">C</span> ' + optC + '</span>' : '') +
                (optD ? '<span class="opsi-chip ' + (kunci==='D'?'is-correct':'') + '"><span class="opsi-chip-key">D</span> ' + optD + '</span>' : '') +
            '</div>';
        }

        rows += '<tr>' +
            '<td class="fw-bold text-muted">' + (idx + 1) + '</td>' +
            '<td>' +
                '<div class="mb-1">' + tipeBadge + '</div>' +
                '<div class="soal-pertanyaan-box" title="' + cleanText.replace(/"/g,'&quot;') + '">' + cleanText + '</div>' +
                opsiHtml +
            '</td>' +
            '<td>' +
                '<div class="d-flex flex-column gap-1">' +
                    '<span class="badge-ujian"><i class="bi bi-file-earmark-text me-1"></i>' + ujianNm + '</span>' +
                    '<span class="badge-kelas"><i class="bi bi-building me-1"></i>' + kelasNm + '</span>' +
                '</div>' +
            '</td>' +
            '<td><span class="badge-mapel"><i class="bi bi-journal-bookmark me-1"></i>' + mapelNm + '</span></td>' +
            '<td class="text-center">' +
                '<div class="d-flex align-items-center justify-content-center gap-1">' +
                    '<button class="btn-act btn-act-preview" data-id="' + s.id + '" title="Preview Tampilan Siswa"><i class="bi bi-eye"></i></button>' +
                    '<button class="btn-act btn-act-edit" data-id="' + s.id + '" title="Edit Soal"><i class="bi bi-pencil"></i></button>' +
                    '<button class="btn-act btn-act-delete" data-id="' + s.id + '" title="Hapus Soal"><i class="bi bi-trash"></i></button>' +
                '</div>' +
            '</td>' +
        '</tr>';
    });

    tbody.innerHTML = rows;
}

/* ─── Apply Filters ─── */
function applyFilters() {
    var examFocus = document.getElementById('examFocusSelect').value;
    var tipe      = document.getElementById('filterTipe').value;
    var mapelId   = document.getElementById('filterMapel').value;
    var q         = document.getElementById('searchSoal').value.toLowerCase().trim();

    var filtered = allSoal;

    if (examFocus) {
        filtered = filtered.filter(function(s){ return s.exam_id == examFocus; });
    }
    if (tipe) {
        if (tipe === 'multiple_choice') {
            filtered = filtered.filter(function(s){ return s.type === 'multiple_choice' || s.type === 'pg'; });
        } else if (tipe === 'essay') {
            filtered = filtered.filter(function(s){ return s.type === 'essay'; });
        }
    }
    if (mapelId) {
        filtered = filtered.filter(function(s){ return s.subject_id == mapelId; });
    }
    if (q) {
        filtered = filtered.filter(function(s){
            var text  = (s.pertanyaan || s.question_text || '').toLowerCase();
            var optA  = (s.opsi_a || '').toLowerCase();
            var optB  = (s.opsi_b || '').toLowerCase();
            var optC  = (s.opsi_c || '').toLowerCase();
            var optD  = (s.opsi_d || '').toLowerCase();
            return text.includes(q) || optA.includes(q) || optB.includes(q) || optC.includes(q) || optD.includes(q);
        });
    }

    renderSoal(filtered);
}

/* ─── Fetch All Initial Data ─── */
function loadData() {
    fetch('/guru/soal/filters', { headers:{'Accept':'application/json'} })
    .then(function(r){ return r.ok ? r.json() : {}; })
    .then(function(res) {
        allSubjects = res.subjects || [];
        allExams    = res.exams    || [];

        // Isi dropdown filter
        var examSelectHero = document.getElementById('examFocusSelect');
        var tambahExamSel  = document.getElementById('tambah-exam_id');
        var editExamSel    = document.getElementById('edit-exam_id');

        var examOpt = '<option value="">-- Tampilkan Semua Ujian --</option>';
        var examOptForm = '<option value="">-- Pilih Ujian --</option>';

        allExams.forEach(function(e) {
            var label = (e.title || e.nama || '') + ' (' + (e.school_class ? e.school_class.name : '-') + ')';
            examOpt     += '<option value="' + e.id + '">' + label + '</option>';
            examOptForm += '<option value="' + e.id + '">' + label + '</option>';
        });

        examSelectHero.innerHTML = examOpt;
        tambahExamSel.innerHTML  = examOptForm;
        editExamSel.innerHTML    = examOptForm;

        // Isi mapel
        var mapelFilterSel = document.getElementById('filterMapel');
        var tambahMapelSel = document.getElementById('tambah-subject_id');
        var editMapelSel   = document.getElementById('edit-subject_id');

        var mapelOptFilter = '<option value="">Semua Mata Pelajaran</option>';
        var mapelOptForm   = '<option value="">-- Pilih Mapel --</option>';

        allSubjects.forEach(function(m) {
            mapelOptFilter += '<option value="' + m.id + '">' + m.name + '</option>';
            mapelOptForm   += '<option value="' + m.id + '">' + m.name + '</option>';
        });

        mapelFilterSel.innerHTML = mapelOptFilter;
        tambahMapelSel.innerHTML = mapelOptForm;
        editMapelSel.innerHTML   = mapelOptForm;

        return fetch('/guru/soal/list', { headers:{'Accept':'application/json'} });
    })
    .then(function(r){ return r.ok ? r.json() : []; })
    .then(function(data) {
        allSoal = data;
        applyFilters();
    })
    .catch(function(err) {
        console.error(err);
        document.getElementById('soalTbody').innerHTML = '<tr><td colspan="5"><div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.08);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat data bank soal</h6></div></td></tr>';
    });
}

/* ─── Event Handlers ─── */
document.addEventListener('DOMContentLoaded', function () {
    var csrf = getCsrfToken();

    loadData();

    // Filter listeners
    document.getElementById('examFocusSelect').addEventListener('change', applyFilters);
    document.getElementById('filterTipe').addEventListener('change', applyFilters);
    document.getElementById('filterMapel').addEventListener('change', applyFilters);
    document.getElementById('searchSoal').addEventListener('input', applyFilters);

    document.getElementById('btnResetFilter').addEventListener('click', function(){
        document.getElementById('examFocusSelect').value = '';
        document.getElementById('filterTipe').value = '';
        document.getElementById('filterMapel').value = '';
        document.getElementById('searchSoal').value = '';
        applyFilters();
    });

    /* ─── Open Tambah Modal ─── */
    document.getElementById('btnTambahSoalModal').addEventListener('click', function() {
        document.getElementById('formTambahSoal').reset();
        toggleOpsiForm('tambah', 'multiple_choice');

        // Jika ada ujian yang sedang difokuskan, set otomatis
        var currentFocusExam = document.getElementById('examFocusSelect').value;
        if (currentFocusExam) {
            document.getElementById('tambah-exam_id').value = currentFocusExam;
            onTambahExamChange(currentFocusExam);
        }

        var container = document.getElementById('tambah-ck-container');
        if (!tambahEditor) {
            container.innerHTML = '';
            ClassicEditor.create(container, CK_CONFIG)
            .then(function(editor) {
                tambahEditor = editor;
                editor.setData('');
            });
        } else {
            tambahEditor.setData('');
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahSoal')).show();
    });

    /* ─── Submit Tambah Soal ─── */
    document.getElementById('formTambahSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        var pertanyaan = tambahEditor ? tambahEditor.getData() : '';
        if (!pertanyaan.trim()) {
            Swal.fire('Peringatan', 'Teks pertanyaan wajib diisi!', 'warning');
            return;
        }

        var examId    = document.getElementById('tambah-exam_id').value;
        var subjectId = document.getElementById('tambah-subject_id').value;
        var type      = document.getElementById('tambah-type').value;

        var payload = {
            exam_id:       examId,
            subject_id:    subjectId,
            type:          type,
            pertanyaan:    pertanyaan,
            opsi_a:        document.getElementById('tambah-opsi_a').value,
            opsi_b:        document.getElementById('tambah-opsi_b').value,
            opsi_c:        document.getElementById('tambah-opsi_c').value,
            opsi_d:        document.getElementById('tambah-opsi_d').value,
            jawaban_benar: document.getElementById('tambah-jawaban_benar').value,
        };

        if (type === 'multiple_choice' && !payload.jawaban_benar) {
            Swal.fire('Peringatan', 'Silakan pilih kunci jawaban yang benar untuk soal PG!', 'warning');
            return;
        }

        var btn = document.getElementById('btnSimpanTambah');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch('/guru/soal/store', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify(payload)
        })
        .then(function(r){ return r.json(); })
        .then(function(res) {
            if (res.success) {
                if (res.question) allSoal.unshift(res.question);
                applyFilters();
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahSoal')).hide();
                Swal.fire({ icon:'success', title:'Berhasil!', text:'Soal baru berhasil ditambahkan.', timer:1500, showConfirmButton:false });
            } else {
                Swal.fire('Gagal', res.message || 'Gagal menambahkan soal.', 'error');
            }
        })
        .catch(function(){ Swal.fire('Error', 'Terjadi kesalahan sistem saat menyimpan.', 'error'); })
        .finally(function(){ btn.disabled = false; btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Soal'; });
    });

    /* ─── Submit Edit Soal ─── */
    document.getElementById('formEditSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        var id = document.getElementById('edit-id').value;
        var pertanyaan = editEditor ? editEditor.getData() : '';
        if (!pertanyaan.trim()) {
            Swal.fire('Peringatan', 'Teks pertanyaan tidak boleh kosong!', 'warning');
            return;
        }

        var examId    = document.getElementById('edit-exam_id').value;
        var subjectId = document.getElementById('edit-subject_id').value;
        var type      = document.getElementById('edit-type').value;

        var payload = {
            exam_id:       examId,
            subject_id:    subjectId,
            type:          type,
            pertanyaan:    pertanyaan,
            opsi_a:        document.getElementById('edit-opsi_a').value,
            opsi_b:        document.getElementById('edit-opsi_b').value,
            opsi_c:        document.getElementById('edit-opsi_c').value,
            opsi_d:        document.getElementById('edit-opsi_d').value,
            jawaban_benar: document.getElementById('edit-jawaban_benar').value,
        };

        var btn = document.getElementById('btnSimpanEdit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch('/guru/soal/' + id, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify(payload)
        })
        .then(function(r){ return r.json(); })
        .then(function(res) {
            if (res.success) {
                var idx = allSoal.findIndex(function(x){ return x.id == id; });
                if (idx !== -1 && res.data) allSoal[idx] = res.data;
                applyFilters();
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditSoal')).hide();
                Swal.fire({ icon:'success', title:'Tersimpan!', text:'Perubahan soal berhasil disimpan.', timer:1500, showConfirmButton:false });
            } else {
                Swal.fire('Gagal', res.message || 'Gagal menyimpan soal.', 'error');
            }
        })
        .catch(function(){ Swal.fire('Error', 'Gagal menghubungi server.', 'error'); })
        .finally(function(){ btn.disabled = false; btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Perubahan'; });
    });

    /* ─── Table Delegation (Preview, Edit, Delete) ─── */
    document.getElementById('soalTbody').addEventListener('click', function(e) {
        var btnPreview = e.target.closest('.btn-act-preview');
        var btnEdit    = e.target.closest('.btn-act-edit');
        var btnDelete  = e.target.closest('.btn-act-delete');

        /* PREVIEW */
        if (btnPreview) {
            var id = btnPreview.getAttribute('data-id');
            var s  = allSoal.find(function(x){ return x.id == id; });
            if (!s) return;

            currentPreviewSoalId = id;
            var isEssay = (s.type === 'essay');
            var ujian   = allExams.find(function(e){ return e.id === s.exam_id; });

            document.getElementById('previewUjianText').textContent = ujian ? (ujian.title || ujian.nama) : '-';
            
            var metaBadges = isEssay
                ? '<span class="badge-tipe badge-essay"><i class="bi bi-pencil-square"></i> Esai</span>'
                : '<span class="badge-tipe badge-pg"><i class="bi bi-ui-radios"></i> Pilihan Ganda</span>';
            metaBadges += '<span class="badge-mapel ms-2">' + (s.subject ? s.subject.name : '-') + '</span>';
            document.getElementById('previewMetaBadges').innerHTML = metaBadges;

            document.getElementById('previewQuestionText').innerHTML = s.pertanyaan || s.question_text || '-';

            var optWrapper = document.getElementById('previewOptionsWrapper');
            if (isEssay) {
                optWrapper.innerHTML = '<div class="alert alert-info py-2 px-3 small border-0"><i class="bi bi-info-circle me-1"></i> Soal tipe esai dijawab dengan teks bebas oleh siswa dan dinilai secara manual.</div>';
            } else {
                var kunci = (s.jawaban_benar || s.answer_key || '').toUpperCase();
                var optA  = s.opsi_a || (s.options && s.options['A']) || '';
                var optB  = s.opsi_b || (s.options && s.options['B']) || '';
                var optC  = s.opsi_c || (s.options && s.options['C']) || '';
                var optD  = s.opsi_d || (s.options && s.options['D']) || '';

                var optList = '';
                [
                    {k:'A', v:optA},
                    {k:'B', v:optB},
                    {k:'C', v:optC},
                    {k:'D', v:optD}
                ].forEach(function(item) {
                    if (!item.v) return;
                    var isAns = (kunci === item.k);
                    optList += '<div class="preview-option-item ' + (isAns ? 'is-answer' : '') + '">' +
                        '<div class="preview-opt-circle">' + item.k + '</div>' +
                        '<div class="flex-grow-1">' + item.v + '</div>' +
                        (isAns ? '<span class="badge bg-success rounded-pill px-2 py-1"><i class="bi bi-check-lg me-1"></i> Kunci Jawaban</span>' : '') +
                    '</div>';
                });
                optWrapper.innerHTML = optList;
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPreviewSoal')).show();
        }

        /* EDIT */
        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            openEditModal(id);
        }

        /* DELETE */
        if (btnDelete) {
            var id = btnDelete.getAttribute('data-id');
            Swal.fire({
                title: 'Hapus Butir Soal Ini?',
                text: 'Soal akan dihapus permanen dari ujian.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(res) {
                if (!res.isConfirmed) return;
                fetch('/guru/soal/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': csrf }
                })
                .then(function(r){ return r.json(); })
                .then(function(res) {
                    if (res.success) {
                        allSoal = allSoal.filter(function(x){ return x.id != id; });
                        applyFilters();
                        Swal.fire({ icon:'success', title:'Terhapus!', text:'Soal berhasil dihapus.', timer:1400, showConfirmButton:false });
                    } else {
                        Swal.fire('Gagal', res.message || 'Soal tidak dapat dihapus.', 'error');
                    }
                })
                .catch(function(){ Swal.fire('Error', 'Gagal menghapus soal.', 'error'); });
            });
        }
    });

    document.getElementById('btnPreviewToEdit').addEventListener('click', function() {
        if (currentPreviewSoalId) {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPreviewSoal')).hide();
            openEditModal(currentPreviewSoalId);
        }
    });

    function openEditModal(id) {
        var s = allSoal.find(function(x){ return x.id == id; });
        if (!s) return;

        document.getElementById('edit-id').value            = s.id;
        document.getElementById('edit-exam_id').value       = s.exam_id || '';
        document.getElementById('edit-subject_id').value    = s.subject_id || '';
        document.getElementById('edit-type').value          = s.type || 'multiple_choice';
        document.getElementById('edit-opsi_a').value        = s.opsi_a || (s.options && s.options['A']) || '';
        document.getElementById('edit-opsi_b').value        = s.opsi_b || (s.options && s.options['B']) || '';
        document.getElementById('edit-opsi_c').value        = s.opsi_c || (s.options && s.options['C']) || '';
        document.getElementById('edit-opsi_d').value        = s.opsi_d || (s.options && s.options['D']) || '';
        document.getElementById('edit-jawaban_benar').value = s.jawaban_benar || s.answer_key || '';

        toggleOpsiForm('edit', s.type || 'multiple_choice');

        var container = document.getElementById('edit-ck-container');
        var content   = s.pertanyaan || s.question_text || '';

        if (!editEditor) {
            container.innerHTML = '';
            ClassicEditor.create(container, CK_CONFIG)
            .then(function(editor) {
                editEditor = editor;
                editor.setData(content);
            });
        } else {
            editEditor.setData(content);
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditSoal')).show();
    }
});
</script>
@endpush
