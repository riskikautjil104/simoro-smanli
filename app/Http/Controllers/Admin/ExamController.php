<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller

{
    /**
     * Return ujian data as JSON for AJAX table.
     */
    public function list()
    {
        $ujians = \App\Models\Exam::with(['subject', 'schoolClass'])->get();
        $result = $ujians->map(function ($ujian) {
            // Handle start_time as Carbon instance if possible
            $tanggal = null;
            if ($ujian->start_time) {
                if ($ujian->start_time instanceof \Carbon\Carbon) {
                    $tanggal = $ujian->start_time->format('Y-m-d');
                } else {
                    $tanggal = date('Y-m-d', strtotime($ujian->start_time));
                }
            }
            return [
                'id' => $ujian->id,
                'nama' => $ujian->title,
                'mapel' => $ujian->subject ? ['id' => $ujian->subject->id, 'nama' => $ujian->subject->name] : null,
                'kelas' => $ujian->schoolClass ? ['id' => $ujian->schoolClass->id, 'nama' => $ujian->schoolClass->name] : null,
                'tanggal' => $tanggal,
            ];
        });
        return response()->json($result);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Jika request expects JSON (AJAX), return data ujian sebagai JSON
        if (request()->wantsJson()) {
            $ujians = \App\Models\Exam::with(['subject', 'schoolClass'])->get();
            $result = $ujians->map(function ($ujian) {
                $tanggal = null;
                if ($ujian->start_time) {
                    if ($ujian->start_time instanceof \Carbon\Carbon) {
                        $tanggal = $ujian->start_time->format('Y-m-d');
                    } else {
                        $tanggal = date('Y-m-d', strtotime($ujian->start_time));
                    }
                }
                return [
                    'id' => $ujian->id,
                    'nama' => $ujian->title,
                    'mapel' => $ujian->subject ? ['id' => $ujian->subject->id, 'nama' => $ujian->subject->name] : null,
                    'kelas' => $ujian->schoolClass ? ['id' => $ujian->schoolClass->id, 'nama' => $ujian->schoolClass->name] : null,
                    'tanggal' => $tanggal,
                ];
            });
            return response()->json($result);
        }
        return view('admin.ujian');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'mapel_id' => 'required|integer|exists:subjects,id',
            'kelas_id' => 'required|integer|exists:classes,id',
            'tanggal' => 'required|date',
        ]);
        $ujian = \App\Models\Exam::create([
            'title' => $validated['nama'],
            'subject_id' => $validated['mapel_id'],
            'class_id' => $validated['kelas_id'],
            'start_time' => $validated['tanggal'],
            'end_time' => $validated['tanggal'], // bisa diubah jika ada duration
            'duration' => 0, // default, bisa diubah jika ada duration
            'status' => 'draft',
        ]);
        return response()->json($ujian);
    }

    public function show($id)
    {
        $ujian = \App\Models\Exam::findOrFail($id);
        return response()->json($ujian);
    }

    public function update(Request $request, $id)
    {
        $ujian = \App\Models\Exam::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'mapel_id' => 'required|integer|exists:subjects,id',
            'kelas_id' => 'required|integer|exists:classes,id',
            'tanggal' => 'required|date',
        ]);
        $ujian->update([
            'title' => $validated['nama'],
            'subject_id' => $validated['mapel_id'],
            'class_id' => $validated['kelas_id'],
            'start_time' => $validated['tanggal'],
            'end_time' => $validated['tanggal'],
        ]);
        return response()->json($ujian);
    }

    public function destroy($id)
    {
        $ujian = \App\Models\Exam::findOrFail($id);
        $ujian->delete();
        return response()->json(['success' => true]);
    }
    // Peserta ujian (list siswa yang ikut ujian)
    public function peserta($id)
    {
        $exam = \App\Models\Exam::findOrFail($id);
        $peserta = \App\Models\ExamSession::where('exam_id', $id)
            ->with(['user.class'])
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->user_id,
                    'nama' => $s->user->name,
                    'kelas' => $s->user->class->name ?? '-',
                    'mulai' => $s->start_time,
                    'selesai' => $s->end_time,
                    'durasi' => $s->start_time && $s->end_time ? (\Carbon\Carbon::parse($s->start_time)->diffInMinutes($s->end_time) . ' menit') : '-',
                    'nilai' => $s->score,
                ];
            });
        return response()->json($peserta);
    }

    // Halaman detail ujian
    public function detail($id)
    {
        $ujian = \App\Models\Exam::findOrFail($id);
        return view('admin.ujian_detail', compact('ujian'));
    }

    // Ranking nilai tertinggi
    public function ranking($id)
    {
        $exam = \App\Models\Exam::findOrFail($id);
        $ranking = \App\Models\ExamSession::where('exam_id', $id)
            ->with(['user.class'])
            ->orderByDesc('score')
            ->take(10)
            ->get()
            ->map(function ($s) {
                $user = $s->user;
                return [
                    'id' => $s->user_id,
                    'nama' => $user ? $user->name : '-',
                    'kelas' => ($user && $user->class) ? $user->class->name : '-',
                    'nilai' => $s->score,
                ];
            })
            ->values(); // pastikan array numerik
        return response()->json($ranking);
    }

    // Jawaban siswa untuk ujian tertentu
    public function jawaban($ujianId, $userId)
    {
        $exam = \App\Models\Exam::findOrFail($ujianId);
        $jawaban = \App\Models\StudentAnswer::where('exam_id', $ujianId)
            ->where('user_id', $userId)
            ->with('question')
            ->get()
            ->map(function ($a) {
                $q = $a->question;
                $tipe = 'pg';
                if (isset($q->type)) {
                    if ($q->type === 'essay') {
                        $tipe = 'essay';
                    } else if ($q->type === 'multiple_choice' || $q->type === 'pg') {
                        $tipe = 'pg';
                    } else {
                        $tipe = $q->type;
                    }
                }
                // Ambil opsi PG dari opsi_a-d atau dari options (array)
                $opsi_a = $q->opsi_a ?? null;
                $opsi_b = $q->opsi_b ?? null;
                $opsi_c = $q->opsi_c ?? null;
                $opsi_d = $q->opsi_d ?? null;
                if (($tipe === 'pg' || $tipe === 'multiple_choice') && (!$opsi_a && !$opsi_b && !$opsi_c && !$opsi_d) && isset($q->options) && is_array($q->options)) {
                    $opsi_a = $q->options[0] ?? null;
                    $opsi_b = $q->options[1] ?? null;
                    $opsi_c = $q->options[2] ?? null;
                    $opsi_d = $q->options[3] ?? null;
                }
                return [
                    'id' => $q->id,
                    'pertanyaan' => $q->pertanyaan ?? $q->question_text ?? '-',
                    'tipe' => $tipe,
                    'opsi_a' => $opsi_a,
                    'opsi_b' => $opsi_b,
                    'opsi_c' => $opsi_c,
                    'opsi_d' => $opsi_d,
                    'jawaban_benar' => $q->jawaban_benar ?? $q->answer_key ?? '-',
                    'jawaban_siswa' => $a->answer,
                    'nilai_essay' => $a->nilai_essay,
                ];
            });
        return response()->json($jawaban);
    }

    // Simpan penilaian essay siswa
    public function simpanNilai($ujianId, $userId, Request $request)
    {
        $nilaiEssay = $request->input('nilai_essay', []);
        $nilaiPgInput = $request->input('nilai_pg', []);

        // Simpan nilai essay
        foreach ($nilaiEssay as $questionId => $nilai) {
            \App\Models\StudentAnswer::where('exam_id', $ujianId)
                ->where('user_id', $userId)
                ->where('question_id', $questionId)
                ->update(['nilai_essay' => $nilai]);
        }
        // Simpan nilai PG manual jika ada
        foreach ($nilaiPgInput as $questionId => $nilai) {
            \App\Models\StudentAnswer::where('exam_id', $ujianId)
                ->where('user_id', $userId)
                ->where('question_id', $questionId)
                ->update(['score' => $nilai]);
        }


        // Hitung nilai dinamis sesuai rumus
        $exam = \App\Models\Exam::find($ujianId);
        $questions = $exam ? $exam->questions : collect();
        $pgQuestions = $questions->where('type', 'multiple_choice')->count();
        $essayQuestions = $questions->where('type', 'essay')->count();

        // Bobot PG dan Essay (default: 50:50, bisa diubah sesuai kebutuhan)
        $bobotPg = 50;
        $bobotEssay = 50;
        if ($pgQuestions == 0) {
            $bobotEssay = 100;
            $bobotPg = 0;
        } else if ($essayQuestions == 0) {
            $bobotPg = 100;
            $bobotEssay = 0;
        }

        // Nilai per soal
        $nilaiPerPg = $pgQuestions > 0 ? $bobotPg / $pgQuestions : 0;
        $nilaiPerEssay = $essayQuestions > 0 ? $bobotEssay / $essayQuestions : 0;

        // Hitung jumlah PG benar
        $jawabanBenar = \App\Models\StudentAnswer::where('student_answers.exam_id', $ujianId)
            ->where('student_answers.user_id', $userId)
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->where('questions.type', 'multiple_choice')
            ->whereRaw('student_answers.answer = questions.jawaban_benar')
            ->count();
        $nilaiPg = $jawabanBenar * $nilaiPerPg;

        // Hitung total nilai essay (dibatasi max per soal)
        $nilaiEssayTotal = 0;
        foreach ($nilaiEssay as $questionId => $nilai) {
            $nilaiEssayTotal += min($nilai, $nilaiPerEssay);
        }

        // Total nilai max 100
        $total = $nilaiPg + $nilaiEssayTotal;
        if ($total > 100) $total = 100;

        \App\Models\ExamSession::where('exam_id', $ujianId)
            ->where('user_id', $userId)
            ->update(['score' => $total]);
        return response()->json(['success' => true, 'nilai_pg' => $nilaiPg, 'nilai_essay' => $nilaiEssayTotal, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
}
