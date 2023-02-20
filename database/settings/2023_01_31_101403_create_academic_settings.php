<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAcademicSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('academic.term_begins', '12-12-2024');
        $this->migrator->add('academic.term_ends', '12-12-2024');
        $this->migrator->add('academic.current_session', 'Select current session');
        $this->migrator->add('academic.cre_fees', 0);
        $this->migrator->add('academic.nur_fees', 0);
        $this->migrator->add('academic.pri_fees', 0);
        $this->migrator->add('academic.jss_fees', 0);
        $this->migrator->add('academic.sss_fees', 0);
        $this->migrator->add('academic.lock_exam', false);
       
    }
}
