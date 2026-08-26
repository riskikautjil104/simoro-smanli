<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilUjianPdfController extends Controller
{
    public function hasilPdf($id)
    {
        $user = Auth::user();
        $examSession = \App\Models\ExamSession::where('user_id', $user->id)
            ->where(function($q) use ($id) {
                $q->where('exam_id', $id)->orWhere('id', $id);
            })
            ->with(['exam.subject.teacher'])
            ->latest('id')
            ->firstOrFail();
        if ($examSession->score === null) {
            abort(403, 'Hasil ujian belum diperiksa guru.');
        }
        $exam = $examSession->exam;
        $guru = $exam->subject ? $exam->subject->teacher : null;
        $kepsek = \App\Models\User::where('role', 'kepala_sekolah')->first();

        $questions = \App\Models\Question::where('exam_id', $exam->id)->get();
        $answers = \App\Models\StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->get()
            ->keyBy('question_id');

        $pdf = Pdf::loadView('siswa.hasil-ujian-pdf', compact('examSession', 'exam', 'questions', 'answers', 'guru', 'kepsek'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('hasil-ujian-' . $examSession->id . '.pdf');
    }
}
