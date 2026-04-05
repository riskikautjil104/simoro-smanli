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
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->boolean('is_detected')->default(false)->after('reapply_reason');
            $table->timestamp('detection_time')->nullable()->after('is_detected');
            $table->string('detection_reason')->nullable()->max(500)->after('detection_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->dropColumn(['is_detected', 'detection_time', 'detection_reason']);
        });
    }
};
