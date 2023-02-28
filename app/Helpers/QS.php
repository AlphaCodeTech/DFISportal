<?php

namespace App\Helpers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Guardian;
use App\Models\TeamSetting;
use App\Settings\SystemSetting;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class QS
{
    public static function getAppCode()
    {
        return self::getAppSetting('acr') ?: 'DFIS';
    }

    public static function getUserRecord($remove = [])
    {
        $data = ['name', 'email', 'phone', 'phone2', 'dob', 'gender', 'address', 'bg_id', 'nal_id', 'state_id', 'lga_id'];

        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function getStaffRecord($remove = [])
    {
        $data = ['emp_date',];

        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function getStudentData($remove = [])
    {
        $data = ['class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'year_admitted', 'house', 'age'];

        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function getTeamSAT()
    {
        $setting = Cache::remember('TeamSAT', 500, function () {
            return json_decode(TeamSetting::where('name', 'TeamSAT')->pluck('roles')->first()) ?? [];
        });

        return $setting;
    }

    public static function getTeamAccount()
    {
        $setting = Cache::remember('TeamAccount', 500, function () {
            return json_decode(TeamSetting::where('name', 'TeamAccount')->pluck('roles')->first()) ?? [];
        });

        return $setting;
    }

    public static function getTeamSA()
    {
        $setting = Cache::remember('TeamSA', 500, function () {
            return json_decode(TeamSetting::where('name', 'TeamSA')->pluck('roles')->first()) ?? [];
        });

        return $setting;
    }

    public static function getTeamAdministrative()
    {
        $setting = Cache::remember('TeamAdministrative', 500, function () {
            return json_decode(TeamSetting::where('name', 'TeamAdministrative')->pluck('roles')->first()) ?? [];
        });

        return $setting;
    }

    public static function userIsAdmin()
    {
        return Auth::user()->hasRole('admin');
    }

    public static function userIsTeamSAT()
    {
        return Auth::user()->hasAnyRole(self::getTeamSAT());
    }

    public static function userIsTeamSA()
    {
        return Auth::user()->hasAnyRole(self::getTeamSA());
    }

    public static function userIsAdministrative()
    {
        return Auth::user()->hasAnyRole(self::getTeamAdministrative());
    }

    public static function userIsProfileOwner()
    {
        return auth()->check();
    }

    public static function getUserType()
    {
        return Auth::user()->roles->pluck('name')[0] ?? '';
    }

    public static function userIsSuperAdmin()
    {
        return Auth::user()->hasRole('super admin');
    }

    public static function userIsStudent()
    {
        return Auth::user() instanceof Student;
    }

    public static function userIsTeacher()
    {
        return Auth::user()->hasRole('teacher');
    }

    public static function userIsParent()
    {
        return Auth::user() instanceof Guardian;
    }


    public static function userIsTeamAccount()
    {
        return Auth::user()->hasAnyRole(self::getTeamAccount());
    }


    public static function userIsStaff()
    {
        return Auth::user()->hasAnyRole(self::getStaff());
    }

    public static function getStaff($remove = [])
    {
        $data =  ['super admin', 'admin', 'teacher', 'accountant', 'librarian'];
        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function getAllUserTypes($remove = [])
    {
        $data =  ['super admin', 'admin', 'teacher', 'accountant', 'librarian', 'student', 'parent'];
        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    // Check if User is Head of Super Admins (Untouchable)
    public static function headSA(int $role)
    {
        return $role === 'super admin';
    }

    public static function userIsPTA()
    {
        return Auth::user()->hasAnyRole(self::getPTA());
    }

    public static function userIsMyChild($student_id, $parent_id)
    {
        $data = ['id' => $student_id, 'guardian_id' => $parent_id];
        return Student::where($data)->exists();
    }

    public static function getSRByUserID($user_id)
    {
        return Student::where('id', $user_id)->first();
    }

    public static function getPTA()
    {
        return ['super admin', 'admin', 'teacher', 'parent'];
    }

    public static function getSetting($type)
    {
        $academicSetting = App::make(AcademicSetting::class);
        return $academicSetting->$type;
    }
    public static function getAppSetting($type)
    {
        $systemSetting = App::make(SystemSetting::class);
        return $systemSetting->$type;
    }

    public static function getCurrentSession()
    {
        return self::getSetting('current_session');
    }

    public static function getNextSession()
    {
        $oy = self::getCurrentSession();
        $old_yr = explode('-', $oy);
        return ++$old_yr[0] . '-' . ++$old_yr[1];
    }

    public static function getSystemName()
    {
        return self::getSetting('name');
    }

    public static function findMyChildren($parent_id)
    {
        return Student::where('guardian_id', $parent_id)->with(['class'])->get();
    }

    public static function findTeacherSubjects($teacher_id)
    {
        return Subject::where('teacher_id', $teacher_id)->with('classes')->get();
    }

    public static function findStudentRecord($user_id)
    {
        return Student::where('id', $user_id)->first();
    }

    public static function getMarkType($class_type)
    {
        switch ($class_type) {
            case 'JS':
                return 'junior';
            case 'SS':
                return 'senior';
            case 'NU':
                return 'nursery';
            case 'PR':
                return 'primary';
            case 'PN':
                return 'pre_nursery';
            case 'CR':
                return 'creche';
        }
        return $class_type;
    }

    public static function json($msg, $ok = TRUE, $arr = [])
    {
        return $arr ? response()->json($arr) : response()->json(['ok' => $ok, 'msg' => $msg]);
    }

    public static function jsonStoreOk()
    {
        return self::json(__('msg.store_ok'));
    }

    public static function jsonUpdateOk()
    {
        return self::json(__('msg.update_ok'));
    }

    public static function storeOk($routeName)
    {
        return self::goWithSuccess($routeName, __('msg.store_ok'));
    }

    public static function deleteOk($routeName)
    {
        return self::goWithSuccess($routeName, __('msg.del_ok'));
    }

    public static function updateOk($routeName)
    {
        return self::goWithSuccess($routeName, __('msg.update_ok'));
    }

    public static function goToRoute($goto, $status = 302, $headers = [], $secure = null)
    {
        $data = [];
        $to = (is_array($goto) ? $goto[0] : $goto) ?: 'admin';
        if (is_array($goto)) {
            array_shift($goto);
            $data = $goto;
        }
        return app('redirect')->to(route($to, $data), $status, $headers, $secure);
    }

    public static function goWithDanger($to = 'dashboard', $msg = NULL)
    {
        $msg = $msg ? $msg : __('msg.rnf');

        toast($msg, 'error');

        return self::goToRoute($to);
    }

    public static function goWithSuccess($to, $msg)
    {
        return self::goToRoute($to)->with('flash_success', $msg);
    }

    public static function getDaysOfTheWeek()
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }
}
