<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('exam_id')->nullable()->after('id');
            $table->text('pertanyaan')->nullable()->after('exam_id');
            $table->string('opsi_a')->nullable()->after('pertanyaan');
            $table->string('opsi_b')->nullable()->after('opsi_a');
            $table->string('opsi_c')->nullable()->after('opsi_b');
            $table->string('opsi_d')->nullable()->after('opsi_c');
            $table->string('jawaban_benar')->nullable()->after('opsi_d');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropColumn(['exam_id', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban_benar']);
        });
    }
};
