<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class CreateRoleComponent extends Component
{
    public $permissions;

    public function mount()
    {
        $this->permissions = Permission::all();
    }
    
    public function render()
    {
        return view('livewire.role.create-role-component');
    }
}
