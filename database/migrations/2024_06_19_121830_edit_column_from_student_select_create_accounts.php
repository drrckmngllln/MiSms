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
        Schema::table('create_accounts', function (Blueprint $table) {
            //
            $table->string('id_number')->change()->nullable();
            $table->string('last_name')->change()->nullable();
            $table->string('first_name')->change()->nullable();
            $table->string('middle_name')->change()->nullable();
            $table->string('gender')->change()->nullable();
            $table->string('civil_status')->change()->nullable();
            $table->string('date_of_birth')->change()->nullable();
            $table->string('place_of_birth')->change()->nullable();
            $table->string('nationality')->change()->nullable();
            $table->string('religion')->change()->nullable();
            $table->string('control_number')->change()->nullable();
            $table->string('email')->change()->nullable();
            $table->string('home_address')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('create_accounts', function (Blueprint $table) {
            //
        });
    }
};
