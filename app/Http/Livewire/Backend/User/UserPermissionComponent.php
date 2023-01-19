<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class UserPermissionComponent extends Component
{

    public $permissions;

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function render()
    {
        return view('livewire.user.user-permission-component');
    }

}
