<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Sidebar
{
    public static function getTeamSA()
    {
        return ['admin', 'super_admin'];
    }

    public static function getTeamAccount()
    {
        return ['admin', 'super_admin', 'accountant'];
    }

   

    // roles that can see students link on the sidebar
    public static function getTeamStudent()
    {
        return ['super admin', 'teacher', 'developer'];
    }

    public static function getTeamSubject()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamLevel()
    {
        return ['super admin', 'developer', 'teacher'];
    }

    public static function getTeamFee()
    {
        return ['super admin', 'accountant', 'developer'];
    }

    public static function getTeamDepartment()
    {
        return ['super admin', 'developer'];
    }

    public static function getTeamClassroom()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamUser()
    {
        return ['super admin','developer','teacher'];
    }

    public static function getTeamProfile()
    {
        return auth()->check();
    }

    public static function getTeamPermission()
    {
        return ['super admin','developer'];
    }
    public static function getTeamRole()
    {
        return ['super admin','developer'];
    }
    
    public static function getTeamSession()
    {
        return ['super admin','developer'];
    }

    public static function getTeamTerm()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamExam()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamGuardian()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamEvent()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamBursary()
    {
        return ['super admin', 'developer', 'bursar', 'accountant'];
    }

    public static function getTeamAdmission()
    {
        return ['teacher', 'super admin','developer'];
    }

    public static function getTeamSetting()
    {
        return ['super admin','developer'];
    }

    public static function getTeamPin()
    {
        return ['super admin','developer'];
    }

    public static function getTeamAdministrative()
    {
        return ['admin', 'super_admin', 'accountant'];
    } 

    public static function userCanSeeStudent()
    {
        return Auth::user()->hasAnyRole(self::getTeamStudent());
    }

    public static function userCanSeeSubject()
    {
        return Auth::user()->hasAnyRole(self::getTeamSubject());
    }

    public static function userCanSeeLevel()
    {
        return Auth::user()->hasAnyRole(self::getTeamLevel());
    }

    public static function userCanSeeFee()
    {
        return Auth::user()->hasAnyRole(self::getTeamFee());
    }

    public static function userCanSeeDepartment()
    {
        return Auth::user()->hasAnyRole(self::getTeamDepartment());
    }

    public static function userCanSeeClassroom()
    {
        return Auth::user()->hasAnyRole(self::getTeamClassroom());
    }

    public static function userCanSeeUser()
    {
        return Auth::user()->hasAnyRole(self::getTeamUser());
    }

    public static function userCanSeeProfile()
    {
        return self::getTeamProfile();
    }

    public static function userCanSeePermission()
    {
        return Auth::user()->hasAnyRole(self::getTeamPermission());
    }

    public static function userCanSeeRole()
    {
        return Auth::user()->hasAnyRole(self::getTeamRole());
    }

    public static function userCanSeeSession()
    {
        return Auth::user()->hasAnyRole(self::getTeamSession());
    }

    public static function userCanSeeTerm()
    {
        return Auth::user()->hasAnyRole(self::getTeamTerm());
    }

    public static function userCanSeeExam()
    {
        return Auth::user()->hasAnyRole(self::getTeamTerm());
    }

    public static function userCanSeeGuardian()
    {
        return Auth::user()->hasAnyRole(self::getTeamGuardian());
    }

    public static function userCanSeeBursary()
    {
        return Auth::user()->hasAnyRole(self::getTeamBursary());
    }

    public static function userCanSeeAdmission()
    {
        return Auth::user()->hasAnyRole(self::getTeamAdmission());
    }

    public static function userCanSeeEvent()
    {
        return Auth::user()->hasAnyRole(self::getTeamEvent());
    }

    public static function userCanSeeSetting()
    {
        return Auth::user()->hasAnyRole(self::getTeamSetting());
    }

    public static function userCanSeePin()
    {
        return Auth::user()->hasAnyRole(self::getTeamPin());
    }


}
