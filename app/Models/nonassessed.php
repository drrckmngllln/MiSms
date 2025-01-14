<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nonassessed extends Model
{
    use HasFactory;
    public $fillable = [
        'or_number', 'particulars', 'id_number', 'amount', 'cahier_in_charge', 'name', 'date', 'excess', 'payable'
    ];

    public function create_account()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }
}
