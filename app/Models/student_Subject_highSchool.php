<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_Subject_highSchool extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number', 'curriculum_id', 'course_id', 'campus_id', 'year_level', 'semester',
        'section_id', 'code', 'descriptive_tittle', 'total_units', 'lecture_units', 'lab_units',
        'pre_requisite', 'total_hrs_per_week', 'lab_id', 'subject_id', 'department_id', 'section_id', 'school_year', 'department_id'
    ];

    public static $rules = [
        'id_number' => ['required'],
        'curriculum_id' => ['required'],
        'course_id' => ['required'],
        'campus_id' => ['required'],
        'year_level' => ['required'],
        'semester' => ['required'],
        'code' => ['required'],
        'descriptive_tittle' => ['required'],
        'total_units' => ['required'],
        'lecture_units' => ['required'],
        'lab_units' => ['required'],
        'pre_requisite' => ['required'],
        'total_hrs_per_week' => ['required'],
        'subject_id' => ['required'],

    ];
    public function create_account()
    {
        return $this->hasOne(CreateAccount::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function studentassessmentaccount()
    {
        return $this->belongsTo(CreateAccount::class);
    }
    public function miscFee()
    {
        return $this->hasMany(MiscFee::class, 'campus_id', 'campus_id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'campus_id');
    }
    public function laboratory()
    {
        return $this->belongsTo(laboratoryModel::class, 'lab_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function curriculumSubject()
    {
        return $this->belongsTo(curriculumSubject::class, 'section_i');
    }
    public function adddetails()
    {
        return $this->hasMany(adddetails::class, 'subject_id', 'subject_id');
    }
    public function tuitionfee()
    {
        return $this->belongsTo(TuitionFee::class, 'campus_id', 'campus_id');
    }
    public function miscFees()
    {
        return $this->belongsTo(MiscFee::class, 'campus_id', 'campus_id');
    }
    public function otherFees()
    {
        return $this->belongsTo(OtherFee::class, 'campus_id', 'campus_id');
    }
    public function additionalSubjectDetails()
    {
        return $this->hasOne(adddetails::class, 'subject_id', 'subject_id');
    }
    public function otherFees2()
    {
        return $this->hasMany(OtherFee::class, 'semester', 'semester')
            ->where('campus_id', $this->campus_id);
    }
    public function latestDetailOfSubject()
    {
        return $this->hasOne(adddetails::class, 'subject_id', 'subject_id')->latestOfMany();
    }
    public function miscfee2()
    {
        return $this->hasMany(MiscFee::class, 'semester', 'semester')
            ->where('campus_id', $this->campus_id);
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
    public function create_accountHS()
    {
        return $this->hasOne(CreateAccountHighSchool::class);
    }
}
