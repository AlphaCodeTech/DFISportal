<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSystemSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('system.name', 'Your School Name here');
        $this->migrator->add('system.acr', 'School Acronym here');
        $this->migrator->add('system.email', 'schoolemail@example.com');
        $this->migrator->add('system.phone', 'School Phone Number');
        $this->migrator->add('system.address', 'School Address');
        $this->migrator->add('system.logo', 'null.jpg');
    }
}
