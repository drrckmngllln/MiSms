<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            'semester_id' => 1,
            'code' => Str::random(50),
            'descriptive_tittle' => Str::random(50),
            'total_units' => 3,
            'lecture_units' => 3,
            'lab_units' => 3,
            'pre_requisite' => 'none',
            'total_hrs_per_week' => 3,
            'is_active' => 1,
        ]);
    }
}
