<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'course_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'email',
        'mobile',
        'address',
    ];

    public function scholarships(){
        return $this->hasMany(ScholarshipApplication::class);
    }

    // public function course(){
    //     return $this->hasOne(Course::class);
    // }
}
