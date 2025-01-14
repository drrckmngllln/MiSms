<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'level_id', 'campus_id', 'department_id', 'max_units', 'is_offered', 'is_active'
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'course_id');
    }
    public function create_accounts()
    {
        return $this->hasMany(CreateAccount::class, 'course_id', 'id');
    }
}
