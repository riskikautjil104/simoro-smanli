@extends('layouts.master')

@section('title', 'Data Ujian')

@push('styles')
        @section('layoutContent')
@endpush

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Ujian</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUjian">Tambah Ujian</button>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="ujianTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data ujian akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit Ujian -->
<div class="modal fade" id="modalUjian" tabindex="-1" aria-labelledby="modalUjianLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUjianLabel">Tambah/Edit Ujian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formUjian">
        <div class="modal-body">
          <input type="hidden" name="id" id="ujianId">
          <div class="mb-3">
            <label for="namaUjian" class="form-label">Nama Ujian</label>
            <input type="text" class="form-control" id="namaUjian" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="mapelUjian" class="form-label">Mata Pelajaran</label>
            <select class="form-control" id="mapelUjian" name="mapel_id" required>
              {{-- Opsi mapel --}}
            </select>
          </div>
          <div class="mb-3">
            <label for="kelasUjian" class="form-label">Kelas</label>
            <select class="form-control" id="kelasUjian" name="kelas_id" required>
              {{-- Opsi kelas --}}
            </select>
          </div>
          <div class="mb-3">
            <label for="tanggalUjian" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggalUjian" name="tanggal" required>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  fetchUjian();
  fetchMapel();
  fetchKelas();

  function fetchUjian() {
    fetch('/admin/ujian-list')
      .then(res => res.json())
      .then(data => {
        let rows = '';
        data.forEach((ujian, i) => {
          rows += `<tr>
            <td>${i+1}</td>
            <td>${ujian.nama}</td>
            <td>${ujian.mapel ? ujian.mapel.nama : '-'}</td>
            <td>${ujian.kelas ? ujian.kelas.nama : '-'}</td>
            <td>${ujian.tanggal}</td>
            <td>
              <button class='btn btn-sm btn-warning btn-edit' data-id='${ujian.id}'>Edit</button>
              <button class='btn btn-sm btn-danger btn-delete' data-id='${ujian.id}'>Hapus</button>
            </td>
          </tr>`;
        });
        document.querySelector('#ujianTable tbody').innerHTML = rows;
      });
  }

  function fetchMapel() {
    fetch('/admin/mapel', {
      headers: { 'Accept': 'application/json' }
    })
      .then(res => res.json())
      .then(data => {
        let options = '';
        data.forEach(mapel => {
          options += `<option value="${mapel.id}">${mapel.name}</option>`;
        });
        document.getElementById('mapelUjian').innerHTML = options;
      });
  }
  function fetchKelas() {
    fetch('/admin/kelas', {
      headers: { 'Accept': 'application/json' }
    })
      .then(res => res.json())
      .then(data => {
        let options = '';
        data.forEach(kelas => {
          options += `<option value="${kelas.id}">${kelas.name}</option>`;
        });
        document.getElementById('kelasUjian').innerHTML = options;
      });
  }

  document.getElementById('formUjian').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('ujianId').value;
    const method = id ? 'PUT' : 'POST';
    const url = id ? `/admin/ujian/${id}` : '/admin/ujian';
    const data = {
      nama: document.getElementById('namaUjian').value,
      mapel_id: document.getElementById('mapelUjian').value,
      kelas_id: document.getElementById('kelasUjian').value,
      tanggal: document.getElementById('tanggalUjian').value
    };
    fetch(url, {
      method: method,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
    })
    .then(res => {
      if (!res.ok) throw new Error('Gagal menyimpan data');
      return res.json();
    })
    .then(() => {
      fetchUjian();
      this.reset();
      document.getElementById('ujianId').value = '';
      var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUjian'));
      modal.hide();
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data ujian berhasil disimpan!',
        timer: 1200,
        showConfirmButton: false
      });
    })
    .catch(() => {
      Swal.fire('Error', 'Gagal menyimpan data ujian', 'error');
    });
  });

  document.querySelector('#ujianTable').addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
      const id = e.target.getAttribute('data-id');
      fetch(`/admin/ujian/${id}`)
        .then(res => res.json())
        .then(ujian => {
          document.getElementById('ujianId').value = ujian.id;
          document.getElementById('namaUjian').value = ujian.title || ujian.nama || '';
          document.getElementById('mapelUjian').value = ujian.subject_id || ujian.mapel_id || '';
          document.getElementById('kelasUjian').value = ujian.class_id || ujian.kelas_id || '';
          // Format tanggal ke yyyy-mm-dd jika ada
          let tgl = ujian.start_time || ujian.tanggal || '';
          if (tgl && tgl.length > 10) tgl = tgl.substring(0, 10);
          document.getElementById('tanggalUjian').value = tgl;
          var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUjian'));
          modal.show();
        });
    }
    if (e.target.classList.contains('btn-delete')) {
      const id = e.target.getAttribute('data-id');
      Swal.fire({
        title: 'Hapus Ujian?',
        text: 'Data ujian akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/admin/ujian/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            }
          })
          .then(() => {
            fetchUjian();
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Data ujian berhasil dihapus!',
              timer: 1200,
              showConfirmButton: false
            });
          })
          .catch(() => {
            Swal.fire('Error', 'Terjadi error saat hapus ujian', 'error');
          });
        }
      });
    }
  });
});
</script>
@endpush
