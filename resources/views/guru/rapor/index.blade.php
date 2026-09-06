@extends('layouts.master')
@section('title', 'Manajemen E-Rapor Kelas ' . ($kelas->name ?? ''))

@push('styles')
<style>
.page-header { background:linear-gradient(135deg, #1e3a8a, #0284c7); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.btn-header { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,0.2); color:#fff !important; border:1.5px solid rgba(255,255,255,0.45); padding:8px 18px; border-radius:50px; font-size:0.875rem; font-weight:600; cursor:pointer; transition:all .2s; }
.btn-header:hover { background:rgba(255,255,255,0.35); transform:translateY(-1px); }
.table-card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); overflow:hidden; }
.table thead th { background:#f8fafc; color:#334155; font-weight:700; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; padding:14px 16px; border-bottom:1px solid #e2e8f0; }
.table tbody td { padding:14px 16px; vertical-align:middle; border-bottom:1px solid #f1f5f9; font-size:0.875rem; }
.student-avatar { width:38px; height:38px; background:linear-gradient(135deg,#0284c7,#38bdf8); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:0.85rem; }
.badge-status { padding:5px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; }
.badge-draft { background:#fef3c7; color:#b45309; }
.badge-published { background:#dcfce7; color:#15803d; }
.chip-absensi { display:inline-flex; align-items:center; gap:3px; padding:2px 8px; border-radius:6px; font-size:0.72rem; font-weight:700; }
</style>
@endpush

@section('layoutContent')
<div class="page-header">
    <div class="page-header-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-white text-primary px-3 py-1 rounded-pill fw-bold">Wali Kelas</span>
                <span class="text-white-50 fs-6">SMAN 5 Pulau Morotai</span>
            </div>
            <h4 class="fw-bold mb-1"><i class="bi bi-mortarboard me-2"></i>E-Rapor Digital: {{ $kelas->name }}</h4>
            <p class="text-white-50 mb-0">Kelola capaian nilai akademik, rekapitulasi kehadiran, dan cetak rapor resmi peserta didik.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn-header" id="btnPublishAll">
                <i class="bi bi-send-check"></i> Terbitkan Semua Rapor
            </button>
        </div>
    </div>
</div>

{{-- Filter Semester & Tahun Ajaran --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 p-3 bg-white">
    <form method="GET" action="{{ route('guru.rapor.index') }}" class="row g-3 align-items-end">
        @if(count($allClasses) > 0)
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Pilih Kelas</label>
            <select name="class_id" class="form-select form-select-sm" onchange="this.form.submit()">
                @foreach($allClasses as $c)
                    <option value="{{ $c->id }}" {{ $kelas->id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Tahun Ajaran</label>
            <select name="tahun_ajaran" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="2025/2026" {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                <option value="2024/2025" {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Semester</label>
            <select name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <span class="text-muted small">Total Siswa: <strong>{{ count($reports) }} orang</strong></span>
        </div>
    </form>
</div>

{{-- Tabel Data Rapor Siswa --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Siswa</th>
                    <th>NIS / NISN</th>
                    <th>Rata-rata Nilai</th>
                    <th>Kehadiran (S / I / A)</th>
                    <th>Status Rapor</th>
                    <th style="width: 180px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $index => $r)
                @php
                    $initials = strtoupper(substr($r->student->name, 0, 2));
                    $avg = $r->average_score;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="student-avatar">{{ $initials }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $r->student->name }}</div>
                                <div class="text-muted small">{{ $r->student->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $r->student->nis ?? '-' }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-6 {{ $avg >= 75 ? 'text-success' : 'text-primary' }}">{{ number_format($avg, 1) }}</span>
                            <span class="text-muted small">({{ count($r->scores) }} mapel)</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <span class="chip-absensi bg-light text-warning" title="Sakit">S: {{ $r->sakit }}</span>
                            <span class="chip-absensi bg-light text-info" title="Izin">I: {{ $r->izin }}</span>
                            <span class="chip-absensi bg-light text-danger" title="Tanpa Keterangan">A: {{ $r->tanpa_keterangan }}</span>
                        </div>
                    </td>
                    <td>
                        @if($r->status === 'published')
                            <span class="badge-status badge-published"><i class="bi bi-check-circle-fill me-1"></i> Terbit</span>
                        @else
                            <span class="badge-status badge-draft"><i class="bi bi-hourglass-split me-1"></i> Draft</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('guru.rapor.detail', $r->id) }}" class="btn btn-sm btn-primary rounded-3 px-2 py-1" title="Input Nilai & Catatan">
                                <i class="bi bi-pencil-square"></i> Input
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1 btn-toggle-publish" data-id="{{ $r->id }}" title="Ubah Status">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                            <a href="{{ route('guru.rapor.pdf', $r->id) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="Cetak PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada siswa di kelas ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toggle publish single student
    document.querySelectorAll('.btn-toggle-publish').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            fetch('/guru/rapor/' + id + '/publish', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1200, showConfirmButton: false })
                    .then(function() { location.reload(); });
                }
            });
        });
    });

    // Publish all
    var btnPubAll = document.getElementById('btnPublishAll');
    if (btnPubAll) {
        btnPubAll.addEventListener('click', function() {
            Swal.fire({
                title: 'Terbitkan Seluruh Rapor?',
                text: 'Semua siswa di kelas ini dapat langsung melihat nilai rapor mereka di aplikasi mobile.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0284c7',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Terbitkan Semua!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) return;

                fetch('{{ route("guru.rapor.publish-all") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        class_id: '{{ $kelas->id }}',
                        tahun_ajaran: '{{ $tahunAjaran }}',
                        semester: '{{ $semester }}'
                    })
                })
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Sukses!', text: res.message, timer: 1500, showConfirmButton: false })
                        .then(function() { location.reload(); });
                    }
                });
            });
        });
    }
});
</script>
@endpush
