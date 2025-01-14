<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\StudentApplicant;
use App\Models\Testing;

use App\Models\Subject;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         */
        public function run(): void
        {
                // \App\Models\User::factory(10)->create();

                // \App\Models\User::factory()->create([
                //     'name' => 'Test User',
                //     'email' => 'test@example.com',
                // ]); 
                // $this->call(RoleSeeder::class);

                // $this->call(FakeDataSeeder::class);
                // Testing::factory('1000')->create();
                // Subject::factory(5000)->create();
                Subject::factory(7000)->create();
        }
}