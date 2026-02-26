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
                // Show loading
                Swal.fire({
                    title: 'Mengirim jawaban...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
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
</script>
@endpush
@endsection