<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nonassesed extends Model
{
    use HasFactory;

    public $fillable = [
        'or_number', 'particulars', 'id_number', 'amount'
    ];
}
