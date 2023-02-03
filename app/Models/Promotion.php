<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fromClass()
    {
        return $this->belongsTo(Clazz::class, 'current_class');
    }

    public function fromSection()
    {
        return $this->belongsTo(ClassSection::class, 'current_section');
    }

    public function toSection()
    {
        return $this->belongsTo(ClassSection::class, 'next_section');
    }

    public function toClass()
    {
        return $this->belongsTo(Clazz::class, 'next_class');
    }
}
