<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom fcm_token ke tabel users
     * Digunakan untuk menyimpan Firebase Cloud Messaging Device Token
     * agar server dapat mengirim push notification ke HP siswa/guru.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('fcm_token')->nullable()->after('remember_token')
                  ->comment('Firebase Cloud Messaging device token untuk push notification');
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('fcm_token');
        });
        
    }
};
// batas suci
