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
        Schema::create('full_packagefees', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('description');
            $table->integer('campus_id');
            $table->decimal('fourth_year', 10, 4);
            $table->decimal('fifth_year', 10, 4);
            $table->integer('semester');
            $table->integer('course_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_packagefees');
    }
};