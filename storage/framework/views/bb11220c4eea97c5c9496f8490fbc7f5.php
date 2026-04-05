<?php $__env->startSection('title', 'Data Soal'); ?>

<?php $__env->startPush('styles'); ?>

<style>
/* ── CKEditor custom styles ── */
.ck-editor__editable_inline {
    min-height: 120px;
    max-height: 220px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.875rem;
    color: var(--text-main);
    overflow-y: auto;
}
.ck.ck-toolbar {
    border-radius: 8px 8px 0 0 !important;
    border: 1.5px solid var(--border-color) !important;
    border-bottom: none !important;
    background: #f8faff !important;
    padding: 4px 6px !important;
    flex-wrap: wrap !important;
}
.ck.ck-editor__main > .ck-editor__editable {
    border-radius: 0 0 8px 8px !important;
    border: 1.5px solid var(--border-color) !important;
    border-top: none !important;
}
.ck.ck-editor__main > .ck-editor__editable:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1) !important;
}
.ck.ck-toolbar:has(~ .ck-editor__main .ck-editor__editable:focus) {
    border-color: var(--primary) !important;
}
/* Batch editor — smaller */
.batch-ck-editor .ck-editor__editable_inline {
    min-height: 70px !important;
    max-height: 140px !important;
}
/* RTL support (Arab) */
.ck-editor__editable[dir="rtl"] {
    text-align: right;
    direction: rtl;
    font-family: 'Amiri', 'Traditional Arabic', serif, 'Poppins';
}

/* ── Image Styles in CKEditor ── */
.ck-content .image-small {
    max-width: 300px;
    width: 100%;
}
.ck-content .image-medium {
    max-width: 500px;
    width: 100%;
}
.ck-content img {
    max-width: 100%;
    height: auto;
}
.batch-ck-editor img {
    max-width: 100%;
    height: auto;
}
/* RTL Toggle Button */
.btn-outline-secondary.active {
    background-color: #6f42c1;
    color: #fff;
    border-color: #6f42c1;
}
/* Image inline resize */
.batch-ck-editor figure img {
    max-width: 100%;
    height: auto;
}
/* Math LaTeX styling */
.latex-hint {
    background: rgba(111, 66, 193, 0.1);
    border: 1px dashed rgba(111, 66, 193, 0.3);
    color: #6f42c1;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 8px;
    display: flex;
    gap: 8px;
    align-items: center;
}

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
#modalBatchSoal .modal-dialog { max-height: 90vh; }
#modalBatchSoal .modal-content { max-height: 90vh; display: flex; flex-direction: column; }
#modalBatchSoal .modal-body { overflow-y: auto; flex: 1 1 auto; min-height: 0; }
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
.page-header h4 { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p  { font-size: 0.85rem; opacity: 0.85; margin: 0; }

/* ── Table card ── */
.table-card { background: #fff; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden; }
.table-card .table { margin: 0; font-size: 0.875rem; }
.table-card .table thead th { background: #f0f4ff; color: var(--text-main); font-weight: 600; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
.table-card .table tbody td { padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid rgba(13,110,253,0.05); color: var(--text-main); }
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr { transition: background 0.15s ease; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

/* ── Guru avatar ── */
.guru-avatar { width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.78rem; flex-shrink: 0; box-shadow: 0 2px 8px rgba(13,110,253,0.25); }

/* ── Mapel badge ── */
.badge-mapel { display: inline-flex; align-items: center; gap: 4px; background: rgba(13,110,253,0.08); color: var(--primary); font-size: 0.72rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }

/* ── Ujian pill ── */
.ujian-pill { display: inline-flex; align-items: center; gap: 5px; background: rgba(13,202,240,0.1); color: #0a9bba; border: 1px solid rgba(13,202,240,0.25); font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-decoration: none; margin: 2px 2px 0 0; transition: var(--transition); cursor: pointer; }
.ujian-pill:hover { background: var(--accent); color: #fff; border-color: var(--accent); transform: translateY(-1px); }

/* ── Action buttons ── */
.btn-act { display: inline-flex; align-items: center; gap: 5px; padding: 6px 11px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; border: none; cursor: pointer; transition: var(--transition); font-family: 'Poppins', sans-serif; white-space: nowrap; margin: 2px 2px 0 0; }
.btn-act-import  { background: rgba(32,201,151,0.12); color: #198754; }
.btn-act-import:hover  { background: #198754; color: #fff; transform: translateY(-1px); }
.btn-act-manual  { background: rgba(13,110,253,0.1);  color: var(--primary); }
.btn-act-manual:hover  { background: var(--primary);  color: #fff; transform: translateY(-1px); }
.btn-act-batch   { background: rgba(255,193,7,0.15);  color: #856404; }
.btn-act-batch:hover   { background: #ffc107; color: #000; transform: translateY(-1px); }
.btn-act-detail  { background: rgba(13,202,240,0.1);  color: #0a9bba; }
.btn-act-detail:hover  { background: var(--accent);   color: #fff; transform: translateY(-1px); }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 56px 24px; }
.empty-state .empty-icon { width: 72px; height: 72px; background: rgba(13,110,253,0.07); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--primary); margin-bottom: 16px; }
.empty-state h6 { font-weight: 700; color: var(--text-main); margin-bottom: 6px; }
.empty-state p  { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

/* ── Modal ── */
.modal-header-brand { background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; padding: 16px 20px; }
.modal-header-brand .modal-title { font-weight: 700; font-size: 1rem; }
.modal-header-brand .btn-close { filter: brightness(0) invert(1); opacity: 0.85; transition: transform 0.2s; }
.modal-header-brand .btn-close:hover { transform: rotate(90deg); opacity: 1; }
.modal-content { border-radius: 16px; overflow: visible; border: none; box-shadow: 0 20px 60px rgba(13,110,253,0.2); }
#modalBatchSoal .modal-header,
#modalImportSoal .modal-header,
#modalTambahSoal .modal-header { border-radius: 16px 16px 0 0; }
#modalBatchSoal .modal-footer,
#modalImportSoal .modal-footer,
#modalTambahSoal .modal-footer { border-radius: 0 0 16px 16px; }

/* ── Soal detail table ── */
.soal-table thead th { background: #f0f4ff; font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: var(--text-main); padding: 12px 14px; }
.soal-table tbody td { padding: 12px 14px; font-size: 0.85rem; vertical-align: middle; }
.soal-table tbody tr:hover { background: rgba(13,110,253,0.03); }
.soal-table .pertanyaan-cell img { max-width: 160px; max-height: 100px; border-radius: 6px; object-fit: contain; }
/* Math formula rendering */
.soal-table .pertanyaan-cell .math-tex { font-family: 'STIX Two Math', 'Latin Modern Math', serif; }

.badge-pg    { background: rgba(13,110,253,0.1);  color: var(--primary); font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.badge-essay { background: rgba(13,202,240,0.12); color: #0a9bba;        font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.badge-ans   { background: rgba(32,201,151,0.12); color: #198754;        font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; min-width: 30px; text-align: center; display: inline-block; }

/* ── Batch soal card ── */
.batch-soal-card { background: #f8faff; border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; margin-bottom: 12px; }
.batch-soal-card .batch-no { font-size: 0.75rem; font-weight: 700; color: var(--primary); background: rgba(13,110,253,0.08); padding: 3px 10px; border-radius: 20px; margin-bottom: 10px; display: inline-block; }

/* ── Rich text info badge ── */
.rich-text-hint { display: inline-flex; align-items: center; gap: 5px; background: rgba(13,110,253,0.06); border: 1px dashed rgba(13,110,253,0.25); color: var(--primary); font-size: 0.72rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; margin-bottom: 8px; }

/* ── Count badge ── */
.count-badge { display: inline-flex; align-items: center; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.35); color: #fff; font-size: 0.78rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; margin-left: 10px; }

/* ── Search ── */
.search-wrap { position: relative; max-width: 280px; }
.search-wrap i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 0.9rem; pointer-events: none; }
.search-wrap input { padding-left: 36px; border-radius: 50px; border: 1.5px solid var(--border-color); font-size: 0.875rem; height: 38px; transition: var(--transition); }
.search-wrap input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,110,253,0.1); }

/* ── CKEditor Math equation rendered output ── */
.ck-math-tex { display: inline-block; }

/* ── Image drag-to-resize styling ── */
.ck-editor__editable img {
    cursor: grab;
    transition: filter 0.2s ease;
}

.ck-editor__editable img:active {
    cursor: grabbing;
    filter: brightness(0.9);
}

.ck-editor__editable img[style*="width"],
.ck-editor__editable img[style*="max-width"] {
    resize: both;
    overflow: auto;
}

/* Math symbols button styling */
.ck-button-math-symbols { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.ck-button-math-symbols:hover { background: linear-gradient(135deg, #5568d3 0%, #694093 100%); }

/* Arabic mode button styling */
.ck-button-arabic-mode { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.ck-button-arabic-mode:hover { background: linear-gradient(135deg, #e67ff0 0%, #e44661 100%); }
.ck-button-arabic-mode.ck-on { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

/* RTL text styling dalam editor */
.ck-editor__editable[dir="rtl"] { direction: rtl; text-align: right; }

/* Image resize styling */
.ck-editor__editable img {
    transition: opacity 0.15s ease, outline 0.15s ease;
    cursor: grab;
}

.ck-editor__editable img:hover {
    cursor: grab;
}

.batch-ck-editor img {
    max-width: 100%;
    height: auto;
}

.batch-ck-editor img[data-drag-resize-enabled="true"] {
    cursor: grab;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('layoutContent'); ?>


<div class="page-header">
    <div class="page-header-content">
        <h4>
            <i class="bi bi-question-circle me-2"></i>Manajemen Soal Ujian
            <span class="count-badge" id="soal-count">0 mapel</span>
        </h4>
        <p>Tambah, import, dan kelola soal ujian — support gambar, Arab, rumus matematika, karakter khusus</p>
    </div>
</div>


<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchSoal" class="form-control" placeholder="Cari guru atau mata pelajaran...">
    </div>
    <div style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan <span id="soal-shown">0</span> baris
    </div>
</div>


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


<div class="modal fade" id="modalDetailSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalDetailSoalLabel"><i class="bi bi-list-ul me-2"></i>Detail Soal Ujian</h5>
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


<div class="modal fade" id="modalImportSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-file-earmark-arrow-up me-2"></i>Import Soal Excel/CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formImportSoal" enctype="multipart/form-data">
                <div class="modal-body p-4" style="overflow-y: auto; max-height: 65vh;">
                    <input type="hidden" id="importGuruId"  name="guru_id">
                    <input type="hidden" id="importMapelId" name="mapel_id">
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
                        <input type="file" class="form-control" id="fileSoal" name="file" accept=".xlsx,.xls,.csv" required>
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


<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Tambah Soal Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTambahSoal">
                <div class="modal-body p-4" style="overflow-y: auto; max-height: 72vh;">
                    <input type="hidden" id="manualGuruId"  name="guru_id">
                    <input type="hidden" id="manualMapelId" name="mapel_id">
                    <input type="hidden" id="manualPertanyaanHidden" name="pertanyaan">

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
                        <label class="form-label d-flex align-items-center justify-content-between">
                            <span>Pertanyaan</span>
                            <span class="rich-text-hint">
                                <i class="bi bi-file-richtext"></i>
                                Full editor — gambar, Arab, rumus, simbol
                            </span>
                        </label>
                        
                        <div id="manualPertanyaanEditor"></div>
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


<div class="modal fade" id="modalBatchSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title"><i class="bi bi-layers me-2"></i>Input Soal Batch (PG &amp; Essay)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBatchSoal">
                <div class="modal-body p-4" style="overflow-y: auto; max-height: 72vh;">
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
                            <input type="number" min="0" max="100" class="form-control" id="jumlahPG" value="20">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Soal Essay</label>
                            <input type="number" min="0" max="100" class="form-control" id="jumlahEssay" value="5">
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-start gap-2 py-2 px-3 mb-3" style="border-radius:10px;font-size:0.82rem;">
                        <i class="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                        <span>
                            Editor soal mendukung penuh: <strong>gambar</strong> (upload/embed URL),
                            <strong>bahasa Arab &amp; RTL</strong>, <strong>rumus matematika</strong> (LaTeX via toolbar Ω),
                            <strong>karakter khusus</strong>, tabel, subscript/superscript, dan format teks lengkap seperti Word.
                        </span>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/id.js"></script>
<!-- Simple Upload Adapter for image upload -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/plugins/simple-upload/simple-upload.js"></script>

<script>
    window.MathJax = {
        tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
        svg: { fontCache: 'global' },
        startup: { typeset: false }
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* ────────────────────────────────────────────
       Image Resize Handler - Enable drag to resize
    ──────────────────────────────────────────── */
    function enableImageResize(editorElement) {
        const images = editorElement.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('mousedown', function(e) {
                if (e.button !== 0) return; // Hanya left click
                
                const startX = e.clientX;
                const startWidth = img.width;
                
                function onMouseMove(e) {
                    const deltaX = e.clientX - startX;
                    const newWidth = Math.max(50, startWidth + deltaX);
                    img.style.width = newWidth + 'px';
                    img.style.height = 'auto';
                }
                
                function onMouseUp() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }
                
                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
                e.preventDefault();
            });
        });
    }

    var csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var allGurus   = [];
    var allMapels  = [];
    var allUjians  = [];
    var allRows    = [];

    /* Custom Math Symbols Plugin - Insert simbol matematika */
    /* Formula templates - pre-made formulas */
    function showFormulaTemplates(editorInstance) {
        try {
            const templates = [
                // IDENTITAS TRIGONOMETRI (KOMPLEKS)
                { name: '🔷 Identitas Pythagoras', latex: '$$\\sin^2 x + \\cos^2 x = 1$$' },
                { name: '🔷 Hubungan tan dan sin/cos', latex: '$$\\tan x = \\frac{\\sin x}{\\cos x}$$' },
                { name: '🔷 Cot Relation', latex: '$$\\cot x = \\frac{\\cos x}{\\sin x}$$' },
                { name: '🔷 Identitas Sec-Tan', latex: '$$1 + \\tan^2 x = \\sec^2 x$$' },
                { name: '🔷 Identitas Csc-Cot', latex: '$$1 + \\cot^2 x = \\csc^2 x$$' },
                
                // JARAK & GEOMETRI (KOMPLEKS)
                { name: '📐 Rumus Jarak 2 Titik', latex: '$$d = \\sqrt{(x_1 - x_2)^2 + (y_1 - y_2)^2}$$' },
                { name: '📐 Rumus Jarak 3D', latex: '$$d = \\sqrt{(x_1 - x_2)^2 + (y_1 - y_2)^2 + (z_1 - z_2)^2}$$' },
                { name: '📐 Midpoint 2D', latex: '$$M = \\left(\\frac{x_1 + x_2}{2}, \\frac{y_1 + y_2}{2}\\right)$$' },
                { name: '📐 Gradient/Slope', latex: '$$m = \\frac{y_2 - y_1}{x_2 - x_1}$$' },
                
                // PERSAMAAN KUADRAT (KOMPLEKS)
                { name: '✖️ Persamaan Kuadrat Standar', latex: '$$ax^2 + bx + c = 0$$' },
                { name: '✖️ Rumus ABC Lengkap', latex: '$$x = \\frac{-b \\pm \\sqrt{b^2-4ac}}{2a}$$' },
                { name: '✖️ Rumus ABC (+)', latex: '$$x_1 = \\frac{-b + \\sqrt{b^2-4ac}}{2a}$$' },
                { name: '✖️ Rumus ABC (-)', latex: '$$x_2 = \\frac{-b - \\sqrt{b^2-4ac}}{2a}$$' },
                { name: '✖️ Diskriminan', latex: '$$\\Delta = b^2 - 4ac$$' },
                
                // Akar dan Pangkat
                { name: '🔹 Akar Kuadrat', latex: '$$\\sqrt{x}$$' },
                { name: '🔹 Akar Pangkat 3', latex: '$$\\sqrt[3]{x}$$' },
                { name: '🔹 Akar Pangkat n', latex: '$$\\sqrt[n]{x}$$' },
                { name: '🔹 Pangkat Umum', latex: '$$x^n$$' },
                
                // Pecahan (KOMPLEKS)
                { name: '📊 Pecahan Dasar', latex: '$$\\frac{a}{b}$$' },
                { name: '📊 Pecahan Kompleks', latex: '$$\\frac{a + b}{c - d}$$' },
                { name: '📊 Pecahan 3 Tingkat', latex: '$$\\frac{\\frac{a}{b}}{c}$$' },
                { name: '📊 Pecahan Turunan', latex: '$$\\frac{d}{dx}\\left(\\frac{u}{v}\\right) = \\frac{v\\frac{du}{dx} - u\\frac{dv}{dx}}{v^2}$$' },
                
                // KALKULUS (KOMPLEKS)
                { name: '∫ Integral Tentu', latex: '$$\\int_a^b f(x)\\,dx$$' },
                { name: '∫ Integral Tak Tentu', latex: '$$\\int f(x)\\,dx$$' },
                { name: '∫ Integral Substitusi', latex: '$$\\int f(g(x))g\'(x)\\,dx = \\int f(u)\\,du$$' },
                { name: 'd/dx Turunan Pertama', latex: '$$\\frac{df}{dx}$$' },
                { name: 'd²/dx² Turunan Kedua', latex: '$$\\frac{d^2f}{dx^2}$$' },
                { name: '→ Limit Tak Hingga', latex: '$$\\lim_{x \\to \\infty} f(x)$$' },
                { name: '→ Limit ke Titik', latex: '$$\\lim_{x \\to a} f(x) = L$$' },
                { name: '∂/∂x Turunan Parsial', latex: '$$\\frac{\\partial f}{\\partial x}$$' },
                
                // Sigma dan Produk (KOMPLEKS)
                { name: 'Σ Penjumlahan Sigma', latex: '$$\\sum_{i=1}^{n} a_i$$' },
                { name: 'Σ Sigma Range', latex: '$$\\sum_{i=m}^{n} (i^2 + 3i)$$' },
                { name: 'Π Produk (Perkalian)', latex: '$$\\prod_{i=1}^{n} a_i$$' },
                
                // LOGARITMA (KOMPLEKS)
                { name: 'log Logaritma Basis', latex: '$$\\log_a(x)$$' },
                { name: 'ln Logaritma Natural', latex: '$$\\ln(x)$$' },
                { name: '🔄 Konversi Log', latex: '$$\\log_a(x) = \\frac{\\log_b(x)}{\\log_b(a)}$$' },
                { name: '🔄 Log Sifat Hasil Bagi', latex: '$$\\log_a\\left(\\frac{x}{y}\\right) = \\log_a(x) - \\log_a(y)$$' },
                { name: '🔄 Log Sifat Eksponen', latex: '$$\\log_a(x^n) = n\\log_a(x)$$' },
                
                // Operasi Dasar
                { name: '⚙️ Perkalian', latex: '$$a \\times b$$' },
                { name: '⚙️ Pembagian', latex: '$$a \\div b = \\frac{a}{b}$$' },
                { name: '⚙️ Lebih Besar Sama', latex: '$$a \\geq b$$' },
                { name: '⚙️ Lebih Kecil Sama', latex: '$$a \\leq b$$' },
                { name: '⚙️ Tidak Sama', latex: '$$a \\neq b$$' },
                { name: '⚙️ Plus-Minus', latex: '$$a \\pm b$$' },
                
                // MATRIKS (KOMPLEKS)
                { name: '📦 Matriks 2x2', latex: '$$\\begin{pmatrix} a & b \\\\ c & d \\end{pmatrix}$$' },
                { name: '📦 Matriks 3x3', latex: '$$\\begin{pmatrix} a & b & c \\\\ d & e & f \\\\ g & h & i \\end{pmatrix}$$' },
                { name: '📦 Determinan 2x2', latex: '$$\\det\\begin{pmatrix} a & b \\\\ c & d \\end{pmatrix} = ad - bc$$' },
                { name: '📦 Perkalian Matriks', latex: '$$\\begin{pmatrix} a & b \\\\ c & d \\end{pmatrix}\\begin{pmatrix} x \\\\ y \\end{pmatrix} = \\begin{pmatrix} ax+by \\\\ cx+dy \\end{pmatrix}$$' },
                
                // Sistem Persamaan (KOMPLEKS)
                { name: '🔗 Sistem 2 Persamaan', latex: '$$\\begin{cases} ax + by = c \\\\ dx + ey = f \\end{cases}$$' },
                { name: '🔗 Sistem 3 Persamaan', latex: '$$\\begin{cases} a_1x + b_1y + c_1z = d_1 \\\\ a_2x + b_2y + c_2z = d_2 \\\\ a_3x + b_3y + c_3z = d_3 \\end{cases}$$' },
                
                // Nilai Mutlak (KOMPLEKS)
                { name: '|x| Nilai Mutlak Definisi', latex: '$$|x| = \\begin{cases} x, & x \\geq 0 \\\\ -x, & x < 0 \\end{cases}$$' },
                { name: '|x| Sifat Jarak', latex: '$$|x - a| = r \\Rightarrow x = a \\pm r$$' },
                
                // Kombinatorika (KOMPLEKS)
                { name: '🎲 Kombinasi', latex: '$$C(n,k) = \\binom{n}{k} = \\frac{n!}{k!(n-k)!}$$' },
                { name: '🎲 Permutasi', latex: '$$P(n,k) = \\frac{n!}{(n-k)!}$$' },
                { name: '🎲 Binomial Expansion', latex: '$$(a+b)^n = \\sum_{k=0}^{n} \\binom{n}{k} a^{n-k}b^k$$' },
                
                // Konstanta Matematika
                { name: '🎯 Pi (π)', latex: '$$\\pi \\approx 3.14159$$' },
                { name: '🎯 Theta (θ)', latex: '$$\\theta$$' },
                { name: '🎯 Alpha (α)', latex: '$$\\alpha$$' },
                { name: '🎯 Beta (β)', latex: '$$\\beta$$' },
                { name: '🎯 Gamma (γ)', latex: '$$\\gamma$$' },
                { name: '🎯 Delta (δ)', latex: '$$\\delta$$' },
                { name: '🎯 Epsilon (ε)', latex: '$$\\varepsilon$$' },
                { name: '🎯 Lambda (λ)', latex: '$$\\lambda$$' },
                { name: '🎯 Phi (φ)', latex: '$$\\phi$$' },
                { name: '🎯 Psi (ψ)', latex: '$$\\psi$$' },
                { name: '🎯 Omega (ω)', latex: '$$\\omega$$' },
                { name: '🎯 e (Euler)', latex: '$$e \\approx 2.71828$$' },
                { name: '🎯 Infinity (∞)', latex: '$$\\infty$$' },
            ];
            
            let html = '<div style="max-height:500px;overflow-y:auto;padding:10px;min-width:450px;">';
            html += '<div style="padding-bottom:10px;border-bottom:2px solid #198754;margin-bottom:10px;"><strong style="color:#198754;">📐 Template Rumus (Klik untuk insert)</strong></div>';
            
            templates.forEach(t => {
                html += `<button class="formula-template" data-latex="${t.latex.replace(/"/g, '&quot;')}" style="display:block;width:100%;text-align:left;padding:12px;margin:6px 0;border:1px solid #ddd;border-radius:4px;background:#f9f9f9;cursor:pointer;transition:0.2s;font-size:13px;line-height:1.6;" title="Click untuk insert"><div style="font-weight:600;color:#333;margin-bottom:6px;">${t.name}</div><div style="font-size:16px;padding:8px;background:white;border-radius:3px;font-family:serif;color:#000;">${t.latex}</div></button>`;
            });
            html += '</div>';
            
            const popup = document.createElement('div');
            popup.innerHTML = html;
            popup.style.cssText = 'position:fixed;z-index:99999;background:white;border:2px solid #198754;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.25);max-width:500px;';
            document.body.appendChild(popup);
            
            // Center position
            popup.style.top = '50%';
            popup.style.left = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
            
            // Render formulas with MathJax
            if (window.MathJax && window.MathJax.typesetPromise) {
                window.MathJax.typesetPromise([popup]).catch(err => console.log('MathJax render error:', err));
            }
            
            popup.querySelectorAll('.formula-template').forEach(btn => {
                btn.onmouseover = function() { 
                    this.style.background = '#e8f5e9';
                    this.style.borderColor = '#198754';
                    this.style.boxShadow = '0 2px 8px rgba(25, 135, 84, 0.2)';
                };
                btn.onmouseout = function() { 
                    this.style.background = '#f9f9f9';
                    this.style.borderColor = '#ddd';
                    this.style.boxShadow = 'none';
                };
                btn.onclick = function(e) {
                    e.stopPropagation();
                    try {
                        const latex = this.getAttribute('data-latex');
                        if (editorInstance && editorInstance.model) {
                            // Insert formula as text with proper delimiters
                            editorInstance.model.change(writer => {
                                // Insert as-is (with $$ delimiters for display mode)
                                writer.insertText(latex, editorInstance.model.document.selection.getFirstPosition());
                            });
                            
                            // Trigger MathJax render after insert
                            setTimeout(function() {
                                if (window.MathJax && window.MathJax.typesetPromise) {
                                    window.MathJax.typesetPromise().catch(err => {});
                                }
                            }, 50);
                        }
                    } catch (e) {
                        console.error('Formula insert error:', e);
                    }
                    if (popup.parentNode) document.body.removeChild(popup);
                };
            });
            
            const closePopup = (e) => {
                if (e.key === 'Escape' || (!popup.contains(e.target) && e.target.className !== 'formula-template')) {
                    if (popup.parentNode) document.body.removeChild(popup);
                    document.removeEventListener('click', closePopup);
                    document.removeEventListener('keydown', closePopup);
                }
            };
            setTimeout(() => {
                document.addEventListener('click', closePopup);
                document.addEventListener('keydown', closePopup);
            }, 100);
        } catch (e) {
            console.error('Formula templates error:', e);
        }
    }

    /* Helper: Show math symbols picker */
    function showMathSymbols(editorInstance) {
        try {
            const symbols = ['∑', '∫', '√', '∛', '±', '×', '÷', '≈', '≠', '≤', '≥', '∞', '°', 'π', 'θ', 'α', 'β', 'γ', 'δ', 'λ', '→', '←'];
            let html = '<div style="display:grid;grid-template-columns:repeat(6,45px);gap:6px;padding:10px;">';
            symbols.forEach(s => html += `<button class="math-sym" data-sym="${s}" style="width:45px;height:45px;border:1px solid #ddd;border-radius:4px;cursor:pointer;font-size:20px;background:#f5f5f5;transition:0.2s;font-weight:bold;">${s}</button>`);
            html += '</div>';
            
            const popup = document.createElement('div');
            popup.innerHTML = html;
            popup.style.cssText = 'position:fixed;z-index:99999;background:white;border:2px solid #0d6efd;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.2);max-width:320px;';
            document.body.appendChild(popup);
            
            // Position popup di tengah window
            const rect = popup.getBoundingClientRect();
            popup.style.top = '50%';
            popup.style.left = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
            
            popup.querySelectorAll('.math-sym').forEach(btn => {
                btn.onmouseover = () => { btn.style.background = '#e3f2fd'; btn.style.borderColor = '#0d6efd'; };
                btn.onmouseout = () => { btn.style.background = '#f5f5f5'; btn.style.borderColor = '#ddd'; };
                btn.onclick = function(e) {
                    e.stopPropagation();
                    try {
                        if (editorInstance && editorInstance.model) {
                            editorInstance.model.change(writer => {
                                writer.insertText(this.dataset.sym, editorInstance.model.document.selection.getFirstPosition());
                            });
                        }
                    } catch (e) {
                        console.error('Symbol insert error:', e);
                    }
                    if (popup.parentNode) document.body.removeChild(popup);
                };
            });
            
            // Close on ESC or outside click
            const closePopup = (e) => {
                if (e.key === 'Escape' || (!popup.contains(e.target) && e.target.className !== 'math-sym')) {
                    if (popup.parentNode) document.body.removeChild(popup);
                    document.removeEventListener('click', closePopup);
                    document.removeEventListener('keydown', closePopup);
                }
            };
            setTimeout(() => {
                document.addEventListener('click', closePopup);
                document.addEventListener('keydown', closePopup);
            }, 100);
        } catch (e) {
            console.error('Math symbols error:', e);
        }
    }

    class CustomUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);
                fetch('/admin/upload-image', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: data
                })
                .then(r => r.json())
                .then(data => {
                    if (data.url) {
                        resolve({ default: data.url });
                    } else {
                        reject('Upload failed');
                    }
                })
                .catch(err => reject(err));
            }));
        }
        abort() {}
    }
    
    function CustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new CustomUploadAdapter(loader);
        };
    }

    /* ─────────────────────────────────────────────────────────
       CKEditor 5 CONFIG
    ────────────────────────────────────────────────────────── */
    var CK_CONFIG_FULL = {
        language: 'id',
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'numberedList', 'bulletedList', 'indent', 'outdent', '|',
                'link', 'imageUpload', 'insertTable', 'blockQuote', 'horizontalLine', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        image: {
            toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'],
            styles: [
                'inline',
                'block',
                'side',
                {
                    name: 'small',
                    title: 'Kecil',
                    icon: '<svg viewBox="0 0 10 10" preserveAspectRatio="xMidYMid meet"><rect x="0" y="0" width="8" height="8" fill="#36c"/></svg>',
                    modelElements: ['imageBlock', 'imageInline'],
                    converterPriority: 'high',
                    className: 'image-small'
                },
                {
                    name: 'medium',
                    title: 'Sedang',
                    icon: '<svg viewBox="0 0 10 10" preserveAspectRatio="xMidYMid meet"><rect x="0" y="0" width="10" height="10" fill="#36c"/></svg>',
                    modelElements: ['imageBlock', 'imageInline'],
                    converterPriority: 'high',
                    className: 'image-medium'
                }
            ],
            upload: {
                types: ['jpeg', 'png', 'gif', 'webp', 'svg+xml']
            },
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    label: '100%',
                    value: null
                },
                {
                    name: 'resizeImage:50',
                    label: '50%',
                    value: '50'
                },
                {
                    name: 'resizeImage:75',
                    label: '75%',
                    value: '75'
                }
            ],
            resizeUnit: '%'
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableCellProperties', 'tableProperties']
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Judul 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Judul 3', class: 'ck-heading_heading3' },
            ]
        },
        language: {
            ui: 'id',
            content: 'id'
        },
        extraPlugins: [CustomUploadAdapterPlugin]
    };

    /* Config untuk batch soal editor */
    var CK_CONFIG_COMPACT = {
        language: 'id',
        toolbar: {
            items: [
                'bold', 'italic', '|',
                'numberedList', 'bulletedList', 'indent', 'outdent', '|',
                'link', 'imageUpload', 'insertTable', 'blockQuote', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        image: {
            toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'],
            styles: {
                options: [
                    { name: 'inline', icon: 'object-inline', title: 'Inline' },
                    { name: 'block', icon: 'object-block', title: 'Block' },
                    { name: 'side', icon: 'object-right', title: 'Side' }
                ]
            },
            upload: { types: ['jpeg', 'png', 'gif', 'webp'] }
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Judul 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Judul 3', class: 'ck-heading_heading3' },
            ]
        },
        language: {
            ui: 'id',
            content: 'id'
        },
        extraPlugins: [CustomUploadAdapterPlugin]
    };

    /* ────────────────────────────────────────────
       Instance CKEditor Manual (1 instance)
    ──────────────────────────────────────────── */
    var ckManual = null;

    function initCKManual() {
        if (ckManual) return;
        ClassicEditor
            .create(document.getElementById('manualPertanyaanEditor'), CK_CONFIG_FULL)
            .then(function(editor) {
                ckManual = editor;
                /* Tambahkan tombol RTL/LTR manual di bawah editor untuk kemudahan bahasa Arab */
                addRtlToggle(editor, document.getElementById('manualPertanyaanEditor').parentNode);
            })
            .catch(function(err) { console.error('CKEditor manual init error:', err); });
    }

    /* Destroy & re-init saat modal dibuka */
    document.getElementById('modalTambahSoal').addEventListener('shown.bs.modal', function () {
        if (ckManual) {
            ckManual.setData('');
        } else {
            initCKManual();
        }
    });
    document.getElementById('modalTambahSoal').addEventListener('hidden.bs.modal', function () {
        /* Biarkan instance hidup untuk reuse */
    });

    /* ── RTL Toggle Helper ── */
    function addRtlToggle(editor, container) {
        var wrapper = document.createElement('div');
        wrapper.style.cssText = 'margin-top:4px; text-align:right;';
        wrapper.innerHTML =
            '<button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:0.72rem;" ' +
            'title="Toggle arah teks (untuk bahasa Arab/RTL)">' +
            '<i class="bi bi-arrow-left-right me-1"></i>Toggle RTL/LTR' +
            '</button>';
        wrapper.querySelector('button').addEventListener('click', function() {
            var editable = editor.editing.view.document.getRoot();
            var isRtl    = editable.getCustomProperty('dir') === 'rtl';
            editor.editing.view.change(function(writer) {
                writer.setAttribute('dir', isRtl ? 'ltr' : 'rtl', editable);
            });
        });
        container.appendChild(wrapper);
    }

    /* ────────────────────────────────────────────
       Map: index → CKEditor instance (batch)
    ──────────────────────────────────────────── */
    var batchCKEditors = {};

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

                var ujianHtml = '<span style="color:#ccc;font-size:0.8rem;">Belum ada ujian</span>';
                if (mapelUjians.length > 0) {
                    ujianHtml = mapelUjians.map(function(u) {
                        return '<span class="ujian-pill link-ujian" data-ujian="' + u.id + '" data-ujian-nama="' + (u.nama || '') + '">' +
                               '<i class="bi bi-file-earmark-text"></i>' + (u.nama || '-') + '</span>';
                    }).join('');
                }

                var detailBtns = '';
                if (mapelUjians.length > 0) {
                    detailBtns = mapelUjians.map(function(u) {
                        return '<a class="btn-act btn-act-detail" href="/admin/ujian/' + u.id + '/detail">' +
                               '<i class="bi bi-eye"></i> ' + (u.nama || 'Detail') + '</a>';
                    }).join('');
                }

                allRows.push({ guruName: guru.name || '', mapelName: mapel.name || '' });

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

        var pill = e.target.closest('.link-ujian');
        if (pill) {
            openDetailSoal(pill.getAttribute('data-ujian'), pill.getAttribute('data-ujian-nama'));
            return;
        }

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

        var btnBatch = e.target.closest('.btn-batch-input');
        if (btnBatch) {
            /* Destroy semua CKEditor batch sebelumnya */
            destroyAllBatchEditors().then(function() {
                batchCKEditors = {};
                document.getElementById('batchGuruId').value  = btnBatch.getAttribute('data-guru');
                document.getElementById('batchMapelId').value = btnBatch.getAttribute('data-mapel');
                document.getElementById('batchUjianSelect').innerHTML = ujianOptions(btnBatch.getAttribute('data-mapel'));
                document.getElementById('jumlahPG').value    = 20;
                document.getElementById('jumlahEssay').value = 5;
                renderBatchFields();
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBatchSoal')).show();
            });
            return;
        }
    });

    /* Destroy all batch editors safely */
    function destroyAllBatchEditors() {
        var promises = Object.keys(batchCKEditors).map(function(k) {
            return batchCKEditors[k] ? batchCKEditors[k].destroy().catch(function(){}) : Promise.resolve();
        });
        return Promise.all(promises);
    }

    /* ── Detail Soal modal ── */
    function openDetailSoal(ujianId, ujianNama) {
        var content = document.getElementById('detailSoalContent');
        document.getElementById('modalDetailSoalLabel').innerHTML = '<i class="bi bi-list-ul me-2"></i>' + ujianNama;
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
                '<thead><tr><th style="width:48px;">No</th><th>Pertanyaan</th><th style="width:80px;">Tipe</th><th style="width:90px;text-align:center;">Jawaban</th><th style="width:70px;text-align:center;">Hapus</th></tr></thead><tbody>';
            data.forEach(function(soal, i) {
                var tipe = soal.opsi_a ? 'PG' : 'Essay';
                var tipeBadge = tipe === 'PG' ? '<span class="badge-pg">PG</span>' : '<span class="badge-essay">Essay</span>';
                var jawaban   = soal.jawaban_benar ? '<span class="badge-ans">' + soal.jawaban_benar + '</span>' : '<span style="color:#ccc;">—</span>';
                html += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td style="max-width:360px;word-break:break-word;" class="pertanyaan-cell">' + soal.pertanyaan + '</td>' +
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

            /* Re-render MathJax untuk rumus di dalam soal */
            if (window.MathJax && MathJax.typesetPromise) {
                MathJax.typesetPromise([content]);
            }
        })
        .catch(function() {
            content.innerHTML = '<div class="empty-state"><div class="empty-icon" style="background:rgba(220,53,69,.1);color:#dc3545;"><i class="bi bi-exclamation-circle"></i></div><h6>Gagal memuat soal</h6></div>';
        });
    }

    /* ── Delete soal inside modal ── */
    document.getElementById('detailSoalContent').addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-delete-soal');
        if (!btn) return;

        var soalId    = btn.getAttribute('data-id');
        var ujianId   = btn.getAttribute('data-ujian');
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
                openDetailSoal(ujianId, ujianNama);
            })
            .catch(function() { Swal.fire('Error', 'Gagal menghapus soal.', 'error'); });
        });
    });

    /* ── Batch input fields render ── */
    function renderBatchFields() {
        /* Destroy semua editor lama dulu */
        destroyAllBatchEditors().then(function() {
            batchCKEditors = {};
            _doBuildBatchHtml();
        });
    }

    function _doBuildBatchHtml() {
        var pg    = parseInt(document.getElementById('jumlahPG').value)    || 0;
        var essay = parseInt(document.getElementById('jumlahEssay').value) || 0;
        var html  = '';

        if (pg > 0) {
            html += '<h6 class="mb-3 fw-bold" style="color:var(--primary);"><i class="bi bi-list-check me-2"></i>Soal Pilihan Ganda (' + pg + ' soal)</h6>';
            for (var i = 0; i < pg; i++) {
                html += '<div class="batch-soal-card">' +
                    '<span class="batch-no">PG #' + (i + 1) + '</span>' +
                    '<input type="hidden" name="soal[' + i + '][tipe]" value="pg">' +
                    '<input type="hidden" class="batch-pertanyaan-hidden" name="soal[' + i + '][pertanyaan]" id="batchPertanyaan_' + i + '">' +
                    '<div class="mb-2">' +
                        '<label class="form-label d-flex align-items-center justify-content-between mb-1" style="font-size:0.8rem;">' +
                            '<span>Pertanyaan</span>' +
                            '<span class="rich-text-hint"><i class="bi bi-file-richtext"></i>Gambar, Arab, Rumus, Simbol</span>' +
                        '</label>' +
                        '<div class="latex-hint" style="display:none;" id="latexHint_' + i + '">' +
                            '<i class="bi bi-function"></i>' +
                            '<span>Rumus: Ketik <code style="background:#fff;padding:2px 4px;border-radius:3px;">$x^2 + y^2 = z^2$</code> untuk LaTeX</span>' +
                        '</div>' +
                        '<div class="batch-ck-editor" id="batchEditor_' + i + '"></div>' +
                    '</div>' +
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
                    '<input type="hidden" class="batch-pertanyaan-hidden" name="soal[' + j + '][pertanyaan]" id="batchPertanyaan_' + j + '">' +
                    '<label class="form-label d-flex align-items-center justify-content-between mb-1" style="font-size:0.8rem;">' +
                        '<span>Pertanyaan Essay</span>' +
                        '<span class="rich-text-hint" style="border-color:rgba(13,202,240,.3);color:#0a9bba;background:rgba(13,202,240,.06);"><i class="bi bi-file-richtext"></i>Gambar, Arab, Rumus, Simbol</span>' +
                    '</label>' +
                    '<div class="latex-hint" style="display:none;" id="latexHint_' + j + '">' +
                        '<i class="bi bi-function"></i>' +
                        '<span>Rumus: Ketik <code style="background:#fff;padding:2px 4px;border-radius:3px;">$x^2 + y^2 = z^2$</code> untuk LaTeX</span>' +
                    '</div>' +
                    '<div class="batch-ck-editor" id="batchEditor_' + j + '"></div>' +
                '</div>';
            }
        }

        var container = document.getElementById('batchInputContainer');
        container.innerHTML = html || '<div class="text-muted text-center py-3">Set jumlah soal PG atau Essay di atas untuk mulai input.</div>';

        /* Init CKEditor untuk setiap soal setelah DOM ready */
        var totalSoal = pg + essay;
        var initChain = Promise.resolve();

        for (var k = 0; k < totalSoal; k++) {
            /* IIFE agar k tidak berubah */
            (function(idx) {
                initChain = initChain.then(function() {
                    var el = document.getElementById('batchEditor_' + idx);
                    if (!el) return Promise.resolve();
                    return ClassicEditor.create(el, CK_CONFIG_COMPACT)
                        .then(function(editor) {
                            batchCKEditors[idx] = editor;
                            // Tambahkan RTL toggle button untuk Arabic support
                            addRtlToggleToBatchEditor(editor, el.parentNode, idx);
                        })
                        .catch(function(err) { console.error('Batch CKEditor ' + idx + ' error:', err); });
                });
            })(k);
        }
    }

    /* RTL Toggle untuk Batch Editor */
    function addRtlToggleToBatchEditor(editor, container, idx) {
        var wrapper = document.createElement('div');
        wrapper.style.cssText = 'margin-top:4px; display:flex; gap:6px; align-items:center; flex-wrap:wrap;';
        wrapper.innerHTML = 
            '<button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:0.72rem;" ' +
            'id="rtlBtn_' + idx + '" title="Toggle RTL untuk bahasa Arab">' +
            '<i class="bi bi-arrow-left-right me-1"></i>RTL/LTR' +
            '</button>' +
            '<button type="button" class="btn btn-sm btn-outline-warning py-0 px-2" style="font-size:0.72rem;" ' +
            'id="mathBtn_' + idx + '" title="Insert simbol matematika">' +
            '<i class="bi bi-function me-1"></i>∑ Simbol' +
            '</button>' +
            '<button type="button" class="btn btn-sm btn-outline-success py-0 px-2" style="font-size:0.72rem;" ' +
            'id="formulaTemplateBtn_' + idx + '" title="Insert template rumus">' +
            '<i class="bi bi-calculator me-1"></i>📐 Rumus' +
            '</button>' +
            '<button type="button" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size:0.72rem;" ' +
            'id="formulaBtn_' + idx + '" title="Tampilkan bantuan rumus LaTeX">' +
            '<i class="bi bi-lightbulb me-1"></i>Bantuan' +
            '</button>' +
            '<small style="color:#999; font-size:0.7rem; flex-basis:100%;">RTL=Arab | ∑=Simbol | 📐=Rumus | Bantuan=LaTeX | 📏Gambar=Klik untuk pilih ukuran</small>';
        
        // Store RTL state
        var isRtlMode = false;
        
        wrapper.querySelector('#rtlBtn_' + idx).addEventListener('click', function(e) {
            e.preventDefault();
            try {
                // Toggle state
                isRtlMode = !isRtlMode;
                
                // Update editor
                if (editor && editor.editing && editor.editing.view) {
                    var editable = editor.editing.view.document.getRoot();
                    if (editable) {
                        editor.editing.view.change(function(writer) {
                            if (isRtlMode) {
                                writer.setAttribute('dir', 'rtl', editable);
                                writer.setAttribute('lang', 'ar', editable);
                            } else {
                                writer.removeAttribute('dir', editable);
                                writer.removeAttribute('lang', editable);
                            }
                        });
                    }
                }
                
                // Update button appearance
                var btn = wrapper.querySelector('#rtlBtn_' + idx);
                if (isRtlMode) {
                    btn.classList.add('active');
                    btn.innerHTML = '<i class="bi bi-arrow-right-left me-1"></i>RTL (ON)';
                    btn.style.background = 'rgba(13,110,253,0.2)';
                } else {
                    btn.classList.remove('active');
                    btn.innerHTML = '<i class="bi bi-arrow-left-right me-1"></i>RTL/LTR';
                    btn.style.background = '';
                }
            } catch (err) {
                console.warn('RTL toggle error:', err);
                isRtlMode = !isRtlMode; // Revert on error
            }
        });
        
        wrapper.querySelector('#mathBtn_' + idx).addEventListener('click', function(e) {
            e.preventDefault();
            if (editor && editor.model) {
                showMathSymbols(editor);
            }
        });
        
        wrapper.querySelector('#formulaTemplateBtn_' + idx).addEventListener('click', function(e) {
            e.preventDefault();
            if (editor && editor.model) {
                showFormulaTemplates(editor);
            }
        });
        
        wrapper.querySelector('#formulaBtn_' + idx).addEventListener('click', function(e) {
            e.preventDefault();
            var hint = document.getElementById('latexHint_' + idx);
            if (hint) {
                hint.style.display = hint.style.display === 'none' ? 'flex' : 'none';
            }
        });
        
        container.appendChild(wrapper);
        
        // Enable image resize for batch editor - multiple triggers
        function attachImageResizers() {
            var editorContent = document.querySelector('#batchEditor_' + idx + ' .ck-editor__editable');
            if (editorContent) {
                var images = editorContent.querySelectorAll('img:not([data-drag-resize-enabled="true"])');
                if (images.length > 0) {
                    enableImageDragResize(images);
                }
            }
        }
        
        // Initial attach (wait for editor to load)
        setTimeout(attachImageResizers, 300);
        setTimeout(attachImageResizers, 600);
        setTimeout(attachImageResizers, 1000);
        
        // Listen to content changes
        if (editor && editor.model && editor.model.document) {
            editor.model.document.on('change:data', function() {
                setTimeout(attachImageResizers, 50);
                
                // Auto-render MathJax when content changes
                setTimeout(function() {
                    if (window.MathJax && window.MathJax.typesetPromise) {
                        window.MathJax.typesetPromise().catch(err => {});
                    }
                }, 150);
            });
            
            // Also trigger on element insertion
            editor.editing.view.on('contentDom', function() {
                setTimeout(attachImageResizers, 50);
            });
        }
        
        // Fallback: Check every time editor gets focus
        var editableElement = document.querySelector('#batchEditor_' + idx + ' .ck-editor__editable');
        if (editableElement) {
            editableElement.addEventListener('click', function() {
                setTimeout(attachImageResizers, 50);
            }, true);
            
            editableElement.addEventListener('drop', function() {
                setTimeout(attachImageResizers, 100);
            }, true);
            
            editableElement.addEventListener('paste', function() {
                setTimeout(attachImageResizers, 100);
            }, true);
        }
    }
    
    /* Enable image resize via selection - reliable method */
    function enableImageDragResize(images) {
        images.forEach(function(img) {
            if (img.dataset.resizeEnabled) return;
            img.dataset.resizeEnabled = 'true';
            
            // Set up double-click to resize
            img.addEventListener('dblclick', function(e) {
                showImageResizeModal(this);
            }, false);
            
            // Visual feedback
            img.style.cursor = 'pointer';
            img.addEventListener('mouseenter', function() {
                this.style.border = '2px solid #FF6F00';
                this.style.boxShadow = '0 0 8px rgba(255, 111, 0, 0.4)';
            });
            
            img.addEventListener('mouseleave', function() {
                this.style.border = '2px solid transparent';
                this.style.boxShadow = 'none';
            });
        });
    }
    
    /* Show image resize modal */
    function showImageResizeModal(img) {
        var currentWidth = img.offsetWidth || img.naturalWidth || 300;
        var originalWidth = img.naturalWidth || 500;
        
        // Create custom modal/popup
        var modal = document.createElement('div');
        modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 99999; display: flex; align-items: center; justify-content: center;';
        
        var content = document.createElement('div');
        content.style.cssText = 'background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); min-width: 350px; text-align: center;';
        
        // Title
        var title = document.createElement('h5');
        title.textContent = '📏 Pilih Ukuran Gambar';
        title.style.cssText = 'margin: 0 0 20px 0; color: #333; font-weight: 600;';
        content.appendChild(title);
        
        // Current size display
        var currentDisplay = document.createElement('p');
        currentDisplay.textContent = 'Ukuran saat ini: ' + Math.round(currentWidth) + 'px';
        currentDisplay.style.cssText = 'color: #666; font-size: 13px; margin: 0 0 15px 0;';
        content.appendChild(currentDisplay);
        
        // Button container
        var buttonContainer = document.createElement('div');
        buttonContainer.style.cssText = 'display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;';
        
        // Size options
        var sizes = [
            { label: '📱 Kecil', width: 250, color: '#FF6B6B' },
            { label: '📄 Sedang', width: 400, color: '#4ECDC4' },
            { label: '📺 Besar', width: 600, color: '#45B7D1' },
            { label: '📸 Original', width: originalWidth, color: '#96CEB4' }
        ];
        
        sizes.forEach(function(size) {
            var btn = document.createElement('button');
            btn.textContent = size.label + ' (' + size.width + 'px)';
            btn.style.cssText = 'padding: 12px 16px; border: 2px solid ' + size.color + '; background: white; color: ' + size.color + '; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px; transition: all 0.2s; font-family: inherit;';
            
            btn.onmouseover = function() {
                this.style.background = size.color;
                this.style.color = 'white';
            };
            btn.onmouseout = function() {
                this.style.background = 'white';
                this.style.color = size.color;
            };
            
            btn.onclick = function() {
                // Apply resize
                img.style.width = size.width + 'px';
                img.style.height = 'auto';
                img.style.maxWidth = '100%';
                
                // Close modal
                if (modal.parentNode) {
                    document.body.removeChild(modal);
                }
            };
            
            buttonContainer.appendChild(btn);
        });
        
        content.appendChild(buttonContainer);
        
        // Custom size input
        var inputContainer = document.createElement('div');
        inputContainer.style.cssText = 'margin-bottom: 15px; padding-top: 15px; border-top: 1px solid #eee;';
        
        var inputLabel = document.createElement('label');
        inputLabel.textContent = 'Ukuran Custom (px):';
        inputLabel.style.cssText = 'display: block; font-size: 12px; color: #666; margin-bottom: 8px; text-align: left;';
        inputContainer.appendChild(inputLabel);
        
        var inputField = document.createElement('input');
        inputField.type = 'number';
        inputField.min = '50';
        inputField.max = '1200';
        inputField.value = Math.round(currentWidth);
        inputField.style.cssText = 'width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; box-sizing: border-box;';
        inputContainer.appendChild(inputField);
        
        var applyBtn = document.createElement('button');
        applyBtn.textContent = '✓ Terapkan Custom';
        applyBtn.style.cssText = 'width: 100%; margin-top: 8px; padding: 8px; border: 1px solid #666; background: white; color: #666; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 12px; font-family: inherit;';
        applyBtn.onmouseover = function() { this.style.background = '#f0f0f0'; };
        applyBtn.onmouseout = function() { this.style.background = 'white'; };
        applyBtn.onclick = function() {
            var customWidth = parseInt(inputField.value);
            if (customWidth >= 50 && customWidth <= 1200) {
                img.style.width = customWidth + 'px';
                img.style.height = 'auto';
                img.style.maxWidth = '100%';
                if (modal.parentNode) {
                    document.body.removeChild(modal);
                }
            } else {
                alert('Masukkan ukuran antara 50-1200 px');
            }
        };
        inputContainer.appendChild(applyBtn);
        content.appendChild(inputContainer);
        
        // Cancel button
        var cancelBtn = document.createElement('button');
        cancelBtn.textContent = '✕ Tutup';
        cancelBtn.style.cssText = 'width: 100%; padding: 10px; border: 1px solid #ddd; background: #f5f5f5; color: #666; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px; font-family: inherit;';
        cancelBtn.onmouseover = function() { this.style.background = '#e0e0e0'; };
        cancelBtn.onmouseout = function() { this.style.background = '#f5f5f5'; };
        cancelBtn.onclick = function() {
            if (modal.parentNode) {
                document.body.removeChild(modal);
            }
        };
        content.appendChild(cancelBtn);
        
        // Close on background click
        modal.onclick = function(e) {
            if (e.target === modal && modal.parentNode) {
                document.body.removeChild(modal);
            }
        };
        
        // Close on ESC
        var closeOnEsc = function(e) {
            if (e.key === 'Escape' && modal.parentNode) {
                document.body.removeChild(modal);
                document.removeEventListener('keydown', closeOnEsc);
            }
        };
        document.addEventListener('keydown', closeOnEsc);
        
        modal.appendChild(content);
        document.body.appendChild(modal);
    }

    /* Debounce render saat angka diubah */
    var batchRenderTimer;
    function debouncedRenderBatch() {
        clearTimeout(batchRenderTimer);
        batchRenderTimer = setTimeout(renderBatchFields, 400);
    }
    document.getElementById('jumlahPG').addEventListener('input',    debouncedRenderBatch);
    document.getElementById('jumlahEssay').addEventListener('input', debouncedRenderBatch);

    /* Destroy semua batch editor saat modal ditutup */
    document.getElementById('modalBatchSoal').addEventListener('hidden.bs.modal', function() {
        destroyAllBatchEditors().then(function() {
            batchCKEditors = {};
            document.getElementById('batchInputContainer').innerHTML = '';
        });
    });

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

        if (!ckManual) { Swal.fire('Perhatian', 'Editor belum siap, coba lagi.', 'warning'); return; }

        var pertanyaanHtml = ckManual.getData();
        var pertanyaanText = pertanyaanHtml.replace(/<[^>]*>/g, '').trim();

        if (!pertanyaanText) {
            Swal.fire('Perhatian', 'Pertanyaan tidak boleh kosong!', 'warning');
            return;
        }

        document.getElementById('manualPertanyaanHidden').value = pertanyaanHtml;

        var formData  = new FormData(this);
        var payload   = {
            exam_id:       formData.get('exam_id'),
            pertanyaan:    pertanyaanHtml,
            opsi_a:        formData.get('opsi_a'),
            opsi_b:        formData.get('opsi_b'),
            opsi_c:        formData.get('opsi_c'),
            opsi_d:        formData.get('opsi_d'),
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
            ckManual.setData('');
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

        /* Sync HTML dari semua CKEditor ke hidden fields */
        var hasEmpty = false;
        Object.keys(batchCKEditors).forEach(function(k) {
            var editor = batchCKEditors[k];
            var html   = editor.getData();
            var text   = html.replace(/<[^>]*>/g, '').trim();
            if (!text) { hasEmpty = true; return; }
            var field = document.getElementById('batchPertanyaan_' + k);
            if (field) field.value = html;
        });

        if (hasEmpty) {
            Swal.fire('Perhatian', 'Ada pertanyaan yang masih kosong! Harap isi semua soal.', 'warning');
            return;
        }

        var formData = new FormData(this);
        formData.set('exam_id', ujianId);

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
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Tersimpan ' + (data.count || 'semua') + ' soal.', timer: 1600, showConfirmButton: false });
        })
        .catch(function() { Swal.fire('Error', 'Gagal simpan batch soal!', 'error'); })
        .finally(function() { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Semua Soal'; });
    });

});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Documents/simoro-smanli/resources/views/admin/soal.blade.php ENDPATH**/ ?>