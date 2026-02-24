@extends('layouts.master')

@section('title', 'Detail Ujian')

@section('layoutContent')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('admin.ujian.index') }}" class="btn btn-secondary btn-sm">&larr; Kembali ke Daftar Ujian</a>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <h4 id="ujianTitle">Detail Ujian</h4>
            <div id="ujianInfo" class="mb-2 text-muted">Memuat data ujian...</div>
            <div id="ujianStats" class="mb-2"></div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Daftar Siswa Peserta</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Durasi</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pesertaTableBody">
                    <tr><td colspan="8" class="text-center">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Ranking Nilai Tertinggi</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody id="rankingTableBody">
                    <tr><td colspan="4" class="text-center">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Periksa Jawaban Siswa -->
<div class="modal fade" id="modalPriksaJawaban" tabindex="-1" aria-labelledby="modalPriksaJawabanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPriksaJawabanLabel">Periksa Jawaban Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="priksaJawabanContent">
        Memuat jawaban siswa...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSimpanNilai">Simpan Penilaian</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
        // Ambil ujian_id dari URL (misal: /admin/ujian/{id}/detail)
        const ujianId = window.location.pathname.match(/\/(\d+)(\/detail)?$/) ? window.location.pathname.match(/\/(\d+)(\/detail)?$/)[1] : null;
        if (!ujianId) return;

        // Load info ujian
        fetch(`/admin/ujian/${ujianId}`, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                document.getElementById('ujianTitle').textContent = data.nama || data.title || '-';
                document.getElementById('ujianInfo').innerHTML = `
                    <b>Mapel:</b> ${data.mapel?.nama || '-'}<br>
                    <b>Kelas:</b> ${data.kelas?.nama || '-'}<br>
                    <b>Mulai:</b> ${data.start_time || '-'}<br>
                    <b>Durasi:</b> ${data.duration || '-'} menit
                `;
            });

        // Load peserta ujian
        fetch(`/admin/ujian/${ujianId}/peserta`, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                let rows = '';
                if (!data.length) rows = '<tr><td colspan="8" class="text-center">Belum ada peserta.</td></tr>';
                data.forEach((s, i) => {
                    rows += `<tr>
                        <td>${i+1}</td>
                        <td>${s.nama}</td>
                        <td>${s.kelas || '-'}</td>
                        <td>${s.mulai || '-'}</td>
                        <td>${s.selesai || '-'}</td>
                        <td>${s.durasi || '-'}</td>
                        <td>${s.nilai ?? '-'}</td>
                        <td><button class='btn btn-sm btn-info btn-priksa' data-peserta='${s.id}'>Periksa</button></td>
                    </tr>`;
                });
                document.getElementById('pesertaTableBody').innerHTML = rows;
            });

        // Load ranking
        fetch(`/admin/ujian/${ujianId}/ranking`, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                let rows = '';
                if (!data.length) rows = '<tr><td colspan="4" class="text-center">Belum ada nilai.</td></tr>';
                data.forEach((s, i) => {
                    rows += `<tr>
                        <td>${i+1}</td>
                        <td>${s.nama}</td>
                        <td>${s.kelas || '-'}</td>
                        <td>${s.nilai ?? '-'}</td>
                    </tr>`;
                });
                document.getElementById('rankingTableBody').innerHTML = rows;
            });

        // Handler periksa jawaban
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-priksa')) {
                const pesertaId = e.target.getAttribute('data-peserta');
                document.getElementById('priksaJawabanContent').innerHTML = 'Memuat jawaban siswa...';
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPriksaJawaban'));
                modal.show();
                fetch(`/admin/ujian/${ujianId}/peserta/${pesertaId}/jawaban`, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        if (!data.length) html = '<div class="alert alert-warning">Belum ada jawaban.</div>';
                        data.forEach((j, i) => {
                            html += `<div class='mb-3'><b>#${i+1}.</b> ${j.pertanyaan}<br>`;
                            if (j.tipe === 'pg') {
                                html += `<div class='mb-1'>
                                    <span class='badge bg-secondary'>A</span> ${j.opsi_a} &nbsp;
                                    <span class='badge bg-secondary'>B</span> ${j.opsi_b} &nbsp;
                                    <span class='badge bg-secondary'>C</span> ${j.opsi_c} &nbsp;
                                    <span class='badge bg-secondary'>D</span> ${j.opsi_d}
                                </div>`;
                                html += `<div>Jawaban Siswa: <b>${j.jawaban_siswa || '-'}</b> | Kunci: <b>${j.jawaban_benar || '-'}</b></div>`;
                            } else {
                                html += `<div>Jawaban Siswa: <i>${j.jawaban_siswa || '-'}</i></div>`;
                                html += `<div class='mt-1'>Nilai Essay: <input type='number' class='form-control d-inline-block' style='width:80px' name='nilai_essay[${j.id}]' value='${j.nilai_essay ?? ''}' min='0' max='100'></div>`;
                            }
                            html += '</div>';
                        });
                        document.getElementById('priksaJawabanContent').innerHTML = html;
                    });
                // Simpan penilaian
                document.getElementById('btnSimpanNilai').onclick = function() {
                    const inputs = document.querySelectorAll('#priksaJawabanContent input[name^="nilai_essay"]');
                    let nilai = {};
                    inputs.forEach(inp => {
                        nilai[inp.name.match(/\[(\d+)\]/)[1]] = inp.value;
                    });
                    fetch(`/admin/ujian/${ujianId}/peserta/${pesertaId}/nilai`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ nilai_essay: nilai })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Penilaian berhasil disimpan!');
                        modal.hide();
                    });
                };
            }
        });
});
</script>
@endpush
