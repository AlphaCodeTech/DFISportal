<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAcademicSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('academic.next_term', 'First term');
        $this->migrator->add('academic.term_begins', '12-12-2024');
        $this->migrator->add('academic.term_ends', '12-12-2024');
        $this->migrator->add('academic.current_session', 'Select current session');
        $this->migrator->add('academic.CR_fees', 0);
        $this->migrator->add('academic.NU_fees', 0);
        $this->migrator->add('academic.PR_fees', 0);
        $this->migrator->add('academic.JS_fees', 0);
        $this->migrator->add('academic.SS_fees', 0);
        $this->migrator->add('academic.lock_exam', false);
       
    }
}
