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
        Schema::create('section_subjectsses', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->integer('course_id');
            $table->integer('year_level');
            $table->integer('curriculum_id');
            $table->integer('semester');
            $table->integer('subject_id');
            $table->string('code');
            $table->string('descriptive_tittle');
            $table->string('total_units')->decimal(8, 2);
            $table->string('lecture_units');
            $table->integer('lab_units');
            $table->string('pre_requisite');
            $table->string('total_hrs_per_week');
            $table->integer('department_id')->nullable();
            $table->string('time')->nullable();
            $table->string('day')->nullable();
            $table->string('room')->nullable();
            $table->string('instructor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_subjectsses');
    }
};