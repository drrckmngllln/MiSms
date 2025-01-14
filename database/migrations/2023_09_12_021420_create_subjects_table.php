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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('semester_id');
            $table->string('code');
            $table->text('descriptive_tittle');
            $table->integer('total_units');
            $table->integer('lecture_units');
            $table->integer('lab_units');
            $table->string('pre_requisite');
            $table->integer('total_hrs_per_week');
            $table->integer('otherdetails_id')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
