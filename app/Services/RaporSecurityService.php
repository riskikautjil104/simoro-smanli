<?php

namespace App\Services;

use App\Models\RaporStudent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RaporSecurityService
{
    /**
     * Pastikan data keamanan (token, serial, dan hash) telah terisi pada objek RaporStudent
     */
    public static function ensureSecurityData(RaporStudent $rapor): RaporStudent
    {
        $dirty = false;

        if (empty($rapor->verification_token)) {
            $rapor->verification_token = self::generateVerificationToken($rapor);
            $dirty = true;
        }

        if (empty($rapor->document_serial)) {
            $rapor->document_serial = self::generateDocumentSerial($rapor);
            $dirty = true;
        }

        $currentHash = self::calculateDigitalSignature($rapor);
        if ($rapor->digital_signature_hash !== $currentHash) {
            $rapor->digital_signature_hash = $currentHash;
            $dirty = true;
        }

        if ($dirty) {
            // Simpan tanpa memicu event jika kolom tersedia
            try {
                $rapor->save();
            } catch (\Exception $e) {
                // Toleran jika migrasi belum dijalankan di database server
            }
        }

        return $rapor;
    }

    /**
     * Hasilkan token verifikasi unik kriptografis (HMAC-SHA256)
     */
    public static function generateVerificationToken(RaporStudent $rapor): string
    {
        $payload = implode('|', [
            $rapor->id,
            $rapor->student_id,
            $rapor->tahun_ajaran,
            $rapor->semester,
            microtime(true),
            Str::random(16),
        ]);

        return hash_hmac('sha256', $payload, config('app.key', 'simoro-smanli-secret-key'));
    }

    /**
     * Hasilkan Nomor Registrasi Dokumen Rapor Resmi SMAN 5 Pulau Morotai
     * Contoh: SMAN5/RAPOR/2025-2026/G1/0002
     */
    public static function generateDocumentSerial(RaporStudent $rapor): string
    {
        $cleanTahun = str_replace(['/', '\\', ' '], '-', $rapor->tahun_ajaran ?? '2025-2026');
        $semCode    = strtoupper(substr($rapor->semester ?? 'G', 0, 1)) . ($rapor->semester === 'Genap' ? '2' : '1');
        $paddedId   = str_pad((string)($rapor->id ?? 1), 4, '0', STR_PAD_LEFT);

        return "SMAN5/RAPOR/{$cleanTahun}/{$semCode}/{$paddedId}";
    }

    /**
     * Hitung Digital Signature Hash SHA-256 untuk memverifikasi keutuhan nilai rapor
     */
    public static function calculateDigitalSignature(RaporStudent $rapor): string
    {
        $scoresPayload = '';
        if ($rapor->relationLoaded('scores') && $rapor->scores->isNotEmpty()) {
            $scoresPayload = $rapor->scores->map(function ($s) {
                return "{$s->subject_id}:{$s->nilai_akhir}";
            })->implode(';');
        }

        $raw = implode('||', [
            'SMAN5-PULAU-MOROTAI',
            $rapor->id,
            $rapor->student_id,
            $rapor->class_id,
            $rapor->tahun_ajaran,
            $rapor->semester,
            $rapor->sakit,
            $rapor->izin,
            $rapor->tanpa_keterangan,
            $scoresPayload,
            config('app.key', 'secret'),
        ]);

        return hash('sha256', $raw);
    }

    /**
     * Enkripsi ID untuk digunakan di URL publik (penyamaran ID)
     */
    public static function encryptId($id): string
    {
        return rtrim(strtr(base64_encode(Crypt::encryptString((string)$id)), '+/', '-_'), '=');
    }

    /**
     * Dekripsi token URL kembali ke integer ID
     */
    public static function decryptId(string $token): ?int
    {
        try {
            $decoded = base64_decode(strtr($token, '-_', '+/'));
            $decrypted = Crypt::decryptString($decoded);
            return is_numeric($decrypted) ? (int)$decrypted : null;
        } catch (\Exception $e) {
            return is_numeric($token) ? (int)$token : null;
        }
    }

    /**
     * Buat / Ambil QR Code Gambar untuk lembar PDF rapor
     * Mengembalikan Base64 Data URI yang langsung dapat dirender di DomPDF
     */
    public static function getQrCodeDataUri(string $url): string
    {
        $hash = md5($url);
        $qrDir = storage_path('app/public/qrcodes');
        File::ensureDirectoryExists($qrDir);
        $filePath = $qrDir . '/' . $hash . '.png';

        if (file_exists($filePath)) {
            $data = file_get_contents($filePath);
            return 'data:image/png;base64,' . base64_encode($data);
        }

        // Coba download dari QR generator API dengan timeout pendek
        try {
            $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=4&format=png&data=' . urlencode($url);
            $response = Http::timeout(3)->get($apiUrl);
            if ($response->successful() && strlen($response->body()) > 100) {
                file_put_contents($filePath, $response->body());
                return 'data:image/png;base64,' . base64_encode($response->body());
            }
        } catch (\Exception $e) {
            // Abaikan kegagalan koneksi luar, gunakan generator fallback SVG lokal
        }

        // Fallback: Kembalikan SVG QR Code placeholder mandiri
        $svg = self::generateFallbackSvgQr($url);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * SVG QR Code Fallback Mandiri (Offline Safe)
     */
    private static function generateFallbackSvgQr(string $url): string
    {
        $shortHash = substr(md5($url), 0, 8);
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" width="160" height="160">
    <rect width="160" height="160" fill="#ffffff" rx="10" stroke="#0d6efd" stroke-width="2"/>
    <!-- Position Markers -->
    <rect x="15" y="15" width="35" height="35" fill="none" stroke="#0f172a" stroke-width="5"/>
    <rect x="25" y="25" width="15" height="15" fill="#0d6efd"/>
    <rect x="110" y="15" width="35" height="35" fill="none" stroke="#0f172a" stroke-width="5"/>
    <rect x="120" y="25" width="15" height="15" fill="#0d6efd"/>
    <rect x="15" y="110" width="35" height="35" fill="none" stroke="#0f172a" stroke-width="5"/>
    <rect x="25" y="120" width="15" height="15" fill="#0d6efd"/>
    <!-- Decorative Matrix -->
    <rect x="60" y="20" width="8" height="8" fill="#1e293b"/>
    <rect x="75" y="20" width="8" height="8" fill="#1e293b"/>
    <rect x="90" y="30" width="8" height="8" fill="#1e293b"/>
    <rect x="60" y="45" width="40" height="8" fill="#1e293b"/>
    <rect x="60" y="60" width="12" height="12" fill="#0d6efd"/>
    <rect x="80" y="60" width="20" height="12" fill="#1e293b"/>
    <rect x="20" y="65" width="25" height="8" fill="#1e293b"/>
    <rect x="115" y="65" width="30" height="8" fill="#1e293b"/>
    <rect x="20" y="85" width="120" height="6" fill="#0f172a"/>
    <rect x="60" y="95" width="40" height="8" fill="#0d6efd"/>
    <rect x="110" y="110" width="15" height="15" fill="#1e293b"/>
    <rect x="130" y="125" width="15" height="15" fill="#1e293b"/>
    <!-- Seal Text -->
    <text x="80" y="150" font-family="sans-serif" font-size="7.5" font-weight="bold" text-anchor="middle" fill="#0d6efd">VERIFIKASI RESMI</text>
</svg>
SVG;
    }
}
