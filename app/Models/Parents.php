<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Model
{
    use HasFactory,
    SoftDeletes;

    protected $table = 'parents';

    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(Student::class,'parent_id');
    }
}
