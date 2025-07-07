<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'password',
        'category_id',
    ];

    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }
}
