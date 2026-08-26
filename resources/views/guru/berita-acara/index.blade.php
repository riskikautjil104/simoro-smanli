@extends('layouts.master')
@section('title', 'Berita Acara Ujian')

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
    width: 220px; height: 220px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    top: -60px; right: -60px;
    pointer-events: none;
}
.page-header-content { position: relative; z-index: 2; }
.page-header h4 { font-size: 1.3rem; font-weight: 700; margin: 0 0 4px; }
.page-header p  { font-size: 0.85rem; opacity: 0.85; margin: 0; }
.count-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 10px;
}

.table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.table-card .table { margin: 0; font-size: 0.875rem; }
.table-card .table thead th {
    background: #f8faff;
    color: var(--text-main);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(13,110,253,0.05);
    color: var(--text-main);
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr:hover { background: rgba(13,110,253,0.025); }

.badge-mapel {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(13,110,253,0.08);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.badge-kelas {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(32,201,151,0.1);
    color: #198754;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

.search-wrap { position: relative; max-width: 320px; }
.search-wrap i {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
}
.search-wrap input {
    padding-left: 38px;
    border-radius: 50px;
    border: 1.5px solid var(--border-color);
    font-size: 0.875rem;
    height: 40px;
}

.btn-act-ba {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}
</style>
@endpush

@section('layoutContent')

<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-file-earmark-ruled me-2"></i>Berita Acara & Presensi Ujian <span class="count-badge">{{ $exams->count() }} Ujian</span></h4>
            <p>Rekapitulasi kehadiran, status pengerjaan siswa, dan cetak Berita Acara per mata pelajaran</p>
        </div>
    </div>
</div>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchExam" class="form-control" placeholder="Cari nama ujian atau mapel...">
    </div>
    <div class="text-muted small">
        Menampilkan <strong>{{ $exams->count() }}</strong> ujian yang Anda ampu
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table" id="examBaTable">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Judul Ujian</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th>Status Ujian</th>
                    <th class="text-end" style="min-width:240px;">Aksi Berita Acara</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $idx => $exam)
                <tr>
                    <td class="fw-bold text-muted">{{ $idx + 1 }}</td>
                    <td>
                        <div class="fw-bold text-dark fs-6">{{ $exam->title }}</div>
                        <div class="text-muted small"><i class="bi bi-clock me-1"></i>Durasi: {{ $exam->duration ?? 0 }} menit</div>
                    </td>
                    <td>
                        <span class="badge-mapel"><i class="bi bi-journal-bookmark me-1"></i>{{ $exam->subject ? $exam->subject->name : '-' }}</span>
                    </td>
                    <td>
                        <span class="badge-kelas"><i class="bi bi-building me-1"></i>{{ $exam->schoolClass ? $exam->schoolClass->name : '-' }}</span>
                    </td>
                    <td class="small">
                        <div><i class="bi bi-calendar-event me-1 text-primary"></i>{{ $exam->start_time ? $exam->start_time->format('d M Y, H:i') : '-' }}</div>
                        <div class="text-muted"><i class="bi bi-arrow-right-short"></i>{{ $exam->end_time ? $exam->end_time->format('H:i') : '-' }} WIT</div>
                    </td>
                    <td>
                        @php
                            $st = strtolower($exam->status ?? '');
                        @endphp
                        @if(str_contains($st, 'aktif') || str_contains($st, 'berlangsung'))
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-play-circle me-1"></i>Aktif</span>
                        @elseif(str_contains($st, 'selesai'))
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-check2-circle me-1"></i>Selesai</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-hourglass-split me-1"></i>Draft / Siap</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex align-items-center justify-content-end gap-1 flex-wrap">
                            <a href="{{ route('guru.berita-acara.show', $exam->id) }}" class="btn-act-ba btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Presensi
                            </a>
                            <a href="{{ route('guru.berita-acara.pdf', $exam->id) }}" class="btn-act-ba btn btn-sm btn-danger shadow-sm" title="Download PDF Resmi">
                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                            </a>
                            <a href="{{ route('guru.berita-acara.excel', $exam->id) }}" class="btn-act-ba btn btn-sm btn-success shadow-sm" title="Download Excel">
                                <i class="bi bi-file-earmark-excel-fill"></i> Excel
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                        Belum ada data ujian yang dibuat untuk mata pelajaran Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchExam');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = this.value.toLowerCase().trim();
            var rows = document.querySelectorAll('#examBaTable tbody tr');
            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush
