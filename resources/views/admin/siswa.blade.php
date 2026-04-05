@extends('layouts.master')

@section('title', 'Data Siswa')

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

.page-header-content { position: relative; z-index: 2; }
.page-header h4      { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p       { font-size: 0.85rem; opacity: 0.85; margin: 0; }

.btn-header {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.2);
    color: #fff !important;
    border: 1.5px solid rgba(255,255,255,0.45);
    padding: 9px 20px;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    backdrop-filter: blur(8px);
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
}

.btn-header:hover {
    background: rgba(255,255,255,0.32);
    transform: translateY(-2px);
    color: #fff !important;
}

/* ── Search & toolbar ── */
.search-wrap {
    position: relative;
    max-width: 300px;
}

.search-wrap i {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 0.9rem;
    pointer-events: none;
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

.filter-kelas {
    height: 38px;
    border-radius: 50px;
    border: 1.5px solid var(--border-color);
    font-size: 0.875rem;
    padding: 0 14px;
    min-width: 160px;
    cursor: pointer;
    transition: var(--transition);
}

.filter-kelas:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    outline: none;
}

/* ── Table card ── */
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.table-card .table {
    margin: 0;
    font-size: 0.875rem;
}

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
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
    color: var(--text-main);
}

.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr { transition: background 0.15s ease; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.03); }

/* ── Avatar ── */
.siswa-avatar {
    width: 34px; height: 34px;
    background: linear-gradient(135deg, var(--secondary), #198754);
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.78rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(32,201,151,0.3);
}

/* ── Kelas badge ── */
.badge-kelas {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(32,201,151,0.1);
    color: #198754;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

/* ── Action buttons ── */
.btn-act {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Poppins', sans-serif;
}

.btn-act-edit {
    background: rgba(13,110,253,0.1);
    color: var(--primary);
}

.btn-act-edit:hover {
    background: var(--primary);
    color: #fff;
    transform: translateY(-1px);
}

.btn-act-delete {
    background: rgba(220,53,69,0.1);
    color: var(--danger);
}

.btn-act-delete:hover {
    background: var(--danger);
    color: #fff;
    transform: translateY(-1px);
}

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 56px 24px;
}

.empty-state .empty-icon {
    width: 72px; height: 72px;
    background: rgba(32,201,151,0.08);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: var(--secondary);
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

/* ── Count badge ── */
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
</style>
@endpush

@section('layoutContent')

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4>
                <i class="bi bi-people me-2"></i>Data Siswa
                <span class="count-badge" id="siswa-count">0 siswa</span>
            </h4>
            <p>Kelola data siswa SMA Negeri 5 Morotai</p>
        </div>
        <button class="btn-header" data-bs-toggle="modal" data-bs-target="#modalSiswa" id="btnTambahSiswa">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </button>
    </div>
</div>

{{-- ── TOOLBAR ── --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="d-flex gap-2 flex-wrap">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchSiswa" class="form-control" placeholder="Cari nama atau email...">
        </div>
        <select id="filterKelas" class="filter-kelas form-select">
            <option value="">Semua Kelas</option>
        </select>
    </div>
    <div style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan <span id="siswa-shown">0</span> data
    </div>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="siswaTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Siswa</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="siswaTbody">
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

{{-- ── MODAL TAMBAH / EDIT ── --}}
<div class="modal fade" id="modalSiswa" tabindex="-1" aria-labelledby="modalSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalSiswaLabel">
                    <i class="bi bi-person-plus me-2"></i>Tambah Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSiswa">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="siswaId">

                    <div class="mb-3">
                        <label for="namaSiswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="namaSiswa" name="nama"
                               placeholder="Contoh: Ahmad Fauzi" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailSiswa" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailSiswa" name="email"
                               placeholder="siswa@sman5morotai.sch.id" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelasSiswa" class="form-label">Kelas</label>
                        <select class="form-select" id="kelasSiswa" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanSiswa">
                        <i class="bi bi-save me-1"></i> Simpan
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

    var allSiswa  = [];
    var allKelas  = [];
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ── Fetch kelas (untuk select & filter) ── */
    function fetchKelas() {
        fetch('/admin/kelas', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            credentials: 'same-origin'
        })
        .then(function (res) {
            if (!res.ok) throw new Error();
            return res.json();
        })
        .then(function (data) {
            allKelas = data;

            /* Isi select di modal */
            var optModal = '<option value="">-- Pilih Kelas --</option>';
            data.forEach(function (k) {
                optModal += '<option value="' + k.id + '">' + k.name + '</option>';
            });
            document.getElementById('kelasSiswa').innerHTML = optModal;

            /* Isi filter kelas di toolbar */
            var optFilter = '<option value="">Semua Kelas</option>';
            data.forEach(function (k) {
                optFilter += '<option value="' + k.id + '">' + k.name + '</option>';
            });
            document.getElementById('filterKelas').innerHTML = optFilter;
        })
        .catch(function () {
            /* Gagal muat kelas — tidak critical, form tetap bisa dibuka */
        });
    }

    /* ── Fetch & render siswa ── */
    function fetchSiswa() {
        fetch('/admin/siswa', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            credentials: 'same-origin'
        })
        .then(function (res) {
            if (!res.ok) throw new Error('Gagal memuat data');
            return res.json();
        })
        .then(function (data) {
            allSiswa = data;
            applyFilter();
        })
        .catch(function () {
            renderEmptyRow('bi-exclamation-circle', 'Gagal memuat data', 'Coba refresh halaman.');
        });
    }

    function applyFilter() {
        var q      = document.getElementById('searchSiswa').value.toLowerCase().trim();
        var kelas  = document.getElementById('filterKelas').value;
        var result = allSiswa;

        if (q) {
            result = result.filter(function (s) {
                return (s.nama || '').toLowerCase().includes(q) ||
                       (s.email || '').toLowerCase().includes(q);
            });
        }

        if (kelas) {
            result = result.filter(function (s) {
                return String(s.kelas_id) === kelas || (s.kelas && String(s.kelas.id) === kelas);
            });
        }

        renderSiswa(result);
    }

    function renderSiswa(data) {
        var tbody = document.getElementById('siswaTbody');
        var count = document.getElementById('siswa-count');
        var shown = document.getElementById('siswa-shown');

        count.textContent = allSiswa.length + ' siswa';
        shown.textContent = data.length;

        if (data.length === 0) {
            renderEmptyRow('bi-people', 'Tidak ada data ditemukan', 'Coba ubah kata kunci pencarian atau filter kelas.');
            return;
        }

        var rows = '';
        data.forEach(function (siswa, i) {
            var nama    = siswa.nama || '-';
            var inisial = nama.substring(0, 2).toUpperCase();
            var kelas   = siswa.kelas ? siswa.kelas.nama || siswa.kelas.name : '-';

            rows += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<div class="siswa-avatar">' + inisial + '</div>' +
                        '<div style="font-weight:600;">' + nama + '</div>' +
                    '</div>' +
                '</td>' +
                '<td>' + (siswa.email || '-') + '</td>' +
                '<td>' +
                    '<span class="badge-kelas"><i class="bi bi-building"></i>' + kelas + '</span>' +
                '</td>' +
                '<td>' +
                    '<button class="btn-act btn-act-edit me-1" data-id="' + siswa.id + '">' +
                        '<i class="bi bi-pencil"></i> Edit' +
                    '</button>' +
                    '<button class="btn-act btn-act-delete" data-id="' + siswa.id + '" data-nama="' + nama + '">' +
                        '<i class="bi bi-trash"></i>' +
                    '</button>' +
                '</td>' +
            '</tr>';
        });

        tbody.innerHTML = rows;
    }

    function renderEmptyRow(icon, title, desc) {
        document.getElementById('siswaTbody').innerHTML =
            '<tr><td colspan="5"><div class="empty-state">' +
            '<div class="empty-icon"><i class="bi ' + icon + '"></i></div>' +
            '<h6>' + title + '</h6><p>' + desc + '</p>' +
            '</div></td></tr>';
    }

    /* ── Search & filter listeners ── */
    document.getElementById('searchSiswa').addEventListener('input',  applyFilter);
    document.getElementById('filterKelas').addEventListener('change', applyFilter);

    /* ── Reset modal on tambah ── */
    document.getElementById('btnTambahSiswa').addEventListener('click', function () {
        document.getElementById('formSiswa').reset();
        document.getElementById('siswaId').value = '';
        document.getElementById('modalSiswaLabel').innerHTML =
            '<i class="bi bi-person-plus me-2"></i>Tambah Siswa';
    });

    /* ── Submit (create / update) ── */
    document.getElementById('formSiswa').addEventListener('submit', function (e) {
        e.preventDefault();

        var id       = document.getElementById('siswaId').value;
        var url      = id ? '/admin/siswa/' + id : '/admin/siswa'; /* URL konsisten /admin/siswa */
        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT'); /* PUT untuk update */

        var btn = document.getElementById('btnSimpanSiswa');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(function (res) {
            if (!res.ok) return res.json().then(function (e) { throw e; });
            return res.json();
        })
        .then(function () {
            fetchSiswa();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSiswa')).hide();
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data siswa berhasil disimpan.', timer: 1500, showConfirmButton: false });
        })
        .catch(function (err) {
            var msg = 'Gagal menyimpan data siswa.';
            if (err && err.errors) msg = Object.values(err.errors).flat().join('<br>');
            else if (err && err.message) msg = err.message;
            Swal.fire({ icon: 'error', title: 'Gagal', html: msg });
        })
        .finally(function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan';
        });
    });

    /* ── Edit & Delete via delegation ── */
    document.getElementById('siswaTbody').addEventListener('click', function (e) {
        var btnEdit   = e.target.closest('.btn-act-edit');
        var btnDelete = e.target.closest('.btn-act-delete');

        /* EDIT */
        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            fetch('/admin/siswa/' + id, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin'
            })
            .then(function (res) { return res.json(); })
            .then(function (siswa) {
                document.getElementById('siswaId').value    = siswa.id;
                document.getElementById('namaSiswa').value  = siswa.nama || '';
                document.getElementById('emailSiswa').value = siswa.email || '';
                document.getElementById('kelasSiswa').value = siswa.kelas_id || '';
                document.getElementById('modalSiswaLabel').innerHTML =
                    '<i class="bi bi-pencil me-2"></i>Edit Siswa';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSiswa')).show();
            })
            .catch(function () {
                Swal.fire('Error', 'Gagal mengambil data siswa.', 'error');
            });
        }

        /* DELETE — URL sekarang konsisten /admin/siswa/{id} */
        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({
                title: 'Hapus "' + nama + '"?',
                text: 'Data siswa akan dihapus permanen dan tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (!result.isConfirmed) return;
                fetch('/admin/siswa/' + id, { /* FIXED: konsisten /admin/siswa */
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(function (res) {
                    if (!res.ok) throw new Error();
                    return res.json();
                })
                .then(function () {
                    fetchSiswa();
                    Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Data siswa berhasil dihapus.', timer: 1400, showConfirmButton: false });
                })
                .catch(function () {
                    Swal.fire('Error', 'Gagal menghapus data siswa.', 'error');
                });
            });
        }
    });

    /* ── Init ── */
    fetchKelas();
    fetchSiswa();
});
</script>
@endpush