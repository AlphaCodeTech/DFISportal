<?php

namespace App\Repositories;

use App\Models\Pin;
use Illuminate\Support\Facades\DB;

class PinRepository
{
    public function create($data)
    {
        return DB::table('pins')->insert($data);
    }

    public function countValid()
    {
        return $this->getPin(['used' => 0])->count();
    }

    public function update($id, $data)
    {
        return Pin::find($id)->update($data);
    }

    public function getUserPin($code, $user_id, $st_id)
    {
        return  $this->getPin(['code' => $code, 'user_id' => $user_id, 'student_id' => $st_id])->get();
    }

    public function findValidCode($code)
    {
        return  $this->getPin(['code' => $code, 'used' => 0])->get();
    }

    public function deleteUsed()
    {
        return $this->getPin(['used' => 1])->delete();
    }

    public function getPin($data)
    {
        return Pin::where($data);
    }

    public function getValid()
    {
        return $this->getPin(['used' => 0])->get();
    }

    public function getInValid()
    {
        return $this->getPin(['used' => 1])->with(['user', 'student'])->get();
    }

    function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
