<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class SoalStoreController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'pertanyaan' => 'required|string',
            'type' => 'required|in:multiple_choice,essay,PG',
            'opsi_a' => 'nullable|string',
            'opsi_b' => 'nullable|string',
            'opsi_c' => 'nullable|string',
            'opsi_d' => 'nullable|string',
            'jawaban_benar' => 'nullable|string',
        ]);

        $subject = Subject::where('id', $validated['subject_id'])->where('teacher_id', $user->id)->firstOrFail();
        
        $type = in_array($validated['type'], ['PG', 'multiple_choice']) ? 'multiple_choice' : 'essay';
        $options = null;
        $answer_key = null;
        if ($type === 'multiple_choice') {
            $options = [
                'A' => $request->opsi_a,
                'B' => $request->opsi_b,
                'C' => $request->opsi_c,
                'D' => $request->opsi_d,
            ];
            $answer_key = $request->jawaban_benar;
        }

        $question = Question::create([
            'exam_id' => $validated['exam_id'],
            'subject_id' => $subject->id,
            'type' => $type,
            'question_text' => $validated['pertanyaan'],
            'pertanyaan' => $validated['pertanyaan'],
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawaban_benar' => $answer_key,
            'options' => $options,
            'answer_key' => $answer_key,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil ditambahkan.',
            'question' => $question->load(['subject', 'exam.schoolClass'])
        ]);
    }
}
