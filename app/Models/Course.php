<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_courses');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
