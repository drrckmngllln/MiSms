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
        Schema::create('section_with_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('section_code_id');
            $table->integer('course_id');
            $table->integer('year_level');
            $table->integer('curriculum_id');
            $table->integer('add_details_id');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_with_subjects');
    }
};
