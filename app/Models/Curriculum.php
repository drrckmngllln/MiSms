<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'campus_id',
        'course_id',
        'effective',
        'expires',
        'status'
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function section()
    {
        // Foreign key: section_code_id
        return $this->belongsTo(Section::class, 'section_code_id');
    }

    public function subjects()
    {
        return $this->hasMany(CurriculumSubject::class, 'curriculum_id');
    }

    public function create_accounts()
    {
        return $this->hasOne(CreateAccount::class, 'course_id');
    }

    public function createAccount()
    {
        return $this->hasOne(CreateAccount::class, 'course_id', 'course_id');
    }
}
