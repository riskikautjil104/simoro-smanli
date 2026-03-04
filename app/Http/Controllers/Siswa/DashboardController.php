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
        // Hanya tampilkan jika sudah ada nilai
        if ($examSession->score === null) {
            abort(403, 'Hasil ujian belum diperiksa guru.');
        }
        return view('siswa.hasil-ujian', compact('examSession'));
    }
    public function simpanLokasiUjian(Request $request)
    {
        $user = Auth::user();
        $examId = $request->input('exam_id');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        // Simpan ke ExamSession
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
        $now = now();
        // Cek waktu ujian
        if (($exam->start_time && $now->lt($exam->start_time)) || ($exam->end_time && $now->gt($exam->end_time))) {
            return abort(403, 'Ujian belum dimulai atau sudah berakhir.');
        }
        // Ambil session ujian
        $session = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
        if ($session && $session->status_logout == 1 && $session->reapply_status != 2) {
            // Jika logout dan belum di-approve, blokir akses view ujian (abort 403 kecuali ke form reapply)
            if (!request()->isMethod('post')) {
                return view('siswa.ujian_reapply', compact('exam', 'session'));
            } else {
                abort(403, 'Akses ujian diblokir, menunggu persetujuan admin/guru.');
            }
        }
        // Jika session belum ada, atau sudah di-approve reapply, baru boleh aktifkan ujian
        if (!$session) {
            \App\Models\ExamSession::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'start_time' => now(),
                'is_active' => true,
                'ip_address' => request()->ip(),
                'session_id' => session()->getId(),
            ]);
        } elseif ($session->status_logout != 1 || $session->reapply_status == 2) {
            // Jika tidak logout, atau sudah di-approve reapply, update session ke aktif
            $session->is_active = true;
            $session->start_time = $session->start_time ?? now();
            $session->ip_address = request()->ip();
            $session->session_id = session()->getId();
            $session->save();
        }
        // Ambil session lagi (pastikan sudah ada)
        $session = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
        $startTime = $session ? $session->start_time : now();
        $duration = $exam->duration; // menit
        $now = now();
        $elapsed = $now->diffInSeconds($startTime, false) < 0 ? abs($now->diffInSeconds($startTime)) : 0;
        $remaining = max($duration * 60 - $elapsed, 0);
        return view('siswa.ujian', compact('exam', 'remaining'));
    }
    public function logoutUjian(Request $request)
    {
        $user = Auth::user();
        $examId = $request->input('exam_id');
        $session = \App\Models\ExamSession::where('user_id', $user->id)
            ->where('exam_id', $examId)
            ->first();
        if ($session) {
            $session->is_active = false;
            $session->status_logout = 1;
            $session->logout_time = now();
            $session->save();
        }
        return response()->json(['success' => true]);
    }

    public function submitUjian(Request $request, $id)
    {
        $user = Auth::user();
        $exam = \App\Models\Exam::findOrFail($id);
        $session = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
        if ($session && $session->status_logout == 1 && $session->reapply_status != 2) {
            abort(403, 'Akses submit ujian diblokir, menunggu persetujuan admin/guru.');
        }
        $answers = $request->input('answers', []);
        foreach ($answers as $questionId => $answerValue) {
            \App\Models\StudentAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                ],
                [
                    'answer' => $answerValue,
                ]
            );
        }
        // Update waktu selesai ujian dan status, nilai default 0 jika belum ada
        \App\Models\ExamSession::updateOrCreate(
            [
                'user_id' => $user->id,
                'exam_id' => $exam->id,
            ],
            [
                'end_time' => now(),
                'is_active' => false,
                'ip_address' => $request->ip(),
                'session_id' => session()->getId(),
                'score' => 0, // default score, bisa diupdate oleh guru/admin
            ]
        );
        return redirect()->route('siswa.dashboard')->with('success', 'Jawaban berhasil disimpan!');
    }
    public function ujianAktif()
    {
        $user = Auth::user();
        $now = now();
        $ujians = \App\Models\Exam::where('class_id', $user->class_id)
            ->where('start_time', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->get();
        $result = $ujians->map(function ($u) use ($user) {
            $session = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $u->id)->first();
            $status_logout = $session ? $session->status_logout : 0;
            $reapply_status = $session ? $session->reapply_status : 0;
            return [
                'id' => $u->id,
                'nama' => $u->title,
                'mapel' => $u->subject->name ?? '-',
                'tanggal' => $u->start_time,
                'status_logout' => $status_logout,
                'reapply_status' => $reapply_status,
            ];
        });
        return response()->json($result);
    }

    public function riwayatUjian()
    {
        $user = Auth::user();
        // Ambil hasil ujian dari exam_sessions
        $riwayat = \App\Models\ExamSession::where('user_id', $user->id)
            ->with(['exam.subject'])
            ->orderByDesc('created_at')
            ->get();
        $result = $riwayat->map(function ($r) {
            return [
                'id' => $r->id,
                'nama' => $r->exam->title ?? '-',
                'mapel' => $r->exam->subject->name ?? '-',
                'nilai' => $r->score ?? '-',
                'tanggal' => $r->created_at ? $r->created_at->format('d-m-Y') : '-',
            ];
        });
        return response()->json($result);
    }

    public function reapplyUjian(Request $request, $id)
    {
        $user = Auth::user();
        $session = \App\Models\ExamSession::where('user_id', $user->id)->where('exam_id', $id)->firstOrFail();
        $session->reapply_status = 1; // menunggu
        $session->reapply_reason = $request->input('alasan');
        $session->save();
        return redirect()->route('siswa.ujian.detail', $id)->with('success', 'Pengajuan ulang akses ujian berhasil diajukan, tunggu persetujuan admin/guru.');
    }
}
