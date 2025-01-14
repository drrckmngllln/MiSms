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
        Schema::table('student__subject_high_schools', function (Blueprint $table) {
            //

            $table->integer('section_id')->nullable()->change();
            $table->integer('department_id')->nullable()->change();
            $table->integer('school_year')->nullable()->change();
            $table->integer('lab_id')->nullable()->change();
            $table->integer('subject_id')->nullable()->change();
            $table->integer('grade')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student__subject_high_schools', function (Blueprint $table) {
            //
        });
    }
};