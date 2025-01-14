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
        Schema::create('fees_categories', function (Blueprint $table) {
            $table->id();
            $table->text('category');
            $table->text('freetype');
            $table->integer('course_id');
            $table->integer('year_level');
            $table->decimal('amount');
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_categories');
    }
};