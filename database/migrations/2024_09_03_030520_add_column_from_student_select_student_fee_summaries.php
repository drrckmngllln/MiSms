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
        Schema::table('fee_summaries', function (Blueprint $table) {
            //
            $table->string('or_number')->change()->nullable();
            $table->string('particulars')->change()->nullable();
            $table->string('id_number')->change()->nullable();
            $table->decimal('downpayment', 8, 2)->change()->nullable();
            $table->decimal('total_assessment', 10, 2)->change()->nullable();
            $table->string('cahier_in_charge')->change()->nullable();
            $table->string('name')->change()->nullable();
            $table->string('excess')->change()->nullable();
            $table->string('downpayment2')->change()->nullable();
            $table->date('date')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_summaries', function (Blueprint $table) {
            //
        });
    }
};
