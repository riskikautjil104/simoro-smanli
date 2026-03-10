<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display mobile settings dashboard.
     */
    public function index()
    {
        return view('mobile.dashboard');
    }

    /**
     * Get current config values.
     */
    public function getConfig()
    {
        return response()->json([
            'app' => [
                'app_name' => config('app.app_name'),
                'school_name' => config('app.school_name'),
                'tagline' => config('app.tagline'),
                'location' => config('app.location'),
                'version' => config('app.version'),
                'maintenance_mode' => config('app.maintenance_mode'),
                'maintenance_message' => config('app.maintenance_message'),
            ],
            'theme' => [
                'primary' => config('theme.primary'),
                'secondary' => config('theme.secondary'),
                'background' => config('theme.background'),
                'surface' => config('theme.surface'),
                'error' => config('theme.error'),
                'success' => config('theme.success'),
                'text_primary' => config('theme.text_primary'),
                'text_secondary' => config('theme.text_secondary'),
            ],
            'features' => [
                'show_onboarding' => config('features.show_onboarding'),
                'show_notifications' => config('features.show_notifications'),
                'enable_location_tracking' => config('features.enable_location_tracking'),
            ],
        ]);
    }

    /**
     * Update app config.
     */
    public function updateAppConfig(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'sometimes|string|max:255',
            'school_name' => 'sometimes|string|max:255',
            'tagline' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'version' => 'sometimes|string|max:50',
            'maintenance_mode' => 'sometimes|boolean',
            'maintenance_message' => 'sometimes|string',
        ]);

        // Update .env file
        foreach ($validated as $key => $value) {
            $envKey = strtoupper($key);
            if ($key === 'maintenance_mode') {
                $envKey = 'MAINTENANCE_MODE';
            } else {
                $envKey = strtoupper(preg_replace('/([a-zA-Z])/', '_$1', $key));
                $envKey = str_replace(' ', '', $envKey);
            }
            
            // Map to correct .env key
            $envMapping = [
                'app_name' => 'APP_NAME_MOBILE',
                'school_name' => 'SCHOOL_NAME',
                'tagline' => 'APP_TAGLINE',
                'location' => 'SCHOOL_LOCATION',
                'version' => 'APP_VERSION',
                'maintenance_mode' => 'MAINTENANCE_MODE',
                'maintenance_message' => 'MAINTENANCE_MESSAGE',
            ];
            
            if (isset($envMapping[$key])) {
                $this->updateEnvFile($envMapping[$key], $value);
            }
        }

        // Clear config cache
        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi app berhasil diperbarui'
        ]);
    }

    /**
     * Update theme config.
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'primary' => 'sometimes|string',
            'secondary' => 'sometimes|string',
            'background' => 'sometimes|string',
            'surface' => 'sometimes|string',
            'error' => 'sometimes|string',
            'success' => 'sometimes|string',
            'text_primary' => 'sometimes|string',
            'text_secondary' => 'sometimes|string',
        ]);

        foreach ($validated as $key => $value) {
            $envKey = 'THEME_' . strtoupper($key);
            $this->updateEnvFile($envKey, $value);
        }

        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi tema berhasil diperbarui'
        ]);
    }

    /**
     * Update features config.
     */
    public function updateFeatures(Request $request)
    {
        $validated = $request->validate([
            'show_onboarding' => 'sometimes|boolean',
            'show_notifications' => 'sometimes|boolean',
            'enable_location_tracking' => 'sometimes|boolean',
        ]);

        foreach ($validated as $key => $value) {
            $envKey = 'FEATURE_' . strtoupper(preg_replace('/([a-zA-Z])/', '_$1', $key));
            $envKey = str_replace(' ', '', $envKey);
            $this->updateEnvFile($envKey, $value ? 'true' : 'false');
        }

        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi fitur berhasil diperbarui'
        ]);
    }

    /**
     * Helper to update .env file.
     */
    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        if (!file_exists($path)) return;

        $value = is_bool($value) ? ($value ? 'true' : 'false') : '"' . $value . '"';
        
        file_put_contents($path, str_replace(
            $key . '="' . env($key) . '"',
            $key . '=' . $value,
            file_get_contents($path)
        ));
    }
}

