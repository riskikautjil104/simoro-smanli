<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom 'agama' di tabel users (untuk Siswa & Guru)
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'agama')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('agama', 50)->nullable()->after('nis');
            });
        }

        // 2. Tambah kolom 'kategori_agama' & 'is_pilihan' di tabel subjects
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (!Schema::hasColumn('subjects', 'kategori_agama')) {
                    $table->string('kategori_agama', 50)->default('semua')->after('name');
                }
                if (!Schema::hasColumn('subjects', 'is_pilihan')) {
                    $table->boolean('is_pilihan')->default(false)->after('kategori_agama');
                }
            });
        }

        // 3. Tambah kolom 'target_agama' di tabel exams
        if (Schema::hasTable('exams')) {
            Schema::table('exams', function (Blueprint $table) {
                if (!Schema::hasColumn('exams', 'target_agama')) {
                    $table->string('target_agama', 50)->nullable()->default('semua')->after('class_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'agama')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('agama');
            });
        }

        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (Schema::hasColumn('subjects', 'kategori_agama')) {
                    $table->dropColumn('kategori_agama');
                }
                if (Schema::hasColumn('subjects', 'is_pilihan')) {
                    $table->dropColumn('is_pilihan');
                }
            });
        }

        if (Schema::hasTable('exams') && Schema::hasColumn('exams', 'target_agama')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->dropColumn('target_agama');
            });
        }
    }
};
