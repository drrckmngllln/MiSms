<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplicantEdit extends Model
{
    use HasFactory;
    protected $fillable = [
        'enrollment_id',
        'curriculum_id', // Correct the field name here
        'image',
        'last_name',
        'middle_name',
        'first_name',
        'prefix',
        'fullname',
        'gender',
        'birthdate',
        'street_barangay',
        'municipality_province',
    ];
}
