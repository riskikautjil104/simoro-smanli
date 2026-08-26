@extends('layouts.master')
@section('title', 'Tambah Soal')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
}
.choice-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid var(--border-color);
    padding: 32px 24px;
    text-align: center;
    transition: all 0.25s ease;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
}
.choice-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 12px 30px rgba(13,110,253,0.12);
    transform: translateY(-4px);
    color: inherit;
}
.choice-icon {
    width: 72px; height: 72px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 18px;
}
.choice-icon.single {
    background: rgba(13,110,253,0.1);
    color: #0d6efd;
}
.choice-icon.batch {
    background: rgba(111,66,193,0.1);
    color: #6f42c1;
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <h4 class="fw-bold mb-1"><i class="bi bi-plus-circle me-2"></i>Pilih Metode Tambah Soal</h4>
    <p class="mb-0 text-white-50">Tentukan cara pembuatan soal ujian yang Anda inginkan</p>
</div>

<div class="row g-4 justify-content-center max-w-4xl mx-auto">
    <div class="col-md-5">
        <a href="{{ route('guru.soal') }}" class="choice-card">
            <div class="choice-icon single">
                <i class="bi bi-file-earmark-plus"></i>
            </div>
            <h5 class="fw-bold mb-2">Tambah Soal Satuan</h5>
            <p class="text-muted small mb-4">Input butir soal satu per satu langsung di Bank Soal dengan editor lengkap (CKEditor, upload gambar & rumus).</p>
            <span class="btn btn-outline-primary rounded-pill px-4 mt-auto">Buka Bank Soal</span>
        </a>
    </div>

    <div class="col-md-5">
        <a href="{{ route('guru.soal.batch') }}" class="choice-card">
            <div class="choice-icon batch">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <h5 class="fw-bold mb-2">Tambah Soal Batch</h5>
            <p class="text-muted small mb-4">Generate banyak soal PG & Esai sekaligus dalam satu halaman form cepat untuk ujian Anda.</p>
            <span class="btn btn-primary rounded-pill px-4 mt-auto" style="background:linear-gradient(135deg,#6f42c1,#9c27b0);border:none;">Buat Soal Batch</span>
        </a>
    </div>
</div>

@endsection
