<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'student_id',
        'current',
        "pass",
    ];


}
