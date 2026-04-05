@extends('layouts.master')
@section('title', 'Ikuti Ujian')

@push('styles')
<style>
/* ── Exam header ── */
.exam-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    border-radius: 16px; padding: 24px 28px;
    color: #fff; position: relative; overflow: hidden; margin-bottom: 24px;
}
.exam-header::before { content:''; position:absolute; width:220px; height:220px; background:rgba(255,255,255,0.07); border-radius:50%; top:-60px; right:-60px; pointer-events:none; }
.exam-header-content { position: relative; z-index: 2; }
.exam-header h4 { font-size: 1.25rem; font-weight: 700; margin: 0 0 10px; }
.exam-chip { display:inline-flex; align-items:center; gap:5px; background:rgba(255,255,255,0.18); border:1px solid rgba(255,255,255,0.3); color:#fff; font-size:0.75rem; font-weight:600; padding:4px 12px; border-radius:20px; margin-right:6px; margin-bottom:4px; }

/* ── Timer ── */
.timer-bar { background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.3); border-radius: 12px; padding: 12px 18px; display: inline-flex; align-items: center; gap: 10px; margin-top: 12px; backdrop-filter: blur(6px); }
.timer-digits { font-size: 1.5rem; font-weight: 800; letter-spacing: 2px; color: #fff; font-variant-numeric: tabular-nums; }
.timer-label { font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.7); }
.timer-bar.warning { background: rgba(255,193,7,0.2); border-color: rgba(255,193,7,0.5); }
.timer-bar.warning .timer-digits { color: #ffc107; }
.timer-bar.danger  { background: rgba(220,53,69,0.25); border-color: rgba(220,53,69,0.5); animation: pulse-danger 1s infinite; }
.timer-bar.danger  .timer-digits { color: #ff6b6b; }
@keyframes pulse-danger { 0%,100%{opacity:1} 50%{opacity:.75} }

/* ── Progress nav ── */
.progress-nav { background: #fff; border-radius: 14px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); padding: 16px; margin-bottom: 20px; }
.progress-nav-title { font-size: 0.78rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; }
.progress-nav-dots { display: flex; flex-wrap: wrap; gap: 6px; }
.qnav-dot { width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--border-color); background: #fff; color: var(--text-muted); font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); }
.qnav-dot:hover { border-color: var(--primary); color: var(--primary); }
.qnav-dot.answered { background: linear-gradient(135deg,#0d6efd,#0dcaf0); border-color: #0d6efd; color: #fff; box-shadow: 0 2px 6px rgba(13,110,253,0.3); }
.qnav-dot.current  { border-color: var(--primary); background: rgba(13,110,253,0.08); color: var(--primary); }

/* ── Section header ── */
.section-banner { border-radius: 12px; padding: 14px 18px; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
.section-banner.pg    { background: rgba(13,110,253,0.08); border: 1px solid rgba(13,110,253,0.15); }
.section-banner.essay { background: rgba(111,66,193,0.07); border: 1px solid rgba(111,66,193,0.15); }
.section-banner-icon  { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
.section-banner.pg    .section-banner-icon { background: rgba(13,110,253,0.12); color: #0d6efd; }
.section-banner.essay .section-banner-icon { background: rgba(111,66,193,0.1); color: #6f42c1; }
.section-banner-title { font-weight: 700; font-size: 0.9rem; }
.section-banner-sub   { font-size: 0.75rem; color: var(--text-muted); }

/* ── Question card ── */
.question-card {
    background: #fff; border-radius: 16px;
    border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);
    overflow: hidden; margin-bottom: 16px;
    transition: var(--transition); scroll-margin-top: 80px;
}
.question-card:hover { box-shadow: 0 4px 18px rgba(13,110,253,0.1); }
.question-card-header { padding: 14px 18px 0; display: flex; align-items: center; gap: 8px; }
.q-number { width: 30px; height: 30px; background: linear-gradient(135deg,#0d6efd,#0dcaf0); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.78rem; flex-shrink: 0; }
.q-number.essay-num { background: linear-gradient(135deg,#6f42c1,#9c27b0); }
.q-text { font-size: 0.9rem; font-weight: 600; color: var(--text-main); line-height: 1.6; padding: 12px 18px; }
.question-card-body { padding: 0 18px 18px; }

/* ── Radio options ── */
.option-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 10px; border: 1.5px solid var(--border-color); margin-bottom: 8px; cursor: pointer; transition: var(--transition); }
.option-item:hover { border-color: rgba(13,110,253,0.3); background: rgba(13,110,253,0.025); }
.option-item input[type="radio"] { display: none; }
.option-item.selected { border-color: var(--primary); background: rgba(13,110,253,0.06); }
.option-item.selected .option-key { background: linear-gradient(135deg,#0d6efd,#0dcaf0); color: #fff; border-color: transparent; }
.option-key { width: 28px; height: 28px; border-radius: 7px; border: 1.5px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); flex-shrink: 0; transition: var(--transition); }
.option-label { font-size: 0.875rem; color: var(--text-main); flex: 1; }

/* ── Essay textarea ── */
.essay-textarea { width: 100%; border-radius: 12px; border: 1.5px solid var(--border-color); padding: 12px 14px; font-size: 0.875rem; font-family: 'Poppins', sans-serif; color: var(--text-main); resize: vertical; min-height: 100px; transition: var(--transition); }
.essay-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,110,253,0.1); outline: none; }

/* ── Image sizing in exam ── */
.q-text img, .option-label img { max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; }
@media (max-width: 768px) {
    .q-text img, .option-label img { max-height: 250px; }
}

/* ── Submit button ── */
.btn-submit-ujian { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 14px; background: linear-gradient(135deg,#0d6efd,#0dcaf0); color: #fff; border: none; border-radius: 14px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); font-family: 'Poppins',sans-serif; box-shadow: 0 4px 18px rgba(13,110,253,0.3); }
.btn-submit-ujian:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,110,253,0.4); }
</style>
@endpush

@section('layoutContent')

<form id="formUjian" method="POST" action="{{ route('siswa.ujian.submit', $exam->id) }}">
@csrf

{{-- Exam header + timer --}}
<div class="exam-header">
    <div class="exam-header-content">
        <h4><i class="bi bi-clipboard-check me-2"></i>{{ $exam->title }}</h4>
        <div>
            <span class="exam-chip"><i class="bi bi-journal"></i> {{ $exam->subject->name ?? '-' }}</span>
            <span class="exam-chip"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y, H:i') }}</span>
            <span class="exam-chip"><i class="bi bi-clock"></i> {{ $exam->duration }} menit</span>
        </div>
        <div class="timer-bar" id="timerBar">
            <i class="bi bi-stopwatch-fill" style="font-size:1.1rem;"></i>
            <div>
                <div class="timer-label">Sisa Waktu</div>
                <div class="timer-digits" id="timerDisplay">--:--</div>
            </div>
        </div>
    </div>
</div>

@php
    $multipleChoiceQuestions = collect();
    $essayQuestions = collect();
    foreach($exam->questions as $question) {
        if(($question->type ?? null) === 'multiple_choice' ||
           (is_array($question->options) && count($question->options)) ||
           !empty($question->opsi_a) || !empty($question->opsi_b) ||
           !empty($question->opsi_c) || !empty($question->opsi_d)) {
            $multipleChoiceQuestions->push($question);
        } else {
            $essayQuestions->push($question);
        }
    }
    $sortedQuestions = $multipleChoiceQuestions->concat($essayQuestions);
    $totalSoal = $sortedQuestions->count();
@endphp

{{-- Progress nav --}}
@if($totalSoal > 0)
<div class="progress-nav">
    <div class="progress-nav-title"><i class="bi bi-grid-3x3-gap me-1"></i> Navigasi Soal — <span id="answeredCount">0</span>/{{ $totalSoal }} terjawab</div>
    <div class="progress-nav-dots" id="progressDots">
        @for($i = 1; $i <= $totalSoal; $i++)
            <div class="qnav-dot" id="dot-{{ $i }}" onclick="scrollToQuestion({{ $i }})">{{ $i }}</div>
        @endfor
    </div>
</div>
@endif

{{-- Bagian A: PG --}}
@if($multipleChoiceQuestions->count() > 0)
<div class="section-banner pg">
    <div class="section-banner-icon"><i class="bi bi-ui-radios"></i></div>
    <div>
        <div class="section-banner-title">BAGIAN A — PILIHAN GANDA</div>
        <div class="section-banner-sub">{{ $multipleChoiceQuestions->count() }} soal · Pilih satu jawaban yang paling tepat</div>
    </div>
</div>

@foreach($multipleChoiceQuestions as $index => $question)
@php $qNo = $index + 1; @endphp
<div class="question-card" id="question-{{ $qNo }}" data-qno="{{ $qNo }}">
    <div class="question-card-header">
        <div class="q-number">{{ $qNo }}</div>
        <span style="font-size:.72rem;font-weight:600;color:var(--primary);">Pilihan Ganda</span>
    </div>
    <div class="q-text">{!! $question->question_text ?? $question->pertanyaan ?? $question->text !!}</div>
    <div class="question-card-body">
        @if(is_array($question->options) && count($question->options))
            @foreach($question->options as $key => $option)
            <label class="option-item" for="choice_{{ $question->id }}_{{ $key }}">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" id="choice_{{ $question->id }}_{{ $key }}" onchange="markAnswered({{ $qNo }})">
                <span class="option-key">{{ strtoupper($key) }}</span>
                <span class="option-label">{{ $option }}</span>
            </label>
            @endforeach
        @else
            @foreach(['a','b','c','d'] as $optionKey)
            @php $optionField = 'opsi_' . $optionKey; @endphp
            @if(!empty($question->$optionField))
            <label class="option-item" for="choice_{{ $question->id }}_{{ $optionKey }}">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ strtoupper($optionKey) }}" id="choice_{{ $question->id }}_{{ $optionKey }}" onchange="markAnswered({{ $qNo }})">
                <span class="option-key">{{ strtoupper($optionKey) }}</span>
                <span class="option-label">{{ $question->$optionField }}</span>
            </label>
            @endif
            @endforeach
        @endif
    </div>
</div>
@endforeach
@endif

{{-- Bagian B: Essay --}}
@if($essayQuestions->count() > 0)
<div class="section-banner essay mt-2">
    <div class="section-banner-icon"><i class="bi bi-pencil-square"></i></div>
    <div>
        <div class="section-banner-title">BAGIAN B — ESSAY</div>
        <div class="section-banner-sub">{{ $essayQuestions->count() }} soal · Jawab dengan lengkap dan jelas</div>
    </div>
</div>

@foreach($essayQuestions as $index => $question)
@php $qNo = $multipleChoiceQuestions->count() + $index + 1; @endphp
<div class="question-card" id="question-{{ $qNo }}" data-qno="{{ $qNo }}">
    <div class="question-card-header">
        <div class="q-number essay-num">{{ $qNo }}</div>
        <span style="font-size:.72rem;font-weight:600;color:#6f42c1;">Essay</span>
    </div>
    <div class="q-text">{!! $question->question_text ?? $question->pertanyaan ?? $question->text !!}</div>
    <div class="question-card-body">
        <textarea
            class="essay-textarea"
            name="answers[{{ $question->id }}]"
            rows="4"
            placeholder="Tulis jawaban Anda di sini..."
            oninput="markAnswered({{ $qNo }})"
        ></textarea>
    </div>
</div>
@endforeach
@endif

{{-- Submit --}}
<div style="margin-top: 24px;">
    <button type="submit" class="btn-submit-ujian">
        <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
        Submit Jawaban
    </button>
</div>

</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Anti-cheat CSS ── */
(function(){
    var s = document.createElement('style');
    s.innerHTML = 'body,#formUjian,.question-card,.q-text,.option-label{-webkit-user-select:none!important;-moz-user-select:none!important;user-select:none!important;}';
    document.head.appendChild(s);
})();

var TOTAL_SOAL  = {{ $totalSoal }};
var DURASI_SECS = {{ $exam->duration * 60 }};
var answered    = {};
var formModified = false;
var timerInterval;

/* ── Timer ── */
function startTimer(seconds) {
    var remaining = seconds;
    function tick() {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;
        document.getElementById('timerDisplay').textContent =
            String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        var bar = document.getElementById('timerBar');
        bar.className = 'timer-bar';
        if (remaining <= 300) bar.classList.add('warning');
        if (remaining <= 60)  { bar.classList.remove('warning'); bar.classList.add('danger'); }
        if (remaining <= 0) {
            clearInterval(timerInterval);
            Swal.fire({ title:'Waktu Habis!', text:'Jawaban Anda akan otomatis dikumpulkan.', icon:'warning', allowOutsideClick:false, showConfirmButton:false, timer:2000 })
            .then(function(){ formModified=false; document.getElementById('formUjian').submit(); });
            return;
        }
        remaining--;
    }
    tick();
    timerInterval = setInterval(tick, 1000);
}
startTimer(DURASI_SECS);

/* ── Progress dots ── */
function markAnswered(qNo) {
    answered[qNo] = true;
    formModified  = true;
    var dot = document.getElementById('dot-' + qNo);
    if (dot) dot.classList.add('answered');
    document.getElementById('answeredCount').textContent = Object.keys(answered).length;

    /* Visual: highlight selected option */
    var card = document.getElementById('question-' + qNo);
    if (card) {
        card.querySelectorAll('.option-item').forEach(function(item) {
            item.classList.remove('selected');
        });
        var checkedInput = card.querySelector('input[type="radio"]:checked');
        if (checkedInput) checkedInput.closest('.option-item').classList.add('selected');
    }
}

function scrollToQuestion(qNo) {
    var el = document.getElementById('question-' + qNo);
    if (el) el.scrollIntoView({ behavior:'smooth', block:'start' });
    document.querySelectorAll('.qnav-dot').forEach(function(d){ d.classList.remove('current'); });
    var dot = document.getElementById('dot-' + qNo);
    if (dot) dot.classList.add('current');
}

/* ── Welcome alert + fullscreen + lokasi ── */
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Siap Ikuti Ujian?',
        html: '<b>' + {{ Js::from($exam->title) }} + '</b><br><small>Pastikan Anda sudah berdoa dan siap sebelum memulai.</small>',
        icon: 'info',
        confirmButtonText: '<i class="bi bi-play-fill me-1"></i> Mulai Ujian!',
        allowOutsideClick: false,
        customClass: { confirmButton: 'btn btn-primary px-4' },
        buttonsStyling: false
    }).then(function() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen().catch(function(){});
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                fetch('/api/siswa/ujian/lokasi', {
                    method: 'POST',
                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ exam_id: {{ $exam->id }}, lat: pos.coords.latitude, lng: pos.coords.longitude })
                });
            });
        }
    });

    /* ── Anti tab-switch ── */
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) return;
        clearInterval(timerInterval);
        fetch('/api/siswa/ujian/logout', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ exam_id: {{ $exam->id }} })
        }).finally(function() {
            var f = document.createElement('form');
            f.method = 'POST'; f.action = '/logout';
            var t = document.createElement('input');
            t.type='hidden'; t.name='_token'; t.value=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            f.appendChild(t); document.body.appendChild(f); f.submit();
        });
    });

    /* ── Submit confirm ── */
    document.getElementById('formUjian').addEventListener('submit', function(e) {
        e.preventDefault();
        var unanswered = TOTAL_SOAL - Object.keys(answered).length;
        Swal.fire({
            title: 'Yakin mau submit?',
            html: unanswered > 0
                ? '<b style="color:#dc3545;">Masih ada ' + unanswered + ' soal belum dijawab!</b><br>Pastikan semua soal sudah terisi.'
                : '<b>Semua soal sudah terjawab.</b><br>Periksa kembali sebelum mengumpulkan.',
            icon: unanswered > 0 ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Submit!',
            cancelButtonText: 'Cek Lagi',
            customClass: { confirmButton:'btn btn-primary px-4 me-2', cancelButton:'btn btn-outline-secondary px-4' },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                clearInterval(timerInterval);
                Swal.fire({ title:'Mengirim jawaban...', allowOutsideClick:false, didOpen:function(){ Swal.showLoading(); } });
                formModified = false;
                document.getElementById('formUjian').submit();
            }
        });
    });

    /* ── Prevent accidental leave ── */
    window.addEventListener('beforeunload', function(e) {
        if (formModified) { e.preventDefault(); e.returnValue = ''; }
    });

    /* ── Anti copy/paste/contextmenu ── */
    ['copy','paste','cut','dragstart'].forEach(function(ev) {
        document.body.addEventListener(ev, function(e){ e.preventDefault(); });
    });
    document.body.addEventListener('contextmenu', function(e){ e.preventDefault(); });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen') {
            e.preventDefault();
            if (navigator.clipboard) navigator.clipboard.writeText('Screenshot dinonaktifkan!');
        }
        if ((e.ctrlKey && (e.key==='s'||e.key==='u')) || (e.ctrlKey&&e.shiftKey&&e.key.toLowerCase()==='i')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush