<?php

namespace Database\Seeders;

use App\Models\CreateAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CreateAccount::factory(9000)->create();
    }
}
