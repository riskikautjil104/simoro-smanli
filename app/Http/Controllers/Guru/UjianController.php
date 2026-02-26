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
        // Ambil ujian yang dibuat oleh guru ini (berdasarkan subject yang diajarkan)
        $subjects = Subject::where('teacher_id', $user->id)->pluck('id');
        $exams = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjects)
            ->get();
        return response()->json($exams);
    }

    // Daftar peserta ujian
    public function peserta($id, Request $request)
    {
        $user = $request->user();
        $exam = Exam::where('id', $id)
            ->whereIn('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))
            ->firstOrFail();
        $results = \App\Models\ExamResult::with('student')
            ->where('exam_id', $exam->id)
            ->get();
        return response()->json($results);
    }

    // Lihat jawaban siswa
    public function jawaban($ujianId, $userId, Request $request)
    {
        $user = $request->user();
        $exam = Exam::where('id', $ujianId)
            ->whereIn('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))
            ->firstOrFail();
        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->firstOrFail();
        $answers = \App\Models\StudentAnswer::with('question')
            ->where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->get();
        return response()->json($answers);
    }

    // Simpan nilai siswa
    public function simpanNilai($ujianId, $userId, Request $request)
    {
        $user = $request->user();
        $exam = Exam::where('id', $ujianId)
            ->whereIn('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))
            ->firstOrFail();
        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->firstOrFail();
        $nilai = $request->input('nilai');
        $result = \App\Models\ExamResult::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->firstOrFail();
        $result->score = $nilai;
        $result->save();
        return response()->json(['message' => 'Nilai berhasil disimpan']);
    }

     // Simpan nilai per soal
    public function simpanNilaiPerSoal($ujianId, $userId, Request $request)
    {
        $user = $request->user();
        $exam = Exam::where('id', $ujianId)
            ->whereIn('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))
            ->firstOrFail();
        $student = \App\Models\User::where('id', $userId)->where('role', 'student')->firstOrFail();
        $scores = $request->input('scores'); // array: [{answer_id, score}]
        foreach ($scores as $s) {
            $answer = \App\Models\StudentAnswer::where('id', $s['answer_id'])
                ->where('exam_id', $exam->id)
                ->where('user_id', $student->id)
                ->first();
            if ($answer) {
                $answer->score = $s['score'];
                $answer->save();
            }
        }
        return response()->json(['message' => 'Nilai per soal berhasil disimpan']);
    }
}
