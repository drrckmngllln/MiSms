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
        Schema::create('students_admitteds', function (Blueprint $table) {
            $table->id();
            $table->string('enrollment_id')->nullable();
            $table->text('image')->nullable();
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('first_name');
            $table->text('prefix')->nullable();
            $table->string('email')->unique();
            $table->string('fullname')->unique();
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('religion');
            $table->string('nationality');
            $table->text('gender');
            $table->text('civil_status');
            $table->text('dialect');
            $table->string('contact_number');
            $table->text('complete_address');
            $table->string('fathers_fullname');
            $table->string('fathers_occupation');
            $table->string('mothers_fullname');
            $table->string('mothers_occupation');
            $table->string('parents_address');
            $table->string('parents_contact_number');

            // guardian information
            $table->string('guardian_fullname')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('employer_details')->nullable();

            // last school attended
            $table->string('primary_school');
            $table->string('secondary_school');
            $table->string('junior_highschool');
            $table->string('senior_highschool');
            $table->string('last_school_attended')->nullable();
            $table->string('lastschool_name')->nullable();
            $table->string('lastschool_address')->nullable();

            // course details
            $table->integer('course_id');
            $table->integer('currirulum_id')->nullable();

            //eto titignan mo kung freshman or transferee
            $table->text('student_type');
            //year level kung transferee
            $table->text('year_level');
            //credentials presented
            $table->boolean('form_138')->nullable();
            $table->boolean('transcript_of_record')->nullable();
            $table->boolean('honorable_dismissal')->nullable();
            $table->boolean('birth_certificate')->nullable();
            $table->boolean('ncae_copt')->nullable();
            $table->boolean('good_moral')->nullable();
            $table->boolean('true_copy_of_grades')->nullable();
            $table->boolean('police_clearance')->nullable();
            $table->text('student_id')->nullable();
            $table->text('enrollmentStatus')->nullable();
            $table->integer('section_id')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_admitteds');
    }
};
