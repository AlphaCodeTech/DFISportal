<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AcademicSetting extends Settings
{
    public string $term_begins;
    public string $term_ends;   
    public string $current_session;
    public bool $lock_exam;

    public static function group(): string
    {
        return 'academic';
    }

}