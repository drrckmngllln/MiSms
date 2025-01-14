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
        Schema::table('other_fees', function (Blueprint $table) {
            //
            $table->integer('campus_id')->change()->nullable();
            $table->integer('semester')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_fees', function (Blueprint $table) {
            //
        });
    }
};
