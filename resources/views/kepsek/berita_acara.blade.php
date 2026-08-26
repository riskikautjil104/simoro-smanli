@extends('layouts.master')

@section('title', 'Berita Acara Ujian - Kepala Sekolah')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
}
.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.86rem; }
.table-card .table thead th {
    background: #f8faff;
    font-weight: 600;
    font-size: 0.76rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
}
.table-card .table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-ruled me-2"></i>Peninjauan Berita Acara Ujian (Kepala Sekolah)</h4>
    <p class="mb-0 text-white-50">Validasi, pantau presensi pengerjaan siswa, dan unduh dokumen Berita Acara resmi berkop sekolah</p>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Judul Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Pengampu</th>
                    <th>Kelas</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th class="text-end" style="min-width: 200px;">Aksi Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $idx => $ex)
                <tr>
                    <td class="fw-bold text-muted">{{ $idx + 1 }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $ex->title }}</div>
                        <div class="text-muted small"><i class="bi bi-clock me-1"></i>Durasi: {{ $ex->duration ?? 0 }} menit</div>
                    </td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">{{ $ex->subject ? $ex->subject->name : '-' }}</span></td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $ex->subject && $ex->subject->teacher ? $ex->subject->teacher->name : '-' }}</div>
                        <div class="text-muted small">NIP: {{ $ex->subject && $ex->subject->teacher ? ($ex->subject->teacher->nip ?? '-') : '-' }}</div>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">{{ $ex->schoolClass ? $ex->schoolClass->name : '-' }}</span></td>
                    <td class="small text-muted">{{ $ex->start_time ? $ex->start_time->format('d M Y, H:i') : '-' }} WIT</td>
                    <td class="text-end">
                        <div class="d-flex align-items-center justify-content-end gap-1">
                            <a href="{{ route('kepala-sekolah.berita-acara.show', $ex->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Detail Presensi
                            </a>
                            <a href="{{ route('kepala-sekolah.berita-acara.pdf', $ex->id) }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" title="Cetak Berita Acara Resmi">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF Resmi
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Belum ada data ujian yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
