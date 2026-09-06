<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\ExamSession;
use App\Models\RaporScore;
use App\Models\RaporStudent;
use App\Models\SchoolClass;
use App\Models\User;
use App\Services\FcmService;
use App\Services\RaporSecurityService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RaporController extends Controller
{
    /**
     * Dashboard E-Rapor Wali Kelas
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Cari kelas yang diampu guru ini sebagai Wali Kelas (atau jika admin/kepsek, bisa pilih kelas)
        $kelas = SchoolClass::where('wali_kelas_id', $user->id)->first();
        
        if (!$kelas && in_array($user->role, ['admin', 'kepala_sekolah'])) {
            $classId = $request->input('class_id', SchoolClass::first()?->id);
            $kelas = SchoolClass::find($classId);
        }

        if (!$kelas) {
            return view('guru.rapor.not_wali');
        }

        $tahunAjaran = $request->input('tahun_ajaran', '2025/2026');
        $semester = $request->input('semester', 'Ganjil');

        // Ambil seluruh siswa di kelas ini
        $students = User::where('class_id', $kelas->id)
            ->whereIn('role', ['student', 'siswa'])
            ->orderBy('name')
            ->get();

        // Generate / Sinkronisasi entri rapor jika belum ada
        foreach ($students as $student) {
            RaporStudent::firstOrCreate([
                'student_id' => $student->id,
                'class_id' => $kelas->id,
                'tahun_ajaran' => $tahunAjaran,
                'semester' => $semester,
            ], [
                'wali_kelas_id' => $kelas->wali_kelas_id ?? $user->id,
                'status' => 'draft',
                'tanggal_rapor' => now(),
            ]);
        }

        // Ambil daftar rapor kelas
        $reports = RaporStudent::with(['student', 'scores.subject'])
            ->where('class_id', $kelas->id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get();

        $allClasses = in_array($user->role, ['admin', 'kepala_sekolah']) ? SchoolClass::orderBy('name')->get() : [];

        return view('guru.rapor.index', compact('kelas', 'reports', 'tahunAjaran', 'semester', 'allClasses'));
    }

    /**
     * Cari Rapor berdasarkan ID numerik, encrypted ID, atau verification token
     */
    private function resolveRapor($id, array $with = []): RaporStudent
    {
        $resolvedId = is_numeric($id) ? (int)$id : RaporSecurityService::decryptId($id);

        $query = RaporStudent::query();
        if (!empty($with)) {
            $query->with($with);
        }

        if ($resolvedId) {
            $rapor = $query->find($resolvedId);
        } else {
            $rapor = $query->where('verification_token', $id)->first();
        }

        if (!$rapor) {
            abort(404, 'Data rapor tidak ditemukan.');
        }

        return $rapor;
    }

    /**
     * Detail Rapor Siswa & Form Input Nilai Mapel
     */
    public function detail($id)
    {
        $rapor = $this->resolveRapor($id, ['student', 'schoolClass.subjects.teacher', 'scores.subject', 'waliKelas']);

        $user = Auth::user();
        if ($rapor->wali_kelas_id !== $user->id && !in_array($user->role, ['admin', 'kepala_sekolah'])) {
            abort(403, 'Anda bukan Wali Kelas dari siswa ini.');
        }

        // Pastikan setiap mapel kelas ini ada di rapor_scores
        $classSubjects = $rapor->schoolClass->subjects;
        foreach ($classSubjects as $subject) {
            RaporScore::firstOrCreate([
                'rapor_student_id' => $rapor->id,
                'subject_id' => $subject->id,
            ]);
        }

        $rapor->load('scores.subject.teacher');

        $defaultWeightTugas = (int) \App\Models\MobileConfig::get('rapor_weight_tugas', 40);
        $defaultWeightCbt   = (int) \App\Models\MobileConfig::get('rapor_weight_cbt', 60);
        $defaultKkm         = (int) \App\Models\MobileConfig::get('rapor_kkm_default', 75);

        return view('guru.rapor.detail', compact('rapor', 'defaultWeightTugas', 'defaultWeightCbt', 'defaultKkm'));
    }

    /**
     * Tarik otomatis nilai rata-rata ujian CBT siswa per mapel
     */
    public function pullCbt($id)
    {
        $rapor = $this->resolveRapor($id, ['scores', 'schoolClass.subjects']);
        
        // Pastikan setiap mapel pada kelas ini sudah ada entri RaporScore
        if ($rapor->schoolClass && $rapor->schoolClass->subjects) {
            foreach ($rapor->schoolClass->subjects as $subject) {
                RaporScore::firstOrCreate([
                    'rapor_student_id' => $rapor->id,
                    'subject_id' => $subject->id,
                ]);
            }
        }
        $rapor->load('scores');

        $updatedCount = 0;

        foreach ($rapor->scores as $score) {
            // 1. Ambil nilai rata-rata dari ExamSession (penyimpanan CBT utama SIMORO)
            $avgScore = ExamSession::where('user_id', $rapor->student_id)
                ->whereNotNull('score')
                ->whereHas('exam', function ($q) use ($score) {
                    $q->where('subject_id', $score->subject_id);
                })
                ->avg('score');

            // 2. Fallback jika ada data di ExamResult
            if ($avgScore === null) {
                $avgScore = ExamResult::where('user_id', $rapor->student_id)
                    ->whereNotNull('score')
                    ->whereHas('exam', function ($q) use ($score) {
                        $q->where('subject_id', $score->subject_id);
                    })
                    ->avg('score');
            }

            if ($avgScore !== null) {
                $score->nilai_cbt = round((float) $avgScore, 2);
                $score->calculateFinalScore(
                    $rapor->effective_weight_tugas,
                    $rapor->effective_weight_cbt
                );
                $score->save();
                $updatedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'updated_count' => $updatedCount,
            'message' => $updatedCount > 0 
                ? "Berhasil menarik nilai rata-rata CBT untuk {$updatedCount} mata pelajaran."
                : "Siswa ini belum memiliki nilai ujian CBT yang tersimpan di sistem untuk mata pelajaran kelas ini.",
        ]);
    }

    /**
     * Tarik rekap absensi dari web absensi (atau fallback toleran)
     */
    public function pullAttendance($id)
    {
        $rapor = $this->resolveRapor($id);
        
        try {
            $response = Http::timeout(4)->get("https://absensi.sma-n5-morotai.id/api/rekap/siswa/{$rapor->student_id}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['sakit'])) $rapor->sakit = (int) $data['sakit'];
                if (isset($data['izin'])) $rapor->izin = (int) $data['izin'];
                if (isset($data['alpa'])) $rapor->tanpa_keterangan = (int) $data['alpa'];
                $rapor->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Data absensi berhasil ditarik dari server absensi.',
                    'data' => $rapor,
                ]);
            }
        } catch (\Exception $e) {
            // Silently fall back to manual edit
        }

        return response()->json([
            'success' => true,
            'message' => 'Silakan verifikasi atau masukkan angka absensi secara manual pada form.',
            'data' => $rapor,
        ]);
    }

    /**
     * Simpan Perubahan Nilai, Catatan Wali Kelas, dan Absensi
     */
    public function save(Request $request, $id)
    {
        $rapor = $this->resolveRapor($id, ['scores']);

        $request->validate([
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'tanpa_keterangan' => 'nullable|integer|min:0',
            'catatan_wali_kelas' => 'nullable|string',
            'status_kenaikan' => 'nullable|string|max:255',
            'tanggal_rapor' => 'nullable|date',
            'weight_tugas' => 'nullable|numeric|min:0|max:100',
            'weight_cbt' => 'nullable|numeric|min:0|max:100',
            'kkm' => 'nullable|numeric|min:0|max:100',
            'scores' => 'nullable|array',
        ]);

        $updateData = [
            'sakit' => $request->input('sakit', 0),
            'izin' => $request->input('izin', 0),
            'tanpa_keterangan' => $request->input('tanpa_keterangan', 0),
            'catatan_wali_kelas' => $request->input('catatan_wali_kelas'),
            'status_kenaikan' => $request->input('status_kenaikan'),
            'tanggal_rapor' => $request->input('tanggal_rapor') ?? now(),
        ];

        if ($request->filled('weight_tugas')) $updateData['weight_tugas'] = (float) $request->input('weight_tugas');
        if ($request->filled('weight_cbt'))   $updateData['weight_cbt']   = (float) $request->input('weight_cbt');
        if ($request->filled('kkm'))          $updateData['kkm']          = (float) $request->input('kkm');

        $rapor->update($updateData);

        $wTugas = $rapor->effective_weight_tugas;
        $wCbt   = $rapor->effective_weight_cbt;

        // Simpan nilai masing-masing mapel
        if ($request->has('scores')) {
            foreach ($request->input('scores') as $scoreId => $data) {
                $score = RaporScore::where('id', $scoreId)
                    ->where('rapor_student_id', $rapor->id)
                    ->first();

                if ($score) {
                    $score->nilai_tugas = (float) ($data['nilai_tugas'] ?? 0);
                    $score->nilai_cbt   = (float) ($data['nilai_cbt'] ?? 0);
                    
                    if (isset($data['nilai_akhir']) && is_numeric($data['nilai_akhir'])) {
                        $score->nilai_akhir = (float) $data['nilai_akhir'];
                    } else {
                        $score->calculateFinalScore($wTugas, $wCbt);
                    }

                    $score->capaian_kompetensi = $data['capaian_kompetensi'] ?? null;
                    $score->save();
                }
            }
        }

        // Perbarui data keamanan dan digital signature hash agar selalu mutakhir
        $rapor->load('scores');
        RaporSecurityService::ensureSecurityData($rapor);

        return response()->json([
            'success' => true,
            'message' => 'Data Rapor berhasil disimpan!',
        ]);
    }

    /**
     * Terbitkan Rapor (Publikasikan ke Siswa / Mobile)
     */
    public function togglePublish($id)
    {
        $rapor = $this->resolveRapor($id, ['student', 'schoolClass']);
        $rapor->status = ($rapor->status === 'published') ? 'draft' : 'published';
        $rapor->save();

        if ($rapor->status === 'published') {
            $this->sendRaporNotification($rapor);
        }

        return response()->json([
            'success' => true,
            'status' => $rapor->status,
            'message' => $rapor->status === 'published' 
                ? 'Rapor berhasil diterbitkan ke siswa & mobile.' 
                : 'Status rapor dikembalikan ke draft.',
        ]);
    }

    /**
     * Terbitkan Semua Rapor Kelas Sekaligus
     */
    public function publishAll(Request $request)
    {
        $classId = $request->input('class_id');
        $tahunAjaran = $request->input('tahun_ajaran');
        $semester = $request->input('semester');

        // Ambil seluruh rapor siswa di kelas ini beserta data siswa
        $rapors = RaporStudent::with(['student', 'schoolClass'])
            ->where('class_id', $classId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get();

        RaporStudent::where('class_id', $classId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->update(['status' => 'published']);

        // Kirim push notification ke seluruh siswa di kelas
        $this->sendBulkRaporNotification($rapors, (string) $semester, (string) $tahunAjaran);

        return response()->json([
            'success' => true,
            'message' => 'Seluruh rapor siswa di kelas ini berhasil diterbitkan!',
        ]);
    }

    /**
     * Kirim notifikasi FCM ke siswa saat rapor diterbitkan secara individu
     */
    private function sendRaporNotification(RaporStudent $rapor): void
    {
        try {
            if (!$rapor->student || empty($rapor->student->fcm_token)) {
                return;
            }

            $fcm = app(FcmService::class);
            $studentName = $rapor->student->name ?? 'Siswa';
            $title = "Rapor Akademik Diterbitkan! 📄";
            $body = "Halo {$studentName}, E-Rapor Semester {$rapor->semester} {$rapor->tahun_ajaran} Anda telah resmi diterbitkan oleh Wali Kelas. Ketuk untuk melihat!";

            $fcm->sendToDevice(
                $rapor->student->fcm_token,
                $title,
                $body,
                [
                    'type' => 'rapor_published',
                    'rapor_id' => (string) $rapor->id,
                    'student_id' => (string) $rapor->student_id,
                    'semester' => (string) $rapor->semester,
                    'tahun_ajaran' => (string) $rapor->tahun_ajaran,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ]
            );
        } catch (\Throwable $e) {
            Log::error('[FCM Rapor Notification Error] ' . $e->getMessage());
        }
    }

    /**
     * Kirim notifikasi FCM massal ke siswa saat seluruh rapor kelas diterbitkan
     */
    private function sendBulkRaporNotification($rapors, string $semester, string $tahunAjaran): void
    {
        try {
            $fcm = app(FcmService::class);
            $tokens = [];

            foreach ($rapors as $rapor) {
                if ($rapor->student && !empty($rapor->student->fcm_token)) {
                    $tokens[] = $rapor->student->fcm_token;
                }
            }

            $tokens = array_values(array_unique(array_filter($tokens)));
            if (empty($tokens)) {
                return;
            }

            $title = "Rapor Kelas Resmi Diterbitkan! 📄";
            $body = "E-Rapor Semester {$semester} {$tahunAjaran} kelas Anda telah resmi diterbitkan oleh Wali Kelas. Silakan periksa nilai Anda di aplikasi!";

            $fcm->sendToMultiple(
                $tokens,
                $title,
                $body,
                [
                    'type' => 'rapor_published',
                    'semester' => (string) $semester,
                    'tahun_ajaran' => (string) $tahunAjaran,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ]
            );
        } catch (\Throwable $e) {
            Log::error('[FCM Rapor Bulk Notification Error] ' . $e->getMessage());
        }
    }

    /**
     * Cetak Lembar Rapor Resmi Format PDF A4
     */
    public function exportPdf($id)
    {
        $rapor = $this->resolveRapor($id, [
            'student',
            'schoolClass',
            'waliKelas',
            'scores.subject.teacher'
        ]);

        // Pastikan token keamanan, nomor registrasi, dan hash digital terisi
        RaporSecurityService::ensureSecurityData($rapor);
        $qrCodeDataUri = RaporSecurityService::getQrCodeDataUri($rapor->verification_url);

        $kepsek = User::where('role', 'kepala_sekolah')->first() ?? User::where('role', 'admin')->first();

        $pdf = Pdf::loadView('pdf.rapor_siswa', compact('rapor', 'kepsek', 'qrCodeDataUri'))
            ->setPaper('a4', 'portrait');

        $cleanName = \Illuminate\Support\Str::slug($rapor->student->name ?? 'siswa', '_');
        $cleanSemester = \Illuminate\Support\Str::slug($rapor->semester ?? 'semester', '_');
        $cleanTahun = str_replace(['/', '\\', ' '], ['-', '-', '_'], $rapor->tahun_ajaran ?? 'rapor');
        $filename = "Rapor_{$cleanName}_{$cleanSemester}_{$cleanTahun}.pdf";

        return $pdf->stream($filename);
    }
}
