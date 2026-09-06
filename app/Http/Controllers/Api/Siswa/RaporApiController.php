<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\RaporStudent;
use App\Services\RaporSecurityService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RaporApiController extends Controller
{
    /**
     * Ambil daftar rapor semester milik siswa yang berstatus 'published'
     * GET /api/siswa/rapor
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $rapors = RaporStudent::with(['schoolClass', 'waliKelas', 'scores.subject'])
            ->where('student_id', $user->id)
            ->where('status', 'published')
            ->orderByDesc('id')
            ->get();

        $data = $rapors->map(function ($r) {
            return [
                'id' => $r->id,
                'encrypted_id' => $r->encrypted_id,
                'tahun_ajaran' => $r->tahun_ajaran,
                'semester' => $r->semester,
                'kelas' => $r->schoolClass?->name ?? '-',
                'wali_kelas' => $r->waliKelas?->name ?? '-',
                'rata_rata_nilai' => $r->average_score,
                'total_mapel' => count($r->scores),
                'sakit' => $r->sakit,
                'izin' => $r->izin,
                'tanpa_keterangan' => $r->tanpa_keterangan,
                'catatan_wali_kelas' => $r->catatan_wali_kelas,
                'status_kenaikan' => $r->status_kenaikan,
                'tanggal_rapor' => $r->tanggal_rapor?->format('d M Y'),
                'document_serial' => $r->effective_serial,
                'verification_url' => $r->verification_url,
                'pdf_url' => url("/api/siswa/rapor/{$r->encrypted_id}/pdf"),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar rapor berhasil diambil.',
            'data' => $data,
        ]);
    }

    /**
     * Detail rapor siswa termasuk rincian per mata pelajaran
     * GET /api/siswa/rapor/{id}
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $resolvedId = is_numeric($id) ? (int)$id : RaporSecurityService::decryptId($id);
        $query = RaporStudent::with(['schoolClass', 'waliKelas', 'scores.subject.teacher'])
            ->where('student_id', $user->id)
            ->where('status', 'published');

        if ($resolvedId) {
            $rapor = $query->find($resolvedId);
        } else {
            $rapor = $query->where('verification_token', $id)->first();
        }

        if (!$rapor) {
            abort(404, 'Rapor tidak ditemukan atau belum diterbitkan.');
        }

        $scores = $rapor->scores->map(function ($s) {
            return [
                'id' => $s->id,
                'mapel' => $s->subject?->name ?? '-',
                'kode_mapel' => $s->subject?->code ?? '-',
                'guru' => $s->subject?->teacher?->name ?? '-',
                'nilai_tugas' => $s->nilai_tugas,
                'nilai_cbt' => $s->nilai_cbt,
                'nilai_akhir' => $s->nilai_akhir,
                'capaian_kompetensi' => $s->capaian_kompetensi,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $rapor->id,
                'encrypted_id' => $rapor->encrypted_id,
                'tahun_ajaran' => $rapor->tahun_ajaran,
                'semester' => $rapor->semester,
                'kelas' => $rapor->schoolClass?->name ?? '-',
                'wali_kelas' => $rapor->waliKelas?->name ?? '-',
                'wali_kelas_nip' => $rapor->waliKelas?->nip ?? '-',
                'rata_rata_nilai' => $rapor->average_score,
                'sakit' => $rapor->sakit,
                'izin' => $rapor->izin,
                'tanpa_keterangan' => $rapor->tanpa_keterangan,
                'catatan_wali_kelas' => $rapor->catatan_wali_kelas,
                'status_kenaikan' => $rapor->status_kenaikan,
                'tanggal_rapor' => $rapor->tanggal_rapor?->translatedFormat('d F Y'),
                'document_serial' => $rapor->effective_serial,
                'verification_url' => $rapor->verification_url,
                'scores' => $scores,
                'pdf_url' => url("/api/siswa/rapor/{$rapor->encrypted_id}/pdf"),
            ],
        ]);
    }

    /**
     * Download langsung file PDF rapor
     * GET /api/siswa/rapor/{id}/pdf
     */
    public function downloadPdf(Request $request, $id)
    {
        // 1. Cek autentikasi (Bearer token atau ?token=...)
        $user = $request->user('sanctum');
        if (!$user && $request->filled('token')) {
            $personalToken = \Laravel\Sanctum\PersonalAccessToken::findToken($request->token);
            if ($personalToken && $personalToken->tokenable instanceof \App\Models\User) {
                $user = $personalToken->tokenable;
            }
        }

        $resolvedId = is_numeric($id) ? (int)$id : RaporSecurityService::decryptId($id);
        $query = RaporStudent::with([
            'student',
            'schoolClass',
            'waliKelas',
            'scores.subject.teacher'
        ])
        ->where('status', 'published');

        // Jika request dari user dengan role student, pastikan hanya milik siswa tersebut
        if ($user && in_array($user->role, ['student', 'siswa'])) {
            $query->where('student_id', $user->id);
        }

        if ($resolvedId) {
            $rapor = $query->find($resolvedId);
        } else {
            $rapor = $query->where('verification_token', $id)->first();
        }

        if (!$rapor) {
            abort(404, 'Rapor tidak ditemukan atau belum diterbitkan.');
        }

        RaporSecurityService::ensureSecurityData($rapor);
        $qrCodeDataUri = RaporSecurityService::getQrCodeDataUri($rapor->verification_url);

        $kepsek = \App\Models\User::where('role', 'kepala_sekolah')->first() 
               ?? \App\Models\User::where('role', 'admin')->first();

        $pdf = Pdf::loadView('pdf.rapor_siswa', compact('rapor', 'kepsek', 'qrCodeDataUri'))
            ->setPaper('a4', 'portrait');

        $cleanName = \Illuminate\Support\Str::slug($rapor->student->name ?? 'siswa', '_');
        $cleanSemester = \Illuminate\Support\Str::slug($rapor->semester ?? 'semester', '_');
        $cleanTahun = str_replace(['/', '\\', ' '], ['-', '-', '_'], $rapor->tahun_ajaran ?? 'rapor');
        $filename = "Rapor_{$cleanName}_{$cleanSemester}_{$cleanTahun}.pdf";

        return $pdf->stream($filename);
    }
}
