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

        $results = \App\Models\ExamSession::with('user')
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

        $scores = $request->input('scores'); // array: [{answer_id, score}]

        foreach ($scores as $s) {
            $answer = \App\Models\StudentAnswer::where('id', $s['answer_id'])
                ->where('exam_id', $exam->id)
                ->where('user_id', $student->id)
                ->first();

            if ($answer) {
                $answer->nilai_essay = $s['score'];
                $answer->save();
            }
        }

        // Hitung ulang total nilai essay
        $total = \App\Models\StudentAnswer::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->sum('nilai_essay');

        $session = \App\Models\ExamSession::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->first();

        if ($session) {
            $session->score = $total;
            $session->save();
        }

        return response()->json(['message' => 'Nilai per soal berhasil disimpan', 'total' => $total]);
    }
}
