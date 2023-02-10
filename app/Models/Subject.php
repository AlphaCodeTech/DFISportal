<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Subject extends Model
{
    use HasFactory,
        BelongsToThrough;

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(Clazz::class, 'class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_user');
    }

    public function classes()
    {
        return $this->belongsToMany(Clazz::class, 'class_subjects')->withTimestamps();
    }
}
