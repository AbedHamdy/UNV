<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        "course_id",
        "category_id",
        "level_id",
        "semester_id",
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
