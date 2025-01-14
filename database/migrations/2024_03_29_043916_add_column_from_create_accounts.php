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
        Schema::table('create_accounts', function (Blueprint $table) {
            $table->enum('status', ['PENDING', 'FOR ENROLLMENT', 'ACCOUNTING', 'OFFICIALLY ENROLLED', 'CANCEL ACCOUNT'])->default('PENDING')->after('year_level');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('create_accounts', function (Blueprint $table) {
            //
        });
    }
};
