<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSetting extends Settings
{
    public string $name;
    public string $acr;
    public string $email;
    public string $phone;
    public string $logo;
    public string $address;
    public int $first_CA;
    public int $second_CA;
    public int $exam;


    public static function group(): string
    {
        return 'system';
    }
}