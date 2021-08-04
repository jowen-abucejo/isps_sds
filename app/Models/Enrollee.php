<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollee extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'sy',
        'sem',
        'year_level',
        'num_of_enrollee'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
