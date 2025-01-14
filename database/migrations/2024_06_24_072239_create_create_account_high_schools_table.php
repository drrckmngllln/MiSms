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
        Schema::create('create_account_high_schools', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('control_number')->nullable();
            $table->string('email')->nullable();
            $table->string('home_address')->nullable();
            $table->string('elementary')->nullable();
            $table->string('year_graduated_elem')->nullable();
            $table->string('junior_high_school')->nullable();
            $table->string('year_graduated_elem_jhs')->nullable();
            $table->string('senior_high_school')->nullable();
            $table->string('year_graduated_elem_shs')->nullable();
            $table->string('mothers_fullname')->nullable();
            $table->string('occupation_mother')->nullable();
            $table->string('contact_number_mother')->nullable();
            $table->string('fathers_fullname')->nullable();
            $table->string('occupation_father')->nullable();
            $table->string('contact_number_father')->nullable();
            $table->string('type_of_students')->nullable();
            $table->integer('discount_id')->nullable();
            $table->enum('status', ['PENDING', 'FOR ENROLLMENT', 'ACCOUNTING', 'OFFICIALLY ENROLLED'])->default('PENDING');
            $table->date('admission_date')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('curriculum_id')->nullable();
            $table->integer('campus_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_account_high_schools');
    }
};
