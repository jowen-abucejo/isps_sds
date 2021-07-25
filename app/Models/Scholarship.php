<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship_code',
        'description',
        'type',
        'gpa_max',
        'gpa_min',
        'lowest_grade',
        'active',        
    ];

    public function applications(){
        return $this->hasMany(ScholarshipApplication::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'requirement_scholarship', 'requirement_id', 'scholarship_id')->withTimestamps();
    }

    public function qualification(){
        return $this->hasOne(Qualification::class);
    }

}
