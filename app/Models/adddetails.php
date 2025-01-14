<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adddetails extends Model
{
    use HasFactory;
    // protected $table = 'subjects';
    protected $fillable = [
        'time',
        'day',
        'room',
        'instructor_id',
        'subject_id',
        'email',
        'section_id',
        'semester',
        'school_year'

    ];
    public static $rules = [
        'time' => ['required'],
        'day' => ['required'],
        'room' => ['required'],
        'instructor_id' => ['required'],
        'subject_id' => ['required'],
        'section_id' => ['required'],
        'semester' => ['required'],
        'school_year' => ['required'],
    ];

    public function subject_id()
    {
        return $this->hasOne(Subject::class);
    }
    public function instructorss()
    {
        return $this->belongsTo(instructor::class, 'instructor_id');
    }
    public function subject()
    {
        return $this->belongsTo(CurriculumSubject::class, 'subject_id');
    }
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function student_subject()
    {
        return $this->hasOne(StudentSubject::class, 'subject_id', 'subject_id');
    }
    public function view()
    {
        return $this->hasOne(adddetails::class, 'subject_id', 'id');
    }
    public function subjectsss()
    {
        return $this->belongsTo(section_subjectss::class, 'subject_id', 'subject_id');
    }
    public function student_subjects()
    {
        return $this->hasMany(StudentSubject::class, 'subject_id', 'subject_id');
    }
    public function instructors()
    {
        return $this->hasMany(instructor::class, 'instructor_id');
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year');
    }

    public function subjects()
    {
        return $this->hasMany(StudentSubject::class, 'subject_id', 'subject_id');
    }
}