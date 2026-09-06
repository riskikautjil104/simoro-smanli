@extends('layouts.master')
@section('title', 'Input Rapor: ' . $rapor->student->name)

@push('styles')
<style>
.rapor-header { background:linear-gradient(135deg,#1e293b,#334155); border-radius:16px; padding:24px 28px; color:#fff; margin-bottom:24px; }
.card-rapor { border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); }
.table-scores th { background:#f8fafc; font-weight:700; font-size:0.8rem; text-transform:uppercase; color:#475569; }
.input-score { width:80px; text-align:center; font-weight:700; border-radius:8px; border:1.5px solid #cbd5e1; }
.input-score:focus { border-color:#0284c7; box-shadow:0 0 0 3px rgba(2,132,199,0.15); }
.final-score { font-size:1.05rem; font-weight:800; color:#0f172a; width:85px; text-align:center; background:#f1f5f9; border-radius:8px; border:1.5px solid #cbd5e1; }
</style>
@endpush

@section('layoutContent')
<div class="rapor-header d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <a href="{{ route('guru.rapor.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Kelas
        </a>
        <h4 class="fw-bold mb-1"><i class="bi bi-person-circle me-2"></i>{{ $rapor->student->name }}</h4>
        <div class="d-flex flex-wrap gap-3 text-white-50 small mt-1">
            <span><strong>Kelas:</strong> {{ $rapor->schoolClass->name }}</span>
            <span><strong>NIS / NISN:</strong> {{ $rapor->student->nis ?? '-' }} / {{ $rapor->student->nik ?? '-' }}</span>
            <span><strong>Tahun Ajaran:</strong> {{ $rapor->tahun_ajaran }} ({{ $rapor->semester }})</span>
            <span><strong>Wali Kelas:</strong> {{ $rapor->waliKelas->name ?? '-' }}</span>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" class="btn btn-warning rounded-pill px-3 fw-bold text-dark" id="btnPullCbt">
            <i class="bi bi-cloud-arrow-down-fill me-1"></i> Tarik Nilai CBT
        </button>
        <button type="button" class="btn btn-info rounded-pill px-3 fw-bold text-white" id="btnPullAbsensi">
            <i class="bi bi-calendar-check-fill me-1"></i> Tarik Absensi
        </button>
        <a href="{{ route('guru.rapor.pdf', $rapor->id) }}" target="_blank" class="btn btn-outline-light rounded-pill px-3">
            <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
        </a>
    </div>
</div>

<form id="formRapor">
    @csrf

    {{-- Tabel Nilai Mata Pelajaran --}}
    <div class="card card-rapor mb-4 bg-white">
        <div class="card-header bg-transparent py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-bookmark me-2 text-primary"></i>Capaian Hasil Belajar Siswa</h5>
            <span class="text-muted small">Rumus: <strong>40% Tugas + 60% CBT</strong> (Dapat disesuaikan manual)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-scores align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengampu</th>
                        <th class="text-center" style="width: 110px;">Nilai Tugas (40%)</th>
                        <th class="text-center" style="width: 110px;">Nilai CBT (60%)</th>
                        <th class="text-center" style="width: 110px;">Nilai Akhir</th>
                        <th>Deskripsi Capaian Pembelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rapor->scores as $index => $score)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $score->subject->name }}</div>
                            <small class="text-muted">Kode: {{ $score->subject->code ?? '-' }}</small>
                        </td>
                        <td>
                            <small class="text-muted">{{ $score->subject->teacher->name ?? 'Belum Ditentukan' }}</small>
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.01" min="0" max="100" 
                                   class="form-control form-control-sm input-score input-tugas" 
                                   name="scores[{{ $score->id }}][nilai_tugas]" 
                                   value="{{ $score->nilai_tugas }}" 
                                   data-id="{{ $score->id }}">
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.01" min="0" max="100" 
                                   class="form-control form-control-sm input-score input-cbt" 
                                   name="scores[{{ $score->id }}][nilai_cbt]" 
                                   value="{{ $score->nilai_cbt }}" 
                                   data-id="{{ $score->id }}">
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.01" min="0" max="100" 
                                   class="form-control form-control-sm final-score" 
                                   id="final_{{ $score->id }}" 
                                   name="scores[{{ $score->id }}][nilai_akhir]" 
                                   value="{{ $score->nilai_akhir }}">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm rounded-3" 
                                   name="scores[{{ $score->id }}][capaian_kompetensi]" 
                                   value="{{ $score->capaian_kompetensi }}" 
                                   placeholder="Contoh: Menunjukkan penguasaan yang sangat baik dalam...">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada mata pelajaran yang ditugaskan ke kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Rekapitulasi Presensi & Catatan Wali Kelas --}}
    <div class="row g-4 mb-4">
        {{-- Kolom Presensi --}}
        <div class="col-lg-4">
            <div class="card card-rapor bg-white p-4 h-100">
                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-calendar-event me-2 text-info"></i>Rekap Ketidakhadiran</h6>
                <p class="text-muted small mb-3">Jumlah ketidakhadiran selama satu semester:</p>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Sakit (Hari)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-warning fw-bold">S</span>
                        <input type="number" min="0" class="form-control fw-bold" name="sakit" id="inputSakit" value="{{ $rapor->sakit }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Izin (Hari)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-info fw-bold">I</span>
                        <input type="number" min="0" class="form-control fw-bold" name="izin" id="inputIzin" value="{{ $rapor->izin }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanpa Keterangan / Alpa (Hari)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-danger fw-bold">A</span>
                        <input type="number" min="0" class="form-control fw-bold" name="tanpa_keterangan" id="inputAlpa" value="{{ $rapor->tanpa_keterangan }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Catatan Wali Kelas & Status Kenaikan --}}
        <div class="col-lg-8">
            <div class="card card-rapor bg-white p-4 h-100">
                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-quote me-2 text-primary"></i>Catatan & Evaluasi Wali Kelas</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Catatan Perkembangan Karakter & Motivasi</label>
                    <textarea class="form-control" rows="3" name="catatan_wali_kelas" placeholder="Tuliskan pesan motivasi atau evaluasi kepribadian peserta didik selama semester ini...">{{ $rapor->catatan_wali_kelas }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Keputusan Kenaikan / Kelulusan (Khusus Akhir Tahun)</label>
                        <input type="text" class="form-control" name="status_kenaikan" value="{{ $rapor->status_kenaikan }}" placeholder="Contoh: Naik ke Kelas XI / Lulus">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Tanggal Pembagian Rapor</label>
                        <input type="date" class="form-control" name="tanggal_rapor" value="{{ $rapor->tanggal_rapor ? $rapor->tanggal_rapor->format('Y-m-d') : date('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Action Bar --}}
    <div class="card card-rapor bg-white p-3 mb-5 d-flex flex-row justify-content-between align-items-center">
        <div>
            <span class="text-muted small">Pastikan semua nilai dan catatan telah diperiksa sebelum disimpan.</span>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary rounded-pill px-4" onclick="history.back()">Batal</button>
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold" id="btnSimpanRapor">
                <i class="bi bi-save me-1"></i> Simpan Nilai Rapor
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var csrfToken = '{{ csrf_token() }}';
    var raporId = '{{ $rapor->id }}';

    // Auto-calculate Final Score live when Tugas or CBT changes
    function recalcScore(scoreId) {
        var tugasInput = document.querySelector('.input-tugas[data-id="' + scoreId + '"]');
        var cbtInput   = document.querySelector('.input-cbt[data-id="' + scoreId + '"]');
        var finalInput = document.getElementById('final_' + scoreId);

        var tugas = parseFloat(tugasInput.value) || 0;
        var cbt   = parseFloat(cbtInput.value) || 0;

        var final = (tugas * 0.40) + (cbt * 0.60);
        finalInput.value = final.toFixed(2);
    }

    document.querySelectorAll('.input-tugas, .input-cbt').forEach(function(input) {
        input.addEventListener('input', function() {
            var id = this.getAttribute('data-id');
            recalcScore(id);
        });
    });

    // Auto-pull CBT Exam Results
    document.getElementById('btnPullCbt').addEventListener('click', function() {
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menarik...';

        fetch('/guru/rapor/' + raporId + '/pull-cbt', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            Swal.fire({
                icon: res.success ? 'success' : 'info',
                title: 'Hasil Penarikan CBT',
                text: res.message,
                confirmButtonColor: '#0284c7'
            }).then(function() {
                location.reload();
            });
        })
        .catch(function() {
            Swal.fire('Error', 'Gagal menghubungi server CBT.', 'error');
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-cloud-arrow-down-fill me-1"></i> Tarik Nilai CBT';
        });
    });

    // Auto-pull Attendance from Web Absensi
    document.getElementById('btnPullAbsensi').addEventListener('click', function() {
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyinkronkan...';

        fetch('/guru/rapor/' + raporId + '/pull-attendance', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.data) {
                if (res.data.sakit !== undefined) document.getElementById('inputSakit').value = res.data.sakit;
                if (res.data.izin !== undefined) document.getElementById('inputIzin').value = res.data.izin;
                if (res.data.tanpa_keterangan !== undefined) document.getElementById('inputAlpa').value = res.data.tanpa_keterangan;
            }
            Swal.fire({
                icon: 'success',
                title: 'Sinkronisasi Absensi',
                text: res.message,
                confirmButtonColor: '#0284c7'
            });
        })
        .catch(function() {
            Swal.fire('Error', 'Gagal menyinkronkan data absensi.', 'error');
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-calendar-check-fill me-1"></i> Tarik Absensi';
        });
    });

    // Form Submit
    document.getElementById('formRapor').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('btnSimpanRapor');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan Data...';

        var formData = new FormData(this);

        fetch('/guru/rapor/' + raporId + '/save', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersimpan!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', res.message || 'Gagal menyimpan rapor.', 'error');
            }
        })
        .catch(function() {
            Swal.fire('Error', 'Terjadi kesalahan sistem saat menyimpan.', 'error');
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Nilai Rapor';
        });
    });
});
</script>
@endpush
