<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_id',
        'year_level',
        'fee_type_id',
        'remarks',
        'amount_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
