<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function examination()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class);
    }

    public function class()
    {
        return $this->belongsTo(Clazz::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
