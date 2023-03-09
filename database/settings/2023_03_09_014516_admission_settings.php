<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AdmissionSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('admission.form_fee', 0);
        $this->migrator->add('admission.is_active', false);
        $this->migrator->add('admission.current_session', 'Select current session');
    }
}
