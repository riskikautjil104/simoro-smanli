@extends('layouts.master')

@section('title', 'Data Guru')

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
    text-decoration: none;
    backdrop-filter: blur(8px);
    cursor: pointer;
    transition: var(--transition);
    font-family: 'Poppins', sans-serif;
}

.btn-header:hover {
    background: rgba(255,255,255,0.32);
    transform: translateY(-2px);
    color: #fff !important;
}

/* ── Search bar ── */
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

.table-card .table tbody tr {
    transition: background 0.15s ease;
}

.table-card .table tbody tr:hover { background: rgba(13,110,253,0.03); }

/* ── Avatar in table ── */
.guru-avatar {
    width: 34px; height: 34px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.78rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(13,110,253,0.25);
}

/* ── Badge ── */
.badge-mapel {
    display: inline-block;
    background: rgba(13,110,253,0.08);
    color: var(--primary);
    font-size: 0.72rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    margin: 2px 2px 0 0;
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
    text-decoration: none;
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
    background: rgba(13,110,253,0.07);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: var(--primary);
    margin-bottom: 16px;
}

.empty-state h6 {
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 6px;
}

.empty-state p {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
}

/* ── Modal ── */
.modal-header-brand {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff;
    border-radius: 0;
    padding: 16px 20px;
}

.modal-header-brand .modal-title { font-weight: 700; font-size: 1rem; }

.modal-header-brand .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.85;
    transition: transform 0.2s;
}

.modal-header-brand .btn-close:hover { transform: rotate(90deg); opacity: 1; }

.modal-content { border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(13,110,253,0.2); }

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
                <i class="bi bi-person-badge me-2"></i>Data Guru
                <span class="count-badge" id="guru-count">0 guru</span>
            </h4>
            <p>Kelola data guru pengajar SMA Negeri 5 Morotai</p>
        </div>
        <button class="btn-header" data-bs-toggle="modal" data-bs-target="#modalGuru" id="btnTambahGuru">
            <i class="bi bi-plus-lg"></i> Tambah Guru
        </button>
    </div>
</div>

{{-- ── TOOLBAR ── --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchGuru" class="form-control" placeholder="Cari nama, email, NIP...">
    </div>
    <div style="font-size:0.82rem; color:var(--text-muted);">
        Menampilkan <span id="guru-shown">0</span> data
    </div>
</div>

{{-- ── TABLE ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="guruTable">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Guru</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>No HP</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="guruTbody">
                <tr>
                    <td colspan="6">
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
<div class="modal fade" id="modalGuru" tabindex="-1" aria-labelledby="modalGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-brand">
                <h5 class="modal-title" id="modalGuruLabel">
                    <i class="bi bi-person-badge me-2"></i>Tambah Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGuru">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="guruId">

                    <div class="mb-3">
                        <label for="namaGuru" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="namaGuru" name="nama"
                               placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailGuru" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailGuru" name="email"
                               placeholder="guru@sman5morotai.sch.id" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nipGuru" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nipGuru" name="nip"
                                   placeholder="19XXXXXXXXXXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label for="hpGuru" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="hpGuru" name="phone"
                                   placeholder="08XXXXXXXXXX">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanGuru">
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

    var allGuru = [];
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ── Fetch & render ── */
    function fetchGuru() {
        fetch('/admin/guru', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            credentials: 'same-origin'
        })
        .then(function (res) {
            if (!res.ok) throw new Error('Gagal memuat data');
            return res.json();
        })
        .then(function (data) {
            allGuru = data;
            renderGuru(data);
        })
        .catch(function () {
            renderError('Gagal memuat data guru. Coba refresh halaman.');
        });
    }

    function renderGuru(data) {
        var tbody  = document.getElementById('guruTbody');
        var count  = document.getElementById('guru-count');
        var shown  = document.getElementById('guru-shown');

        count.textContent = data.length + ' guru';
        shown.textContent = data.length;

        if (data.length === 0) {
            tbody.innerHTML = emptyState(
                'bi-person-badge',
                'Belum ada data guru',
                'Klik "Tambah Guru" untuk menambahkan data guru baru.'
            );
            return;
        }

        var rows = '';
        data.forEach(function (guru, i) {
            var inisial   = (guru.name || guru.nama || 'G').substring(0, 2).toUpperCase();
            var namaGuru  = guru.name || guru.nama || '-';
            var mapelList = guru.subjects ? guru.subjects.map(function (s) {
                return '<span class="badge-mapel">' + s.name + '</span>';
            }).join('') : '';

            rows += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' +
                    '<div class="d-flex align-items-center gap-2">' +
                        '<div class="guru-avatar">' + inisial + '</div>' +
                        '<div>' +
                            '<div style="font-weight:600;">' + namaGuru + '</div>' +
                            (mapelList ? '<div class="mt-1">' + mapelList + '</div>' : '') +
                        '</div>' +
                    '</div>' +
                '</td>' +
                '<td>' + (guru.email || '-') + '</td>' +
                '<td>' + (guru.nip || '<span style="color:#ccc;">—</span>') + '</td>' +
                '<td>' + (guru.phone || '<span style="color:#ccc;">—</span>') + '</td>' +
                '<td>' +
                    '<button class="btn-act btn-act-edit me-1" data-id="' + guru.id + '">' +
                        '<i class="bi bi-pencil"></i> Edit' +
                    '</button>' +
                    '<button class="btn-act btn-act-delete" data-id="' + guru.id + '" data-nama="' + namaGuru + '">' +
                        '<i class="bi bi-trash"></i>' +
                    '</button>' +
                '</td>' +
            '</tr>';
        });

        tbody.innerHTML = rows;
    }

    function renderError(msg) {
        document.getElementById('guruTbody').innerHTML =
            '<tr><td colspan="6">' + emptyState('bi-exclamation-circle', 'Terjadi kesalahan', msg) + '</td></tr>';
    }

    function emptyState(icon, title, desc) {
        return '<tr><td colspan="6"><div class="empty-state">' +
            '<div class="empty-icon"><i class="bi ' + icon + '"></i></div>' +
            '<h6>' + title + '</h6>' +
            '<p>' + desc + '</p>' +
            '</div></td></tr>';
    }

    /* ── Search / filter ── */
    document.getElementById('searchGuru').addEventListener('input', function () {
        var q = this.value.toLowerCase().trim();
        if (!q) { renderGuru(allGuru); return; }
        var filtered = allGuru.filter(function (g) {
            var nama  = (g.name || g.nama || '').toLowerCase();
            var email = (g.email || '').toLowerCase();
            var nip   = (g.nip || '').toLowerCase();
            return nama.includes(q) || email.includes(q) || nip.includes(q);
        });
        renderGuru(filtered);
    });

    /* ── Reset modal on open (Tambah) ── */
    document.getElementById('btnTambahGuru').addEventListener('click', function () {
        document.getElementById('formGuru').reset();
        document.getElementById('guruId').value = '';
        document.getElementById('modalGuruLabel').innerHTML =
            '<i class="bi bi-person-badge me-2"></i>Tambah Guru';
    });

    /* ── Submit (create / update) ── */
    document.getElementById('formGuru').addEventListener('submit', function (e) {
        e.preventDefault();

        var id       = document.getElementById('guruId').value;
        var url      = id ? '/admin/guru/' + id : '/admin/guru';
        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        var btn = document.getElementById('btnSimpanGuru');
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
            fetchGuru();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalGuru')).hide();
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data guru berhasil disimpan.', timer: 1500, showConfirmButton: false });
        })
        .catch(function (err) {
            var msg = 'Gagal menyimpan data guru.';
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
    document.getElementById('guruTbody').addEventListener('click', function (e) {
        var btnEdit   = e.target.closest('.btn-act-edit');
        var btnDelete = e.target.closest('.btn-act-delete');

        /* EDIT */
        if (btnEdit) {
            var id = btnEdit.getAttribute('data-id');
            fetch('/admin/guru/' + id, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin'
            })
            .then(function (res) { return res.json(); })
            .then(function (guru) {
                document.getElementById('guruId').value    = guru.id;
                document.getElementById('namaGuru').value  = guru.name || guru.nama || '';
                document.getElementById('emailGuru').value = guru.email || '';
                document.getElementById('nipGuru').value   = guru.nip || '';
                document.getElementById('hpGuru').value    = guru.phone || '';
                document.getElementById('modalGuruLabel').innerHTML =
                    '<i class="bi bi-pencil me-2"></i>Edit Guru';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalGuru')).show();
            })
            .catch(function () {
                Swal.fire('Error', 'Gagal mengambil data guru.', 'error');
            });
        }

        /* DELETE */
        if (btnDelete) {
            var id   = btnDelete.getAttribute('data-id');
            var nama = btnDelete.getAttribute('data-nama');
            Swal.fire({
                title: 'Hapus "' + nama + '"?',
                text: 'Data guru akan dihapus permanen dan tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (!result.isConfirmed) return;
                fetch('/admin/guru/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(function (res) {
                    if (!res.ok) throw new Error();
                    return res.json();
                })
                .then(function () {
                    fetchGuru();
                    Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Data guru berhasil dihapus.', timer: 1400, showConfirmButton: false });
                })
                .catch(function () {
                    Swal.fire('Error', 'Gagal menghapus data guru.', 'error');
                });
            });
        }
    });

    /* ── Init ── */
    fetchGuru();
});
</script>
@endpush