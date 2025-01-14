<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laboratoryModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description',
        'semester',
        'campus_id',
        'first_year',
        'second_year',
        'third_year',
        'fourth_year',
        'course_id'
    ];

    public static $rules = [
        'category' => 'required',
        'description' => 'required',
        'semester' => 'required',
        'campus_id' => 'required',
        'first_year' => 'required',
        'second_year' => 'required',
        'third_year' => 'required',
        'fourth_year' => 'required',


    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function curriculumSubject()
    {
        return $this->hasMany(CurriculumSubject::class, 'lab_id', 'lab_id');
    }
    public function createAccount()
    {
        return $this->belongsTo(createAccount::class);
    }
    public function createAccountHS()
    {
        return $this->belongsTo(CreateAccountHighSchool::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
