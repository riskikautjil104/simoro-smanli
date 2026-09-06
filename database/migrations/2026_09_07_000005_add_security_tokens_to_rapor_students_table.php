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
            if (!Schema::hasColumn('rapor_students', 'verification_token')) {
                $table->string('verification_token', 64)->nullable()->unique()->after('status');
            }
            if (!Schema::hasColumn('rapor_students', 'document_serial')) {
                $table->string('document_serial', 60)->nullable()->unique()->after('verification_token');
            }
            if (!Schema::hasColumn('rapor_students', 'digital_signature_hash')) {
                $table->string('digital_signature_hash', 64)->nullable()->after('document_serial');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapor_students', function (Blueprint $table) {
            $table->dropColumn(['verification_token', 'document_serial', 'digital_signature_hash']);
        });
    }
};
