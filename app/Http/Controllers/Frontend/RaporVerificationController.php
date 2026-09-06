<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RaporStudent;
use App\Models\User;
use App\Services\RaporSecurityService;
use Illuminate\Http\Request;

class RaporVerificationController extends Controller
{
    /**
     * Halaman Publik Verifikasi Keabsahan Dokumen E-Rapor Digital
     * URL: GET /verifikasi-rapor/{token}
     */
    public function show($token = null, Request $request = null)
    {
        $token = $token ?: request('token', request('q'));

        if (!$token) {
            return redirect()->to('/#verifikasi-rapor');
        }

        $token = trim($token);

        // 1. Cari berdasarkan verification_token unik atau nomor registrasi dokumen resmi
        $rapor = RaporStudent::with([
            'student',
            'schoolClass',
            'waliKelas',
            'scores.subject.teacher',
        ])
        ->where(function ($q) use ($token) {
            $q->where('verification_token', $token)
              ->orWhere('document_serial', $token);
        })
        ->first();

        // 2. Fallback jika token adalah encrypted ID
        if (!$rapor) {
            $decryptedId = RaporSecurityService::decryptId($token);
            if ($decryptedId) {
                $rapor = RaporStudent::with([
                    'student',
                    'schoolClass',
                    'waliKelas',
                    'scores.subject.teacher',
                ])->find($decryptedId);
            }
        }

        // 3. Jika dokumen tidak ditemukan sama sekali di database
        if (!$rapor) {
            return view('frontend.verifikasi_rapor', [
                'rapor' => null,
                'isValid' => false,
                'statusMessage' => 'Dokumen Rapor Tidak Terdaftar atau Kode Verifikasi Tidak Valid.',
                'token' => $token,
                'kepsek' => null,
            ]);
        }

        // 4. Jika dokumen masih berstatus draft (belum dipublikasikan resmi)
        if ($rapor->status !== 'published') {
            return view('frontend.verifikasi_rapor', [
                'rapor' => $rapor,
                'isValid' => false,
                'statusMessage' => 'Dokumen Rapor Ini Masih Berstatus DRAFT (Belum Diterbitkan Resmi oleh Sekolah).',
                'token' => $token,
                'kepsek' => null,
            ]);
        }

        // 5. Pastikan data keamanan terpasang
        RaporSecurityService::ensureSecurityData($rapor);

        // 6. Ambil data Kepala Sekolah
        $kepsek = User::where('role', 'kepala_sekolah')->first() ?? User::where('role', 'admin')->first();

        return view('frontend.verifikasi_rapor', [
            'rapor' => $rapor,
            'isValid' => true,
            'statusMessage' => 'Dokumen Asli & Sah Terverifikasi di Sistem Akademik SMA Negeri 5 Pulau Morotai',
            'token' => $token,
            'kepsek' => $kepsek,
        ]);
    }
}
