<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'from',
        'to',
        'semester',
        'status'
    ];
    public static $rules = [
        'code' => 'required',
        'description' => 'required',
        'from' => 'required',
        'to' => 'required',
        'semester' => 'required',
        'status' => 'required'

    ];
}
