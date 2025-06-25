<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
