@extends('layouts.master')

@section('title', 'Dashboard Siswa')

@section('layoutContent')
<div class="container py-4">
    <h4 class="mb-4">Selamat datang, {{ auth()->user()->name }}</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Ujian Aktif</h5>
                    <div id="ujianAktifContent">
                        <div class="text-muted">Memuat ujian...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Riwayat Ujian</h5>
                    <div id="riwayatUjianContent">
                        <div class="text-muted">Memuat riwayat...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Profil</h5>
                    <table class="table table-sm">
                        <tr><th>Nama</th><td>{{ auth()->user()->name }}</td></tr>
                        <tr><th>NIS</th><td>{{ auth()->user()->nis }}</td></tr>
                        <tr><th>Kelas</th><td>{{ auth()->user()->class->name ?? '-' }}</td></tr>
                        <tr><th>Email</th><td>{{ auth()->user()->email }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
fetch('/siswa/ujian/aktif/json')
    .then(res => res.json())
    .then(data => {
        let html = '';
        if (!data.length) {
            html = '<div class="text-muted">Tidak ada ujian aktif.</div>';
        } else {
            html = '<ul class="list-group">';
            data.forEach(ujian => {
                html += `<li class="list-group-item">
                    <b>${ujian.nama}</b><br>
                    <span class="badge bg-info">${ujian.mapel}</span>
                    <span class="badge bg-success">${ujian.tanggal}</span>
                    <a href="/siswa/ujian/${ujian.id}" class="btn btn-sm btn-primary float-end">Ikuti</a>
                </li>`;
            });
            html += '</ul>';
        }
        document.getElementById('ujianAktifContent').innerHTML = html;
    });

fetch('/siswa/ujian/riwayat/json')
    .then(res => res.json())
    .then(data => {
        let html = '';
        if (!data.length) {
            html = '<div class="text-muted">Belum ada riwayat ujian.</div>';
        } else {
            html = '<ul class="list-group">';
            data.forEach(riwayat => {
                html += `<li class="list-group-item">
                    <b>${riwayat.nama}</b><br>
                    <span class="badge bg-info">${riwayat.mapel}</span>
                    <span class="badge bg-secondary">Nilai: ${riwayat.nilai}</span>
                    <span class="badge bg-success">${riwayat.tanggal}</span>
                </li>`;
            });
            html += '</ul>';
        }
        document.getElementById('riwayatUjianContent').innerHTML = html;
    });
</script>
@endpush
