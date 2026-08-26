@extends('layouts.master')

@section('title', 'Tabel Alumni SMA Negeri 5')

@section('layoutContent')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold text-success"><i class="bi bi-mortarboard-fill me-2"></i> Tabel Alumni SMA Negeri 5 Pulau Morotai</h4>
        <p class="text-muted small mb-0">Database resmi alumni siswa SMA Negeri 5 yang telah lulus per angkatan &bull; Akun dinonaktifkan dari sistem CBT.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.kelulusan.index') }}" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Evaluasi Kelulusan Kelas XII
        </a>
        <a href="{{ route('admin.kelulusan.alumni.export-excel', request()->query()) }}" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel Alumni
        </a>
        <a href="{{ route('admin.kelulusan.alumni.export-pdf', request()->query()) }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak Buku Alumni (PDF)
        </a>
    </div>
</div>

{{-- ── ALERT NOTIFICATIONS ── --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- ── SUMMARY CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-4 border-start border-4 border-success">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 fs-3">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">TOTAL ALUMNI LULUS</div>
                    <div class="fs-3 fw-bold text-success">{{ $totalAlumni ?? 0 }} <span class="fs-6 fw-normal text-muted">Orang</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-4 border-start border-4 border-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 fs-3">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">TOTAL ANGKATAN</div>
                    <div class="fs-3 fw-bold text-primary">{{ count($angkatanList ?? []) }} <span class="fs-6 fw-normal text-muted">Angkatan</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-4 border-start border-4 border-info">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 fs-3">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">STATUS AKUN CBT</div>
                    <div class="fs-5 fw-bold text-dark"><span class="badge bg-secondary">Nonaktif (Terkunci)</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── FILTER PER ANGKATAN & PENCARIAN ── --}}
<form method="GET" action="{{ route('admin.kelulusan.alumni') }}" class="mb-4 shadow-sm p-3 bg-white rounded-4 border-0">
    <div class="row g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control bg-light border-0 ps-1" placeholder="Cari NISN, Nama Alumni, Kelas..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="angkatan" class="form-select bg-light border-0 text-muted" onchange="this.form.submit()">
                <option value="">-- Semua Angkatan --</option>
                @foreach($angkatanList as $akt)
                    <option value="{{ $akt }}" {{ request('angkatan') == $akt ? 'selected' : '' }}>Angkatan {{ $akt }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select bg-light border-0 text-muted" onchange="this.form.submit()">
                <option value="">Terbaru Lulus</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama Alumni (A-Z)</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Alumni (Z-A)</option>
                <option value="angkatan_desc" {{ request('sort') == 'angkatan_desc' ? 'selected' : '' }}>Angkatan Terbaru</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-primary w-100" title="Terapkan Filter"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
            <a href="{{ route('admin.kelulusan.alumni') }}" class="btn btn-light border" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </div>
</form>

{{-- ── TABEL ALUMNI SMA 5 ── --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-bold text-dark">
            <i class="bi bi-table me-2 text-success"></i>
            Daftar Alumni SMA Negeri 5 Pulau Morotai
            @if(request('angkatan'))
                <span class="badge bg-success ms-2">Angkatan {{ request('angkatan') }}</span>
            @endif
        </div>
        <div class="text-muted small">
            Menampilkan {{ $graduations->count() }} dari {{ $graduations->total() }} alumni
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted">#</th>
                        <th class="px-4 py-3 text-muted">NISN / NIS</th>
                        <th class="px-4 py-3 text-muted">Nama Siswa Alumni</th>
                        <th class="px-4 py-3 text-muted">Kelas Asal</th>
                        <th class="px-4 py-3 text-muted">Angkatan</th>
                        <th class="px-4 py-3 text-muted">Tahun Ajaran</th>
                        <th class="px-4 py-3 text-muted">Status</th>
                        <th class="px-4 py-3 text-muted">Tanggal Kelulusan</th>
                        <th class="px-4 py-3 text-end text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($graduations as $index => $grad)
                    <tr>
                        <td class="px-4 py-3">{{ $graduations->firstItem() + $index }}</td>
                        <td class="px-4 py-3 fw-bold">{{ $grad->nisn }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.82rem;">
                                    {{ strtoupper(substr($grad->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="fw-bold text-dark">{{ $grad->name }}</span>
                                    <div class="text-muted small">Alumni SMA Negeri 5</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">{{ $grad->class_name ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 fw-bold">Angkatan {{ $grad->angkatan ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-muted small">
                            {{ $grad->tahun_ajaran ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-mortarboard-fill me-1"></i> Lulus (Alumni)</span>
                        </td>
                        <td class="px-4 py-3 text-muted small">
                            <i class="bi bi-calendar-check me-1"></i> {{ $grad->archived_at ? $grad->archived_at->format('d M Y, H:i') : ($grad->created_at ? $grad->created_at->format('d M Y') : '-') }}
                        </td>
                        <td class="px-4 py-3 text-end">
                            {{-- Pulihkan Status --}}
                            <form action="{{ route('admin.kelulusan.unarchive', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan kelulusan & aktifkan kembali siswa {{ $grad->name }} ke kelas asalnya?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1" title="Batalkan Kelulusan / Pulihkan Akun">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan Siswa
                                </button>
                            </form>

                            {{-- Hapus Data --}}
                            <form action="{{ route('admin.kelulusan.destroy', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus permanen data alumni {{ $grad->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-mortarboard fs-1 d-block mb-3 text-success opacity-50"></i>
                            <div class="fw-semibold">Belum ada data alumni pada filter ini.</div>
                            <div class="small">Data siswa yang berstatus Lulus di menu <a href="{{ route('admin.kelulusan.index') }}">Evaluasi Kelulusan</a> akan otomatis masuk ke tabel ini.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($graduations->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-center">
            {{ $graduations->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
