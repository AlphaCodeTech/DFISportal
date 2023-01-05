<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory,
    \Znck\Eloquent\Traits\BelongsToThrough;
    

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->admno = "DFIS/SEC/" . date('Y') . '/' . rand(10000, 99999);
        });
    }

    public function class()
    {
        return $this->belongsTo(Clazz::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class,'parent_id');
    }

    public function level()
    {
        return $this->belongsToThrough(Level::class,Clazz::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }
}
