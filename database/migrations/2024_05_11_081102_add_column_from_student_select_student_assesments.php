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
        Schema::table('student_assesments', function (Blueprint $table) {
            //
            $table->decimal('sdownpayment', 10, 2)->nullable()->after('computation');
            $table->decimal('sprelims', 10, 2)->nullable();
            $table->decimal('smidterms', 10, 2)->nullable();
            $table->decimal('ssemi_finals', 10, 2)->nullable();
            $table->decimal('sfinals', 10, 2)->nullable();
            $table->decimal('stotal_assessment', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_assesments', function (Blueprint $table) {
            //
        });
    }
};
