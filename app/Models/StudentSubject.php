<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class StudentSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'curriculum_id',
        'course_id',
        'campus_id',
        'year_level',
        'semester',
        'section_id',
        'code',
        'descriptive_tittle',
        'total_units',
        'lecture_units',
        'lab_units',
        'pre_requisite',
        'total_hrs_per_week',
        'lab_id',
        'subject_id',
        'department_id',
        'section_id',
        'school_year'
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
        return $this->belongsTo(Course::class, 'course_id', 'id');
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
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function curriculumSubject()
    {
        return $this->hasOne(curriculumSubject::class, 'subject_id', 'id');
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
    public function studentAss()
    {
        return $this->hasOne(studentAssesment::class, 'id_number', 'id_number');
    }
    public function create_accountss()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }
    public function student()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }

    public function adddetailss()
    {
        return $this->hasMany(adddetails::class, 'subject_id');
    }
    public function sectionSubject()
    {
        return $this->hasOne(section_subjectss::class, 'subject_id', 'subject_id');
    }
    public function fullpackage()
    {
        return $this->belongsTo(FullPackagefees::class, 'campus_id', 'campus_id');
    }
}