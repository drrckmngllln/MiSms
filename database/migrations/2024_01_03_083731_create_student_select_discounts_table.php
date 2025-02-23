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
        Schema::create('student_select_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->nullable();
            $table->string('code');
            $table->string('discount_target');
            $table->string('description');
            $table->integer('discount_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_select_discounts');
    }
};
