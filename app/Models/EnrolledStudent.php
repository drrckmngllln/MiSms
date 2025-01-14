<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number', 'course_id', 'curriculum_id', 'year_level', 'section_code', 'semester', 'student_type', 'student_applicant_id', 'status', 'total_units'
    ]; //

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function section()
    {
        //sectioncode para ma access yung relationship 
        return $this->belongsTo(Section::class, 'section_code');
    }
    public function student_applicant_id()
    {
        return $this->hasOne(StudentApplicant::class );
    }
}