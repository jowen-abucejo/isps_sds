<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_desc',
        'active',
        'major',        
    ];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function applications(){
        return $this->hasMany(ScholarshipApplication::class);
    }
}
