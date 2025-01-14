<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Files\Disk;

class StudentSelectDiscount extends Model
{
    use HasFactory;

    protected $fillable = [

        'id_number',
        'code',
        'discount_target',
        'description',
        'discount_percentage',
        'school_year',
        'semester'


    ];
    public function studentAssesment()
    {
        return $this->hasOne(studentAssesment::class);
    }
    public function discount()
    {
        return $this->hasOne(Discount::class, 'id_number', 'id_number');
    }
    public function schoolyear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
}
