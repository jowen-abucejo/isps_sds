<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'requirement_id',
        'scholarship_application_id',
        'filename',
        'comments',
        'status',
    ];

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function scholarship_application()
    {
        return $this->belongsTo(ScholarshipApplication::class);
    }
}
