<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherId = \DB::table('users')->where('role', 'teacher')->value('id');
        $subjects = [
            [
                'name' => 'Matematika',
                'code' => 'MAT01',
                'teacher_id' => $teacherId,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'code' => 'BIN01',
                'teacher_id' => $teacherId,
            ],
        ];
        foreach ($subjects as $subject) {
            \DB::table('subjects')->updateOrInsert(
                ['code' => $subject['code']],
                [
                    'name' => $subject['name'],
                    'teacher_id' => $subject['teacher_id'],
                ]
            );
        }
    }
}
