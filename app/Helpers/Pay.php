<?php

namespace App\Helpers;

use App\Models\Payment;

class Pay
{
    public static function getYears($student_id)
    {
        return Payment::where(['student_id' => $student_id])->pluck('year')->unique();
    }

    public static function genRefCode()
    {
        return date('Y') . '/' . mt_rand(10000, 999999);
    }
}
