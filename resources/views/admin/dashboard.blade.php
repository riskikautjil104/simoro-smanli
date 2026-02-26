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
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp" style="background:linear-gradient(135deg,#e0ffe7 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-people-fill text-success" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Siswa</div>
            <div class="display-5 fw-bold text-success">0</div>
            <div class="small text-muted">Siswa aktif terdaftar</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-1s" style="background:linear-gradient(135deg,#e0f0ff 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-person-badge-fill text-primary" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Guru</div>
            <div class="display-5 fw-bold text-primary">0</div>
            <div class="small text-muted">Guru pengajar aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-2s" style="background:linear-gradient(135deg,#fffbe0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-building text-warning" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Kelas</div>
            <div class="display-5 fw-bold text-warning">0</div>
            <div class="small text-muted">Kelas aktif</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-lg p-4 text-center animate__animated animate__fadeInUp animate__delay-3s" style="background:linear-gradient(135deg,#ffe0e0 60%,#fff 100%);">
            <div class="mb-2"><i class="bi bi-journal-bookmark-fill text-danger" style="font-size:3rem;"></i></div>
            <div class="fw-bold text-muted">Total Mapel</div>
            <div class="display-5 fw-bold text-danger">0</div>
            <div class="small text-muted">Mata pelajaran aktif</div>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeInUp">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Total Ujian</div>
                    <div class="display-6 fw-bold text-primary">0</div>
                    <div class="small text-muted">Ujian aktif & selesai</div>
                </div>
                <i class="bi bi-clipboard-data text-primary" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartUjian" height="120"></canvas>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Monitoring Ujian</div>
                    <div class="display-6 fw-bold text-success">0</div>
                    <div class="small text-muted">Peserta ujian online</div>
                </div>
                <i class="bi bi-activity text-success" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartPeserta" height="120"></canvas>
        </div>
    </div>
</div>
<div class="row mb-4 g-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg p-4 animate__animated animate__fadeIn animate__delay-2s">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <div class="fw-bold">Laporan Hasil Ujian</div>
                    <div class="small text-muted">Statistik nilai, kelulusan, dan analisis hasil ujian.</div>
                </div>
                <i class="bi bi-bar-chart-line text-info" style="font-size:2.5rem;"></i>
            </div>
            <canvas id="chartLaporan" height="120"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/admin/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        document.querySelectorAll('.display-5.text-success')[0].textContent = data.total_siswa;
        document.querySelectorAll('.display-5.text-primary')[0].textContent = data.total_guru;
        document.querySelectorAll('.display-5.text-warning')[0].textContent = data.total_kelas;
        document.querySelectorAll('.display-5.text-danger')[0].textContent = data.total_mapel;
        document.querySelector('.display-6.text-primary').textContent = data.total_ujian;
        document.querySelector('.display-6.text-success').textContent = data.total_peserta;
    });

    // Chart data real
    fetch('/admin/dashboard/chart', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(chart => {
        // Ujian chart
        const ctxUjian = document.getElementById('chartUjian').getContext('2d');
        new Chart(ctxUjian, {
            type: 'line',
            data: {
                labels: chart.ujian.labels,
                datasets: [{
                    label: 'Ujian',
                    data: chart.ujian.data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
        // Peserta chart
        const ctxPeserta = document.getElementById('chartPeserta').getContext('2d');
        new Chart(ctxPeserta, {
            type: 'bar',
            data: {
                labels: chart.peserta.labels,
                datasets: [{
                    label: 'Peserta',
                    data: chart.peserta.data,
                    backgroundColor: '#198754',
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
        // Laporan chart
        const ctxLaporan = document.getElementById('chartLaporan').getContext('2d');
        new Chart(ctxLaporan, {
            type: 'bar',
            data: {
                labels: chart.laporan.labels,
                datasets: [{
                    label: 'Nilai',
                    data: chart.laporan.data,
                    backgroundColor: '#0dcaf0',
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    });
});
</script>
@endpush
