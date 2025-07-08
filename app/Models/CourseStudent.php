<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        "course_id",
        "student_id",
        "semester_id",
        "category_id",
        "pass",
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'student_id', 'student_id');
    }
}
