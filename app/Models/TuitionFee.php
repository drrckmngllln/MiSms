<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description',
        'semester',
        'campus_id',
        'first_year',
        'second_year',
        'third_year',
        'fourth_year',
        'course_id'
    ];
    public static $rules = [
        'category' => 'required',
        'description' => 'required',
        'semester' => 'required',
        'campus_id' => 'required',
        'first_year' => 'required',
        'second_year' => 'required',
        'third_year' => 'required',
        'fourth_year' => 'required',

    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
