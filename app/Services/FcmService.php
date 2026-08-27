<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Firebase Cloud Messaging (FCM) HTTP v1 API Service
 * 
 * Menggunakan Service Account (firebase-credentials.json) untuk autentikasi,
 * lalu mengirim push notification ke HP siswa/guru melalui FCM HTTP v1 API.
 * 
 * File credentials harus diletakkan di: storage/app/firebase-credentials.json
 */
class FcmService
{
    protected string $projectId;
    protected string $credentialsPath;

    public function __construct()
    {
        $this->credentialsPath = storage_path('app/firebase-credentials.json');

        // Baca project_id langsung dari file credentials
        $this->projectId = 'moro5smart-cbt';
        if (file_exists($this->credentialsPath)) {
            $json = json_decode(file_get_contents($this->credentialsPath), true);
            $this->projectId = $json['project_id'] ?? $this->projectId;
        }
    }

    /**
     * Ambil OAuth2 Access Token dari Service Account Key
     */
    protected function getAccessToken(): ?string
    {
        try {
            if (!file_exists($this->credentialsPath)) {
                Log::error('[FCM] Service account credentials file tidak ditemukan: ' . $this->credentialsPath);
                return null;
            }

            $client = new GoogleClient();
            $client->setAuthConfig($this->credentialsPath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();

            return $token['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error('[FCM] Gagal mendapatkan Access Token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Kirim notifikasi ke satu device (token tunggal)
     * 
     * @param  string  $fcmToken   FCM device token tujuan
     * @param  string  $title      Judul notifikasi
     * @param  string  $body       Isi pesan notifikasi
     * @param  array   $data       Data tambahan (key-value, semua harus string)
     * @return bool    true jika berhasil terkirim, false jika gagal
     */
    public function sendToDevice(string $fcmToken, string $title, string $body, array $data = []): bool
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        try {
            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($url, [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'android' => [
                        'notification' => [
                            'channel_id' => 'moro5smart_high_importance_channel',
                            'sound'      => 'default',
                            'priority'   => 'HIGH',
                        ],
                        'priority' => 'high',
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'alert' => [
                                    'title' => $title,
                                    'body'  => $body,
                                ],
                                'sound' => 'default',
                                'badge' => 1,
                            ],
                        ],
                    ],
                    'data' => collect($data)->map(fn($v) => (string) $v)->toArray(),
                ],
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('[FCM] Gagal kirim ke device.', [
                'token_prefix' => substr($fcmToken, 0, 20) . '...',
                'status'  => $response->status(),
                'body'    => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('[FCM] Exception saat kirim notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi ke banyak device sekaligus (bulk)
     * 
     * @param  array   $fcmTokens  Array FCM device tokens
     * @param  string  $title
     * @param  string  $body
     * @param  array   $data
     * @return array   ['success' => int, 'failed' => int]
     */
    public function sendToMultiple(array $fcmTokens, string $title, string $body, array $data = []): array
    {
        $success = 0;
        $failed  = 0;

        foreach ($fcmTokens as $token) {
            if (empty($token)) continue;
            $result = $this->sendToDevice($token, $title, $body, $data);
            $result ? $success++ : $failed++;
        }

        Log::info("[FCM] Bulk send selesai. Berhasil: {$success}, Gagal: {$failed}");

        return ['success' => $success, 'failed' => $failed];
    }

    /**
     * Kirim notifikasi ke Topic FCM (misal: 'siswa', 'pengumuman_sekolah')
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        try {
            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($url, [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'android' => [
                        'notification' => [
                            'channel_id' => 'moro5smart_high_importance_channel',
                            'sound'      => 'default',
                            'priority'   => 'HIGH',
                        ],
                        'priority' => 'high',
                    ],
                    'data' => collect($data)->map(fn($v) => (string) $v)->toArray(),
                ],
            ]);

            if ($response->successful()) {
                Log::info("[FCM] Topic '{$topic}' berhasil dikirim.");
                return true;
            }

            Log::warning("[FCM] Gagal kirim ke topic '{$topic}'.", [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('[FCM] Exception sendToTopic: ' . $e->getMessage());
            return false;
        }
    }
    // batas suci
}
