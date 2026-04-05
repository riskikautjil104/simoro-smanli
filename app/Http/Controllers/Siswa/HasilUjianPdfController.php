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
        $examSession = \App\Models\ExamSession::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['exam.subject'])
            ->firstOrFail();
        if ($examSession->score === null) {
            abort(403, 'Hasil ujian belum diperiksa guru.');
        }
        $exam = $examSession->exam;
        $questions = \App\Models\Question::where('exam_id', $exam->id)->get();
        $answers = \App\Models\StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->get()
            ->keyBy('question_id');
        $pdf = Pdf::loadView('siswa.hasil-ujian-pdf', compact('examSession', 'exam', 'questions', 'answers'));
        return $pdf->stream('hasil-ujian-' . $examSession->id . '.pdf');
    }
}
