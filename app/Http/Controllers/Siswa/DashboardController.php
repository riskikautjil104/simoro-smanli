<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }

    public function cetakHasilUjian($id)
    {
        $user = Auth::user();
        $examSession = \App\Models\ExamSession::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['exam.subject'])
            ->firstOrFail();

        if ($examSession->score === null) {
            abort(403, 'Hasil ujian belum diperiksa guru.');
        }

        return view('siswa.hasil-ujian', compact('examSession'));
    }

    public function simpanLokasiUjian(Request $request)
    {
        $user = Auth::user();
        $examId = $request->input('exam_id');
        $lat    = $request->input('lat');
        $lng    = $request->input('lng');

        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $examId)
            ->first();

        if ($session) {
            $session->lat = $lat;
            $session->lng = $lng;
            $session->save();
        }

        return response()->json(['success' => true]);
    }

    public function ujianDetail($id)
    {
        $exam = \App\Models\Exam::with(['subject', 'questions'])->findOrFail($id);
        $user = Auth::user();
        $now  = now();

        // Cek waktu ujian
        if (
            ($exam->start_time && $now->lt($exam->start_time)) ||
            ($exam->end_time   && $now->gt($exam->end_time))
        ) {
            abort(403, 'Ujian belum dimulai atau sudah berakhir.');
        }

        // Ambil session ujian
        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        // Block if already completed (submitted)
        if ($session && $session->end_time) {
            abort(403, 'Ujian sudah diselesaikan dan tidak dapat diakses lagi. Lihat hasil di riwayat ujian.');
        }

        // Block jika sesi sedang ditandai mencurigakan
        if ($session && $session->is_detected && !$session->end_time) {
            abort(403, 'Sesi ujian Anda sedang dalam pengawasan. Silakan hubungi pengawas/admin.');
        }

        if ($session && $session->status_logout == 1 && $session->reapply_status != 2) {
            if (!request()->isMethod('post')) {
                return view('siswa.ujian_reapply', compact('exam', 'session'));
            } else {
                abort(403, 'Akses ujian diblokir, menunggu persetujuan admin/guru.');
            }
        }

        // Buat atau update session
        if (!$session) {
            \App\Models\ExamSession::create([
                'user_id'    => $user->id,
                'exam_id'    => $exam->id,
                'start_time' => now(),
                'is_active'  => true,
                'ip_address' => request()->ip(),
                'session_id' => session()->getId(),
            ]);
        } elseif (($session->status_logout != 1 || $session->reapply_status == 2) && !$session->end_time) {
            $session->is_active  = true;
            $session->start_time = $session->start_time ?? now();
            $session->ip_address = request()->ip();
            $session->session_id = session()->getId();
            $session->save();
        }

        // Ambil session terbaru
        $session   = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
        $startTime = $session ? $session->start_time : now();

        if ($startTime && !($startTime instanceof \Carbon\Carbon)) {
            $startTime = \Carbon\Carbon::parse($startTime);
        }

        $duration = $exam->duration; // menit
        $now      = now();
        $elapsed  = $startTime ? $startTime->diffInSeconds($now, false) : 0;

        if ($elapsed < 0) {
            $elapsed = abs($elapsed);
        }

        $remaining = max($duration * 60 - $elapsed, 0);

        return view('siswa.ujian', compact('exam', 'remaining'));
    }

    public function logoutUjian(Request $request)
    {
        $user   = Auth::user();
        $examId = $request->input('exam_id');

        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $examId)
            ->first();

        if ($session) {
            $session->is_active    = false;
            $session->status_logout = 1;
            $session->logout_time  = now();
            $session->save();
        }

        return response()->json(['success' => true]);
    }

    public function submitUjian(Request $request, $id)
    {
        $user = Auth::user();
        $exam = \App\Models\Exam::with('questions')->findOrFail($id);

        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        // Block jika sudah submit
        if ($session && $session->end_time) {
            abort(403, 'Akses submit ujian diblokir. Ujian sudah selesai.');
        }

        // Block jika terdeteksi dan sudah submit
        if ($session && $session->is_detected && $session->end_time) {
            abort(403, 'Tidak bisa ikut ujian lagi karena sudah terdeteksi dan submit.');
        }

        // Block jika logout dan belum di-approve
        if ($session && $session->status_logout == 1 && $session->reapply_status != 2) {
            abort(403, 'Akses submit ujian diblokir, menunggu persetujuan admin/guru.');
        }

        $answers = $request->input('answers', []);

        // Simpan semua jawaban siswa
        foreach ($answers as $questionId => $answerValue) {
            \App\Models\StudentAnswer::updateOrCreate(
                [
                    'user_id'     => $user->id,
                    'exam_id'     => $exam->id,
                    'question_id' => $questionId,
                ],
                [
                    'answer' => $answerValue,
                ]
            );
        }

        // ── Auto-scoring untuk soal pilihan ganda ──
        $questions  = $exam->questions;
        $totalSoal  = $questions->count();
        $benar      = 0;

        foreach ($questions as $question) {
            $jawaban = $answers[$question->id] ?? null;

            // Bandingkan jawaban siswa dengan kunci jawaban (case-insensitive trim)
            if (
                $jawaban !== null &&
                strtolower(trim($jawaban)) === strtolower(trim($question->correct_answer ?? ''))
            ) {
                $benar++;
            }
        }

        // Nilai skala 0–100, 2 desimal
        $score = $totalSoal > 0 ? round(($benar / $totalSoal) * 100, 2) : 0;

        // Simpan hasil ujian
        \App\Models\ExamSession::updateOrCreate(
            [
                'user_id' => $user->id,
                'exam_id' => $exam->id,
            ],
            [
                'end_time'   => now(),
                'is_active'  => false,
                'ip_address' => $request->ip(),
                'session_id' => session()->getId(),
                'score'      => $score, // ✅ nilai otomatis dari jawaban benar
            ]
        );

        return redirect()->route('siswa.dashboard')->with('success', 'Jawaban berhasil disimpan! Nilai kamu: ' . $score);
    }

    public function ujianAktif()
    {
        $user = Auth::user();
        $now  = now();

        $ujians = \App\Models\Exam::where('class_id', $user->class_id)
            ->where('start_time', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->with('subject')
            ->get();

        $result = $ujians->map(function ($u) use ($user) {
            $session = \App\Models\ExamSession::where('user_id', $user->id)
                ->where('exam_id', $u->id)
                ->first();

            $status_logout      = $session ? $session->status_logout : 0;
            $reapply_status     = $session ? $session->reapply_status : 0;
            $is_completed       = $session ? !!$session->end_time : false;
            $is_detected_blocked = $session ? ($session->is_detected && !$session->end_time) : false;

            return [
                'id'                  => $u->id,
                'exam_session_id'     => $session?->id,
                'nama'                => $u->title,
                'mapel'               => $u->subject->name ?? '-',
                'is_completed'        => $is_completed,
                'tanggal'             => $u->start_time,
                'status_logout'       => $status_logout,
                'reapply_status'      => $reapply_status,
                'is_detected_blocked' => $is_detected_blocked,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $result,
        ]);
    }

    public function riwayatUjian()
    {
        $user = Auth::user();

        // ✅ Fix: hanya ambil sesi yang sudah selesai (end_time tidak null)
        $riwayat = \App\Models\ExamSession::where('user_id', $user->id)
            ->whereNotNull('end_time')
            ->with(['exam.subject'])
            ->orderByDesc('created_at')
            ->get();

        $result = $riwayat->map(function ($r) {
            return [
                'id'      => $r->id,
                'exam_id' => $r->exam_id,
                'nama'    => $r->exam->title ?? '-',
                'mapel'   => $r->exam->subject->name ?? '-',
                'nilai'   => $r->score !== null ? $r->score : '-', // ✅ tampilkan '-' jika null
                'tanggal' => $r->created_at ? $r->created_at->format('d-m-Y') : '-',
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $result,
        ]);
    }

    public function reapplyUjian(Request $request, $id)
    {
        $user    = Auth::user();
        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->firstOrFail();

        $session->reapply_status = 1; // menunggu
        $session->reapply_reason = $request->input('alasan');
        $session->save();

        return redirect()
            ->route('siswa.ujian.detail', $id)
            ->with('success', 'Pengajuan ulang akses ujian berhasil diajukan, tunggu persetujuan admin/guru.');
    }
}