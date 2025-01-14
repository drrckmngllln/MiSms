<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['section_code', 'semester', 'course_id', 'year_level',  'number_of_students', 'max_number_of_students', 'status', 'department_id', 'remarks', 'from', 'to', 'school_year'];

    public static $rules = [
        'section_code' => 'required',
        'semester' => 'required',
        'course_id' => 'required',
        'year_level' => 'required',
        'number_of_students' => 'required',
        'max_number_of_students' => 'required',
        'status' => 'required',
        'department_id' => 'required',
        'remarks' => 'required',
        'from' => 'required',
        'to' => 'required',
        'school_year' => 'required',
    ];
    public function subjects()
    {
        return $this->hasMany(SectionSubject::class, 'section_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function create_accounts()
    {
        return $this->hasMany(CreateAccount::class, 'course_id', 'id');
    }
    public function studentSubjects()
    {
        return $this->hasMany(StudentSubject::class);
    }
    public function department()
    {
        return $this->hasMany(Department::class, 'department_id', 'id');
    }
    public function adddetails()
    {
        return $this->belongsTo(Adddetails::class, 'section_id', 'id');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function studentSections()
    {
        return $this->hasMany(StudentsSection::class, 'section_id');
    }
    public function create_accountHS()
    {
        return $this->hasMany(CreateAccountHighSchool::class, 'course_id', 'id');
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
}