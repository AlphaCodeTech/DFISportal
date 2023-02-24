<?php

namespace App\Helpers;

use App\Models\Guardian;
use Hashids\Hashids;
use App\Models\Student;
use App\Models\Subject;
use App\Settings\AcademicSetting;
use App\Settings\SystemSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class QS
{
    public static function getAppCode()
    {
        return self::getSetting('system_title') ?: 'CJ';
    }

    public static function hash($id)
    {
        $date = date('dMY') . 'DFIS';
        $hash = new Hashids($date, 14);
        return $hash->encode($id);
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
        $data = ['my_class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'year_admitted', 'house', 'age'];

        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function decodeHash($str, $toString = true)
    {
        $date = date('dMY') . 'CJ';
        $hash = new Hashids($date, 14);
        $decoded = $hash->decode($str);
        return $toString ? implode(',', $decoded) : $decoded;
    }

    public static function getPanelOptions()
    {
        return '    <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>';
    }


    public static function getTeamSAT()
    {
        return ['developer', 'super admin', 'teacher'];
    }

    public static function getTeamAccount()
    {
        return ['admin', 'super admin', 'accountant'];
    }

    public static function getTeamSA()
    {
        return ['super admin', 'developer', 'teacher'];
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

    public static function getUserType()
    {
        return Auth::user()->user_type;
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
        return in_array(Auth::user()->user_type, self::getStaff());
    }

    public static function getStaff($remove = [])
    {
        $data =  ['super_admin', 'admin', 'teacher', 'accountant', 'librarian'];
        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    public static function getAllUserTypes($remove = [])
    {
        $data =  ['super_admin', 'admin', 'teacher', 'accountant', 'librarian', 'student', 'parent'];
        return $remove ? array_values(array_diff($data, $remove)) : $data;
    }

    // Check if User is Head of Super Admins (Untouchable)
    public static function headSA(int $user_id)
    {
        return $user_id === 1;
    }

    public static function userIsPTA()
    {
        return in_array(Auth::user()->user_type, self::getPTA());
    }

    public static function userIsMyChild($student_id, $parent_id)
    {
        $data = ['id' => $student_id, 'guardian_id' => $parent_id];
        return Student::where($data)->exists();
    }

    public static function getSRByUserID($user_id)
    {
        return Student::where('user_id', $user_id)->first();
    }

    public static function getPTA()
    {
        return ['super_admin', 'admin', 'teacher', 'parent'];
    }

    /*public static function filesToUpload($programme)
    {
        return ['birth_cert', 'passport',  'neco_cert', 'waec_cert', 'ref1', 'ref2'];
    }*/

    public static function getPublicUploadPath()
    {
        return 'uploads/';
    }

    public static function getUserUploadPath()
    {
        return 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
    }

    public static function getUploadPath($user_type)
    {
        return 'uploads/' . $user_type . '/';
    }

    public static function getFileMetaData($file)
    {
        //$dataFile['name'] = $file->getClientOriginalName();
        $dataFile['ext'] = $file->getClientOriginalExtension();
        $dataFile['type'] = $file->getClientMimeType();
        $dataFile['size'] = self::formatBytes($file->getSize());
        return $dataFile;
    }

    public static function generateUserCode()
    {
        return substr(uniqid(mt_rand()), -7, 7);
    }

    public static function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
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
        return self::getSetting('system_name');
    }

    public static function findMyChildren($parent_id)
    {
        return Student::where('my_parent_id', $parent_id)->with(['user', 'my_class'])->get();
    }

    public static function findTeacherSubjects($teacher_id)
    {
        return Subject::where('teacher_id', $teacher_id)->with('my_class')->get();
    }

    public static function findStudentRecord($user_id)
    {
        return Student::where('user_id', $user_id)->first();
    }

    public static function getMarkType($class_type)
    {
        switch ($class_type) {
            case 'J':
                return 'junior';
            case 'S':
                return 'senior';
            case 'N':
                return 'nursery';
            case 'P':
                return 'primary';
            case 'PN':
                return 'pre_nursery';
            case 'C':
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
