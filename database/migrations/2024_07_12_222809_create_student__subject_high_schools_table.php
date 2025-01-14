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
        Schema::create('student__subject_high_schools', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->integer('curriculum_id');
            $table->integer('course_id');
            $table->integer('campus_id');
            $table->integer('year_level');
            $table->integer('semester_id');
            $table->integer('section_id');
            $table->integer('department_id');
            $table->integer('school_year');
            $table->string('code');
            $table->string('descriptive_tittle');
            $table->string('total_units');
            $table->string('lecture_units');
            $table->string('lab_units');
            $table->string('pre_requisite');
            $table->string('total_hrs_per_week');
            $table->integer('lab_id');
            $table->integer('subject_id');
            $table->integer('grade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student__subject_high_schools');
    }
};