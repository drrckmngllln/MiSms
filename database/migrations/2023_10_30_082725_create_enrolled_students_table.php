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
        Schema::create('enrolled_students', function (Blueprint $table) {
            $table->id();
            $table->text('id_number')->nullable();
            $table->integer('course_id');
            $table->integer('curriculum_id');
            $table->integer('year_level');
            $table->integer('section_code');
            $table->integer('semester');
            $table->boolean('student_type');
            $table->boolean('status');
            $table->integer('total_units');
            $table->integer('student_applicant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolled_students');
    }
};
