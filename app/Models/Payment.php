<?php

namespace App\Models;

use NumberFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory,
    SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function class()
    {
        return $this->belongsTo(Clazz::class, 'class_id');
    }

    protected function amount(): Attribute
    {
        $amount = new NumberFormatter("en_US", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn ($value) => $amount->formatCurrency($value, 'NGN'),
        );
    }

    protected function balance(): Attribute
    {
        $amount = new NumberFormatter("en_US", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn ($value) => $amount->formatCurrency($value, 'NGN'),
        );
    }
}
