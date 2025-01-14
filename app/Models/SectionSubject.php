<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id', 'semester_id', 'code', 'descriptive_tittle', 'total_units', 'lecture_units',
        'lab_units', 'pre_requisite', 'total_hrs_per_week', 'is_active'
    ];
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
