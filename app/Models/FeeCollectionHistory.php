<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCollectionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'or_number',
        'category',
        'amount_subtracted',
        'id_number',
        'subCategory',
        'other_fees_id'
    ];
}
