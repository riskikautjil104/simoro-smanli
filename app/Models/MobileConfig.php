<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MobileConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
    ];

    /**
     * Default configurations.
     */
    public static function defaults(): array
    {
        return [
            // App & URLs
            'app_name'                 => ['value' => 'SIMORO Mobile', 'group' => 'app', 'type' => 'string', 'description' => 'Nama Aplikasi Mobile'],
            'school_name'              => ['value' => 'SMA Negeri 5 Pulau Morotai', 'group' => 'app', 'type' => 'string', 'description' => 'Nama Resmi Sekolah'],
            'tagline'                  => ['value' => 'Sistem Informasi CBT & Akademik', 'group' => 'app', 'type' => 'string', 'description' => 'Slogan Aplikasi'],
            'location'                 => ['value' => 'Pulau Morotai, Maluku Utara', 'group' => 'app', 'type' => 'string', 'description' => 'Lokasi / Wilayah Sekolah'],
            'base_url'                 => ['value' => 'http://127.0.0.1:8000/api', 'group' => 'app', 'type' => 'string', 'description' => 'Base API Endpoint URL'],
            'web_url'                  => ['value' => 'http://127.0.0.1:8000', 'group' => 'app', 'type' => 'string', 'description' => 'URL Web Portal Utama'],
            'version'                  => ['value' => '2.0.0', 'group' => 'app', 'type' => 'string', 'description' => 'Versi Aplikasi Mobile Saat Ini'],
            'min_version'              => ['value' => '1.0.0', 'group' => 'app', 'type' => 'string', 'description' => 'Versi Minimum (Force Update)'],
            'playstore_url'            => ['value' => '', 'group' => 'app', 'type' => 'string', 'description' => 'Link Unduh Google Play Store'],
            'appstore_url'             => ['value' => '', 'group' => 'app', 'type' => 'string', 'description' => 'Link Unduh Apple App Store'],
            'maintenance_mode'         => ['value' => 'false', 'group' => 'app', 'type' => 'boolean', 'description' => 'Status Mode Pemeliharaan'],
            'maintenance_message'      => ['value' => 'Aplikasi sedang dalam pemeliharaan server berkala. Silakan coba kembali beberapa saat lagi.', 'group' => 'app', 'type' => 'string', 'description' => 'Pesan Saat Maintenance'],

            // Assets, Logos & Media
            'logo_url'                 => ['value' => '/assets/img/icon.png', 'group' => 'assets', 'type' => 'string', 'description' => 'Logo Aplikasi Mobile'],
            'splash_logo_url'          => ['value' => '/assets/img/icon.png', 'group' => 'assets', 'type' => 'string', 'description' => 'Logo Splash Screen'],
            'onboarding_img_1'         => ['value' => '/assets/img/people.svg', 'group' => 'assets', 'type' => 'string', 'description' => 'Gambar Onboarding Slide 1'],
            'onboarding_img_2'         => ['value' => '/assets/img/people.svg', 'group' => 'assets', 'type' => 'string', 'description' => 'Gambar Onboarding Slide 2'],
            'onboarding_img_3'         => ['value' => '/assets/img/people.svg', 'group' => 'assets', 'type' => 'string', 'description' => 'Gambar Onboarding Slide 3'],

            // Lottie Animations
            'lottie_splash'            => ['value' => '', 'group' => 'lottie', 'type' => 'string', 'description' => 'Animasi Lottie Splash Screen / Loading'],
            'lottie_exam_success'      => ['value' => '', 'group' => 'lottie', 'type' => 'string', 'description' => 'Animasi Lottie Selesai Ujian'],
            'lottie_exam_timer'        => ['value' => '', 'group' => 'lottie', 'type' => 'string', 'description' => 'Animasi Lottie Countdown Timer'],
            'lottie_warning_cheat'     => ['value' => '', 'group' => 'lottie', 'type' => 'string', 'description' => 'Animasi Lottie Deteksi Kecurangan'],
            'lottie_maintenance'       => ['value' => '', 'group' => 'lottie', 'type' => 'string', 'description' => 'Animasi Lottie Mode Maintenance'],

            // Theme & Branding Colors
            'primary'                  => ['value' => '#0d6efd', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Utama'],
            'secondary'                => ['value' => '#6c757d', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Sekunder'],
            'accent'                   => ['value' => '#06b6d4', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Aksen'],
            'background'               => ['value' => '#ffffff', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Latar Belakang'],
            'surface'                  => ['value' => '#f8f9fa', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Kartu / Surface'],
            'error'                    => ['value' => '#dc3545', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Status Error / Bahaya'],
            'success'                  => ['value' => '#198754', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Status Sukses'],
            'text_primary'             => ['value' => '#212529', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Teks Utama'],
            'text_secondary'           => ['value' => '#6c757d', 'group' => 'theme', 'type' => 'string', 'description' => 'Warna Teks Sekunder'],

            // Feature Flags & Exam Security Rules
            'show_onboarding'          => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Tampilkan Halaman Pengenalan'],
            'show_notifications'       => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Fitur Notifikasi Mobile'],
            'enable_location_tracking' => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Pelacakan Koordinat GPS'],
            'require_gps'              => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Wajibkan GPS Aktif sebelum Ujian'],
            'enable_anti_cheat'        => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Sensor Anti-Curang (Pindah Layar)'],
            'auto_lock_on_detect'      => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Kunci Otomatis saat Terdeteksi Pindah Tab'],
            'allow_resume_exam'        => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Izinkan Lanjutkan Ujian jika Terkeluar'],
            'max_exit_attempts'        => ['value' => '3', 'group' => 'features', 'type' => 'integer', 'description' => 'Batas Maksimal Keluar App sebelum Terkunci'],
            'enable_reapply'           => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Pengajuan Buka Ujian Terkunci'],
            'allow_screenshot'         => ['value' => 'false', 'group' => 'features', 'type' => 'boolean', 'description' => 'Izinkan Screenshot saat Ujian'],
            'show_score_after_exam'    => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Tampilkan Nilai Langsung setelah Submit'],
            'allow_review_answers'     => ['value' => 'true', 'group' => 'features', 'type' => 'boolean', 'description' => 'Izinkan Siswa Review Jawaban setelah Selesai'],

            // Contact & Legal
            'contact_whatsapp'         => ['value' => '081234567890', 'group' => 'contact', 'type' => 'string', 'description' => 'WhatsApp Helpdesk CBT'],
            'contact_email'            => ['value' => 'admin@sma5.sch.id', 'group' => 'contact', 'type' => 'string', 'description' => 'Email Bantuan Sekolah'],
            'privacy_policy_url'       => ['value' => 'http://127.0.0.1:8000/docs#kebijakan-privasi', 'group' => 'contact', 'type' => 'string', 'description' => 'Link Kebijakan Privasi'],
            'terms_url'                => ['value' => 'http://127.0.0.1:8000/docs#syarat-ketentuan', 'group' => 'contact', 'type' => 'string', 'description' => 'Link Syarat & Ketentuan'],

            // E-Rapor Standar Sekolah
            'rapor_weight_tugas'       => ['value' => '40', 'group' => 'rapor', 'type' => 'integer', 'description' => 'Bobot Nilai Tugas Default (%)'],
            'rapor_weight_cbt'         => ['value' => '60', 'group' => 'rapor', 'type' => 'integer', 'description' => 'Bobot Nilai CBT Default (%)'],
            'rapor_kkm_default'        => ['value' => '75', 'group' => 'rapor', 'type' => 'integer', 'description' => 'Standar KKM Default Sekolah'],
        ];
    }

    /**
     * Get single config value.
     */
    public static function get(string $key, $default = null)
    {
        $all = self::getAllCached();
        if (isset($all[$key])) {
            return $all[$key];
        }

        $defaults = self::defaults();
        if (isset($defaults[$key])) {
            return self::castValue($defaults[$key]['value'], $defaults[$key]['type']);
        }

        return $default;
    }

    /**
     * Set / Update single config value.
     */
    public static function set(string $key, $value, string $group = 'app', string $type = 'string', ?string $description = null)
    {
        $strValue = is_bool($value) ? ($value ? 'true' : 'false') : (string)$value;

        self::updateOrCreate(
            ['key' => $key],
            [
                'value'       => $strValue,
                'group'       => $group,
                'type'        => $type,
                'description' => $description,
            ]
        );

        Cache::forget('mobile_configs_all');
    }

    /**
     * Get all configs grouped.
     */
    public static function getGrouped(): array
    {
        $defaults = self::defaults();
        $dbRecords = self::all()->keyBy('key');

        $result = [
            'app'      => [],
            'assets'   => [],
            'lottie'   => [],
            'theme'    => [],
            'features' => [],
            'contact'  => [],
            'rapor'    => [],
        ];

        foreach ($defaults as $key => $def) {
            $record = $dbRecords->get($key);
            $val = $record ? $record->value : $def['value'];
            $type = $record ? $record->type : $def['type'];
            $group = $record ? $record->group : $def['group'];

            $result[$group][$key] = self::castValue($val, $type);
        }

        return $result;
    }

    /**
     * Format asset URL to full absolute URL.
     */
    private static function formatUrl($path)
    {
        if (empty($path)) return '';
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url($path);
    }

    /**
     * Get full public config format for mobile clients.
     */
    public static function getPublicConfig(): array
    {
        $grouped = self::getGrouped();

        return [
            'app_name'            => $grouped['app']['app_name'] ?? 'SIMORO Mobile',
            'school_name'         => $grouped['app']['school_name'] ?? 'SMA Negeri 5 Pulau Morotai',
            'tagline'             => $grouped['app']['tagline'] ?? 'Sistem Ujian Online',
            'location'            => $grouped['app']['location'] ?? 'Pulau Morotai, Maluku Utara',
            'base_url'            => $grouped['app']['base_url'] ?? url('/api'),
            'web_url'             => $grouped['app']['web_url'] ?? url('/'),
            'version'             => $grouped['app']['version'] ?? '2.0.0',
            'min_version'         => $grouped['app']['min_version'] ?? '1.0.0',
            'playstore_url'       => $grouped['app']['playstore_url'] ?? '',
            'appstore_url'        => $grouped['app']['appstore_url'] ?? '',
            'maintenance_mode'    => (bool)($grouped['app']['maintenance_mode'] ?? false),
            'maintenance_message' => $grouped['app']['maintenance_message'] ?? '',
            
            // Assets & Logo URLs
            'assets'              => [
                'logo_url'         => self::formatUrl($grouped['assets']['logo_url'] ?? '/assets/img/icon.png'),
                'splash_logo_url'  => self::formatUrl($grouped['assets']['splash_logo_url'] ?? '/assets/img/icon.png'),
                'onboarding_img_1' => self::formatUrl($grouped['assets']['onboarding_img_1'] ?? '/assets/img/people.svg'),
                'onboarding_img_2' => self::formatUrl($grouped['assets']['onboarding_img_2'] ?? '/assets/img/people.svg'),
                'onboarding_img_3' => self::formatUrl($grouped['assets']['onboarding_img_3'] ?? '/assets/img/people.svg'),
            ],

            // Lottie Animations
            'lottie'              => [
                'splash'          => self::formatUrl($grouped['lottie']['lottie_splash'] ?? ''),
                'exam_success'    => self::formatUrl($grouped['lottie']['lottie_exam_success'] ?? ''),
                'exam_timer'      => self::formatUrl($grouped['lottie']['lottie_exam_timer'] ?? ''),
                'warning_cheat'   => self::formatUrl($grouped['lottie']['lottie_warning_cheat'] ?? ''),
                'maintenance'     => self::formatUrl($grouped['lottie']['lottie_maintenance'] ?? ''),
            ],

            // Theme & Branding
            'theme'               => [
                'primary'        => $grouped['theme']['primary'] ?? '#0d6efd',
                'secondary'      => $grouped['theme']['secondary'] ?? '#6c757d',
                'accent'         => $grouped['theme']['accent'] ?? '#06b6d4',
                'background'     => $grouped['theme']['background'] ?? '#ffffff',
                'surface'        => $grouped['theme']['surface'] ?? '#f8f9fa',
                'error'          => $grouped['theme']['error'] ?? '#dc3545',
                'success'        => $grouped['theme']['success'] ?? '#198754',
                'text_primary'   => $grouped['theme']['text_primary'] ?? '#212529',
                'text_secondary' => $grouped['theme']['text_secondary'] ?? '#6c757d',
            ],

            // Features & Security Rules
            'features'            => [
                'show_onboarding'          => (bool)($grouped['features']['show_onboarding'] ?? true),
                'show_notifications'       => (bool)($grouped['features']['show_notifications'] ?? true),
                'enable_location_tracking' => (bool)($grouped['features']['enable_location_tracking'] ?? true),
                'require_gps'              => (bool)($grouped['features']['require_gps'] ?? true),
                'enable_anti_cheat'        => (bool)($grouped['features']['enable_anti_cheat'] ?? true),
                'auto_lock_on_detect'      => (bool)($grouped['features']['auto_lock_on_detect'] ?? true),
                'allow_resume_exam'        => (bool)($grouped['features']['allow_resume_exam'] ?? true),
                'max_exit_attempts'        => (int)($grouped['features']['max_exit_attempts'] ?? 3),
                'enable_reapply'           => (bool)($grouped['features']['enable_reapply'] ?? true),
                'allow_screenshot'         => (bool)($grouped['features']['allow_screenshot'] ?? false),
                'show_score_after_exam'    => (bool)($grouped['features']['show_score_after_exam'] ?? true),
                'allow_review_answers'     => (bool)($grouped['features']['allow_review_answers'] ?? true),
            ],

            // Help & Legal
            'contact'             => [
                'whatsapp'           => $grouped['contact']['contact_whatsapp'] ?? '',
                'email'              => $grouped['contact']['contact_email'] ?? '',
                'privacy_policy_url' => $grouped['contact']['privacy_policy_url'] ?? '',
                'terms_url'          => $grouped['contact']['terms_url'] ?? '',
            ],

            // Promo & Ads Banners Carousel
            'banners'             => \App\Models\MobileBanner::active()->get(),
        ];
    }

    /**
     * Get all cached key-values.
     */
    public static function getAllCached(): array
    {
        return Cache::remember('mobile_configs_all', 3600, function () {
            $defaults = self::defaults();
            $records = self::all()->keyBy('key');
            $merged = [];

            foreach ($defaults as $key => $def) {
                $record = $records->get($key);
                $val = $record ? $record->value : $def['value'];
                $type = $record ? $record->type : $def['type'];
                $merged[$key] = self::castValue($val, $type);
            }

            return $merged;
        });
    }

    private static function castValue($val, $type)
    {
        if ($type === 'boolean') {
            return filter_var($val, FILTER_VALIDATE_BOOLEAN);
        }
        if ($type === 'integer') {
            return (int)$val;
        }
        if ($type === 'json') {
            return json_decode($val, true);
        }
        return (string)$val;
    }
}
