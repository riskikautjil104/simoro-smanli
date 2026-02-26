@extends('layouts.master')

@section('title', 'Data Guru')

@push('styles')
{{-- Tambahkan custom style jika perlu --}}
@endpush

@section('layoutContent')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Guru</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGuru">Tambah Guru</button>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="guruTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data guru akan di-render di sini --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit Guru -->
<div class="modal fade" id="modalGuru" tabindex="-1" aria-labelledby="modalGuruLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGuruLabel">Tambah/Edit Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formGuru">
        <div class="modal-body">
          <input type="hidden" name="id" id="guruId">
          <div class="mb-3">
            <label for="namaGuru" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" id="namaGuru" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="emailGuru" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailGuru" name="email" required>
          </div>
          <div class="mb-3">
            <label for="nipGuru" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nipGuru" name="nip" required>
          </div>
          <div class="mb-3">
            <label for="hpGuru" class="form-label">No HP</label>
            <input type="text" class="form-control" id="hpGuru" name="phone" required>
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
// Tambah Akun Guru
document.addEventListener('DOMContentLoaded', function () {
  fetchGuruListAkun();
  function fetchGuruListAkun() {
    fetch('/admin/guru-list', { headers: { 'Accept': 'application/json' } })
      .then(res => res.json())
      .then(data => {
        let options = '<option value="">-- Pilih Guru --</option>';
        data.forEach(guru => {
          options += `<option value="${guru.id}" data-nip="${guru.nip}" data-phone="${guru.phone}">${guru.name}</option>`;
        });
        document.getElementById('pilihGuruAkun').innerHTML = options;
      });
  }
  document.getElementById('pilihGuruAkun').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('nipGuruAkun').value = selected.getAttribute('data-nip') || '';
    document.getElementById('hpGuruAkun').value = selected.getAttribute('data-phone') || '';
  });
  document.getElementById('formAkunGuru').addEventListener('submit', function(e) {
    e.preventDefault();
    const guruId = document.getElementById('pilihGuruAkun').value;
    const email = document.getElementById('emailGuruAkun').value;
    const password = document.getElementById('passwordGuruAkun').value;
    if (!guruId || !email || !password) {
      Swal.fire('Error', 'Semua field wajib diisi!', 'error');
      return;
    }
    fetch(`/admin/guru-akun/${guruId}`, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(resp => {
      if (resp.success) {
        fetchGuru();
        this.reset();
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalAkunGuru'));
        modal.hide();
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: 'Akun guru berhasil dibuat!',
          timer: 1200,
          showConfirmButton: false
        });
        fetchGuruListAkun();
      } else {
        Swal.fire('Error', resp.message || 'Gagal membuat akun guru', 'error');
      }
    })
    .catch(err => {
      Swal.fire('Error', 'Gagal membuat akun guru', 'error');
    });
  });
});
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  fetchGuru();

  function fetchGuru() {
    fetch('/admin/guru', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(res => res.json())
      .then(data => {
        let rows = '';
        data.forEach((guru, i) => {
          let mapelList = guru.subjects ? guru.subjects.map(s => s.name).join(', ') : '-';
          let kelasList = guru.subjects ? guru.subjects.flatMap(s => s.classes.map(k => k.name)).filter((v, i, arr) => arr.indexOf(v) === i).join(', ') : '-';
          let namaGuru = guru.name || guru.nama || '-';
          rows += `<tr>
            <td>${i+1}</td>
            <td>${namaGuru}<br><small>Mapel: ${mapelList}</small><br><small>Kelas: ${kelasList}</small></td>
            <td>${guru.email}</td>
            <td>${guru.nip || ''}</td>
            <td>${guru.phone || ''}</td>
            <td>
              <button class='btn btn-sm btn-warning btn-edit' data-id='${guru.id}'>Edit</button>
              <button class='btn btn-sm btn-danger btn-delete' data-id='${guru.id}'>Hapus</button>
            </td>
          </tr>`;
        });
        document.querySelector('#guruTable tbody').innerHTML = rows;
      })
      .catch(err => {
        Swal.fire('Error', 'Gagal memuat data guru', 'error');
      });
  }

  document.getElementById('formGuru').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('guruId').value;
    let method = 'POST';
    const url = id ? `/admin/guru/${id}` : '/admin/guru';
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
    .then(res => res.json())
    .then(() => {
      fetchGuru();
      this.reset();
      document.getElementById('guruId').value = '';
      var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalGuru'));
      modal.hide();
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data guru berhasil disimpan!',
        timer: 1200,
        showConfirmButton: false
      });
    })
    .catch(err => {
      Swal.fire('Error', 'Gagal menyimpan data guru', 'error');
    });
  });

  document.querySelector('#guruTable').addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-edit')) {
      const id = e.target.getAttribute('data-id');
      fetch(`/admin/guru/${id}`, {
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
        .then(res => res.json())
        .then(guru => {
          document.getElementById('guruId').value = guru.id;
          document.getElementById('namaGuru').value = guru.name || guru.nama || '';
          document.getElementById('emailGuru').value = guru.email;
          document.getElementById('nipGuru').value = guru.nip || '';
          document.getElementById('hpGuru').value = guru.phone || '';
          var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalGuru'));
          modal.show();
        })
        .catch(err => {
          Swal.fire('Error', 'Gagal mengambil data guru', 'error');
        });
    }
    if (e.target.classList.contains('btn-delete')) {
      const id = e.target.getAttribute('data-id');
      Swal.fire({
        title: 'Hapus Guru?',
        text: 'Data guru akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`/admin/guru/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            }
          })
          .then(res => res.json())
          .then(() => {
            fetchGuru();
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Data guru berhasil dihapus!',
              timer: 1200,
              showConfirmButton: false
            });
          })
          .catch(err => {
            Swal.fire('Error', 'Gagal menghapus data guru', 'error');
          });
        }
      });
    }
  });
});
</script>
@endpush
