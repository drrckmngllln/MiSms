<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cashierlogs extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'or_number',
        'particulars',
        'school_year',
        'department',
        'credit',
        'debit',
        'balance',
    ];
}
