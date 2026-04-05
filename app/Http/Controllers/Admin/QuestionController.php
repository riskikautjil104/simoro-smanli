<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exam;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->expectsJson()) {
            $query = Question::with('exam');
            
            if ($request->has('exam_id')) {
                $query->where('exam_id', $request->exam_id);
            }
            
            $questions = $query->get();
            return response()->json($questions);
        }
        return view('admin.soal');
    }

    public function batch(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'soal' => 'required|array|min:1',
            'soal.*.tipe' => 'required|in:pg,essay',
            'soal.*.pertanyaan' => 'required',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        
        if (!$exam->subject_id) {
            return response()->json([
                'success' => false, 
                'message' => 'Ujian ini belum memiliki mata pelajaran'
            ], 400);
        }

        $inserted = [];
        foreach ($request->soal as $item) {
            // Base data yang WAJIB ada
            $data = [
                'exam_id' => $request->exam_id,
                'subject_id' => $exam->subject_id,
                'question_text' => $item['pertanyaan'], // NOT NULL - WAJIB
                'pertanyaan' => $item['pertanyaan'],    // Nullable - isi juga
                'type' => $item['tipe'] === 'pg' ? 'multiple_choice' : 'essay', // NOT NULL - WAJIB
            ];

            if ($item['tipe'] === 'pg') {
                // Validasi PG
                if (!isset($item['opsi_a'], $item['opsi_b'], $item['opsi_c'], $item['opsi_d'], $item['jawaban_benar'])) {
                    continue;
                }

                // Isi kolom lama (varchar)
                $data['opsi_a'] = $item['opsi_a'];
                $data['opsi_b'] = $item['opsi_b'];
                $data['opsi_c'] = $item['opsi_c'];
                $data['opsi_d'] = $item['opsi_d'];
                $data['jawaban_benar'] = strtoupper($item['jawaban_benar']);
                
                // Isi kolom baru (JSON & varchar)
                $data['options'] = json_encode([
                    'A' => $item['opsi_a'],
                    'B' => $item['opsi_b'],
                    'C' => $item['opsi_c'],
                    'D' => $item['opsi_d'],
                ]);
                $data['answer_key'] = strtoupper($item['jawaban_benar']);
            } else {
                // Essay - set NULL untuk opsi
                $data['opsi_a'] = null;
                $data['opsi_b'] = null;
                $data['opsi_c'] = null;
                $data['opsi_d'] = null;
                $data['jawaban_benar'] = null;
                $data['options'] = null;
                $data['answer_key'] = null;
            }

            $inserted[] = Question::create($data);
        }

        return response()->json([
            'success' => true, 
            'count' => count($inserted),
            'message' => count($inserted) . ' soal berhasil disimpan'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'jawaban_benar' => 'required|in:A,B,C,D',
        ]);

        $exam = Exam::findOrFail($data['exam_id']);
        
        if (!$exam->subject_id) {
            return response()->json([
                'success' => false, 
                'message' => 'Ujian ini belum memiliki mata pelajaran'
            ], 400);
        }

        $questionData = [
            'exam_id' => $data['exam_id'],
            'subject_id' => $exam->subject_id,
            'type' => 'multiple_choice', // NOT NULL
            'question_text' => $data['pertanyaan'], // NOT NULL
            'pertanyaan' => $data['pertanyaan'],
            'opsi_a' => $data['opsi_a'],
            'opsi_b' => $data['opsi_b'],
            'opsi_c' => $data['opsi_c'],
            'opsi_d' => $data['opsi_d'],
            'jawaban_benar' => strtoupper($data['jawaban_benar']),
            'options' => json_encode([
                'A' => $data['opsi_a'],
                'B' => $data['opsi_b'],
                'C' => $data['opsi_c'],
                'D' => $data['opsi_d'],
            ]),
            'answer_key' => strtoupper($data['jawaban_benar']),
        ];

        $question = Question::create($questionData);
        return response()->json($question);
    }

    public function show(string $id)
    {
        $question = Question::with('exam')->findOrFail($id);
        return response()->json($question);
    }

    public function update(Request $request, string $id)
    {
        $question = Question::findOrFail($id);
        
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'jawaban_benar' => 'required|in:A,B,C,D',
        ]);

        $exam = Exam::findOrFail($data['exam_id']);

        $questionData = [
            'exam_id' => $data['exam_id'],
            'subject_id' => $exam->subject_id,
            'type' => 'multiple_choice',
            'question_text' => $data['pertanyaan'],
            'pertanyaan' => $data['pertanyaan'],
            'opsi_a' => $data['opsi_a'],
            'opsi_b' => $data['opsi_b'],
            'opsi_c' => $data['opsi_c'],
            'opsi_d' => $data['opsi_d'],
            'jawaban_benar' => strtoupper($data['jawaban_benar']),
            'options' => json_encode([
                'A' => $data['opsi_a'],
                'B' => $data['opsi_b'],
                'C' => $data['opsi_c'],
                'D' => $data['opsi_d'],
            ]),
            'answer_key' => strtoupper($data['jawaban_benar']),
        ];

        $question->update($questionData);
        return response()->json($question);
    }

    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        
        if (!$exam->subject_id) {
            return response()->json([
                'success' => false, 
                'message' => 'Ujian ini belum memiliki mata pelajaran'
            ], 400);
        }

        // TODO: Implementasi import Excel
        
        return response()->json([
            'success' => true, 
            'message' => 'Import soal berhasil'
        ]);
    }
}