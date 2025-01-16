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
        'discount_percentage',
        'discount_type',
        'discount_code',
    ];

    public static $rules = [
        'code' => 'required',
        'discount_target' => 'required',
        'description' => 'required',
        'discount_percentage' => 'required',
        'discount_type' => 'required',
        'discount_code' => 'required',
    ];
    public function studentdis()
    {
        return $this->belongsTo(StudentSelectDiscount::class);
    }
    public function studentSub()
    {
        return $this->hasOne(StudentSubject::class, 'id_number', 'id_number')->orderBy('created_at', 'desc');
    }
    public function studentAss()
    {
        return $this->hasOne(studentAssesment::class, '', 'id_number')->orderBy('created_at', 'desc');
    }
}