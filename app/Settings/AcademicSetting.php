<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AcademicSetting extends Settings
{
    public string $term_begins;
    public string $term_ends;   
    public string $current_session;
    public int $cre_fees;
    public int $nur_fees;
    public int $pri_fees;
    public int $jss_fees;
    public int $sss_fees;
    public bool $lock_exam;

    public static function group(): string
    {
        return 'academic';
    }

}