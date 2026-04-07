@extends('layouts.master')
@section('title', 'Tambah Soal')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}
.page-header::before {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    top: -60px;
    right: -60px;
    pointer-events: none;
}
.page-header-content {
    position: relative;
    z-index: 2;
}
.page-header h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0 0 4px;
}
.page-header p {
    font-size: 0.85rem;
    opacity: 0.85;
    margin: 0;
}

/* Coming Soon Card */
.coming-soon-card {
    background: #fff;
    border-radius: 24px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    text-align: center;
    padding: 60px 40px;
}
.coming-soon-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(13,110,253,0.08), rgba(13,202,240,0.08));
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
}
.coming-soon-icon i {
    font-size: 4rem;
    color: var(--primary);
}
.coming-soon-card h3 {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 12px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.coming-soon-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
    max-width: 500px;
    margin: 0 auto 16px;
}
.coming-soon-features {
    display: flex;
    justify-content: center;
    gap: 24px;
    margin: 32px 0;
    flex-wrap: wrap;
}
.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(13,110,253,0.05);
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--primary);
}
.feature-item i {
    font-size: 1rem;
}
.btn-batch-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #0d6efd, #0dcaf0);
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 14px 32px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    margin-top: 16px;
    box-shadow: 0 4px 16px rgba(13,110,253,0.3);
}
.btn-batch-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13,110,253,0.4);
    color: #fff;
}
.info-box {
    background: #f0f4ff;
    border-radius: 12px;
    padding: 16px 24px;
    margin-top: 32px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-size: 0.85rem;
    color: var(--primary);
}
.info-box i {
    font-size: 1.2rem;
}
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 1.5px solid var(--border-color);
    border-radius: 50px;
    padding: 10px 24px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-main);
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    margin-top: 20px;
}
.btn-back:hover {
    background: rgba(13,110,253,0.05);
    border-color: var(--primary);
    color: var(--primary);
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-plus-circle me-2"></i>Tambah Soal</h4>
        <p>Buat soal baru untuk bank soal Anda</p>
    </div>
</div>

<div class="coming-soon-card">
    <div class="coming-soon-icon">
        <i class="bi bi-hammer"></i>
    </div>
    <h3>🚧 Sedang Dalam Pengembangan 🚧</h3>
    <p>Fitur tambah soal per individu sedang kami siapkan. Untuk sementara waktu, silakan gunakan fitur <strong>Tambah Soal Batch</strong> yang sudah 100% siap pakai!</p>
    
    <div class="coming-soon-features">
        <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Tambah banyak soal sekaligus</span>
        </div>
        <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Bisa campur PG & Esai</span>
        </div>
        <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Aman & mudah digunakan</span>
        </div>
        <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Bisa tambah kapan saja</span>
        </div>
    </div>

    <a href="{{ route('guru.soal.batch') }}" class="btn-batch-primary">
        <i class="bi bi-plus-circle"></i> Tambah Soal Batch Sekarang
    </a>

    <div>
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <span>Fitur Batch Soal sudah siap dan aman! Kamu bisa tambah soal sebanyak yang kamu mau, kapan saja, dan bisa ditambah lagi kapan pun.</span>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Coming Soon mode - Gunakan Batch Soal');
});
</script>
@endpush
