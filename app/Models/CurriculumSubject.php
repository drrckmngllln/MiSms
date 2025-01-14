<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'year_level',
        'semester_id',
        'code',
        'descriptive_tittle',
        'total_units',
        'lecture_units',
        'lab_units',
        'pre_requisite',
        'total_hrs_per_week',
        'lab_id',
        'section_id'
    ];
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_code');
    }
    public function detailsofsubjects()
    {
        return $this->hasOne(adddetails::class, 'subject_id', 'id')->latest();
    }
    public function detailsofsubjects2()
    {
        return $this->hasMany(adddetails::class, 'subject_id', 'id');
    }
    public function laboratory()
    {
        return $this->belongsTo(laboratoryModel::class, 'lab_id');
    }
    public function create_account()
    {
        return $this->belongsTo(CreateAccount::class, 'curriculum_id', 'curriculum_id')
            ->select(['curriculum_id', 'id_number', 'course_id', 'id']);
    }
    public function studentSubjects()
    {
        return $this->belongsTo(StudentSubject::class, 'curriculum_id', 'curriculum_id');
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
    public function detailsofsubjects3()
    {
        return $this->hasMany(adddetails::class)->latest();
    }
    public function latestDetailOfSubject()
    {
        return $this->hasOne(adddetails::class, 'subject_id', 'id')->latestOfMany();
    }
    public function studentAssessment()
    {
        return $this->belongsTo(studentAssesment::class, 'subject_id');
    }
    public function studentSubjectss()
    {
        return $this->hasMany(StudentSubject::class, 'subject_id', 'subject_id');
    }
    public function studentAssessments()
    {
        return $this->hasMany(studentAssesment::class);
    }
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }
    public function create_account_highSchool()
    {
        return $this->belongsTo(CreateAccountHighSchool::class, 'curriculum_id', 'curriculum_id')
            ->select(['curriculum_id', 'id_number', 'course_id', 'id']);
    }
    public function studentSub()
    {
        return $this->hasOne(StudentSubject::class, 'subject_id', 'subject_id');
    }
}
