<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'semester',
        'or_number',
    ];
    public function cancelReceipt()
    {
        return $this->hasOne(CreateAccount::class, 'id_number', 'id_number');
    }
}
