<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fee_summary extends Model
{
    use HasFactory;

    public $fillable = [
        'or_number',
        'particulars',
        'id_number',
        'downpayment',
        'total_assessment',
        'cahier_in_charge',
        'name',
        'date',
        'excess',
        'downpayment2',
        'type',
        'school_year',
        'department_id',
        'role_name_id',
        'campus_id',
        'discount_type',
        'discount_code',
        'reason/remarks',
        'discount_id',
        'payment_status',
        'check_no',



    ];
    public function create_account()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }
    public function studentAssessment()
    {
        return $this->belongsTo(studentAssesment::class, 'id_number', 'id_number');
    }
    public function discount()
    {
        return $this->belongsTo(StudentSelectDiscount::class, 'discount_id');
    }
    public function fee_collection_summaries()
    {
        return $this->hasOne(FeeCollectionHistory::class, 'or_number', 'or_number');
    }
    public function nonassessed()
    {
        return $this->hasMany(nonassessed::class, 'date', 'date');
    }
    public function fee_summary()
    {
        return $this->belongsTo(fee_summary::class, 'id_number', 'id_number');
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id', 'id');
    }
    public function discount1()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
}
