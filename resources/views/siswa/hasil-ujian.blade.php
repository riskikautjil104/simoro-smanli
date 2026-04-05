@extends('layouts.master')
@section('title', 'Hasil Ujian')

@push('styles')
<style>
.page-header { background:linear-gradient(135deg,var(--primary),var(--accent)); border-radius:16px; padding:24px 28px; color:#fff; position:relative; overflow:hidden; margin-bottom:24px; }
.page-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.page-header-content { position:relative; z-index:2; }
.page-header h4 { font-size:1.3rem; font-weight:700; margin:0 0 4px; }
.page-header p  { font-size:0.85rem; opacity:0.85; margin:0; }

.panel-card { background:#fff; border-radius:16px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:20px; }
.panel-card-header { padding:16px 20px; border-bottom:1px solid var(--border-color); background:#f0f4ff; display:flex; align-items:center; gap:8px; font-weight:700; font-size:0.9rem; color:var(--text-main); }
.panel-card-header i { color:var(--primary); }
.panel-card-body { padding:24px; }

/* ── Score display ── */
.score-display { display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 32px 24px; }
.score-circle { width:130px; height:130px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-direction:column; box-shadow:0 6px 28px rgba(13,110,253,0.25); position:relative; margin-bottom:14px; }
.score-circle::before { content:''; position:absolute; inset:-5px; border-radius:50%; background:linear-gradient(135deg,#0d6efd,#0dcaf0); z-index:-1; opacity:0.15; }
.score-circle.grade-a  { background:linear-gradient(135deg,#198754,#20c997); box-shadow:0 6px 28px rgba(32,201,151,0.35); }
.score-circle.grade-b  { background:linear-gradient(135deg,#0d6efd,#0dcaf0); box-shadow:0 6px 28px rgba(13,110,253,0.35); }
.score-circle.grade-c  { background:linear-gradient(135deg,#ffc107,#fd7e14); box-shadow:0 6px 28px rgba(255,193,7,0.35); }
.score-circle.grade-d  { background:linear-gradient(135deg,#dc3545,#e05260); box-shadow:0 6px 28px rgba(220,53,69,0.35); }
.score-circle.pending  { background:linear-gradient(135deg,#6c757d,#adb5bd); box-shadow:0 6px 28px rgba(108,117,125,0.25); }
.score-value { font-size:2.2rem; font-weight:900; color:#fff; line-height:1; }
.score-label { font-size:0.72rem; font-weight:600; color:rgba(255,255,255,0.8); margin-top:2px; }
.score-grade { font-size:1rem; font-weight:800; color:var(--text-main); }
.score-text  { font-size:0.85rem; color:var(--text-muted); }

/* ── Detail rows ── */
.detail-row { display:flex; align-items:center; gap:12px; padding:13px 0; border-bottom:1px solid rgba(13,110,253,0.05); }
.detail-row:last-child { border-bottom:none; }
.detail-icon { width:36px; height:36px; border-radius:9px; background:rgba(13,110,253,0.08); color:var(--primary); display:flex; align-items:center; justify-content:center; font-size:0.95rem; flex-shrink:0; }
.detail-key { font-size:0.78rem; font-weight:600; color:var(--text-muted); margin-bottom:1px; }
.detail-val { font-size:0.9rem; font-weight:700; color:var(--text-main); }

/* ── Status badge ── */
.status-badge { display:inline-flex; align-items:center; gap:5px; font-size:0.78rem; font-weight:700; padding:5px 12px; border-radius:20px; }
.status-diperiksa  { background:rgba(32,201,151,0.12); color:#198754; }
.status-pending    { background:rgba(255,193,7,0.12); color:#856404; }

/* ── Action buttons ── */
.btn-cetak { display:inline-flex; align-items:center; gap:7px; padding:11px 22px; background:linear-gradient(135deg,#198754,#20c997); color:#fff; border:none; border-radius:50px; font-size:0.875rem; font-weight:600; cursor:pointer; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; box-shadow:0 4px 14px rgba(32,201,151,0.25); }
.btn-cetak:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(32,201,151,0.35); color:#fff; }
.btn-kembali { display:inline-flex; align-items:center; gap:7px; padding:10px 22px; background:transparent; color:var(--text-muted); border:1.5px solid var(--border-color); border-radius:50px; font-size:0.875rem; font-weight:600; transition:var(--transition); font-family:'Poppins',sans-serif; text-decoration:none; }
.btn-kembali:hover { border-color:rgba(13,110,253,0.3); color:var(--primary); transform:translateY(-1px); }
</style>
@endpush

@section('layoutContent')

@php
    $score   = $examSession->score ?? null;
    $gradeClass = 'pending';
    $gradeText  = '—';
    $scoreLabel = 'Belum Diperiksa';
    if ($score !== null) {
        $n = floatval($score);
        if ($n >= 85)      { $gradeClass='grade-a'; $gradeText='A'; }
        elseif ($n >= 70)  { $gradeClass='grade-b'; $gradeText='B'; }
        elseif ($n >= 55)  { $gradeClass='grade-c'; $gradeText='C'; }
        else               { $gradeClass='grade-d'; $gradeText='D'; }
        $scoreLabel = 'Nilai Anda';
    }
@endphp

<div class="page-header">
    <div class="page-header-content">
        <h4><i class="bi bi-award me-2"></i>Hasil Ujian</h4>
        <p>{{ $examSession->exam->title ?? '-' }}</p>
    </div>
</div>

<div class="row g-3">

    {{-- Score --}}
    <div class="col-lg-4">
        <div class="panel-card h-100">
            <div class="panel-card-header"><i class="bi bi-trophy"></i> Nilai</div>
            <div class="panel-card-body">
                <div class="score-display">
                    <div class="score-circle {{ $gradeClass }}">
                        <div class="score-value">{{ $score !== null ? number_format($score, 1) : '—' }}</div>
                        <div class="score-label">{{ $scoreLabel }}</div>
                    </div>
                    <div class="score-grade">
                        @if($score !== null)
                            Predikat: <span style="color:{{ $gradeClass === 'grade-a' ? '#198754' : ($gradeClass === 'grade-b' ? '#0d6efd' : ($gradeClass === 'grade-c' ? '#856404' : '#dc3545')) }}">{{ $gradeText }}</span>
                        @else
                            Menunggu penilaian guru
                        @endif
                    </div>
                    <div class="score-text mt-1">
                        <span class="status-badge {{ $score !== null ? 'status-diperiksa' : 'status-pending' }}">
                            @if($score !== null)
                                <i class="bi bi-check-circle-fill"></i> Sudah Diperiksa
                            @else
                                <i class="bi bi-hourglass-split"></i> Belum Diperiksa
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail --}}
    <div class="col-lg-8">
        <div class="panel-card">
            <div class="panel-card-header"><i class="bi bi-info-circle"></i> Detail Ujian</div>
            <div class="panel-card-body">
                <div class="detail-row">
                    <div class="detail-icon"><i class="bi bi-clipboard-check"></i></div>
                    <div>
                        <div class="detail-key">Nama Ujian</div>
                        <div class="detail-val">{{ $examSession->exam->title ?? '-' }}</div>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="bi bi-journal-bookmark"></i></div>
                    <div>
                        <div class="detail-key">Mata Pelajaran</div>
                        <div class="detail-val">{{ $examSession->exam->subject->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="detail-key">Tanggal Ujian</div>
                        <div class="detail-val">
                            {{ $examSession->created_at ? $examSession->created_at->format('d M Y, H:i') : '-' }}
                        </div>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon" style="background:{{ $score !== null ? 'rgba(32,201,151,0.1)' : 'rgba(255,193,7,0.1)' }};color:{{ $score !== null ? '#198754' : '#856404' }};"><i class="bi bi-{{ $score !== null ? 'check-circle' : 'hourglass-split' }}"></i></div>
                    <div>
                        <div class="detail-key">Status</div>
                        <div class="detail-val">
                            <span class="status-badge {{ $score !== null ? 'status-diperiksa' : 'status-pending' }}">
                                {{ $score !== null ? 'Sudah Diperiksa' : 'Belum Diperiksa' }}
                            </span>
                        </div>
                    </div>
                </div>
                @if($score !== null)
                <div class="detail-row">
                    <div class="detail-icon" style="background:rgba(13,110,253,0.08);color:#0d6efd;"><i class="bi bi-bar-chart-line"></i></div>
                    <div>
                        <div class="detail-key">Nilai Akhir</div>
                        <div class="detail-val" style="font-size:1.2rem;color:{{ $gradeClass === 'grade-a' ? '#198754' : ($gradeClass === 'grade-b' ? '#0d6efd' : ($gradeClass === 'grade-c' ? '#856404' : '#dc3545')) }};">
                            {{ number_format($score, 1) }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('siswa.ujian.hasil.pdf', $examSession->id) }}" target="_blank" class="btn-cetak">
                <i class="bi bi-printer"></i> Cetak Hasil
            </a>
            <a href="{{ route('siswa.ujian.riwayat') }}" class="btn-kembali">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

</div>

@endsection