@extends('layouts.master')

@section('title', 'Dashboard Guru')

@section('layoutContent')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 d-flex flex-column flex-md-row align-items-center justify-content-between animate__animated animate__fadeInDown" style="background:#f8f9fa;">
            <div class="mb-3 mb-md-0">
                <h5 class="fw-bold text-primary mb-2 animate__animated animate__fadeInLeft">Selamat datang, {{ auth()->user()->name }}!</h5>
                <div class="mb-2 animate__animated animate__fadeInLeft animate__delay-1s">Panel guru SMA Negeri 5.<br>Kelola mata pelajaran, soal, ujian, monitoring, dan hasil ujian Anda di sini.</div>
            </div>
            <img src="{{ asset('assets/img/teacher.svg') }}" alt="Guru" width="260" class="d-none d-md-block animate__animated animate__fadeInRight">
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp" style="background:linear-gradient(135deg,#e0ffe7 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-journal-bookmark-fill text-success" style="font-size:2.5rem;"></i></div>
            <div class="fw-bold text-muted">Mapel Saya</div>
            <div class="display-6 fw-bold text-success" id="statMapel">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-1s" style="background:linear-gradient(135deg,#e0f0ff 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-archive text-primary" style="font-size:2.5rem;"></i></div>
            <div class="fw-bold text-muted">Bank Soal</div>
            <div class="display-6 fw-bold text-primary" id="statSoal">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-2s" style="background:linear-gradient(135deg,#fffbe0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-clipboard-plus text-warning" style="font-size:2.5rem;"></i></div>
            <div class="fw-bold text-muted">Ujian Dibuat</div>
            <div class="display-6 fw-bold text-warning" id="statUjian">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-3s" style="background:linear-gradient(135deg,#ffe0e0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-bar-chart-line-fill text-danger" style="font-size:2.5rem;"></i></div>
            <div class="fw-bold text-muted">Hasil Ujian</div>
            <div class="display-6 fw-bold text-danger" id="statHasil">0</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/guru/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('statMapel').textContent = data.mapel;
        document.getElementById('statSoal').textContent = data.soal;
        document.getElementById('statUjian').textContent = data.ujian;
        document.getElementById('statHasil').textContent = data.hasil;
    });
});
</script>
@endpush
