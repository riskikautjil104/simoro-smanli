<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $subjectId = DB::table('subjects')->where('name', 'Matematika')->value('id');
        if ($subjectId) {
            DB::table('exams')->insert([
                'subject_id' => $subjectId,
                'title' => 'Ujian Matematika Semester 1',
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(3)->addHours(2),
                'duration' => 120,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Tambah ujian lain jika perlu
    }
}
