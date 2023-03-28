<?php

namespace App\Models;

use NumberFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'pr_id');
    }

    protected function balance(): Attribute
    {
        $balance = new NumberFormatter("en_US", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn ($value) => $balance->formatCurrency($value, 'NGN'),
        );
    }
}
