<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rate Limiter khusus Login API Mobile (10 percobaan per menit per IP)
        RateLimiter::for('api-login', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percobaan login. Demi keamanan, silakan tunggu 1 menit sebelum mencoba kembali.',
                ], 429);
            });
        });

        // Rate Limiter publik untuk Cek Rapor & Pengumuman (30 request per menit per IP)
        RateLimiter::for('public-verification', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip())->response(function (Request $request) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terlalu banyak permintaan verifikasi dokumen. Silakan tunggu 1 menit sebelum mencoba kembali.',
                    ], 429);
                }
                return response('Terlalu banyak permintaan verifikasi dokumen. Silakan tunggu 1 menit sebelum mencoba kembali.', 429);
            });
        });
    }
}
