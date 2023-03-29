<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory,
        BelongsToThrough,
        SoftDeletes;


    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
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
        return $this->belongsToThrough(Level::class, Clazz::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }


    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ', $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname);
    }

    // public function section()
    // {
    //     return $this->belongsTo(ClassSection::class);
    // }

}
