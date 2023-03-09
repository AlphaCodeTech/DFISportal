<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AdmissionSetting extends Settings
{
    public int $form_fee;
    public string $current_session;
    public int $is_active;

    public static function group(): string
    {
        return 'admission';
    }
}
