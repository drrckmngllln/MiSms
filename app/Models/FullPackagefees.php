<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullPackagefees extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'description',
        'semester',
        'campus_id',
        'fourth_year',
        'fifth_year',
        'course_id'
    ];
    public static $rules = [
        'category' => 'required',
        'description' => 'required',
        'semester' => 'required',
        'campus_id' => 'required',
        'fourth_year' => 'required',
        'fifth_year' => 'required',
        'course_id' => 'required',

    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    // public function createAccount()
    // {
    //     return $this->belongsTo(CreateAccount::class, 'campus_id', 'campus_id');
    // }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}