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
        Schema::table('nonassesseds', function (Blueprint $table) {
            //
            $table->string('cahier_in_charge')->after('amount')->nullable();
            $table->string('name')->after('cahier_in_charge')->nullable();
            $table->date('date')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nonassesseds', function (Blueprint $table) {
            //
        });
    }
};
