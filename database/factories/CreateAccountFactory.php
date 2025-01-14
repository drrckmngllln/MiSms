<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreateAccount>
 */
class CreateAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_number' => $this->faker->unique()->numberBetween(1, 10000), // Unique random ID number
            'last_name' => $this->faker->lastName, // Random last name
            'first_name' => $this->faker->firstName, // Random first name
            'middle_name' => $this->faker->lastName, // You can use last name for middle name too
            'gender' => $this->faker->randomElement(['male', 'female']), // Random gender
            'civil_status' => $this->faker->randomElement(['single', 'married', 'divorced']), // Civil status options
            'date_of_birth' => $this->faker->date(), // Random date of birth
            'place_of_birth' => $this->faker->city, // Random city as place of birth
            'nationality' => $this->faker->randomElement(['Filipino', 'American', 'Canadian']),
            'type_of_students' => $this->faker->randomElement(['Regular', 'Irregular']),
            'course_id' => (12),
            'campus_id' => (2),
            'curriculum_id' => (17),
        ];
    }
}
