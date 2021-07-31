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
        'course_id',
        'year_level',
        'sem',
        'sy',
        'gpa',
        'lowest_grade', 
        'num_of_units',
        'has_inc',
        'has_drop',
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

    public function submitted_documents(){
        return $this->hasMany(SubmittedDocument::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
