<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSetting extends Settings
{
    public $name;
    public $acr;
    public $email;
    public $phone;
    public $logo;
    public $address;


    public static function group(): string
    {
        return 'system';
    }
}