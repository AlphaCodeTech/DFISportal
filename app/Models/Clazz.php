<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clazz extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'classes';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teachers()
    {
        return $this->hasManyThrough(User::class, ClassSection::class, 'user_id','id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subjects', 'class_id')->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(ClassSection::class, 'class_id');
    }
}
