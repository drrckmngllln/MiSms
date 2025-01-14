<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'freetype',
        'course_id',
        'year_level',
        'amount',
        'remarks',
    ];

    public static $rules = [
        'category' => ['required'],
        'freetype' => ['required'],
        'course_id' => ['required'],
        'year_level' => ['required'],
        'amount' => ['required'],
        'remarks' => ['required'],
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
