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
        Schema::table('fee_collection_histories', function (Blueprint $table) {
            //
            $table->integer('course_id')->after('otherFees_id')->nullable();
            $table->integer('year_level')->after('course_id')->nullable();
            $table->integer('campus_id')->after('year_level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee_collection_histories', function (Blueprint $table) {
            //
        });
    }
};