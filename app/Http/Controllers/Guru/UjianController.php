<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class UjianController extends Controller

{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil subject milik guru (cek juga jika teacher_id null agar bisa lihat semua ujian)
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        // Jika guru tidak punya subject tertentu, tetap bisa lihat semua ujian (opsional)
        // Atau bisa juga kasih pesan bahwa belum ada mapel yang diampu

        $exams = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjectIds)
            ->get()
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'subject' => $exam->subject ? [
                        'id' => $exam->subject->id,
                        'name' => $exam->subject->name,
                    ] : null,
                    'school_class' => $exam->schoolClass ? [
                        'id' => $exam->schoolClass->id,
                        'name' => $exam->schoolClass->name,
                    ] : null,
                    'start_time' => $exam->start_time,
                    'end_time' => $exam->end_time,
                    'duration' => $exam->duration,
                ];
            });

        return response()->json($exams);
    }

    // Daftar peserta ujian
    public function peserta($id, Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru (jika kosong, tetap bisa akses untuk debugging)
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        // Cek apakah ini mode debug (subjectIds kosong tapi tetap boleh akses)
        $allowAll = $subjectIds->isEmpty();

        $exam = Exam::where('id', $id)
            ->when(!$allowAll, function ($q) use ($subjectIds) {
                return $q->whereIn('subject_id', $subjectIds);
            })
            ->first();

        if (!$exam) {
            return response()->json(['message' => 'Ujian tidak ditemukan atau bukan milik Anda'], 404);
        }

ExamSession::with(['user.class'])
            ->where('exam_id', $exam->id)
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'user_id' => $session->user_id,
                    'score' => $session->score,
                    'user' => $session->user ? [
                        'id' => $session->user->id,
                        'name' => $session->user->name,
                    ] : null,
                ];
            });

        return response()->json($results);
    }

    // Lihat jawaban siswa
    public function jawaban($ujianId, $userId, Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru (jika kosong, tetap bisa akses untuk debugging)
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        // Cek apakah ini mode debug (subjectIds kosong tapi tetap boleh akses)
        $allowAll = $subjectIds->isEmpty();

        $exam = Exam::where('id', $ujianId)
            ->when(!$allowAll, function ($q) use ($subjectIds) {
                return $q->whereIn('subject_id', $subjectIds);
            })
            ->first();

        if (!$exam) {
            return response()->json(['message' => 'Ujian tidak ditemukan atau bukan milik Anda'], 404);
        }

        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->first();

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        $answers = \App\Models\StudentAnswer::with('question')
            ->where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->get()
            ->map(function ($answer) {
                $question = $answer->question;
                return [
                    'id' => $answer->id,
                    'answer' => $answer->answer,
                    'nilai_essay' => $answer->nilai_essay,
                    'question' => $question ? [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'pertanyaan' => $question->pertanyaan,
                        'type' => $question->type,
                        'answer_key' => $question->answer_key,
                        'jawaban_benar' => $question->jawaban_benar,
                        'opsi_a' => $question->opsi_a,
                        'opsi_b' => $question->opsi_b,
                        'opsi_c' => $question->opsi_c,
                        'opsi_d' => $question->opsi_d,
                        'options' => is_array($question->options) ? $question->options : json_decode($question->options, true),
                    ] : null,
                ];
            });

        return response()->json($answers);
    }

    // Simpan nilai siswa
    public function simpanNilai($ujianId, $userId, Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exam = Exam::where('id', $ujianId)
            ->whereIn('subject_id', $subjectIds)
            ->first();

        if (!$exam) {
            return response()->json(['message' => 'Ujian tidak ditemukan atau bukan milik Anda'], 404);
        }

        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->first();

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        $nilai = $request->input('nilai');

        $session = \App\Models\ExamSession::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->first();

        if (!$session) {
            return response()->json(['message' => 'Sesi ujian tidak ditemukan'], 404);
        }

        $session->score = $nilai;
        $session->save();

        return response()->json(['message' => 'Nilai berhasil disimpan', 'score' => $nilai]);
    }

    // Simpan nilai per soal
    public function simpanNilaiPerSoal($ujianId, $userId, Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exam = Exam::where('id', $ujianId)
            ->whereIn('subject_id', $subjectIds)
            ->first();

        if (!$exam) {
            return response()->json(['message' => 'Ujian tidak ditemukan atau bukan milik Anda'], 404);
        }

        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->first();

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }

        // Support 2 bentuk payload:
        // 1) scores: [{answer_id, score}] (legacy UI guru)
        // 2) nilai_essay: {question_id: nilai} (seperti admin)
        $nilaiEssay = $request->input('nilai_essay', []);
        $scores = $request->input('scores', []);

        if (!empty($scores) && is_array($scores)) {
            foreach ($scores as $s) {
                $answerId = $s['answer_id'] ?? null;
                $scoreVal = $s['score'] ?? null;
                if (!$answerId) continue;

                $answer = \App\Models\StudentAnswer::where('id', $answerId)
                    ->where('exam_id', $exam->id)
                    ->where('user_id', $student->id)
                    ->first();

                if ($answer) {
                    $answer->nilai_essay = is_numeric($scoreVal) ? (float) $scoreVal : null;
                    $answer->save();
                }
            }
        }

        if (!empty($nilaiEssay) && is_array($nilaiEssay)) {
            foreach ($nilaiEssay as $questionId => $nilai) {
                \App\Models\StudentAnswer::where('exam_id', $exam->id)
                    ->where('user_id', $student->id)
                    ->where('question_id', $questionId)
                    ->update(['nilai_essay' => $nilai]);
            }
        }

        // Hitung nilai dinamis (PG otomatis, Essay manual) => bobot 50/50
        $questions = $exam->questions ?? collect();
        $pgQuestionsCount = $questions->whereIn('type', ['multiple_choice', 'pg'])->count();
        $essayQuestionsCount = $questions->where('type', 'essay')->count();

        $bobotPg = 50;
        $bobotEssay = 50;
        if ($pgQuestionsCount === 0) {
            $bobotPg = 0;
            $bobotEssay = 100;
        } elseif ($essayQuestionsCount === 0) {
            $bobotPg = 100;
            $bobotEssay = 0;
        }

        $nilaiPerPg = $pgQuestionsCount > 0 ? ($bobotPg / $pgQuestionsCount) : 0;
        $nilaiPerEssay = $essayQuestionsCount > 0 ? ($bobotEssay / $essayQuestionsCount) : 0;

        // Hitung jumlah PG benar (case-insensitive)
        // Daripada SQL whereRaw (rawan mismatch format jawaban: A vs 0..3),
        // hitung di PHP dengan membandingkan nilai yang sama persis seperti saat cetak hasil.
        $studentAnswers = \App\Models\StudentAnswer::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->get()
            ->keyBy('question_id');

        $pgQuestions = $questions->whereIn('type', ['multiple_choice', 'pg']);
        $correctPgCount = 0;
        foreach ($pgQuestions as $q) {
            $ans = $studentAnswers->get($q->id);
            $jawabanSiswa = $ans?->answer;
            $jawabanBenar = $q->jawaban_benar ?? $q->answer_key;

            if ($jawabanSiswa === null || $jawabanBenar === null) {
                continue;
            }

            if (strtoupper((string) $jawabanSiswa) === strtoupper((string) $jawabanBenar)) {
                $correctPgCount++;
            }
        }

        $nilaiPg = $correctPgCount * $nilaiPerPg;

        // Total nilai essay (dibatasi max per soal)
        $nilaiEssayTotal = \App\Models\StudentAnswer::where('student_answers.exam_id', $exam->id)
            ->where('student_answers.user_id', $student->id)
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->where('questions.type', 'essay')
            ->select('student_answers.nilai_essay')
            ->get()
            ->sum(function ($row) use ($nilaiPerEssay) {
                $v = is_numeric($row->nilai_essay) ? (float) $row->nilai_essay : 0;
                return min($v, $nilaiPerEssay);
            });

        $total = $nilaiPg + $nilaiEssayTotal;
        if ($total > 100) $total = 100;

        $session = \App\Models\ExamSession::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->first();

        if ($session) {
            $session->score = $total;
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Nilai per soal berhasil disimpan',
            'nilai_pg' => $nilaiPg,
            'nilai_essay' => $nilaiEssayTotal,
            'total' => $total,
        ]);
    }

    // Detail ujian
    public function detail($id, Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');
        $allowAll = $subjectIds->isEmpty();

        $exam = Exam::with(['subject', 'schoolClass'])
            ->when(!$allowAll, function ($q) use ($subjectIds) {
                return $q->whereIn('subject_id', $subjectIds);
            })
            ->find($id);

        if (!$exam) {
            abort(404, 'Ujian tidak ditemukan atau bukan milik Anda');
        }

        // Hitung statistik
        $totalPeserta = \App\Models\ExamSession::where('exam_id', $id)->count();
        $pesertaSelesai = \App\Models\ExamSession::where('exam_id', $id)->whereNotNull('end_time')->count();

        return view('guru.ujian-detail', compact('exam', 'totalPeserta', 'pesertaSelesai'));
    }
}
