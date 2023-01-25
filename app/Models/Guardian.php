<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory,
    SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
