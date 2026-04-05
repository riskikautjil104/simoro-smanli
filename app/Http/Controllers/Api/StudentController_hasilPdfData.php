<?php
// Add this method to StudentController class

/**
 * Get hasil ujian as data format (for PDF generation di client/Flutter)
 * GET /api/siswa/ujian/{id}/hasil-pdf
 */
public function hasilPdfData(Request $request, string $id)
{
    $user = $request->user();

    $examSession = ExamSession::where('user_id', $user->id)
        ->where('exam_id', $id)
        ->first();

    if (!$examSession) {
        return response()->json([
            'success' => false,
            'message' => 'Sesi ujian tidak ditemukan'
        ], 404);
    }

    if ($examSession->score === null) {
        return response()->json([
            'success' => false,
            'message' => 'Hasil ujian belum dinilai oleh guru'
        ], 403);
    }

    $exam = Exam::with(['subject', 'questions'])->find($id);

    if (!$exam) {
        return response()->json([
            'success' => false,
            'message' => 'Ujian tidak ditemukan'
        ], 404);
    }

    $studentAnswers = StudentAnswer::where('user_id', $user->id)
        ->where('exam_id', $id)
        ->get()
        ->keyBy('question_id');

    $questionsData = $exam->questions->map(function ($q) use ($studentAnswers) {
        $studentAnswer = $studentAnswers->get($q->id);
        $jawabanSiswa = $studentAnswer?->answer;
        $jawabanBenar = $q->jawaban_benar ?? $q->answer_key ?? null;

        $isCorrect = null;
        $status = null;

        if ($q->type !== 'essay') {
            $isCorrect = ($jawabanSiswa && $jawabanBenar)
                ? (strtoupper($jawabanSiswa) === strtoupper($jawabanBenar))
                : false;
            $status = $isCorrect ? 'BENAR' : 'SALAH';
        } else {
            $status = $studentAnswer?->nilai_essay !== null
                ? 'DINILAI: ' . $studentAnswer->nilai_essay
                : 'BELUM DINILAI';
        }

        return [
            'id' => $q->id,
            'pertanyaan' => $q->pertanyaan ?? $q->question_text,
            'tipe' => $q->type,
            'opsi_a' => $q->opsi_a ?? ($q->options['A'] ?? null),
            'opsi_b' => $q->opsi_b ?? ($q->options['B'] ?? null),
            'opsi_c' => $q->opsi_c ?? ($q->options['C'] ?? null),
            'opsi_d' => $q->opsi_d ?? ($q->options['D'] ?? null),
            'jawaban_siswa' => $jawabanSiswa ?? '-',
            'jawaban_benar' => $jawabanBenar ?? '-',
            'nilai' => $studentAnswer?->score ?? $studentAnswer?->nilai_essay,
            'status' => $status,
            'is_correct' => $isCorrect,
        ];
    });

    $totalPG = $exam->questions->where('type', '!=', 'essay')->count();
    $totalEssay = $exam->questions->where('type', 'essay')->count();
    $benarPG = $questionsData->filter(fn($q) => $q['tipe'] !== 'essay' && $q['is_correct'] === true)->count();

    return response()->json([
        'success' => true,
        'data' => [
            'siswa' => [
                'nama' => $user->name,
                'nis' => $user->nis,
                'kelas' => $user->class?->name,
            ],
            'ujian' => [
                'nama' => $exam->title,
                'mapel' => $exam->subject->name ?? '-',
                'tanggal' => $examSession->created_at->format('d-m-Y H:i'),
                'durasi_menit' => $exam->duration,
            ],
            'ringkasan' => [
                'nilai_akhir' => $examSession->score,
                'total_soal' => $totalPG + $totalEssay,
                'total_pg' => $totalPG,
                'total_essay' => $totalEssay,
                'jawaban_benar_pg' => $benarPG,
            ],
            'soal' => $questionsData->values()->all(),
            'web_pdf_url' => url('/siswa/ujian/' . $examSession->id . '/hasil/pdf'),
        ]
    ]);
}
