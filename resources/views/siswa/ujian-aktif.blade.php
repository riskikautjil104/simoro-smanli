@extends('layouts.master')
@section('title', 'Ujian Aktif')
@section('layoutContent')
<div class="card p-4">
    <h4>Daftar Ujian Aktif</h4>
    <div id="ujianAktifContent">
        <div class="text-muted">Memuat data ujian aktif...</div>
    </div>
</div>
@push('scripts')
<script>


document.addEventListener('DOMContentLoaded', function() {
    fetch('/siswa/ujian/aktif/json', { headers: { 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (!data.length) {
                html = '<div class="text-muted">Tidak ada ujian aktif saat ini.</div>';
            } else {
                html = '<ul class="list-group">';
                data.forEach(ujian => {
                    let tombol = '';
                    if (ujian.status_logout == 1 && ujian.reapply_status != 2) {
                        tombol = `<a href="/siswa/ujian/${ujian.id}" class="btn btn-warning btn-sm">Ajukan Ulang</a>`;
                    } else {
                        tombol = `<a href="/siswa/ujian/${ujian.id}" class="btn btn-primary btn-sm">Kerjakan</a>`;
                    }
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <b>${ujian.nama}</b><br>
                            <span class="badge bg-info">${ujian.mapel}</span>
                            <span class="badge bg-secondary">${ujian.tanggal}</span>
                        </div>
                        ${tombol}
                    </li>`;
                });
                html += '</ul>';
            }
            document.getElementById('ujianAktifContent').innerHTML = html;
        });
});
</script>
@endpush
@endsection
