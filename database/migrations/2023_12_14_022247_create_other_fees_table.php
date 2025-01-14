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
        Schema::create('other_fees', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('description');
            $table->integer('campus_id');
            $table->decimal('first_year', 10, 4);
            $table->decimal('second_year', 10, 4);
            $table->decimal('third_year', 10, 4);
            $table->decimal('fourth_year', 10, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_fees');
    }
};
