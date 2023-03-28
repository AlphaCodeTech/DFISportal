<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function paymentRecord()
    {
        return $this->belongsTo(PaymentRecord::class, 'pr_id');
    }
}
