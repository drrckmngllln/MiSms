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
        Schema::create('create_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('sy_enrolled');
            $table->string('school_year');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('date_of_birth');
            $table->string('place_of_birth');
            $table->string('nationality');
            $table->string('religion');
            $table->string('control_number');
            $table->string('email');
            $table->string('home_address');
            $table->string('elementary')->nullable();
            $table->string('year_graduated_elem')->nullable();
            $table->string('junior_high_school')->nullable();
            $table->string('year_graduated_elem_jhs')->nullable();
            $table->string('senior_high_school')->nullable();
            $table->string('year_graduated_elem_shs')->nullable();
            $table->string('mothers_fullname')->nullable();
            $table->string('occupation_mother')->nullable();
            $table->string('contact_number_mother')->nullable();
            $table->string('fathers_fullname')->nullable();
            $table->string('occupation_father')->nullable();
            $table->string('contact_number_father')->nullable();
            $table->string('type_of_students');
            $table->enum('status', ['PENDING', 'FOR ENROLLMENT', 'ACCOUNTING', 'OFFICIALLY ENROLLED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_accounts');
    }
};
