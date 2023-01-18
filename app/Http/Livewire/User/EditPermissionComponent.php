<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class EditPermissionComponent extends Component
{
    public $permissions;
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->permissions = Permission::all();
    }
    
    public function render()
    {
        return view('livewire.user.edit-permission-component');
    }

    public function updatePermission($id)
    {
        $permission = Permission::find($id);
        if ($this->user->hasDirectPermission($permission->name)) {
            $this->user->revokePermissionTo($permission->name);
            dd($permission->name);
        } else {
            $this->user->givePermissionTo($permission->name);
        }
    }
}
