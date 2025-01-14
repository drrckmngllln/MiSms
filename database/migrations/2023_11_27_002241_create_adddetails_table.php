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
        Schema::create('adddetails', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->string('day');
            $table->string('room');
            $table->integer('instructor_id');
            $table->integer('subject_id');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adddetails');
    }
};
