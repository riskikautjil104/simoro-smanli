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
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'pertanyaan' => 'required|string',
            'type' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|string',
        ]);
        // Pastikan subject milik guru
        $subject = Subject::where('id', $request->subject_id)->where('teacher_id', $user->id)->firstOrFail();
        $type = $request->type === 'PG' ? 'multiple_choice' : 'essay';
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
            'subject_id' => $subject->id,
            'type' => $type,
            'question_text' => $request->pertanyaan,
            'pertanyaan' => $request->pertanyaan,
            'options' => $options,
            'answer_key' => $answer_key,
        ]);
        return response()->json(['success' => true, 'question' => $question]);
    }
}
