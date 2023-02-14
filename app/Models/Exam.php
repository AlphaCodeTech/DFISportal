<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime:d-m-Y',
        'end_date' => 'datetime:d-m-Y',
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function marks()
    {
        return $this->HasMany(Mark::class,'exam_id');
    }

}
