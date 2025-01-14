<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',


    ];

    public static $rules = [
        'full_name' => ['required'],

    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
