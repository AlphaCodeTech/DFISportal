<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AcademicSetting extends Settings
{
    public string $next_term;
    public string $term_begins;
    public string $term_ends;   
    public string $current_session;
    public int $CR_fees;
    public int $NU_fees;
    public int $PR_fees;
    public int $JS_fees;
    public int $SS_fees;
    public bool $lock_exam;

    public static function group(): string
    {
        return 'academic';
    }

}