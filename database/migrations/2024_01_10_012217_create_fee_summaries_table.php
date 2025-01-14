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
        Schema::create('fee_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('or_number');
            $table->string('particulars');
            $table->string('id_number');
            $table->decimal('downpayment');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_summaries');
    }
};
