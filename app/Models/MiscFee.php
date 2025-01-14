<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscFee extends Model
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

    ];
    public static $rules = [
        'category' => 'required',
        'description' => 'required',
        'semester' => 'required',
        'campus_id' => 'required',
        'first_year' => 'required',
        'second_year' => 'required',
        'third_year' => 'required',
        'third_year' => 'required',


    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function createAccount()
    {
        return $this->belongsTo(CreateAccount::class, 'campus_id', 'campus_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}