<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        "number_level",
        "category_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
