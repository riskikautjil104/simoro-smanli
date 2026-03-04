<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->tinyInteger('reapply_status')->default(0); // 0: tidak mengajukan, 1: menunggu, 2: diterima, 3: ditolak
            $table->text('reapply_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->dropColumn(['reapply_status', 'reapply_reason']);
        });
    }
};
