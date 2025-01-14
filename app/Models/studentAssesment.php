<?php

namespace App\Models;

use App\Http\Controllers\Backend\FeeSummaries;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentAssesment extends Model
{
    use HasFactory;
    public $fillable = [
        'id_number',
        'school_year',
        'fee_type',
        'category',
        'amount',
        'lecture_units',
        'computation',
        'downpayment',
        'prelims',
        'midterms',
        'semi_finals',
        'finals',
        'total_assessment',
        'total_miscfee_first_year',
        'total_miscfee_second_year',
        'total_miscfee_third_year',
        'total_miscfees_fourth_year',
        'discount_id',
        'sdownpayment',
        'sprelims',
        'smidterms',
        'ssemi_finals',
        'sfinals',
        'stotal_assessment',
        'semester',
        'computation2Tuition',
        'course_id',
        'year_level',
        'campus_id',
        'tutionFees',
        'tutionFeesDeleteSub',
        'totalAss',
        'or_number',
        'lab_id',
        'miscfee_id',
        'otherFees_id'


    ];
    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
    public function create_account()
    {
        return $this->hasOne(CreateAccount::class);
    }
    public function studentDiscount()
    {
        return $this->belongsTo(StudentSelectDiscount::class);
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
    public function createAccount()
    {
        return $this->belongsTo(CreateAccount::class);
    }
    public function feeSummaries()
    {
        return $this->belongsTo(fee_summary::class, 'id_number', 'id_number');
    }
    public function feeSummariess()
    {
        return $this->hasOne(fee_summary::class, 'id_number', 'id_number');
    }
    public function studentSubject()
    {
        return $this->hasOne(studentSubject::class, 'id_number', 'id_number');
    }
    public function selectDiscount()
    {
        return $this->belongsTo(StudentSelectDiscount::class, 'select_discount_id', 'id');
    }
    public function sy()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year', 'id');
    }
    public function laboratory()
    {
        return $this->belongsTo(laboratoryModel::class, 'lab_id', 'id');
    }
}