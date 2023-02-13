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

    // public function teachers()
    // {
    //     return $this->belongsToMany(User::class, 'subject_user');
    // }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_subject_user')
            ->withPivot('class_id');
    }

    public function teacher()
    {
        $teacher = $this->loadMissing('teachers')->teachers->map(function ($teacher) {
            return $teacher;
        });

        return $teacher;
    }

    public function classes()
    {
        return $this->belongsToMany(Clazz::class, 'class_subject_user', 'user_id', 'class_id')->withPivot('user_id');
    }
}
