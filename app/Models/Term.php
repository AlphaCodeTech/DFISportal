<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function term_type()
    {
        return $this->belongsTo(TermType::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }
   
}
