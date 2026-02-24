@extends('layouts.master')

@section('title', 'Data Kelas')

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Kelas</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKelas">
            Tambah Kelas
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="kelasTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Jumlah Guru</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data akan di-render via JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKelas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah / Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formKelas">
                <div class="modal-body">
                    <input type="hidden" id="kelasId" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="namaKelas" name="nama" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
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

    fetchKelas();

    // ===============================
    // FETCH DATA
    // ===============================
    function fetchKelas() {
        fetch('/admin/kelas/list')
            .then(res => res.json())
            .then(data => {
                let rows = '';
                data.forEach((kelas, i) => {
                    const siswaCount = Array.isArray(kelas.students) ? kelas.students.length : 0;
                    const guruCount = Array.isArray(kelas.subjects) ? kelas.subjects.map(s => s.teacher_id).filter((v, i, arr) => arr.indexOf(v) === i).length : 0;
                    const mapelList = Array.isArray(kelas.subjects) ? kelas.subjects.map(s => s.name).join(', ') : '-';
                    rows += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${kelas.nama ?? kelas.name}<br><small>Mapel: ${mapelList}</small></td>
                            <td>${siswaCount}</td>
                            <td>${guruCount}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${kelas.id}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${kelas.id}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                });

                document.querySelector('#kelasTable tbody').innerHTML = rows;
            })
            .catch(err => {
                Swal.fire('Error', 'Gagal memuat data', 'error');
            });
    }

    // ===============================
    // SIMPAN DATA
    // ===============================
    document.getElementById('formKelas').addEventListener('submit', function(e){
        e.preventDefault();

        const id = document.getElementById('kelasId').value;
        const url = id ? `/admin/kelas/${id}` : '/admin/kelas';
        const formData = new FormData(this);

        if(id){
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(() => {

            fetchKelas();
            this.reset();
            document.getElementById('kelasId').value = '';

            bootstrap.Modal.getInstance(document.getElementById('modalKelas')).hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil disimpan',
                timer: 1200,
                showConfirmButton: false
            });
        })
        .catch(err => {
            Swal.fire('Error', 'Gagal menyimpan data', 'error');
        });
    });

    // ===============================
    // EVENT TABLE (EDIT & DELETE)
    // ===============================
    document.querySelector('#kelasTable').addEventListener('click', function(e){

        // ===== EDIT =====
        if(e.target.classList.contains('btn-edit')){
            const id = e.target.dataset.id;

            fetch(`/admin/kelas/${id}`)
                .then(res => res.json())
                .then(data => {

                    document.getElementById('kelasId').value = data.id;
                    document.getElementById('namaKelas').value = data.nama ?? data.name;

                    new bootstrap.Modal(document.getElementById('modalKelas')).show();
                });
        }

        // ===== DELETE =====
        if(e.target.classList.contains('btn-delete')){
            const id = e.target.dataset.id;

            Swal.fire({
                title: 'Yakin?',
                text: 'Data akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus'
            }).then((result) => {

                if(result.isConfirmed){
                    fetch(`/admin/kelas/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(() => {

                        fetchKelas();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil dihapus',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    });
                }

            });
        }

    });

});
</script>
@endpush