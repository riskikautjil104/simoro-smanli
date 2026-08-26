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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_graduated')->default(false)->after('class_id');
            $table->dateTime('graduated_at')->nullable()->after('is_graduated');
        });

        Schema::table('graduations', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('status');
            $table->dateTime('archived_at')->nullable()->after('is_archived');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_graduated', 'graduated_at']);
        });

        Schema::table('graduations', function (Blueprint $table) {
            $table->dropColumn(['is_archived', 'archived_at']);
        });
    }
};
