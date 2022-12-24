<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditRoleComponent extends Component
{
    public $permissions;
    public $role;

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->permissions = Permission::all();
    }
    
    public function render()
    {
        return view('livewire.role.edit-role-component');
    }
}
