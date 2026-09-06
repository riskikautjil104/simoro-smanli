@extends('layouts.frontend')
@section('title', 'Verifikasi Keabsahan Rapor Siswa - SMAN 5 Pulau Morotai')

@push('styles')
<style>
.verify-container { padding: 50px 0 70px; background: #f8fafc; min-height: 85vh; }
.verify-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; background: #fff; }
.verify-header-valid { background: linear-gradient(135deg, #059669, #10b981); color: #fff; padding: 32px 24px; text-align: center; }
.verify-header-invalid { background: linear-gradient(135deg, #dc2626, #ef4444); color: #fff; padding: 32px 24px; text-align: center; }
.verify-icon { width: 76px; height: 76px; border-radius: 50%; background: rgba(255,255,255,0.2); display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; margin-bottom: 12px; }
.info-row { border-bottom: 1px solid #f1f5f9; padding: 12px 0; font-size: 0.92rem; }
.info-row:last-child { border-bottom: none; }
.hash-box { background: #f1f5f9; border-radius: 8px; padding: 10px 14px; font-family: monospace; font-size: 0.8rem; word-break: break-all; color: #334155; border: 1px dashed #cbd5e1; }
.seal-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.4); border-radius: 50px; padding: 5px 16px; font-size: 0.82rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="verify-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="verify-card">
                    @if($isValid && $rapor)
                        {{-- Header Valid --}}
                        <div class="verify-header-valid">
                            <div class="verify-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3 class="fw-bold mb-1">DOKUMEN RESMI TERVERIFIKASI</h3>
                            <p class="mb-2 opacity-90">Sertifikat Digital Rapor Sah Terdaftar di Basis Data SMA Negeri 5 Pulau Morotai</p>
                            <div class="seal-badge">
                                <i class="bi bi-patch-check-fill"></i> Tanda Tangan Elektronik Terverifikasi (UU ITE)
                            </div>
                        </div>

                        <div class="p-4 p-md-5">
                            <div class="alert alert-success d-flex align-items-center gap-3 mb-4 rounded-3 border-0" style="background:#ecfdf5; color:#065f46;">
                                <i class="bi bi-info-circle-fill fs-4 flex-shrink-0"></i>
                                <div class="small">
                                    Dokumen ini dinyatakan <strong>ASLI & SAH</strong>. Seluruh perolehan nilai, kehadiran, dan evaluasi di bawah ini bersumber langsung dari server pusat SIMORO SMANLI.
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Peserta Didik & Dokumen
                            </h5>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Nomor Registrasi Rapor</div>
                                <div class="col-sm-7 fw-bold text-primary font-monospace">{{ $rapor->effective_serial }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Nama Lengkap Siswa</div>
                                <div class="col-sm-7 fw-bold text-dark">{{ strtoupper($rapor->student->name) }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">NIS / NISN</div>
                                <div class="col-sm-7">{{ $rapor->student->nis ?? '-' }} / {{ $rapor->student->nik ?? '-' }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Rombongan Belajar (Kelas)</div>
                                <div class="col-sm-7 fw-bold">{{ $rapor->schoolClass->name }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Semester & Tahun Ajaran</div>
                                <div class="col-sm-7">Semester {{ $rapor->semester }} • Tahun Ajaran {{ $rapor->tahun_ajaran }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Rata-rata Nilai Semester</div>
                                <div class="col-sm-7">
                                    <span class="badge bg-primary px-3 py-2 fs-6 fw-bold">{{ $rapor->average_score }}</span>
                                    <span class="text-muted small ms-2">(Total {{ count($rapor->scores) }} Mata Pelajaran)</span>
                                </div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Ketidakhadiran</div>
                                <div class="col-sm-7">
                                    <span class="badge bg-warning text-dark me-1">Sakit: {{ $rapor->sakit }}</span>
                                    <span class="badge bg-info text-white me-1">Izin: {{ $rapor->izin }}</span>
                                    <span class="badge bg-danger text-white">Alpa: {{ $rapor->tanpa_keterangan }}</span>
                                </div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Status Evaluasi Akhir</div>
                                <div class="col-sm-7 fw-bold text-success">{{ $rapor->status_kenaikan ?: 'Aktif Mengikuti Pembelajaran' }}</div>
                            </div>

                            <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2">
                                <i class="bi bi-vector-pen me-2 text-primary"></i>Pengesahan & Tanda Tangan Elektronik
                            </h5>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Wali Kelas Pengampu</div>
                                <div class="col-sm-7 fw-bold">{{ $rapor->waliKelas->name ?? '-' }} <small class="text-muted fw-normal">(NIP: {{ $rapor->waliKelas->nip ?? '-' }})</small></div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Kepala Sekolah</div>
                                <div class="col-sm-7 fw-bold">{{ $kepsek->name ?? 'Kepala SMA Negeri 5 Pulau Morotai' }}</div>
                            </div>

                            <div class="info-row row">
                                <div class="col-sm-5 text-muted fw-bold">Tanggal Pengesahan</div>
                                <div class="col-sm-7">{{ $rapor->tanggal_rapor ? \Carbon\Carbon::parse($rapor->tanggal_rapor)->translatedFormat('d F Y') : '-' }}</div>
                            </div>

                            <div class="mt-4">
                                <label class="small fw-bold text-muted mb-1"><i class="bi bi-fingerprint me-1"></i>Digital Signature Checksum (SHA-256 Hash):</label>
                                <div class="hash-box">{{ $rapor->effective_hash }}</div>
                                <div class="text-muted small mt-1">Hash di atas membuktikan data nilai dan identitas siswa tidak pernah mengalami manipulasi sejak diterbitkan resmi.</div>
                            </div>
                        </div>

                    @else
                        {{-- Header Invalid --}}
                        <div class="verify-header-invalid">
                            <div class="verify-icon">
                                <i class="bi bi-shield-x"></i>
                            </div>
                            <h3 class="fw-bold mb-1">DOKUMEN TIDAK VALID / BELUM RESMI</h3>
                            <p class="mb-0 opacity-90">{{ $statusMessage }}</p>
                        </div>

                        <div class="p-4 p-md-5 text-center">
                            <p class="text-muted mb-4">
                                Kode verifikasi yang Anda masukkan tidak terdaftar pada pangkalan data SIMORO SMA Negeri 5 Pulau Morotai atau dokumen rapor belum dipublikasikan secara resmi oleh pihak sekolah.
                            </p>
                            <div class="alert alert-warning border-0 small text-start mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                <strong>Perhatian Keamanan:</strong> Jika Anda mendapatkan lembaran fisik atau berkas PDF yang mengatasnamakan siswa SMA Negeri 5 Pulau Morotai dengan kode ini, mohon lakukan konfirmasi langsung ke bagian Kurikulum / Tata Usaha sekolah untuk mencegah pemalsuan dokumen.
                            </div>
                            <a href="/" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-house me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    @endif

                    <div class="card-footer bg-light py-3 px-4 text-center border-0 small text-muted">
                        &copy; {{ date('Y') }} SMA Negeri 5 Kabupaten Pulau Morotai • Sistem Informasi CBT & E-Rapor Digital (SIMORO)
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
