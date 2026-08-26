<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum role untuk menyertakan kepala_sekolah
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'teacher', 'student', 'mobile', 'kepala_sekolah') NOT NULL DEFAULT 'student'");

        // Tambah kolom nik jika belum ada
        if (!Schema::hasColumn('users', 'nik')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nik')->nullable()->after('nip');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'nik')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('nik');
            });
        }
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'teacher', 'student', 'mobile') NOT NULL DEFAULT 'student'");
    }
};
