<?php

namespace App\Repositories;

use App\Models\Guardian;

class GuardianRepository
{
    public function update($id, $data)
    {
        return Guardian::find($id)->update($data);
    }

    public function delete($id)
    {
        return Guardian::destroy($id);
    }

    public function create($data)
    {
        return Guardian::create($data);
    }

    public function getUserByRole($role)
    {
        return  Guardian::role($role)->orderBy('name', 'asc')->get();
    }

    public function getAllUsersWithRoles()
    {
        return Guardian::with('roles')->get();
    }

    public function getUserRolesByName($name)
    {
        return Guardian::role($name)->get();
    }


    public function find($id)
    {
        return Guardian::find($id);
    }

    public function getAll()
    {
        return Guardian::orderBy('name', 'asc')->get();
    }

    public function getPTAUsers()
    {
        return Guardian::where('user_type', '<>', 'student')->orderBy('name', 'asc')->get();
    }

   
}
