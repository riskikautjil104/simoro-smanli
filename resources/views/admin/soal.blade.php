@extends('layouts.master')

@section('title', 'Data Soal')

@push('styles')
@endpush

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Manajemen Soal Ujian</h4>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="guruMapelUjianTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Daftar Ujian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Soal per Ujian -->
<div class="modal fade" id="modalDetailSoal" tabindex="-1" aria-labelledby="modalDetailSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailSoalLabel">Detail Soal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailSoalContent">
                    <div class="text-center text-muted">Memuat data soal...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Soal -->
<div class="modal fade" id="modalImportSoal" tabindex="-1" aria-labelledby="modalImportSoalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportSoalLabel">Import Soal (Excel/CSV)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportSoal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="importGuruId" name="guru_id">
                    <input type="hidden" id="importMapelId" name="mapel_id">
                    <input type="hidden" id="importUjianId" name="ujian_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Guru</label>
                        <input type="text" class="form-control" id="importGuruName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="importMapelName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ujian</label>
                        <select class="form-control" id="importUjianSelect" required>
                            <option value="">-- Pilih Ujian --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fileSoal" class="form-label">Pilih File Excel/CSV</label>
                        <input type="file" class="form-control" id="fileSoal" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">Download template: <a href="/template-import-soal.xlsx">template-import-soal.xlsx</a></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Soal Manual -->
<div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahSoal">
                <div class="modal-body">
                    <input type="hidden" id="manualGuruId" name="guru_id">
                    <input type="hidden" id="manualMapelId" name="mapel_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Guru</label>
                        <input type="text" class="form-control" id="manualGuruName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="manualMapelName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="manualUjianSelect" class="form-label">Ujian</label>
                        <select class="form-control" id="manualUjianSelect" name="exam_id" required>
                            <option value="">-- Pilih Ujian --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pertanyaanSoal" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="pertanyaanSoal" name="pertanyaan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="opsiA" class="form-label">Opsi A</label>
                        <input type="text" class="form-control" id="opsiA" name="opsi_a" required>
                    </div>
                    <div class="mb-3">
                        <label for="opsiB" class="form-label">Opsi B</label>
                        <input type="text" class="form-control" id="opsiB" name="opsi_b" required>
                    </div>
                    <div class="mb-3">
                        <label for="opsiC" class="form-label">Opsi C</label>
                        <input type="text" class="form-control" id="opsiC" name="opsi_c" required>
                    </div>
                    <div class="mb-3">
                        <label for="opsiD" class="form-label">Opsi D</label>
                        <input type="text" class="form-control" id="opsiD" name="opsi_d" required>
                    </div>
                    <div class="mb-3">
                        <label for="jawabanBenar" class="form-label">Jawaban Benar</label>
                        <select class="form-control" id="jawabanBenar" name="jawaban_benar" required>
                            <option value="">-- Pilih Jawaban --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Batch Input Soal (PG & Essay) -->
<div class="modal fade" id="modalBatchSoal" tabindex="-1" aria-labelledby="modalBatchSoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBatchSoalLabel">Input Soal PG & Essay Sekaligus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formBatchSoal">
                <div class="modal-body">
                    <input type="hidden" id="batchGuruId" name="guru_id">
                    <input type="hidden" id="batchMapelId" name="mapel_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Soal PG</label>
                            <input type="number" min="0" max="100" class="form-control" id="jumlahPG" value="20">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Soal Essay</label>
                            <input type="number" min="0" max="100" class="form-control" id="jumlahEssay" value="5">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ujian</label>
                            <select class="form-control" id="batchUjianSelect" name="exam_id" required>
                                <option value="">-- Pilih Ujian --</option>
                            </select>
                        </div>
                    </div>
                    <div id="batchInputContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Semua Soal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#guruMapelUjianTable tbody');
    if (!tableBody) return;

    let allGurus = [];
    let allMapels = [];
    let allUjians = [];

    // Load semua data
    loadData();

    function loadData() {
        Promise.all([
            fetch('/admin/guru', { 
                headers: { 'Accept': 'application/json' }, 
                credentials: 'same-origin' 
            }).then(res => res.ok ? res.json() : []),
            
            fetch('/admin/mapel', { 
                headers: { 'Accept': 'application/json' }, 
                credentials: 'same-origin' 
            }).then(res => res.ok ? res.json() : []),
            
            fetch('/admin/ujian-list', { 
                headers: { 'Accept': 'application/json' }, 
                credentials: 'same-origin' 
            }).then(res => res.ok ? res.json() : []),
        ])
        .then(([gurus, mapels, ujians]) => {
            allGurus = gurus;
            allMapels = mapels;
            allUjians = ujians;
            renderTable();
        })
        .catch(err => {
            console.error('Error loading data:', err);
            tableBody.innerHTML = '<tr><td colspan="5" class="text-danger text-center">Gagal memuat data. Cek koneksi atau backend!</td></tr>';
        });
    }

    function renderTable() {
        let rows = '';
        let no = 1;

        if (!Array.isArray(allGurus) || !Array.isArray(allMapels) || !Array.isArray(allUjians)) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-danger text-center">Data tidak valid!</td></tr>';
            return;
        }

        allGurus.forEach(guru => {

            let guruMapels = allMapels.filter(m => m.teacher && m.teacher.id === guru.id);
            if (guruMapels.length === 0) return;

            guruMapels.forEach(mapel => {
                let mapelUjians = allUjians.filter(u => u.mapel && u.mapel.id === mapel.id);
                let ujianList = '-';

                if (mapelUjians.length > 0) {
                    ujianList = mapelUjians.map(u => 
                        `<a href='#' class='link-ujian' data-ujian='${u.id}' data-ujian-nama='${u.nama}'>${u.nama}</a>`
                    ).join('<br>');
                }

                // Tombol detail ujian untuk setiap ujian
                let detailUjianBtns = '-';
                if (mapelUjians.length > 0) {
                    detailUjianBtns = mapelUjians.map(u => 
                        `<a class='btn btn-sm btn-info mt-1' href='/admin/ujian/${u.id}/detail'>
                            <i class="bi bi-eye"></i> Detail Ujian (${u.nama})
                        </a>`
                    ).join('<br>');
                }

                rows += `<tr>
                    <td>${no++}</td>
                    <td>${guru.name}</td>
                    <td>${mapel.name}</td>
                    <td>${ujianList}</td>
                    <td>
                        <button class='btn btn-sm btn-success btn-import' 
                                data-guru='${guru.id}' 
                                data-guru-name='${guru.name}'
                                data-mapel='${mapel.id}'
                                data-mapel-name='${mapel.name}'>
                            <i class="bi bi-upload"></i> Import
                        </button>
                        <button class='btn btn-sm btn-primary btn-tambah-manual' 
                                data-guru='${guru.id}' 
                                data-guru-name='${guru.name}'
                                data-mapel='${mapel.id}'
                                data-mapel-name='${mapel.name}'>
                            <i class="bi bi-plus"></i> Manual
                        </button>
                        <button class='btn btn-sm btn-warning btn-batch-input' 
                                data-guru='${guru.id}'
                                data-guru-name='${guru.name}'
                                data-mapel='${mapel.id}'
                                data-mapel-name='${mapel.name}'>
                            <i class="bi bi-layers"></i> Batch
                        </button>
                        ${detailUjianBtns}
                    </td>
                </tr>`;
            });
        });

        tableBody.innerHTML = rows || '<tr><td colspan="5" class="text-center">Tidak ada data guru/mapel/ujian.</td></tr>';
    }

    // Handler klik link ujian untuk detail soal
    document.addEventListener('click', function(e) {
        // Link Ujian - Tampilkan Detail Soal
        if (e.target.classList.contains('link-ujian')) {
            e.preventDefault();
            const ujianId = e.target.getAttribute('data-ujian');
            const ujianNama = e.target.getAttribute('data-ujian-nama');
            
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetailSoal'));
            document.getElementById('modalDetailSoalLabel').textContent = `Detail Soal - ${ujianNama}`;
            document.getElementById('detailSoalContent').innerHTML = '<div class="text-center text-muted">Memuat data soal...</div>';
            modal.show();

            fetch(`/admin/soal?exam_id=${ujianId}`, { 
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (!data || !data.length) {
                    document.getElementById('detailSoalContent').innerHTML = 
                        '<div class="alert alert-warning">Belum ada soal untuk ujian ini.</div>';
                    return;
                }

                let html = `<table class='table table-bordered table-hover'>
                    <thead class='table-light'>
                        <tr>
                            <th width="50">No</th>
                            <th>Pertanyaan</th>
                            <th width="80">Tipe</th>
                            <th width="100">Jawaban</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>`;
                
                data.forEach((soal, i) => {
                    const tipe = soal.opsi_a ? 'PG' : 'Essay';
                    html += `<tr>
                        <td>${i+1}</td>
                        <td>${soal.pertanyaan}</td>
                        <td><span class="badge bg-${tipe === 'PG' ? 'primary' : 'info'}">${tipe}</span></td>
                        <td class="text-center"><span class="badge bg-success">${soal.jawaban_benar || '-'}</span></td>
                        <td class="text-center">
                            <button class='btn btn-sm btn-danger btn-delete-soal' data-id='${soal.id}'>
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                
                html += '</tbody></table>';
                document.getElementById('detailSoalContent').innerHTML = html;
            })
            .catch(err => {
                console.error('Error fetching soal:', err);
                document.getElementById('detailSoalContent').innerHTML = 
                    '<div class="alert alert-danger">Gagal memuat data soal.</div>';
            });
        }

        // Tombol Import
        if (e.target.closest('.btn-import')) {
            const btn = e.target.closest('.btn-import');
            const guruId = btn.getAttribute('data-guru');
            const guruName = btn.getAttribute('data-guru-name');
            const mapelId = btn.getAttribute('data-mapel');
            const mapelName = btn.getAttribute('data-mapel-name');

            document.getElementById('importGuruId').value = guruId;
            document.getElementById('importMapelId').value = mapelId;
            document.getElementById('importGuruName').value = guruName;
            document.getElementById('importMapelName').value = mapelName;

            const ujianOptions = allUjians
                .filter(u => u.mapel && u.mapel.id == mapelId)
                .map(u => `<option value="${u.id}">${u.nama}</option>`)
                .join('');
            
            document.getElementById('importUjianSelect').innerHTML = 
                '<option value="">-- Pilih Ujian --</option>' + ujianOptions;

            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalImportSoal'));
            modal.show();
        }

        // Tombol Tambah Manual
        if (e.target.closest('.btn-tambah-manual')) {
            const btn = e.target.closest('.btn-tambah-manual');
            const guruId = btn.getAttribute('data-guru');
            const guruName = btn.getAttribute('data-guru-name');
            const mapelId = btn.getAttribute('data-mapel');
            const mapelName = btn.getAttribute('data-mapel-name');

            document.getElementById('manualGuruId').value = guruId;
            document.getElementById('manualMapelId').value = mapelId;
            document.getElementById('manualGuruName').value = guruName;
            document.getElementById('manualMapelName').value = mapelName;

            const ujianOptions = allUjians
                .filter(u => u.mapel && u.mapel.id == mapelId)
                .map(u => `<option value="${u.id}">${u.nama}</option>`)
                .join('');
            
            document.getElementById('manualUjianSelect').innerHTML = 
                '<option value="">-- Pilih Ujian --</option>' + ujianOptions;

            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahSoal'));
            modal.show();
        }

        // Tombol Batch Input
        if (e.target.closest('.btn-batch-input')) {
            const btn = e.target.closest('.btn-batch-input');
            const guruId = btn.getAttribute('data-guru');
            const guruName = btn.getAttribute('data-guru-name');
            const mapelId = btn.getAttribute('data-mapel');
            const mapelName = btn.getAttribute('data-mapel-name');

            document.getElementById('batchGuruId').value = guruId;
            document.getElementById('batchMapelId').value = mapelId;

            const ujianOptions = allUjians
                .filter(u => u.mapel && u.mapel.id == mapelId)
                .map(u => `<option value="${u.id}">${u.nama}</option>`)
                .join('');
            
            document.getElementById('batchUjianSelect').innerHTML = 
                '<option value="">-- Pilih Ujian --</option>' + ujianOptions;

            document.getElementById('jumlahPG').value = 20;
            document.getElementById('jumlahEssay').value = 5;
            renderBatchInputFields();

            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBatchSoal'));
            modal.show();
        }

        // Hapus Soal
        if (e.target.closest('.btn-delete-soal')) {
            if (!confirm('Yakin ingin menghapus soal ini?')) return;
            
            const btn = e.target.closest('.btn-delete-soal');
            const soalId = btn.getAttribute('data-id');

            fetch(`/admin/soal/${soalId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                alert('Soal berhasil dihapus');
                // Refresh modal dengan klik link yang sama
                document.querySelector('.link-ujian[data-ujian]')?.click();
            })
            .catch(err => {
                console.error('Error deleting soal:', err);
                alert('Gagal menghapus soal');
            });
        }
    });

    // Render Batch Input Fields
    function renderBatchInputFields() {
        const jumlahPG = parseInt(document.getElementById('jumlahPG').value) || 0;
        const jumlahEssay = parseInt(document.getElementById('jumlahEssay').value) || 0;
        let html = '';

        if (jumlahPG > 0) {
            html += `<h6 class='mt-3 mb-3'><i class="bi bi-list-check"></i> Soal Pilihan Ganda</h6>`;
            for (let i = 0; i < jumlahPG; i++) {
                html += `<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-title'>PG #${i+1}</h6>
                        <input type='hidden' name='soal[${i}][tipe]' value='pg'>
                        <div class='mb-2'>
                            <textarea class='form-control' name='soal[${i}][pertanyaan]' placeholder='Pertanyaan' rows="2" required></textarea>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-6 mb-2'><input type='text' class='form-control' name='soal[${i}][opsi_a]' placeholder='A.' required></div>
                            <div class='col-6 mb-2'><input type='text' class='form-control' name='soal[${i}][opsi_b]' placeholder='B.' required></div>
                            <div class='col-6'><input type='text' class='form-control' name='soal[${i}][opsi_c]' placeholder='C.' required></div>
                            <div class='col-6'><input type='text' class='form-control' name='soal[${i}][opsi_d]' placeholder='D.' required></div>
                        </div>
                        <select class='form-control' name='soal[${i}][jawaban_benar]' required>
                            <option value=''>-- Jawaban Benar --</option>
                            <option value='A'>A</option>
                            <option value='B'>B</option>
                            <option value='C'>C</option>
                            <option value='D'>D</option>
                        </select>
                    </div>
                </div>`;
            }
        }

        if (jumlahEssay > 0) {
            html += `<h6 class='mt-4 mb-3'><i class="bi bi-pencil-square"></i> Soal Essay</h6>`;
            for (let i = jumlahPG; i < jumlahPG + jumlahEssay; i++) {
                html += `<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-title'>Essay #${i-jumlahPG+1}</h6>
                        <input type='hidden' name='soal[${i}][tipe]' value='essay'>
                        <textarea class='form-control' name='soal[${i}][pertanyaan]' placeholder='Pertanyaan Essay' rows="3" required></textarea>
                    </div>
                </div>`;
            }
        }

        document.getElementById('batchInputContainer').innerHTML = html;
    }

    document.getElementById('jumlahPG').addEventListener('input', renderBatchInputFields);
    document.getElementById('jumlahEssay').addEventListener('input', renderBatchInputFields);

    // Submit Form Import
    document.getElementById('formImportSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const ujianId = document.getElementById('importUjianSelect').value;
        if (!ujianId) {
            alert('Pilih ujian terlebih dahulu!');
            return;
        }

        const formData = new FormData(this);
        formData.append('exam_id', ujianId);

        fetch('/admin/soal/import', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert('Import soal berhasil!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalImportSoal'));
            modal.hide();
            this.reset();
        })
        .catch(err => {
            console.error('Error importing soal:', err);
            alert('Gagal import soal. Cek format file!');
        });
    });

    // Submit Form Tambah Soal Manual
    document.getElementById('formTambahSoal').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = {
            exam_id: formData.get('exam_id'),
            pertanyaan: formData.get('pertanyaan'),
            opsi_a: formData.get('opsi_a'),
            opsi_b: formData.get('opsi_b'),
            opsi_c: formData.get('opsi_c'),
            opsi_d: formData.get('opsi_d'),
            jawaban_benar: formData.get('jawaban_benar')
        };

        fetch('/admin/soal', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            alert('Soal berhasil ditambahkan!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahSoal'));
            modal.hide();
            this.reset();
        })
        .catch(err => {
            console.error('Error adding soal:', err);
            alert('Gagal menambah soal!');
        });
    });

    // Submit Form Batch Soal
    document.getElementById('formBatchSoal').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const ujianId = document.getElementById('batchUjianSelect').value;
        if (!ujianId) {
            alert('Pilih ujian terlebih dahulu!');
            return;
        }

        const formData = new FormData(this);
        formData.append('exam_id', ujianId);

        fetch('/admin/soal/batch', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(`Berhasil menyimpan ${data.count || 'semua'} soal!`);
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalBatchSoal'));
            modal.hide();
            this.reset();
            document.getElementById('batchInputContainer').innerHTML = '';
        })
        .catch(err => {
            console.error('Error batch soal:', err);
            alert('Gagal simpan batch soal!');
        });
    });
});
</script>
@endpush