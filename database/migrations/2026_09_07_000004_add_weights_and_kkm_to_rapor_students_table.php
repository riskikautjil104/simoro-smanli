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
        Schema::table('rapor_students', function (Blueprint $table) {
            if (!Schema::hasColumn('rapor_students', 'weight_tugas')) {
                $table->decimal('weight_tugas', 5, 2)->default(40.00)->after('semester');
            }
            if (!Schema::hasColumn('rapor_students', 'weight_cbt')) {
                $table->decimal('weight_cbt', 5, 2)->default(60.00)->after('weight_tugas');
            }
            if (!Schema::hasColumn('rapor_students', 'kkm')) {
                $table->decimal('kkm', 5, 2)->default(75.00)->after('weight_cbt');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapor_students', function (Blueprint $table) {
            $table->dropColumn(['weight_tugas', 'weight_cbt', 'kkm']);
        });
    }
};
