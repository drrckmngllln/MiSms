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
        Schema::create('curriculum_subject_section', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_subject_id');
            $table->unsignedBigInteger('section_id');
            $table->timestamps();

            $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_subject_section');
    }
};
