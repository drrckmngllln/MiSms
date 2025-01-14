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
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('curriculum_id')->default(0);
            $table->integer('year_level');
            $table->integer('semester_id');
            $table->string('code');
            $table->text('descriptive_tittle');
            $table->float('total_units');
            $table->string('lecture_units');
            $table->integer('lab_units');
            $table->string('pre_requisite');
            $table->string('total_hrs_per_week');
            // $table->boolean('is_active');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_subjects');
    }
};
