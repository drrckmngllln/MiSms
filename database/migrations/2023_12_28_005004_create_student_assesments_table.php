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
        Schema::create('student_assesments', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->integer('school_year');
            $table->string('fee_type');
            $table->float('amount');
            $table->float('lecture_units');
            $table->decimal('computation', 10, 2);
            $table->decimal('downpayment', 10, 2);
            $table->decimal('prelims', 10, 2);
            $table->decimal('midterms', 10, 2);
            $table->decimal('semi_finals', 10, 2);
            $table->decimal('finals', 10, 2);
            $table->decimal('total_assessment', 10, 2);
            $table->decimal('total_miscfee_first_year', 10, 2)->nullable();
            $table->decimal('total_miscfee_second_year', 10, 2)->nullable();
            $table->decimal('total_miscfee_third_year', 10, 2)->nullable();
            $table->decimal('total_miscfee_fourth_year', 10, 2)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assesments');
    }
};