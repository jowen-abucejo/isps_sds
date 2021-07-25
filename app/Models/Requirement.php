<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name',
        'status',
    ];
    
    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'requirement_scholarship', 'scholarship_id', 'requirement_id')->withTimestamps();
    }
}
