<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateAccountHighSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        // 'sy_enrolled',
        // 'school_year',
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'civil_status',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'religion',
        'control_number', 'email', 'home_address', 'elementary', 'year_graduated_elem',
        'junior_high_school', 'year_graduated_elem_jhs', 'senior_high_school', 'year_graduated_elem_shs', 'mothers_fullname', 'occupation_mother', 'contact_number_mother',
        'fathers_fullname', 'occupation_father', 'contact_number_father', 'type_of_students', 'course_id',
        'status', 'curriculum_id', 'campus_id', 'discount_id', 'admission_date'
    ];
    public static $rules = [
        'id_number' => 'required',
        // 'sy_enrolled' => 'required',
        // 'school_year' => 'required',
        'last_name' => 'required',
        'first_name' => 'required',
        'middle_name' => 'required',
        'gender' => 'required',
        'civil_status' => 'required',
        'date_of_birth' => 'required',
        'place_of_birth' => 'required',
        'nationality' => 'required',
        'religion' => 'required',
        'control_number' => 'required',
        'email' => 'required',
        'home_address' => 'required',
        'elementary' => 'required',
        'year_graduated_elem_jhs' => 'required',
        'senior_high_school' => 'required',
        'year_graduated_elem_shs' => 'required',
        'mothers_fullname' => 'required',
        'occupation_mother' => 'required',
        'contact_number_mother' => 'required',
        'junior_high_school' => 'required',
        'year_graduated_elem_jhs' => 'required',
        'senior_high_school' => 'required',
        'year_graduated_elem_shs' => 'required',
        'mothers_fullname' => 'required',
        'fathers_fullname' => 'required',
        'occupation_father' => 'required',
        'contact_number_father' => 'required',
        'type_of_students' => 'required',
        // 'status' => 'required',
        'admission_date' => 'required',
        // 'year_level' => 'required',
        'course_id' => 'required',
        'campus_id' => 'required',


    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function student_subject_highSchool()
    {
        return $this->hasOne(student_Subject_highSchool::class, 'id_number', 'id_number')->orderBy('semester', 'desc')
            ->orderBy('year_level', 'desc')
            ->orderBy('course_id');
    }

    public function student_assestment()
    {
        return $this->belongsTo(studentAssesment::class, 'id_number', 'id_number');
    }
    public function feesStudentSummary()
    {
        return $this->belongsTo(fee_summary::class);
    }
    public function studentSubjects()
    {
        return $this->hasMany(StudentSubject::class, 'id_number', 'id_number');
    }
    public function miscFee()
    {
        return $this->hasMany(MiscFee::class);
    }
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'course_id', 'course_id');
    }
    public function laboratory()
    {
        return $this->belongsTo(laboratoryModel::class, 'lab_id');
    }
    public function adddetails()
    {
        return $this->belongsTo(adddetails::class, 'subject_id', 'subject_id');
    }
    public function instructor()
    {
        return $this->belongsTo(instructor::class, 'subject_id', 'subject_id');
    }
    public function miscFees()
    {
        return $this->hasMany(MiscFee::class, 'campus_id', 'campus_id');
    }
    public function fee_summary()
    {
        return $this->belongsTo(fee_summary::class, 'id_number', 'id_number');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'discount_id', 'id');
    }
    public function studentSubjectss()
    {
        return $this->belongsTo(StudentSubject::class, 'id_number', 'id_number');
        // ->select(['id_number', 'year_level', 'semester'])
    }
    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class, 'curriculum_id', 'curriculum_id');
    }
    public function schoolyear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
    public function sections()
    {
        return $this->hasOne(Section::class);
    }
    public function nonassessed()
    {
        return $this->belongsTo(nonassessed::class, 'id_number', 'id_number');
    }
    public function studentSubjectshs()
    {
        return $this->hasMany(student_Subject_highSchool::class, 'id_number', 'id_number');
    }
}
