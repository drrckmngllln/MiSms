<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_target',
        'description',
        'discount_percentage'
    ];

    public static $rules = [
        'code' => 'required',
        'discount_target' => 'required',
        'description' => 'required',
        'discount_percentage' => 'required'
    ];
    public function studentdis()
    {
        return $this->belongsTo(StudentSelectDiscount::class);
    }
}
