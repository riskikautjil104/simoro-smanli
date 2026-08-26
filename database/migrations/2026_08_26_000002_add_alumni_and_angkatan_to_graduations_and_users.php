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
        Schema::table('graduations', function (Blueprint $table) {
            if (!Schema::hasColumn('graduations', 'angkatan')) {
                $table->string('angkatan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('graduations', 'class_name')) {
                $table->string('class_name')->nullable()->after('angkatan');
            }
            if (!Schema::hasColumn('graduations', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable()->after('class_name');
            }
            if (!Schema::hasColumn('graduations', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'angkatan')) {
                $table->string('angkatan')->nullable()->after('graduated_at');
            }
            if (!Schema::hasColumn('users', 'previous_class_id')) {
                $table->unsignedBigInteger('previous_class_id')->nullable()->after('angkatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graduations', function (Blueprint $table) {
            $table->dropColumn(['angkatan', 'class_name', 'tahun_ajaran', 'user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['angkatan', 'previous_class_id']);
        });
    }
};
