<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'curriculum_id' => rand(1, 20),
            'semester_id' => rand(1, 15),
            'code' => Str::random(5),
            'descriptive_tittle' => fake()->sentence(),
            'total_units' => rand(3, 7),
            'lecture_units' => rand(1, 3),
            'lab_units' => rand(1, 3),
            'pre_requisite' => 'none',
            'total_hrs_per_week' => rand(1, 3),
            'is_active' => rand(0, 1)
        ];
    }
}
