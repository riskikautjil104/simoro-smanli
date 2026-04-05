<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\StudentAnswer;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // [FIX #3] Import Hash facade

class StudentController extends Controller
{
    /**
     * Display a listing of the resource (students).
     * For admin/teacher to manage students
     */
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('class')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nis' => 'required|string|unique:users,nis',
            'class_id' => 'required|exists:classes,id',
        ]);

        $student = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // [FIX #3] Hash password sebelum disimpan
            'nis' => $validated['nis'],
            'class_id' => $validated['class_id'],
            'role' => 'student',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dibuat',
            'data' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::where('role', 'student')
            ->with('class')
            ->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'nis' => 'sometimes|string|unique:users,nis,' . $id,
            'class_id' => 'sometimes|exists:classes,id',
        ]);

        // [FIX #3] Hash password jika ada update password
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil diperbarui',
            'data' => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dihapus'
        ]);
    }

    // ==================== ENDPOINTS KHUSUS UNTUK SISWA (MOBILE API) ====================

    /**
     * Get current logged in student profile
     * GET /api/siswa/profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nis' => $user->nis,
                'role' => $user->role,
                'class_id' => $user->class_id,
                'class_name' => $user->class?->name,
                'ttd_signature' => $user->ttd_signature,
            ]
        ]);
    }

    /**
     * Update current logged in student profile
     * PUT /api/siswa/profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'ttd_signature' => 'sometimes|string',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }

    /**
     * Get active exams for current student
     * GET /api/siswa/ujian/aktif
     */
    public function ujianAktif(Request $request)
    {
        $user = $request->user();
        $now = now();

        $ujians = Exam::where('class_id', $user->class_id)
            ->where('start_time', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->with('subject')
            ->get();

        $result = $ujians->map(function ($u) use ($user) {
            $session = ExamSession::where('user_id', $user->id)
                ->where('exam_id', $u->id)
                ->first();

            return [
                'id' => $u->id,
                'nama' => $u->title,
                'mapel' => $u->subject->name ?? '-',
                'mapel_id' => $u->subject->id ?? null,
                'is_completed' => $session ? !!$session->end_time : false,
                'tanggal' => $u->start_time,
                'durasi' => $u->duration,
                'status_logout' => $session ? $session->status_logout : 0,
                'reapply_status' => $session ? $session->reapply_status : 0,
                'is_active' => $session ? $session->is_active : false,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get exam history for current student
     * GET /api/siswa/ujian/riwayat
     */
    public function riwayatUjian(Request $request)
    {
        $user = $request->user();

        $riwayat = ExamSession::where('user_id', $user->id)
            ->with(['exam.subject'])
            ->orderByDesc('created_at')
            ->get();

        $result = $riwayat->map(function ($r) {
            return [
                'id' => $r->id,
                'exam_id' => $r->exam_id,
                'nama' => $r->exam->title ?? '-',
                'mapel' => $r->exam->subject->name ?? '-',
                'nilai' => $r->score,
                'tanggal' => $r->created_at ? $r->created_at->format('d-m-Y H:i') : '-',
                'status' => $r->score !== null ? 'Selesai' : 'Belum Dinilai',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get exam detail (for taking exam)
     * GET /api/siswa/ujian/{id}
     */
    public function ujianDetail(Request $request, string $id)
    {
        $user = $request->user();
        $now = now();

        $exam = Exam::with(['subject', 'questions' => function ($q) {
            $q->select('id', 'exam_id', 'question_text', 'options', 'type');
        }])->find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        // Check exam time
        if (($exam->start_time && $now->lt($exam->start_time)) || ($exam->end_time && $now->gt($exam->end_time))) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian belum dimulai atau sudah berakhir'
            ], 403);
        }

        // [FIX #1] Pindahkan query $session ke ATAS sebelum digunakan
        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        // [FIX #1] Cek session->end_time SETELAH $session didefinisikan
        if ($session && $session->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian sudah selesai dan tidak dapat diakses lagi'
            ], 403);
        }

        if ($session && $session->status_logout == 1 && $session->reapply_status != 2) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ujian diblokir, menunggu persetujuan admin/guru',
                'reapply_status' => $session->reapply_status,
                'reapply_reason' => $session->reapply_reason,
            ], 403);
        }

        // [FIX #2] Hapus kondisi is_detected + end_time di sini karena
        // sudah tertangkap oleh pengecekan end_time di atas
        if ($session && $session->is_detected && !$session->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi ujian Anda sedang dalam pengawasan, hubungi pengawas',
                'reason' => $session->detection_reason,
            ], 403);
        }

        // Prepare questions (hide correct answer)
        $questions = $exam->questions->map(function ($q) {
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'type' => $q->type,
                'options' => $q->options,
                // [FIX #6] Tidak expose jawaban benar ke siswa
            ];
        });

        $startTime = $session ? $session->start_time : now();
        $duration = $exam->duration * 60; // convert to seconds
        $elapsed = $now->diffInSeconds($startTime, false);
        if ($elapsed < 0) {
            $elapsed = abs($elapsed);
        }
        $remaining = max($duration - $elapsed, 0);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $exam->id,
                'title' => $exam->title,
                'subject' => $exam->subject->name ?? '-',
                'duration' => $exam->duration,
                'remaining_seconds' => $remaining,
                'questions' => $questions,
            ]
        ]);
    }

    /**
     * Start/take exam session
     * POST /api/siswa/ujian/{id}/mulai
     */
    public function mulaiUjian(Request $request, string $id)
    {
        $user = $request->user();
        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        // Validasi: jika duration 0, berarti tanpa batas waktu
        if ($exam->duration <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian ini tidak memiliki batas waktu. Hubungi admin untuk info lebih lanjut.'
            ], 400);
        }

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        $now = now();

        // Block if already completed
        if ($session && $session->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian sudah selesai'
            ], 403);
        }

        // [FIX #2] Pindah pengecekan is_detected ke ATAS sebelum end_time,
        // karena kondisi sebelumnya sudah return jika end_time ada,
        // sehingga cek ini hanya berlaku untuk sesi yang belum di-submit
        if ($session && $session->is_detected) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa melanjutkan ujian karena sesi Anda terdeteksi mencurigakan',
                'reason' => $session->detection_reason,
            ], 403);
        }

        if (!$session) {
            // Buat session baru dengan start_time = now()
            $session = ExamSession::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'start_time' => $now,
                'is_active' => true,
                'ip_address' => $request->ip(),
                'session_id' => session()->getId(),
            ]);
        } elseif (($session->status_logout != 1 || $session->reapply_status == 2) && !$session->end_time) {
            // Jika sudah ada session, update start_time ke sekarang (mulai baru)
            $session->is_active = true;
            $session->start_time = $now; // SELALU update ke waktu sekarang
            $session->ip_address = $request->ip();
            $session->session_id = session()->getId();
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Ujian dimulai',
            'data' => [
                'session_id' => $session->id,
                'start_time' => $session->start_time,
                'duration_minutes' => $exam->duration,
            ]
        ]);
    }

    /**
     * Submit exam answers
     * POST /api/siswa/ujian/{id}/submit
     */
    public function submitUjian(Request $request, string $id)
    {
        $user = $request->user();
        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        // [FIX #4] Pastikan siswa sudah mulai ujian (session aktif harus ada)
        if (!$session || !$session->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memulai ujian ini'
            ], 403);
        }

        // [FIX #4] Pastikan ujian belum pernah di-submit sebelumnya
        if ($session->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian sudah pernah di-submit sebelumnya'
            ], 403);
        }

        if ($session->status_logout == 1 && $session->reapply_status != 2) {
            return response()->json([
                'success' => false,
                'message' => 'Akses submit ujian diblokir'
            ], 403);
        }

        $answers = $request->input('answers', []);

        foreach ($answers as $questionId => $answerValue) {
            StudentAnswer::updateOrCreate(
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

        $session->update([
            'end_time' => now(),
            'is_active' => false,
            'ip_address' => $request->ip(),
            'session_id' => session()->getId(),
            'score' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan'
        ]);
    }

    /**
     * Logout from exam (save progress and exit)
     * POST /api/siswa/ujian/{id}/logout
     */
    public function logoutUjian(Request $request, string $id)
    {
        $user = $request->user();

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if ($session) {
            $session->is_active = false;
            $session->status_logout = 1;
            $session->logout_time = now();
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout dari ujian'
        ]);
    }

    /**
     * Mark exam session as detected (called from monitoring)
     * POST /api/siswa/ujian/{id}/detected
     */
    public function markDetected(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $session->is_detected = true;
        $session->detection_time = now();
        $session->detection_reason = $validated['reason'];
        $session->save();

        return response()->json([
            'success' => true,
            'message' => 'Sesi ujian ditandai terdeteksi'
        ]);
    }

    /**
     * Request reapply to exam (after logout)
     * POST /api/siswa/ujian/{id}/reapply
     */
    public function reapplyUjian(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->firstOrFail();

        // Block reapply if already detected and submitted
        if ($session->is_detected && $session->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa ajukan ulang karena sudah terdeteksi dan submit'
            ], 403);
        }

        $session->reapply_status = 1;
        $session->reapply_reason = $validated['alasan'];
        $session->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan ulang akses ujian berhasil diajukan'
        ]);
    }

    /**
     * Save exam location
     * POST /api/siswa/ujian/{id}/lokasi
     */
    public function simpanLokasiUjian(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if ($session) {
            $session->lat = $validated['lat'];
            $session->lng = $validated['lng'];
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil disimpan'
        ]);
    }

    /**
     * Get exam result
     * GET /api/siswa/ujian/{exam_id}/hasil
     *
     * Konsisten dengan endpoint siswa lain: {id} adalah exam_id.
     */
    public function hasilUjian(Request $request, string $id)
    {
        $user = $request->user();

        // $id = exam_id
        $examSession = ExamSession::where('exam_id', $id)
            ->where('user_id', $user->id)
            ->with(['exam.subject'])
            ->orderByDesc('id')
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
                'message' => 'Hasil ujian belum diperiksa guru'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $examSession->id,
                'exam_id' => $examSession->exam_id,
                'exam_title' => $examSession->exam->title ?? '-',
                'subject' => $examSession->exam->subject->name ?? '-',
                'score' => $examSession->score,
                'tanggal' => $examSession->created_at->format('d-m-Y H:i'),
            ]
        ]);
    }

    /**
     * Get student's answered questions
     * GET /api/siswa/ujian/{exam_id}/jawaban
     */
    public function getJawaban(Request $request, string $id)
    {
        $user = $request->user();

        // $id = exam_id
        $answers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->with('question')
            ->get();

        $result = $answers->map(function ($a) {
            return [
                'question_id' => $a->question_id,
                'question_text' => $a->question->question_text ?? '-',
                'answer' => $a->answer,
                'score' => $a->score,
                'nilai_essay' => $a->nilai_essay,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get complete exam result for printing
     * GET /api/siswa/ujian/{exam_id}/cetak
     *
     * Include: student info, exam info, all questions,
     * student answers, correct answers, scores per question
     */
    public function cetakHasil(Request $request, string $id)
    {
        $user = $request->user();

        // $id = exam_id
        $examSession = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if (!$examSession) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi ujian tidak ditemukan'
            ], 404);
        }

        // [FIX #6] Hanya tampilkan jawaban_benar jika ujian sudah selesai dan sudah dinilai
        if ($examSession->score === null) {
            return response()->json([
                'success' => false,
                'message' => 'Hasil cetak belum tersedia, ujian belum dinilai oleh guru'
            ], 403);
        }

        // Get exam with questions
        $exam = Exam::with(['subject', 'questions'])
            ->find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        // Get student's answers
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->get()
            ->keyBy('question_id');

        // Separate PG and Essay questions
        $soalPG = $exam->questions->filter(fn($q) => $q->type !== 'essay');
        $soalEssay = $exam->questions->filter(fn($q) => $q->type === 'essay');

        // Build detailed questions data
        $questionsData = $exam->questions->map(function ($q) use ($studentAnswers) {
            $studentAnswer = $studentAnswers->get($q->id);
            $jawabanSiswa = $studentAnswer?->answer;

            // [FIX #6] jawaban_benar hanya ditampilkan di endpoint cetak
            // karena endpoint ini hanya bisa diakses setelah ujian selesai & dinilai
            $jawabanBenar = $q->jawaban_benar ?? $q->answer_key ?? null;

            // Determine if correct (for PG only)
            $isCorrect = null;
            $status = null;

            if ($q->type !== 'essay') {
                $isCorrect = ($jawabanSiswa && $jawabanBenar)
                    ? (strtoupper($jawabanSiswa) === strtoupper($jawabanBenar))
                    : false;
                $status = $isCorrect ? 'Benar' : 'Salah';
            } else {
                $status = $studentAnswer?->nilai_essay !== null
                    ? 'Dinilai: ' . $studentAnswer->nilai_essay
                    : 'Belum Dinilai';
            }

            return [
                'id' => $q->id,
                'nomor' => $q->id,
                'pertanyaan' => $q->pertanyaan ?? $q->question_text,
                'tipe' => $q->type,
                'opsi_a' => $q->opsi_a ?? ($q->options['A'] ?? null),
                'opsi_b' => $q->opsi_b ?? ($q->options['B'] ?? null),
                'opsi_c' => $q->opsi_c ?? ($q->options['C'] ?? null),
                'opsi_d' => $q->opsi_d ?? ($q->options['D'] ?? null),
                'jawaban_siswa' => $jawabanSiswa ?? '-',
                'jawaban_benar' => $jawabanBenar ?? '-', // Aman: hanya tampil setelah ujian dinilai
                'nilai_pg' => $studentAnswer?->score,
                'nilai_essay' => $studentAnswer?->nilai_essay,
                'status' => $status,
                'is_correct' => $isCorrect,
            ];
        });

        // Calculate summary
        $totalPG = $soalPG->count();
        $totalEssay = $soalEssay->count();
        $benarPG = $questionsData->filter(fn($q) => $q['tipe'] !== 'essay' && $q['is_correct'] === true)->count();
        $salahPG = $questionsData->filter(fn($q) => $q['tipe'] !== 'essay' && $q['is_correct'] === false)->count();
        $belumDinilai = $questionsData->filter(fn($q) => $q['tipe'] === 'essay' && $q['nilai_essay'] === null)->count();

        return response()->json([
            'success' => true,
            'data' => [
                // Student Info
                'siswa' => [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'nis' => $user->nis,
                    'kelas' => $user->class?->name,
                ],
                // Exam Info
                'ujian' => [
                    'id' => $exam->id,
                    'nama' => $exam->title,
                    'mapel' => $exam->subject->name ?? '-',
                    'tanggal' => $examSession->created_at->format('d-m-Y H:i'),
                    'durasi' => $exam->duration,
                ],
                // Score Summary
                'ringkasan' => [
                    'nilai_total' => $examSession->score,
                    'total_soal_pg' => $totalPG,
                    'total_soal_essay' => $totalEssay,
                    'jawaban_benar' => $benarPG,
                    'jawaban_salah' => $salahPG,
                    'belum_dinilai' => $belumDinilai,
                    'status_penilaian' => $examSession->score !== null ? 'Sudah Dinilai' : 'Belum Dinilai',
                ],
                // All Questions with Answers
                'soal' => $questionsData->values()->all(),
            ]
        ]);
    }

    /**
     * Get student's dashboard info: class, subjects, schedule
     * GET /api/siswa/dashboard
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Get class info
        $kelas = SchoolClass::find($user->class_id);

        // Get subjects for this class
        $mapel = DB::table('class_subject')
            ->where('class_id', $user->class_id)
            ->join('subjects', 'class_subject.subject_id', '=', 'subjects.id')
            ->select('subjects.id', 'subjects.name as nama_mapel', 'subjects.code as kode')
            ->get();

        // Get upcoming exams for this class
        $now = now();
        $ujians = Exam::where('class_id', $user->class_id)
            ->where('start_time', '>=', $now)
            ->with('subject')
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'nama' => $u->title,
                    'mapel' => $u->subject->name ?? '-',
                    'tanggal' => $u->start_time->format('d-m-Y H:i'),
                    'durasi' => $u->duration,
                ];
            });

        // Get exam history stats
        $totalUjian = ExamSession::where('user_id', $user->id)->count();
        $ujianSelesai = ExamSession::where('user_id', $user->id)
            ->whereNotNull('score')
            ->count();
        $nilaiRataRata = ExamSession::where('user_id', $user->id)
            ->whereNotNull('score')
            ->avg('score');

        return response()->json([
            'success' => true,
            'data' => [
                'siswa' => [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'nis' => $user->nis,
                ],
                'kelas' => [
                    'id' => $kelas?->id,
                    'nama' => $kelas?->name ?? '-',
                    'tingkat' => $kelas?->level,
                ],
                'mapel' => $mapel->map(function ($m) {
                    return [
                        'id' => $m->id,
                        'nama' => $m->nama_mapel,
                        'kode' => $m->kode,
                    ];
                }),
                'ujian_mendatang' => $ujians,
                'stats' => [
                    'total_ujian' => $totalUjian,
                    'ujian_selesai' => $ujianSelesai,
                    'nilai_rata_rata' => round($nilaiRataRata ?? 0, 2),
                ]
            ]
        ]);
    }
}