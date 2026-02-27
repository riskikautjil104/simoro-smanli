@extends('layouts.master')
@section('title', 'Riwayat Ujian')
@section('layoutContent')
<div class="card p-4">
    <h4>Riwayat Ujian</h4>
    <div id="riwayatUjianContent">
        <div class="text-muted">Memuat riwayat ujian...</div>
    </div>
</div>

@push('scripts')
<script>
fetch('/siswa/ujian/riwayat/json')
    .then(res => res.json())
    .then(data => {
        let html = '';
        if (!data.length) {
            html = '<div class="text-muted">Belum ada riwayat ujian.</div>';
        } else {
            html = '<ul class="list-group">';
            data.forEach(riwayat => {
                let cetakBtn = '';
                if (riwayat.nilai !== '-' && riwayat.nilai !== null && riwayat.id) {
                    cetakBtn = `<a href="/siswa/ujian/${riwayat.id}/hasil" target="_blank" class="btn btn-sm btn-success float-end ms-2">Cetak</a>`;
                }
                html += `<li class="list-group-item">
                    <b>${riwayat.nama}</b><br>
                    <span class="badge bg-info">${riwayat.mapel}</span>
                    <span class="badge bg-secondary">Nilai: ${riwayat.nilai}</span>
                    <span class="badge bg-success">${riwayat.tanggal}</span>
                    ${cetakBtn}
                </li>`;
            });
            html += '</ul>';
        }
        document.getElementById('riwayatUjianContent').innerHTML = html;
    });
</script>
@endpush
@endsection
