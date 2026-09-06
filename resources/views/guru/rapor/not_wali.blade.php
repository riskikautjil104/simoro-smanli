@extends('layouts.master')
@section('title', 'E-Rapor Siswa')

@section('layoutContent')
<div class="container py-5 text-center">
    <div class="card border-0 shadow-sm rounded-4 p-5 mx-auto" style="max-width: 550px;">
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-light text-warning rounded-circle" style="width: 80px; height: 80px;">
                <i class="bi bi-shield-exclamation fs-1"></i>
            </div>
        </div>
        <h4 class="fw-bold mb-2">Akses Khusus Wali Kelas</h4>
        <p class="text-muted mb-4">
            Akun Anda saat ini belum ditugaskan sebagai <strong>Wali Kelas</strong> oleh Admin Sekolah.
            Silakan hubungi Administrator SIMORO untuk menetapkan Anda sebagai Wali Kelas pada menu <strong>Data Kelas</strong>.
        </p>
        <div>
            <a href="{{ route('guru.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
