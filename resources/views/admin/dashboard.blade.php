@extends('layouts.master')

@section('title', 'Dashboard')

@section('layoutContent')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 d-flex flex-column flex-md-row align-items-center justify-content-between animate__animated animate__fadeInDown" style="background:#f8f9fa;">
            <div class="mb-3 mb-md-0">
                <h5 class="fw-bold text-primary mb-2 animate__animated animate__fadeInLeft">Selamat datang di SMA5 CBT!</h5>
                <div class="mb-2 animate__animated animate__fadeInLeft animate__delay-1s">Sistem ujian dan ulangan online SMA Negeri 5.<br>Kelola data siswa, guru, kelas, mapel, ujian, soal, monitoring, dan laporan hasil ujian.</div>
                <a href="/admin/ujian" class="btn btn-primary btn-sm animate__animated animate__pulse animate__infinite">Mulai Ujian</a>
            </div>
            <img src="{{ asset('assets/img/people.svg') }}" alt="CBT" width="300" class="d-none d-md-block animate__animated animate__fadeInRight">
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center animate__animated animate__zoomIn">
            <div class="mb-2"><i class="bi bi-people text-success fs-2"></i></div>
            <div class="fw-bold text-muted">Total Siswa</div>
            <div class="fs-5 fw-bold text-success">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center animate__animated animate__zoomIn animate__delay-1s">
            <div class="mb-2"><i class="bi bi-person-badge text-primary fs-2"></i></div>
            <div class="fw-bold text-muted">Total Guru</div>
            <div class="fs-5 fw-bold text-primary">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center animate__animated animate__zoomIn animate__delay-2s">
            <div class="mb-2"><i class="bi bi-building text-warning fs-2"></i></div>
            <div class="fw-bold text-muted">Total Kelas</div>
            <div class="fs-5 fw-bold text-warning">0</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center animate__animated animate__zoomIn animate__delay-3s">
            <div class="mb-2"><i class="bi bi-journal-bookmark text-danger fs-2"></i></div>
            <div class="fw-bold text-muted">Total Mapel</div>
            <div class="fs-5 fw-bold text-danger">0</div>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-4 animate__animated animate__fadeInUp">
            <div class="fw-bold mb-2">Total Ujian</div>
            <div class="fs-4 fw-bold text-primary">0</div>
            <div class="mb-2">Ujian aktif dan selesai</div>
            <canvas id="chartUjian" height="120"></canvas>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-4 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="fw-bold mb-2">Monitoring Ujian</div>
            <div class="fs-4 fw-bold text-success">0</div>
            <div class="mb-2">Peserta ujian online</div>
            <canvas id="chartPeserta" height="120"></canvas>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 animate__animated animate__fadeIn animate__delay-2s">
            <div class="fw-bold mb-2">Laporan Hasil Ujian</div>
            <div class="mb-2">Statistik nilai, kelulusan, dan analisis hasil ujian.</div>
            <canvas id="chartLaporan" height="120"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// TODO: AJAX statistik dan chart dashboard
</script>
@endpush
