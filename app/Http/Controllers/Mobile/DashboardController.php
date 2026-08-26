<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\MobileConfig;

class DashboardController extends Controller
{
    /**
     * Display mobile settings web dashboard.
     * GET /mobile/dashboard
     */
    public function index()
    {
        $configs = MobileConfig::getGrouped();
        $banners = \App\Models\MobileBanner::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('mobile.dashboard', compact('configs', 'banners'));
    }

    /**
     * Get current grouped config values (Web / Admin API).
     * GET /mobile/config atau GET /api/mobile/config
     */
    public function getConfig()
    {
        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi mobile berhasil diambil',
            'data'    => MobileConfig::getGrouped()
        ]);
    }

    /**
     * Get public config for Mobile App on launch (No Auth required).
     * GET /api/config
     */
    public function getPublicConfig()
    {
        return response()->json([
            'success' => true,
            'data'    => MobileConfig::getPublicConfig()
        ]);
    }

    /**
     * Update app general info & URLs.
     * POST /mobile/config/app atau POST /api/mobile/config/app
     */
    public function updateAppConfig(Request $request)
    {
        $validated = $request->validate([
            'app_name'            => 'sometimes|nullable|string|max:255',
            'school_name'         => 'sometimes|nullable|string|max:255',
            'tagline'             => 'sometimes|nullable|string|max:255',
            'location'            => 'sometimes|nullable|string|max:255',
            'base_url'            => 'sometimes|nullable|url|max:255',
            'web_url'             => 'sometimes|nullable|url|max:255',
            'version'             => 'sometimes|nullable|string|max:50',
            'min_version'         => 'sometimes|nullable|string|max:50',
            'playstore_url'       => 'sometimes|nullable|string|max:255',
            'appstore_url'        => 'sometimes|nullable|string|max:255',
            'maintenance_mode'    => 'sometimes|nullable|boolean',
            'maintenance_message' => 'sometimes|nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            $type = in_array($key, ['maintenance_mode']) ? 'boolean' : 'string';
            MobileConfig::set($key, $value, 'app', $type);
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi Informasi Aplikasi & URL berhasil diperbarui.',
            'data'    => MobileConfig::getGrouped()['app']
        ]);
    }

    /**
     * Upload Logo & Onboarding Images.
     * POST /mobile/config/assets atau POST /api/mobile/config/assets
     */
    public function uploadAssets(Request $request)
    {
        $request->validate([
            'logo'         => 'sometimes|file|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'splash_logo'  => 'sometimes|file|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'onboarding_1' => 'sometimes|file|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'onboarding_2' => 'sometimes|file|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'onboarding_3' => 'sometimes|file|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
        ]);

        $fileKeys = [
            'logo'         => 'logo_url',
            'splash_logo'  => 'splash_logo_url',
            'onboarding_1' => 'onboarding_img_1',
            'onboarding_2' => 'onboarding_img_2',
            'onboarding_3' => 'onboarding_img_3',
        ];

        foreach ($fileKeys as $inputName => $configKey) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = $inputName . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('mobile/assets', $filename, 'public');
                MobileConfig::set($configKey, '/storage/' . $path, 'assets', 'string');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'File Logo & Gambar Onboarding berhasil diunggah.',
            'data'    => MobileConfig::getPublicConfig()['assets']
        ]);
    }

    /**
     * Upload or update Lottie Animation JSON / URLs.
     * POST /mobile/config/lottie atau POST /api/mobile/config/lottie
     */
    public function updateLottie(Request $request)
    {
        $request->validate([
            'lottie_splash_file'        => 'sometimes|file|mimes:json,txt|max:5120',
            'lottie_exam_success_file'  => 'sometimes|file|mimes:json,txt|max:5120',
            'lottie_exam_timer_file'    => 'sometimes|file|mimes:json,txt|max:5120',
            'lottie_warning_cheat_file' => 'sometimes|file|mimes:json,txt|max:5120',
            'lottie_maintenance_file'   => 'sometimes|file|mimes:json,txt|max:5120',
            'lottie_splash'             => 'sometimes|nullable|string',
            'lottie_exam_success'       => 'sometimes|nullable|string',
            'lottie_exam_timer'         => 'sometimes|nullable|string',
            'lottie_warning_cheat'      => 'sometimes|nullable|string',
            'lottie_maintenance'        => 'sometimes|nullable|string',
        ]);

        $lottieKeys = [
            'lottie_splash',
            'lottie_exam_success',
            'lottie_exam_timer',
            'lottie_warning_cheat',
            'lottie_maintenance'
        ];

        // Process file uploads first
        foreach ($lottieKeys as $key) {
            $fileInput = $key . '_file';
            if ($request->hasFile($fileInput)) {
                $file = $request->file($fileInput);
                $filename = $key . '_' . time() . '.json';
                $path = $file->storeAs('mobile/lottie', $filename, 'public');
                MobileConfig::set($key, '/storage/' . $path, 'lottie', 'string');
            } elseif ($request->has($key) && !empty($request->input($key))) {
                MobileConfig::set($key, $request->input($key), 'lottie', 'string');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Animasi Lottie berhasil diperbarui.',
            'data'    => MobileConfig::getPublicConfig()['lottie']
        ]);
    }

    /**
     * Update theme colors config.
     * POST /mobile/config/theme atau POST /api/mobile/config/theme
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'primary'        => 'sometimes|nullable|string|max:50',
            'secondary'      => 'sometimes|nullable|string|max:50',
            'accent'         => 'sometimes|nullable|string|max:50',
            'background'     => 'sometimes|nullable|string|max:50',
            'surface'        => 'sometimes|nullable|string|max:50',
            'error'          => 'sometimes|nullable|string|max:50',
            'success'        => 'sometimes|nullable|string|max:50',
            'text_primary'   => 'sometimes|nullable|string|max:50',
            'text_secondary' => 'sometimes|nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            MobileConfig::set($key, $value, 'theme', 'string');
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi Tema & Warna berhasil diperbarui.',
            'data'    => MobileConfig::getGrouped()['theme']
        ]);
    }

    /**
     * Update feature flags & exam security rules.
     * POST /mobile/config/features atau POST /api/mobile/config/features
     */
    public function updateFeatures(Request $request)
    {
        $validated = $request->validate([
            'show_onboarding'          => 'sometimes|nullable|boolean',
            'show_notifications'       => 'sometimes|nullable|boolean',
            'enable_location_tracking' => 'sometimes|nullable|boolean',
            'require_gps'              => 'sometimes|nullable|boolean',
            'enable_anti_cheat'        => 'sometimes|nullable|boolean',
            'auto_lock_on_detect'      => 'sometimes|nullable|boolean',
            'allow_resume_exam'        => 'sometimes|nullable|boolean',
            'max_exit_attempts'        => 'sometimes|nullable|integer|min:0|max:10',
            'enable_reapply'           => 'sometimes|nullable|boolean',
            'allow_screenshot'         => 'sometimes|nullable|boolean',
            'show_score_after_exam'    => 'sometimes|nullable|boolean',
            'allow_review_answers'     => 'sometimes|nullable|boolean',
        ]);

        foreach ($validated as $key => $value) {
            $type = in_array($key, ['max_exit_attempts']) ? 'integer' : 'boolean';
            MobileConfig::set($key, $value, 'features', $type);
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi Fitur & Keamanan Ujian berhasil diperbarui.',
            'data'    => MobileConfig::getGrouped()['features']
        ]);
    }

    /**
     * Update contact & legal config.
     * POST /mobile/config/contact atau POST /api/mobile/config/contact
     */
    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'contact_whatsapp'   => 'sometimes|nullable|string|max:50',
            'contact_email'      => 'sometimes|nullable|email|max:100',
            'privacy_policy_url' => 'sometimes|nullable|string|max:255',
            'terms_url'          => 'sometimes|nullable|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            MobileConfig::set($key, $value, 'contact', 'string');
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi Kontak & Bantuan berhasil diperbarui.',
            'data'    => MobileConfig::getGrouped()['contact']
        ]);
    }

    /**
     * Update all mobile settings in one batch (REST API).
     * POST /api/mobile/config
     */
    public function updateAll(Request $request)
    {
        if ($request->has('app')) {
            $this->updateAppConfig(new Request($request->input('app')));
        }
        if ($request->has('theme')) {
            $this->updateTheme(new Request($request->input('theme')));
        }
        if ($request->has('features')) {
            $this->updateFeatures(new Request($request->input('features')));
        }
        if ($request->has('contact')) {
            $this->updateContact(new Request($request->input('contact')));
        }

        return response()->json([
            'success' => true,
            'message' => 'Seluruh pengaturan mobile berhasil disimpan.',
            'data'    => MobileConfig::getPublicConfig()
        ]);
    }
}
