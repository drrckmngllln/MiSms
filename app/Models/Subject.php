<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id', 'code', 'descriptive_tittle', 'total_units', 'lecture_units', 'lab_units',
        'pre_requisite', 'total_hrs_per_week', 'is_active'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function campus()
    {
        $this->belongsTo(Campus::class);
    }

    public function detailsofsubjects()
    {
        return $this->hasOne(adddetails::class, 'subject_id');
    }
}
