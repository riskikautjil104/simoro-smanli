@extends('layouts.master')

@section('title', 'Ikuti Ujian')

@section('layoutContent')
<div class="container py-4">
    {{-- Header Section --}}
    <h4 class="mb-4">Ikuti Ujian: {{ $exam->title }}</h4>
    
    {{-- Exam Info Badges --}}
    <div class="mb-4">
        <span class="badge bg-info">Mapel: {{ $exam->subject->name ?? '-' }}</span>
        <span class="badge bg-success">Tanggal: {{ $exam->start_time }}</span>
        <span class="badge bg-secondary">Durasi: {{ $exam->duration }} menit</span>
    </div>

    {{-- Exam Form --}}
    <form id="formUjian" method="POST" action="{{ route('siswa.ujian.submit', $exam->id) }}">
        @csrf
        
        {{-- Questions Section --}}
        <div class="mb-4">
            @php
                // Pisahkan soal berdasarkan tipe
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
                
                // Gabungkan: PG dulu, baru Essay
                $sortedQuestions = $multipleChoiceQuestions->concat($essayQuestions);
            @endphp

            {{-- Bagian A: Pilihan Ganda --}}
            @if($multipleChoiceQuestions->count() > 0)
                <div class="alert alert-primary mb-3">
                    <strong>BAGIAN A - PILIHAN GANDA</strong> ({{ $multipleChoiceQuestions->count() }} Soal)
                </div>

                @foreach($multipleChoiceQuestions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            {{-- Question Text --}}
                            <h6 class="mb-3">
                                <strong>{{ $index + 1 }}.</strong> 
                                {{ $question->question_text ?? $question->pertanyaan ?? $question->text }}
                            </h6>

                            {{-- Multiple Choice Options --}}
                            @if(is_array($question->options) && count($question->options))
                                @foreach($question->options as $key => $option)
                                    <div class="form-check mb-2">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="answers[{{ $question->id }}]" 
                                            value="{{ $key }}" 
                                            id="choice_{{ $question->id }}_{{ $key }}"
                                            required
                                        >
                                        <label class="form-check-label" for="choice_{{ $question->id }}_{{ $key }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                @foreach(['a', 'b', 'c', 'd'] as $optionKey)
                                    @php $optionField = 'opsi_' . $optionKey; @endphp
                                    @if(!empty($question->$optionField))
                                        <div class="form-check mb-2">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="answers[{{ $question->id }}]" 
                                                value="{{ strtoupper($optionKey) }}" 
                                                id="choice_{{ $question->id }}_{{ $optionKey }}"
                                                required
                                            >
                                            <label class="form-check-label" for="choice_{{ $question->id }}_{{ $optionKey }}">
                                                {{ $question->$optionField }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Bagian B: Essay --}}
            @if($essayQuestions->count() > 0)
                <div class="alert alert-success mb-3 mt-4">
                    <strong>BAGIAN B - ESSAY</strong> ({{ $essayQuestions->count() }} Soal)
                </div>

                @foreach($essayQuestions as $index => $question)
                    <div class="card mb-3">
                        <div class="card-body">
                            {{-- Question Text --}}
                            <h6 class="mb-3">
                                <strong>{{ $multipleChoiceQuestions->count() + $index + 1 }}.</strong> 
                                {{ $question->question_text ?? $question->pertanyaan ?? $question->text }}
                            </h6>

                            {{-- Essay Answer --}}
                            <textarea 
                                class="form-control" 
                                name="answers[{{ $question->id }}]" 
                                rows="4" 
                                placeholder="Tulis jawaban essay Anda di sini..."
                                required
                            ></textarea>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-2"></i>Submit Jawaban
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Welcome Alert
    Swal.fire({
        title: 'Siap Ikuti Ujian?',
        text: 'Pastikan Anda sudah berdoa terlebih dahulu sebelum memulai ujian.',
        icon: 'info',
        confirmButtonText: 'Oke, Mulai Ujian!',
        allowOutsideClick: false
    }).then(() => {
        // Paksa fullscreen
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }
        // Minta lokasi
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                fetch('/api/siswa/ujian/lokasi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        exam_id: {{ $exam->id }},
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    })
                });
            }, function(err) {
                Swal.fire('Lokasi diperlukan!','Ijinkan akses lokasi untuk mengikuti ujian.','error');
            });
        }
    });


    // Blokir tab lain (anti switch tab) dan auto logout jika tab ditinggalkan
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            fetch('/api/siswa/ujian/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ exam_id: {{ $exam->id }} })
            }).then(() => {
                // Logout via POST (submit form)
                let logoutForm = document.getElementById('auto-logout-form');
                if (!logoutForm) {
                    logoutForm = document.createElement('form');
                    logoutForm.id = 'auto-logout-form';
                    logoutForm.method = 'POST';
                    logoutForm.action = '/logout';
                    // CSRF token
                    const csrf = document.querySelector('meta[name="csrf-token"]');
                    if (csrf) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_token';
                        input.value = csrf.getAttribute('content');
                        logoutForm.appendChild(input);
                    }
                    document.body.appendChild(logoutForm);
                }
                logoutForm.submit();
            });
        }
    });

    // Submit Confirmation
    const examForm = document.getElementById('formUjian');
    examForm.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin mau submit?',
            html: '<b>Pastikan jawaban Anda sudah terisi dengan benar dan sudah dibaca baik-baik!</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Submit!',
            cancelButtonText: 'Cek Lagi',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengirim jawaban...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                formModified = false;
                examForm.submit();
            }
        });
    });

    // Prevent accidental page leave
    let formModified = false;
    examForm.addEventListener('change', function() {
        formModified = true;
    });
    window.addEventListener('beforeunload', function (e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});
// Anti copy, paste, cut, drag, right click, dan screenshot
document.addEventListener('DOMContentLoaded', function () {
    // Blokir copy, paste, cut
    document.body.addEventListener('copy', e => e.preventDefault());
    document.body.addEventListener('paste', e => e.preventDefault());
    document.body.addEventListener('cut', e => e.preventDefault());
    // Blokir drag
    document.body.addEventListener('dragstart', e => e.preventDefault());
    // Blokir klik kanan
    document.body.addEventListener('contextmenu', e => e.preventDefault());
    // Blokir PrintScreen (screenshot)
    document.addEventListener('keydown', function(e) {
        // PrintScreen
        if (e.key === 'PrintScreen') {
            e.preventDefault();
            // Kosongkan clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText('Screenshot dinonaktifkan!');
            }
            alert('Fitur screenshot dinonaktifkan selama ujian.');
        }
        // Blokir Ctrl+S, Ctrl+U, Ctrl+Shift+I (view source/devtools)
        if ((e.ctrlKey && (e.key === 's' || e.key === 'u')) || (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 'i')) {
            e.preventDefault();
        }
    });
    // Blokir screenshot di HP Android (beberapa browser support)
    if (window.navigator && window.navigator.userAgent.match(/Android/i)) {
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Bisa tambahkan notifikasi atau auto-logout jika ingin
            }
        });
    }
});
// CSS: Blokir user select dan drag
const style = document.createElement('style');
style.innerHTML = `
    body, #formUjian, .container, .card, .card-body {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        -webkit-user-drag: none !important;
        -khtml-user-drag: none !important;
        -moz-user-drag: none !important;
        -o-user-drag: none !important;
        user-drag: none !important;
    }
`;
document.head.appendChild(style);
</script>

@endpush
@endsection