<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester',
        'id_number',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'religion',
        'status'

    ];
    public static $rules = [
        'semester' => 'required',
        'id_number' => 'nullable',
        'last_name' => 'required',
        'first_name' => 'required',
        'middle_name' => 'nullable',
        'suffix' => 'nullable',
        'gender' => 'required',
        'date_of_birth' => 'required',
        'place_of_birth' => 'required',
        'nationality' => 'required',
        'religion' => 'required',
        'status' => 'required',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function enrolled_student()
    {
        return $this->hasOne(EnrolledStudent::class);
    }
    public function subject()
    {
        return $this->hasMany(CurriculumSubject::class);
    }
}
