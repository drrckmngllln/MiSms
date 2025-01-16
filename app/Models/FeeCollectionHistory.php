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
        'other_fees_id',
        'lab_id',
        'misc_fees_id',
        'otherFees_id',
        'year_level',
        'campus_id',
        'course_id',
        'department_id',
        'role_name_id'
    ];
    public function create_account()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function role_name()
    {
        return $this->belongsTo(User::class, 'role_name_id', 'id');
    }
}