<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'campus_id'
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function section()
    {
        return $this->hasMany(Section::class);
    }
    public function studentSubject()
    {
        return $this->hasMany(studentSubject::class);
    }
    public function instructor()
    {
        return $this->hasOne(instructor::class);
    }
}
