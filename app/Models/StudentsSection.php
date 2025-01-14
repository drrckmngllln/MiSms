<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsSection extends Model
{
    use HasFactory;
    protected $fillable = [

        'full_name',
        'id_number',
        'school_year',
        'curriculum_id',
        'course_id',
        'campus_id',
        'year_level',
        'semester',
        'section_id'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Section::class, 'course_id', 'id');
    }
}
