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
        public function ujianDetail($id)
        {
            $exam = \App\Models\Exam::with(['subject', 'questions'])->findOrFail($id);
            $user = Auth::user();
            // Simpan waktu mulai ujian jika belum ada
            \App\Models\ExamSession::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                ],
                [
                    'start_time' => now(),
                    'is_active' => true,
                    'ip_address' => request()->ip(),
                    'session_id' => session()->getId(),
                ]
            );
            return view('siswa.ujian', compact('exam'));
        }

        public function submitUjian(Request $request, $id)
        {
            $user = Auth::user();
            $exam = \App\Models\Exam::findOrFail($id);
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
            // Simulasi: ambil ujian aktif berdasarkan kelas siswa
            $ujian = \App\Models\Exam::where('class_id', $user->class_id)
                ->where('start_time', '>=', now())
                ->get();
            $result = $ujian->map(function ($u) {
                return [
                    'id' => $u->id,
                    'nama' => $u->title,
                    'mapel' => $u->subject->name ?? '-',
                    'tanggal' => $u->start_time,
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
                    'nama' => $r->exam->name ?? '-',
                    'mapel' => $r->exam->subject->name ?? '-',
                    'nilai' => $r->score ?? '-',
                    'tanggal' => $r->created_at ? $r->created_at->format('d-m-Y') : '-',
                ];
            });
            return response()->json($result);
        }
    }
