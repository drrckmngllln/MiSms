<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Commands\CreateRole;

class section_subjectss extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'course_id',
        'year_level',
        'curriculum_id',
        'semester_id',
        'subject_id',
        'code',
        'descriptive_tittle',
        'total_units',
        'lecture_units',
        'lab_units',
        'pre_requisite',
        'total_hrs_per_week',
        'department_id',
        'time',
        'day',
        'room',
        'instructor_id',
        'lab_id',
        'school_year',
        'campus_id',
    ];


    public function laboratory()
    {
        return $this->belongsTo(laboratoryModel::class, 'lab_id', 'id');
    }
    public function sectionSubject()
    {
        return $this->hasOne(section_subjectss::class);
    }
    public function instructor()
    {
        return $this->belongsTo(instructor::class, 'instructor_id', 'id');
    }
    public function studentAssessment()
    {
        return $this->belongsTo(studentAssesment::class, 'subject_id', 'subject_id');
    }
    public function curriculumSubject()
    {
        return $this->hasOne(curriculumSubject::class, 'subject_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function create_account()
    {
        return $this->hasOne(CreateAccount::class, 'curriculum_id', 'curriculum_id');
    }
    public function studentSubjects()
    {
        return $this->hasOne(StudentSubject::class, 'curriculum_id', 'curriculum_id');
    }
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }
    public function adddetails()
    {
        return $this->hasOne(adddetails::class, 'section_id', 'section_id')->latestOfMany();
    }
    public function adddetailss()
    {
        return $this->hasMany(adddetails::class, 'section_id', 'section_id')->latest();
    }
}
