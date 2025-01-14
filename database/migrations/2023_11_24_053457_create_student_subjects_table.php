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
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->integer('curriculum_id');
            $table->integer('course_id');
            $table->integer('campus_id');
            $table->integer('year_level');
            $table->integer('semester');
            $table->integer('section_id')->nullable();
            // $table->integer('curriculum_id')->default(0);
            // $table->integer('year_level');
            // $table->integer('semester_id');
            $table->string('code');
            $table->text('descriptive_tittle');
            $table->string('total_units');
            $table->string('lecture_units');
            $table->string('lab_units');
            $table->string('pre_requisite');
            $table->string('total_hrs_per_week');
            $table->integer('lab_id')->nullable();
            $table->integer('subject_id');
            $table->integer('grade')->nullable();

            // $table->integer('subject_id')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subjects');
    }
};
