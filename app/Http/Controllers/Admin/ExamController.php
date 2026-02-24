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
                return [
                    'id' => $q->id,
                    'pertanyaan' => $q->pertanyaan,
                    'tipe' => $q->opsi_a ? 'pg' : 'essay',
                    'opsi_a' => $q->opsi_a,
                    'opsi_b' => $q->opsi_b,
                    'opsi_c' => $q->opsi_c,
                    'opsi_d' => $q->opsi_d,
                    'jawaban_benar' => $q->jawaban_benar,
                    'jawaban_siswa' => $a->jawaban,
                    'nilai_essay' => $a->nilai_essay,
                ];
            });
        return response()->json($jawaban);
    }

    // Simpan penilaian essay siswa
    public function simpanNilai($ujianId, $userId, Request $request)
    {
        $nilaiEssay = $request->input('nilai_essay', []);
        foreach ($nilaiEssay as $questionId => $nilai) {
            \App\Models\StudentAnswer::where('exam_id', $ujianId)
                ->where('user_id', $userId)
                ->where('question_id', $questionId)
                ->update(['nilai_essay' => $nilai]);
        }
        // Hitung ulang total score jika perlu
        $total = \App\Models\StudentAnswer::where('exam_id', $ujianId)
            ->where('user_id', $userId)
            ->sum('nilai_essay');
        \App\Models\ExamSession::where('exam_id', $ujianId)
            ->where('user_id', $userId)
            ->update(['score' => $total]);
        return response()->json(['success' => true]);
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
