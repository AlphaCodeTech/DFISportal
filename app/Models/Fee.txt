<?php

namespace App\Models;

use NumberFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    protected function amount(): Attribute
    {
        $amount = new NumberFormatter("en_US", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn ($value) => $amount->formatCurrency($value, 'NGN'),
        );
    }

    protected function halfPayment(): Attribute
    {
        $amount = new NumberFormatter("en_US", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn ($value) => $amount->formatCurrency($value, 'NGN'),
        );
    }
}
