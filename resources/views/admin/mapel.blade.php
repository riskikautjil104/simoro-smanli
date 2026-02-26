@extends('layouts.master')

@section('title', 'Data Mapel')

@push('styles')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Tambahkan custom style jika perlu --}}
@endpush

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Mapel</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMapel">Tambah Mapel</button>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="mapelTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mapel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data mapel akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit Mapel -->
<div class="modal fade" id="modalMapel" tabindex="-1" aria-labelledby="modalMapelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMapelLabel">Tambah/Edit Mapel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formMapel">
        <div class="modal-body">
          <input type="hidden" name="id" id="mapelId">
          <div class="mb-3">
            <label for="namaMapel" class="form-label">Nama Mapel</label>
            <input type="text" class="form-control" id="namaMapel" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="kodeMapel" class="form-label">Kode Mapel</label>
            <input type="text" class="form-control" id="kodeMapel" name="code" required>
          </div>
          <div class="mb-3">
            <label for="guruMapel" class="form-label">Guru Pengajar</label>
            <select class="form-control" id="guruMapel" name="teacher_id" required>
              <!-- Opsi guru akan di-render di sini -->
            </select>
          </div>
          <div class="mb-3">
            <label for="kelasMapel" class="form-label">Kelas</label>
            <select class="form-control" id="kelasMapel" name="kelas_id[]" multiple required>
              <!-- Opsi kelas akan di-render di sini -->
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
<script>
document.addEventListener('DOMContentLoaded', function () {
  fetchMapel();
  fetchGuru();
  fetchKelas();

  function fetchMapel() {
    fetch('/admin/mapel', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(res => res.json())
      .then(data => {
        let rows = '';
        data.forEach((mapel, i) => {
          let kelasList = mapel.classes.map(k => k.name).join(', ');
          let guruNama = mapel.teacher ? (mapel.teacher.name || mapel.teacher.nama) : '-';
          rows += `<tr>
            <td>${i+1}</td>
            <td>
              <b>${mapel.name}</b><br>
              <small>Kode: ${mapel.code}</small><br>
              <small>Guru: ${guruNama}</small><br>
              <small>Kelas: ${kelasList}</small>
            </td>
            <td>
              <button class='btn btn-sm btn-warning btn-edit' data-id='${mapel.id}'>Edit</button>
              <button class='btn btn-sm btn-danger btn-delete' data-id='${mapel.id}'>Hapus</button>
            </td>
          </tr>`;
        });
        document.querySelector('#mapelTable tbody').innerHTML = rows;
      });
  }

  function fetchGuru() {
    fetch('/admin/guru', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(res => res.json())
      .then(data => {
        let options = '';
        data.forEach(guru => {
          options += `<option value="${guru.id}">${guru.name || guru.nama}</option>`;
        });
        document.getElementById('guruMapel').innerHTML = options;
      });
  }

  function fetchKelas() {
    fetch('/admin/kelas/list')
      .then(res => res.json())
      .then(data => {
        let options = '';
        data.forEach(kelas => {
          options += `<option value="${kelas.id}">${kelas.nama ?? kelas.name}</option>`;
        });
        document.getElementById('kelasMapel').innerHTML = options;
      });
  }

  document.getElementById('formMapel').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('mapelId').value;
    const method = id ? 'POST' : 'POST';
    const url = id ? `/admin/mapel/${id}` : '/admin/mapel';
    const formData = new FormData(this);
    if (id) {
      formData.append('_method', 'PUT');
    }
    // Ensure kelas multi-select is sent as array
    const kelasSelect = document.getElementById('kelasMapel');
    const selectedKelas = Array.from(kelasSelect.selectedOptions).map(opt => opt.value);
    formData.delete('kelas_id[]');
    selectedKelas.forEach(val => formData.append('kelas_id[]', val));
    // Debug log
    let debug = '';
    for (let pair of formData.entries()) {
      debug += pair[0] + ': ' + pair[1] + '\n';
    }
    console.log('FormData:', debug);
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
        let msg = 'Gagal menyimpan data mapel';
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
      fetchMapel();
      this.reset();
      document.getElementById('mapelId').value = '';
      var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMapel'));
      modal.hide();
      document.activeElement.blur();
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data mapel berhasil disimpan!',
        timer: 1200,
        showConfirmButton: false
      });
    })
    .catch(() => {});
  });

  document.querySelector('#mapelTable').addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
      const id = e.target.getAttribute('data-id');
      fetch(`/admin/mapel/${id}`, {
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
        .then(async res => {
          if (!res.ok) {
            Swal.fire('Error', 'Gagal mengambil data mapel', 'error');
            throw new Error('Gagal mengambil data mapel');
          }
          return res.json();
        })
        .then(mapel => {
          document.getElementById('mapelId').value = mapel.id;
          document.getElementById('namaMapel').value = mapel.name;
          document.getElementById('kodeMapel').value = mapel.code;
          document.getElementById('guruMapel').value = mapel.teacher_id;
          // Set kelas multi-select
          const kelasSelect = document.getElementById('kelasMapel');
          Array.from(kelasSelect.options).forEach(opt => {
            opt.selected = mapel.classes.some(k => k.id == opt.value);
          });
          var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMapel'));
          modal.show();
          Swal.fire({
            icon: 'info',
            title: 'Edit Mapel',
            text: 'Data mapel siap diedit!',
            timer: 1200,
            showConfirmButton: false
          });
        })
        .catch(() => {});
    }
    if (e.target.classList.contains('btn-delete')) {
      const id = e.target.getAttribute('data-id');
      Swal.fire({
        title: 'Hapus Mapel?',
        text: 'Data mapel akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/admin/mapel/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            }
          })
          .then(async res => {
            if (!res.ok) {
              Swal.fire('Error', 'Gagal menghapus data mapel', 'error');
              throw new Error('Gagal menghapus data mapel');
            }
            fetchMapel();
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Data mapel berhasil dihapus!',
              timer: 1200,
              showConfirmButton: false
            });
          })
          .catch(() => {
            Swal.fire('Error', 'Terjadi error saat hapus mapel', 'error');
          });
        }
      });
    }
  });
});
</script>
@endpush
