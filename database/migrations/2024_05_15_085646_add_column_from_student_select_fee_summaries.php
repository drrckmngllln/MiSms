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
            $table->string('cahier_in_charge')->after('total_assessment')->nullable();
            $table->string('name')->after('cahier_in_charge')->nullable();
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
