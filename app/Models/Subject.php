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

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_subject_user', 'subject_id', 'user_id')
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
        return $this->belongsToMany(Clazz::class, 'class_subject_user', 'subject_id', 'class_id')->withPivot('user_id');
    }
}
