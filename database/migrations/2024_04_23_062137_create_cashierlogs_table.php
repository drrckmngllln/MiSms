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
        Schema::create('cashierlogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('or_number');
            $table->string('particulars');
            $table->string('school_year');
            $table->integer('department');
            $table->string('credit')->nullable();
            $table->string('debit')->nullable();
            $table->string('balance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashierlogs');
    }
};
