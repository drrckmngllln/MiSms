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
            $table->renameColumn('semester_id', 'semester');
            $table->integer('semester_id')->nullable()->change();
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