<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship_id',
        'student_id',
        'year_level',
        'sem',
        'sy',
        'gpa',
        'lowest_grade', 
        'status',
    ];
    
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
