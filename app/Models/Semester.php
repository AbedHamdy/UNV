<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        "number_semester",
        "status",
        "level_id",
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'category_courses')
            ->withPivot(['category_id', 'level_id', 'semester_id'])
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
