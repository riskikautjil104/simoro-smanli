<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class SoalBatchController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $subject = Subject::where('id', $request->subject_id)->where('teacher_id', $user->id)->firstOrFail();
        $exam_id = $request->exam_id;
        $created = [];
        // PG
        $jumlah_pg = (int)($request->jumlah_pg ?? 0);
        for ($i = 1; $i <= $jumlah_pg; $i++) {
            $pertanyaan = $request->input("pg_pertanyaan_$i");
            if (!$pertanyaan) continue;
            $options = [
                'A' => $request->input("pg_opsi_a_$i"),
                'B' => $request->input("pg_opsi_b_$i"),
                'C' => $request->input("pg_opsi_c_$i"),
                'D' => $request->input("pg_opsi_d_$i"),
            ];
            $answer_key = $request->input("pg_jawaban_benar_$i");
            $created[] = Question::create([
                'subject_id' => $subject->id,
                'exam_id' => $exam_id,
                'type' => 'multiple_choice',
                'question_text' => $pertanyaan,
                'pertanyaan' => $pertanyaan,
                'options' => $options,
                'answer_key' => $answer_key,
            ]);
        }
        // Esai
        $jumlah_esai = (int)($request->jumlah_esai ?? 0);
        for ($i = 1; $i <= $jumlah_esai; $i++) {
            $pertanyaan = $request->input("esai_pertanyaan_$i");
            if (!$pertanyaan) continue;
            $created[] = Question::create([
                'subject_id' => $subject->id,
                'exam_id' => $exam_id,
                'type' => 'essay',
                'question_text' => $pertanyaan,
                'pertanyaan' => $pertanyaan,
            ]);
        }
        return response()->json(['success' => true, 'count' => count($created)]);
    }
}
