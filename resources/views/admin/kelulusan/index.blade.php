@extends('layouts.master')

@section('title', 'Kelulusan Siswa')

@section('layoutContent')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-mortarboard-fill me-2"></i> Pengumuman Kelulusan Siswa</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.kelulusan.export-excel', request()->query()) }}" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
        </a>
        <a href="{{ route('admin.kelulusan.export-pdf', request()->query()) }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
        </a>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> Tambah Data
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> Terjadi Kesalahan:
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form method="GET" action="{{ route('admin.kelulusan.index') }}" class="mb-4 shadow-sm p-3 bg-white rounded-4 border-0">
    <div class="row g-2">
        <div class="col-md-5">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control bg-light border-0 ps-1" placeholder="Cari NISN atau Nama Siswa..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-lg bg-light border-0 text-muted" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="Tidak Lulus" {{ request('status') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select form-select-lg bg-light border-0 text-muted" onchange="this.form.submit()">
                <option value="">Terbaru Dibuat</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Urut Abjad (A-Z)</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Urut Abjad (Z-A)</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary btn-lg w-100" title="Terapkan Filter"><i class="bi bi-funnel-fill"></i></button>
        </div>
    </div>
</form>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted">#</th>
                        <th class="px-4 py-3 text-muted">NISN</th>
                        <th class="px-4 py-3 text-muted">Nama Siswa</th>
                        <th class="px-4 py-3 text-muted">Status</th>
                        <th class="px-4 py-3 text-end text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($graduations as $index => $grad)
                    <tr>
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 fw-bold">{{ $grad->nisn }}</td>
                        <td class="px-4 py-3">{{ $grad->name }}</td>
                        <td class="px-4 py-3">
                            @if($grad->status == 'Lulus')
                                <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Lulus</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Tidak Lulus</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $grad->id }}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.kelulusan.destroy', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data NISN {{ $grad->nisn }} ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $grad->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('admin.kelulusan.update', $grad->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Kelulusan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">NISN</label>
                                            <input type="text" name="nisn" class="form-control form-control-lg bg-light" value="{{ $grad->nisn }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">Nama Siswa</label>
                                            <input type="text" name="name" class="form-control form-control-lg bg-light" value="{{ $grad->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">Status Kelulusan</label>
                                            <select name="status" class="form-select form-select-lg bg-light" required>
                                                <option value="Lulus" {{ $grad->status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                                <option value="Tidak Lulus" {{ $grad->status == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                            Belum ada data kelulusan yang ditambahkan.
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.kelulusan.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Data Kelulusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">NISN</label>
                        <input type="text" name="nisn" class="form-control form-control-lg bg-light" placeholder="Masukkan NISN" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Nama Siswa</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Status Kelulusan</label>
                        <select name="status" class="form-select form-select-lg bg-light" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Tidak Lulus">Tidak Lulus</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
