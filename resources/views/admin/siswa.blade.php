@extends('layouts.master')

@section('title', 'Data Siswa')

@push('styles')
{{-- Tambahkan custom style jika perlu --}}
@endpush

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Siswa</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSiswa">Tambah Siswa</button>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="siswaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data siswa akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit Siswa -->
<div class="modal fade" id="modalSiswa" tabindex="-1" aria-labelledby="modalSiswaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSiswaLabel">Tambah/Edit Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formSiswa">
        <div class="modal-body">
          <input type="hidden" name="id" id="siswaId">
          <div class="mb-3">
            <label for="namaSiswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" id="namaSiswa" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="emailSiswa" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailSiswa" name="email" required>
          </div>
          <div class="mb-3">
            <label for="kelasSiswa" class="form-label">Kelas</label>
            <select class="form-control" id="kelasSiswa" name="kelas_id" required>
              {{-- Opsi kelas akan di-render di sini --}}
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
@endsection


@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  fetchSiswa();
  fetchKelas();

  // Fetch data siswa
  function fetchSiswa() {
    fetch('/admin/siswa', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      credentials: 'same-origin'
    })
      .then(res => {
        if (!res.ok) throw new Error('admin siswa failed');
        return res.json();
      })
      .then(data => {
        let rows = '';
        data.forEach((siswa, i) => {
          rows += `<tr>
            <td>${i+1}</td>
            <td>${siswa.nama}</td>
            <td>${siswa.email}</td>
            <td>${siswa.kelas ? siswa.kelas.nama : '-'}</td>
            <td>
              <button class='btn btn-sm btn-warning btn-edit' data-id='${siswa.id}'>Edit</button>
              <button class='btn btn-sm btn-danger btn-delete' data-id='${siswa.id}'>Hapus</button>
            </td>
          </tr>`;
        });
        document.querySelector('#siswaTable tbody').innerHTML = rows;
      })
      .catch(err => {
        Swal.fire('Error', 'Gagal memuat data siswa', 'error');
      });
  }

  // Fetch kelas untuk select
  function fetchKelas() {
    fetch('/admin/kelas', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      credentials: 'same-origin'
    })
      .then(res => {
        if (!res.ok) throw new Error('admin kelas failed');
        return res.json();
      })
      .then(data => {
        let options = '';
        data.forEach(kelas => {
          options += `<option value="${kelas.id}">${kelas.name}</option>`;
        });
        document.getElementById('kelasSiswa').innerHTML = options;
      })
      .catch(err => {
        Swal.fire('Error', 'Gagal memuat data kelas', 'error');
      });
  }

  // Submit form create/edit
  document.getElementById('formSiswa').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('siswaId').value;
    const method = id ? 'POST' : 'POST';
    const url = id ? `/siswa/${id}` : '/siswa';
    const formData = new FormData(this);
    if (id) {
      formData.append('_method', 'PUT');
    }
    fetch(url, {
      method: method,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      },
      body: formData
    })
    .then(async res => {
      if (!res.ok) {
        let msg = 'Gagal menyimpan data siswa';
        try {
          const err = await res.json();
          if (err.errors) {
            msg = Object.values(err.errors).map(e => e.join('<br>')).join('<br>');
          } else if (err.message) {
            msg = err.message;
          }
        } catch {}
        Swal.fire('Error', msg, 'error');
        throw new Error(msg);
      }
      return res.json();
    })
    .then(() => {
      fetchSiswa();
      this.reset();
      document.getElementById('siswaId').value = '';
      var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSiswa'));
      modal.hide();
      document.activeElement.blur();
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data siswa berhasil disimpan!',
        timer: 1200,
        showConfirmButton: false
      });
    })
    .catch(() => {});
  });

  // Edit button
  document.querySelector('#siswaTable').addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
      const id = e.target.getAttribute('data-id');
      fetch(`/admin/siswa/${id}`, {
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
      })
        .then(res => {
          if (!res.ok) throw new Error('admin siswa detail failed');
          return res.json();
        })
        .then(siswa => {
          document.getElementById('siswaId').value = siswa.id;
          document.getElementById('namaSiswa').value = siswa.nama;
          document.getElementById('emailSiswa').value = siswa.email;
          document.getElementById('kelasSiswa').value = siswa.kelas_id;
          var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalSiswa'));
          modal.show();
        })
        .catch(err => {
          Swal.fire('Error', 'Gagal mengambil data siswa', 'error');
        });
    }
    // Delete button
    if (e.target.classList.contains('btn-delete')) {
      const id = e.target.getAttribute('data-id');
      Swal.fire({
        title: 'Hapus Siswa?',
        text: 'Data siswa akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/siswa/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            }
          })
          .then(() => {
            fetchSiswa();
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Data siswa berhasil dihapus!',
              timer: 1200,
              showConfirmButton: false
            });
          })
          .catch(() => {
            Swal.fire('Error', 'Gagal menghapus data siswa', 'error');
          });
        }
      });
    }
  });
});
</script>
@endpush
