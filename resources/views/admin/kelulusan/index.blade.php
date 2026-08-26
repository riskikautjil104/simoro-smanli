@extends('layouts.master')

@section('title', 'Penetapan Kelulusan Siswa Tingkat Akhir')

@section('layoutContent')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold text-primary"><i class="bi bi-mortarboard-fill me-2"></i> Penetapan Kelulusan Siswa (Kelas XII)</h4>
        <p class="text-muted small mb-0">Khusus evaluasi kelulusan siswa tingkat akhir (Kelas XII) &bull; Siswa yang dinyatakan Lulus otomatis dipindahkan ke Tabel Alumni SMA 5 dan akun dinonaktifkan.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.kelulusan.alumni') }}" class="btn btn-outline-success shadow-sm">
            <i class="bi bi-mortarboard me-1"></i> <strong>Tabel Alumni SMA 5</strong> <span class="badge bg-success ms-1">{{ $archivedCount ?? 0 }}</span>
        </a>
        <button type="button" class="btn btn-info text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#pullModal">
            <i class="bi bi-cloud-download-fill me-1"></i> Tarik Siswa Kelas XII
        </button>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Manual
        </button>
        <a href="{{ route('admin.kelulusan.export-excel', request()->query()) }}" class="btn btn-outline-success shadow-sm">
            <i class="bi bi-file-earmark-excel-fill"></i> Excel
        </a>
        <a href="{{ route('admin.kelulusan.export-pdf', request()->query()) }}" class="btn btn-outline-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
        </a>
    </div>
</div>

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

{{-- ── FILTER & PENCARIAN ── --}}
<form method="GET" action="{{ route('admin.kelulusan.index') }}" class="mb-4 shadow-sm p-3 bg-white rounded-4 border-0">
    <div class="row g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control bg-light border-0 ps-1" placeholder="Cari NISN, Nama, atau Kelas..." value="{{ request('search') }}">
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
            <select name="status" class="form-select bg-light border-0 text-muted" onchange="this.form.submit()">
                <option value="">-- Semua Status Evaluasi --</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Menunggu Penetapan (Pending)</option>
                <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="Tidak Lulus" {{ request('status') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-primary w-100" title="Terapkan Filter"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
            <a href="{{ route('admin.kelulusan.index') }}" class="btn btn-light border" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </div>
</form>

{{-- ── AKSI KELULUSAN MASSAL ── --}}
@if($graduations->isNotEmpty())
<div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3 border">
    <div class="small text-muted">
        <i class="bi bi-info-circle me-1 text-primary"></i> Menampilkan <strong>{{ $graduations->total() }}</strong> siswa dalam daftar evaluasi kelulusan.
    </div>
    <div>
        <form action="{{ route('admin.kelulusan.kelulusan-massal') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin MENETAPKAN SEMUA SISWA DI DAFTAR INI SEBAGAI LULUS? Mereka akan langsung dipindahkan ke Tabel Alumni SMA 5 dan akun ujian mereka dinonaktifkan.')">
            @csrf
            <input type="hidden" name="action" value="luluskan_semua">
            <button type="submit" class="btn btn-sm btn-success shadow-sm">
                <i class="bi bi-check-all me-1"></i> Luluskan Semua Siswa Ini &rarr; Pindahkan ke Alumni
            </button>
        </form>
    </div>
</div>
@endif

{{-- ── TABEL DATA EVALUASI KELULUSAN ── --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted">#</th>
                        <th class="px-4 py-3 text-muted">NISN / NIS</th>
                        <th class="px-4 py-3 text-muted">Nama Siswa</th>
                        <th class="px-4 py-3 text-muted">Kelas Asal</th>
                        <th class="px-4 py-3 text-muted">Angkatan</th>
                        <th class="px-4 py-3 text-muted">Status Evaluasi</th>
                        <th class="px-4 py-3 text-end text-muted">Tindakan Kelulusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($graduations as $index => $grad)
                    <tr>
                        <td class="px-4 py-3">{{ $graduations->firstItem() + $index }}</td>
                        <td class="px-4 py-3 fw-bold">{{ $grad->nisn }}</td>
                        <td class="px-4 py-3">
                            <div class="fw-semibold text-dark">{{ $grad->name }}</div>
                            <div class="text-muted small">Tahun Ajaran: {{ $grad->tahun_ajaran ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">{{ $grad->class_name ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">Angkatan {{ $grad->angkatan ?? date('Y') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($grad->status == 'Lulus')
                                <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> Lulus (Alumni)</span>
                            @elseif($grad->status == 'Tidak Lulus')
                                <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i> Tidak Lulus</span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            {{-- Tombol Luluskan Cepat --}}
                            <form action="{{ route('admin.kelulusan.set-status', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Nyatakan LULUS untuk {{ $grad->name }}? Siswa akan langsung dipindahkan ke Alumni dan akun dinonaktifkan.')">
                                @csrf
                                <input type="hidden" name="status" value="Lulus">
                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 me-1" title="Nyatakan LULUS & Pindahkan ke Alumni">
                                    <i class="bi bi-mortarboard-fill me-1"></i> Luluskan
                                </button>
                            </form>

                            {{-- Tombol Tidak Lulus --}}
                            <form action="{{ route('admin.kelulusan.set-status', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tetapkan status TIDAK LULUS untuk {{ $grad->name }}?')">
                                @csrf
                                <input type="hidden" name="status" value="Tidak Lulus">
                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-2 me-1" title="Tetapkan Tidak Lulus">
                                    <i class="bi bi-x-circle me-1"></i> Tidak Lulus
                                </button>
                            </form>

                            {{-- Edit Modal Trigger --}}
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $grad->id }}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>

                            {{-- Delete Form --}}
                            <form action="{{ route('admin.kelulusan.destroy', $grad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data kelulusan {{ $grad->name }}?')">
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
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Kelulusan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">NISN / NIS</label>
                                            <input type="text" name="nisn" class="form-control bg-light" value="{{ $grad->nisn }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">Nama Siswa</label>
                                            <input type="text" name="name" class="form-control bg-light" value="{{ $grad->name }}" required>
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold text-muted">Kelas Asal</label>
                                                <input type="text" name="class_name" class="form-control bg-light" value="{{ $grad->class_name }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold text-muted">Tahun Angkatan</label>
                                                <input type="text" name="angkatan" class="form-control bg-light" value="{{ $grad->angkatan ?? date('Y') }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold text-muted">Status Kelulusan</label>
                                            <select name="status" class="form-select bg-light" required>
                                                <option value="Pending" {{ $grad->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                                <option value="Lulus" {{ $grad->status == 'Lulus' ? 'selected' : '' }}>Lulus (Pindah ke Alumni & Nonaktifkan Akun)</option>
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
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-mortarboard fs-1 d-block mb-2 text-primary opacity-50"></i>
                            <div class="fw-semibold">Belum ada siswa dalam daftar evaluasi kelulusan.</div>
                            <div class="small">Klik tombol <strong>"Tarik Siswa Kelas XII"</strong> di atas untuk memuat data siswa tingkat akhir secara otomatis.</div>
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

{{-- ── MODAL TARIK DATA SISWA KELAS XII ── --}}
<div class="modal fade" id="pullModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.kelulusan.pull-kelas') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-cloud-download me-2"></i>Tarik Siswa Kelas Tingkat Akhir</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Pilih rombel / kelas tingkat akhir (Kelas XII) yang akan dievaluasi status kelulusannya.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Pilih Rombel / Kelas</label>
                        <select name="class_id" class="form-select bg-light" required>
                            <option value="all_xii">-- Semua Kelas XII (Tingkat Akhir) --</option>
                            @foreach($classes as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->name }} ({{ $cls->students()->count() }} Siswa)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark">Tahun Angkatan</label>
                            <input type="text" name="angkatan" class="form-control bg-light" value="{{ date('Y') }}" placeholder="Contoh: {{ date('Y') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control bg-light" value="{{ (date('Y')-1) . '/' . date('Y') }}" placeholder="Contoh: {{ (date('Y')-1) . '/' . date('Y') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-arrow-down-circle me-1"></i> Tarik Data Siswa</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL TAMBAH MANUAL ── --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.kelulusan.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus text-primary me-2"></i>Tambah Data Siswa Kelulusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">NISN / NIS</label>
                        <input type="text" name="nisn" class="form-control bg-light" placeholder="Masukkan NISN atau NIS siswa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Nama Lengkap Siswa</label>
                        <input type="text" name="name" class="form-control bg-light" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted">Kelas Asal</label>
                            <input type="text" name="class_name" class="form-control bg-light" placeholder="Contoh: XII IPA 1" value="XII IPA 1">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted">Tahun Angkatan</label>
                            <input type="text" name="angkatan" class="form-control bg-light" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Status Kelulusan</label>
                        <select name="status" class="form-select bg-light" required>
                            <option value="Pending">Pending (Menunggu)</option>
                            <option value="Lulus">Lulus (Langsung Pindah ke Alumni &amp; Nonaktifkan)</option>
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
