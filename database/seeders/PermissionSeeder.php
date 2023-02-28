<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Create all permissions.
         *
         * EVERYTHING HERE IS USED IN A SINGULAR SENSE
         */

        // Permissions for student
        Permission::firstOrCreate([
            'name' => 'create student',
        ]);
        Permission::firstOrCreate([
            'name' => 'read student',
        ]);
        Permission::firstOrCreate([
            'name' => 'update student',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete student',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit student',
        ]);

        // Permissions for class section
        Permission::firstOrCreate([
            'name' => 'create class section',
        ]);
        Permission::firstOrCreate([
            'name' => 'read class section',
        ]);
        Permission::firstOrCreate([
            'name' => 'update class section',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete class section',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit class section',
        ]);

        // Permissions for classroom
        Permission::firstOrCreate([
            'name' => 'create class',
        ]);
        Permission::firstOrCreate([
            'name' => 'read class',
        ]);
        Permission::firstOrCreate([
            'name' => 'update class',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete class',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit class',
        ]);

        // Permissions for session
        Permission::firstOrCreate([
            'name' => 'create session',
        ]);
        Permission::firstOrCreate([
            'name' => 'read session',
        ]);
        Permission::firstOrCreate([
            'name' => 'update session',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete session',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit session',
        ]);

        //Permission for user
        Permission::firstOrCreate([
            'name' => 'create user',
        ]);
        Permission::firstOrCreate([
            'name' => 'read user',
        ]);
        Permission::firstOrCreate([
            'name' => 'update user',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete user',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit user',
        ]);

        //Permission for guardian
        Permission::firstOrCreate([
            'name' => 'create guardian',
        ]);
        Permission::firstOrCreate([
            'name' => 'read guardian',
        ]);
        Permission::firstOrCreate([
            'name' => 'update guardian',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete guardian',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit guardian',
        ]);

        //Permission for subject
        Permission::firstOrCreate([
            'name' => 'create subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'read subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'update subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'assign subject',
        ]);

        //Permission for level
        Permission::firstOrCreate([
            'name' => 'create level',
        ]);
        Permission::firstOrCreate([
            'name' => 'read level',
        ]);
        Permission::firstOrCreate([
            'name' => 'update level',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete level',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit level',
        ]);

        //Permission for profile
        Permission::firstOrCreate([
            'name' => 'create profile',
        ]);
        Permission::firstOrCreate([
            'name' => 'read profile',
        ]);
        Permission::firstOrCreate([
            'name' => 'update profile',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete profile',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit profile',
        ]);

        //Permission for student promotions
        Permission::firstOrCreate([
            'name' => 'promote student',
        ]);
        Permission::firstOrCreate([
            'name' => 'read promotion',
        ]);
        Permission::firstOrCreate([
            'name' => 'reset promotion',
        ]);

        //permission for graduation
        Permission::firstOrCreate([
            'name' => 'graduate student',
        ]);
        Permission::firstOrCreate([
            'name' => 'view graduations',
        ]);
        Permission::firstOrCreate([
            'name' => 'reset graduation',
        ]);

        //permission for term
        Permission::firstOrCreate([
            'name' => 'create term',
        ]);
        Permission::firstOrCreate([
            'name' => 'read term',
        ]);
        Permission::firstOrCreate([
            'name' => 'update term',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete term',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit term',
        ]);

        //permission for payment
        Permission::firstOrCreate([
            'name' => 'create payment',
        ]);
        Permission::firstOrCreate([
            'name' => 'read payment',
        ]);
        Permission::firstOrCreate([
            'name' => 'update payment',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete payment',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit payment',
        ]);

        //todo permission for syllabus
        Permission::firstOrCreate([
            'name' => 'create syllabus',
        ]);
        Permission::firstOrCreate([
            'name' => 'read syllabus',
        ]);
        Permission::firstOrCreate([
            'name' => 'update syllabus',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete syllabus',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit syllabus',
        ]);

        //todo permission for timetable
        Permission::firstOrCreate([
            'name' => 'create timetable',
        ]);
        Permission::firstOrCreate([
            'name' => 'read timetable',
        ]);
        Permission::firstOrCreate([
            'name' => 'update timetable',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete timetable',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit timetable',
        ]);

        //exam permissions
        Permission::firstOrCreate([
            'name' => 'create exam',
        ]);
        Permission::firstOrCreate([
            'name' => 'read exam',
        ]);
        Permission::firstOrCreate([
            'name' => 'update exam',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete exam',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit exam',
        ]);

        //exam events
        Permission::firstOrCreate([
            'name' => 'create event',
        ]);
        Permission::firstOrCreate([
            'name' => 'read event',
        ]);
        Permission::firstOrCreate([
            'name' => 'update event',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete event',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit event',
        ]);

        //exam pin
        Permission::firstOrCreate([
            'name' => 'create pin',
        ]);
        Permission::firstOrCreate([
            'name' => 'read pin',
        ]);
        Permission::firstOrCreate([
            'name' => 'update pin',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete pin',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit pin',
        ]);

        //permission for grade system
        Permission::firstOrCreate([
            'name' => 'create grade system',
        ]);
        Permission::firstOrCreate([
            'name' => 'read grade system',
        ]);
        Permission::firstOrCreate([
            'name' => 'update grade system',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete grade system',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit grade system',
        ]);

        //permission for exam records
        Permission::firstOrCreate([
            'name' => 'create exam record',
        ]);
        Permission::firstOrCreate([
            'name' => 'read exam record',
        ]);
        Permission::firstOrCreate([
            'name' => 'update exam record',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete exam record',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit exam record',
        ]);

        //check result permission
        Permission::firstOrCreate([
            'name' => 'check result',
        ]);

        //permission for notices
        Permission::firstOrCreate([
            'name' => 'create notice',
        ]);
        Permission::firstOrCreate([
            'name' => 'read notice',
        ]);
        Permission::firstOrCreate([
            'name' => 'update notice',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete notice',
        ]);
        Permission::firstOrCreate([
            'name' => 'edit notice',
        ]);

        //permission for admission
        Permission::firstOrCreate([
            'name' => 'read admission',
        ]);
        Permission::firstOrCreate([
            'name' => 'update admission',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete admission',
        ]);
        Permission::firstOrCreate([
            'name' => 'change admission application status',
        ]);

        //header permissions (for controlling the menu headers)
        Permission::firstOrCreate([
            'name' => 'header-administrate',
        ]);
        Permission::firstOrCreate([
            'name' => 'header-academics',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-class',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-section',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-student',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-user',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-parent',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-academic-year',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-semester',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-subject',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-syllabus',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-timetable',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-exam',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-grade-system',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-notice',
        ]);
        Permission::firstOrCreate([
            'name' => 'menu-account-application',
        ]);
        /**
         * assign permissions to roles.
         */

        //assign permissions to admin
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo([
            'header-administrate',
            'header-academics',
            'menu-section',
            'menu-class',
            'menu-student',
            'menu-teacher',
            'menu-academic-year',
            'menu-subject',
            'menu-syllabus',
            'menu-timetable',
            'menu-semester',
            'menu-exam',
            'menu-grade-system',
            'menu-notice',
            'menu-parent',
            'menu-account-application',
            'manage school settings',
            'create section',
            'read section',
            'update section',
            'delete section',
            'create class',
            'read class',
            'update class',
            'delete class',
            'create class group',
            'read class group',
            'update class group',
            'delete class group',
            'create student',
            'read student',
            'update student',
            'delete student',
            'create academic year',
            'read academic year',
            'update academic year',
            'delete academic year',
            'set academic year',
            'create teacher',
            'read teacher',
            'update teacher',
            'delete teacher',
            'create subject',
            'read subject',
            'update subject',
            'delete subject',
            'promote student',
            'read promotion',
            'reset promotion',
            'graduate student',
            'view graduations',
            'reset graduation',
            'create semester',
            'read semester',
            'update semester',
            'delete semester',
            'set semester',
            'create syllabus',
            'read syllabus',
            'update syllabus',
            'delete syllabus',
            'create timetable',
            'read timetable',
            'update timetable',
            'delete timetable',
            'create custom timetable item',
            'read custom timetable item',
            'update custom timetable item',
            'delete custom timetable item',
            'create exam',
            'read exam',
            'update exam',
            'delete exam',
            'create grade system',
            'read grade system',
            'update grade system',
            'delete grade system',
            'create exam slot',
            'read exam slot',
            'update exam slot',
            'delete exam slot',
            'create exam record',
            'read exam record',
            'update exam record',
            'delete exam record',
            'create notice',
            'read notice',
            'update notice',
            'delete notice',
            'check result',
            'create parent',
            'read parent',
            'update parent',
            'delete parent',
            'read applicant',
            'update applicant',
            'delete applicant',
            'change account application status',
        ]);

        //assign permissions to teacher
        $teacher = Role::where('name', 'teacher')->first();
        $teacher->givePermissionTo([
            'header-academics',
            'menu-syllabus',
            'menu-timetable',
            'menu-exam',
            'menu-notice',
            'create syllabus',
            'read syllabus',
            'update syllabus',
            'delete syllabus',
            'create timetable',
            'read timetable',
            'update timetable',
            'delete timetable',
            'create exam record',
            'read exam record',
            'update exam record',
            'delete exam record',
            'read notice',
            'check result',
        ]);

        //assign permissions to student
        $student = Role::where('name', 'student')->first();
        $student->givePermissionTo([
            'header-academics',
            'menu-syllabus',
            'menu-timetable',
            'menu-notice',
            'menu-exam',
            'read syllabus',
            'read timetable',
            'read notice',
            'check result',
        ]);
        //assign permissions to parent
        $parent = Role::where('name', 'parent')->first();
        $parent->givePermissionTo([
            'header-academics',
            'menu-syllabus',
            'menu-timetable',
            'menu-notice',
            'menu-exam',
            'read syllabus',
            'read timetable',
            'read notice',
            'check result',
        ]);

        //assign permissions to librarian

        //assign permissions to accountant
    }
}
