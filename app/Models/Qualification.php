<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship_id',
        'gpa_max',
        'gpa_min',
        'lowest_grade',
        'minimum_units',
        'allow_drop',
        'allow_inc',
    ];

}
