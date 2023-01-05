<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $guarded  = []; 

    public function classes()
    {
        return $this->hasMany(Clazz::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Clazz::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
