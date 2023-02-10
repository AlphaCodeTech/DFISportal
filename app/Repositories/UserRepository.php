<?php

namespace App\Repositories;

use App\Models\BloodGroup;
use App\Models\StaffRecord;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository
{


    public function update($id, $data)
    {
        return User::find($id)->update($data);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function getUserByRole($role)
    {
        return  User::role($role)->orderBy('name', 'asc')->get();
    }

    public function getAllUsersWithRoles()
    {
        return User::with('roles')->get();
    }

    public function getAllRoles()
    {
        return Role::all()->pluck('name');
    }

    public function getUserRolesByName($name)
    {
        return User::role($name)->get();
    }

    public function findType($id)
    {
        return Role::find($id);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function getAll()
    {
        return User::orderBy('name', 'asc')->get();
    }

    public function getPTAUsers()
    {
        return User::where('user_type', '<>', 'student')->orderBy('name', 'asc')->get();
    }

    /********** STAFF RECORD ********/
    public function createStaffRecord($data)
    {
        return StaffRecord::create($data);
    }

    public function updateStaffRecord($where, $data)
    {
        return StaffRecord::where($where)->update($data);
    }

    /********** BLOOD GROUPS ********/
    public function getBloodGroups()
    {
        return BloodGroup::orderBy('name')->get();
    }
}
