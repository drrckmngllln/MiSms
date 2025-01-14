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
        Schema::create('students_sections', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('full_name')->nullable();
            $table->integer('school_year')->nullable();
            $table->integer('curriculum_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('year_level')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('section_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_sections');
    }
};
