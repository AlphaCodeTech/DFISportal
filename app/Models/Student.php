<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,
    \Znck\Eloquent\Traits\BelongsToThrough,
    SoftDeletes;
    

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

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

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function level()
    {
        return $this->belongsToThrough(Level::class,Clazz::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
