<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentApplicant>
 */
class StudentApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_id' => rand(),
            'image' => fake()->sentence(),
            'last_name' => fake()->lastName(),
            'middle_name' => fake()->firstName(),
            'first_name' => fake()->firstName(),
            'prefix' => fake()->randomElement(['A', 'K', 'I', 'U', 'E', 'O']),
            'email' => fake()->email(),
            'fullname' => fake()->name(),
            'date_of_birth' => fake()->date(),
            'place_of_birth' => fake()->city(),
            'religion' => fake()->randomElement(['Catholic', 'Christian', 'Muslim']),
            'nationality' => fake()->randomElement(['Filipino', 'American', 'British']),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'civil_status' => fake()->randomElement(['Single', 'Married']),
            'dialect' => fake()->randomElement(['ilokano', 'ybanag', 'itawes']),
            'contact_number' => rand(),
            'complete_address' => fake()->address(),
            'fathers_fullname' => fake()->name(),
            'fathers_occupation' => fake()->sentence(),
            'mothers_fullname' => fake()->name(),
            'mothers_occupation' => fake()->sentence(),
            'parents_address' => fake()->address(),
            'parents_contact_number' => rand(),
            'primary_school' => fake()->sentence(),
            'secondary_school' => fake()->sentence(),
            'junior_highschool' => fake()->sentence(),
            'senior_highschool' => fake()->sentence(),
            'course' => fake()->randomElement(['BSCS', 'BSA', 'ABPsychology', 'BSIT']),
            'student_type' => fake()->randomElement(['freshmen', 'transferee']),
            'year_level' => rand(1, 5)
        ];
    }
}
