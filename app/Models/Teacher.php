<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->hasManyThrough(Clazz::class,User::class);
    }
}
