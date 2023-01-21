<?php

namespace App\Http\Livewire\Backend\Role;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Role $role;
    public $selectedRole;
    public $permissions;
    public $rolePermission = [];

    protected $listeners = ['delete' => 'destroy'];

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.backend.role.role-component', compact('roles'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:roles,name',
        ])->validate();

        $data['name'] = Str::lower($data['name']);

        Role::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'User created successfully!']);
    }

    public function edit(Role $role)
    {
        $this->role = $role;
        $this->rolePermission = $this->role->permissions()->pluck('id')->toArray();
        // dd($this->rolePermission);
        $this->isEditing = true;
        $this->state = $role->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        // dd($this->rolePermission);
        if ($this->rolePermission) {
            $this->role->syncPermissions(array_unique($this->rolePermission));
        }

        $data =  Validator::make($this->state, [
            'name' => 'required|unique:roles,name,'.$this->role->id,
        ])->validate();

        $data['name'] = Str::lower($data['name']);

        $this->role->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Role updated successfully!']);
    }

    public function show(Role $role)
    {
        $this->selectedRole = $role;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this role?']);
    }

    public function destroy()
    {
        $role = Role::find($this->toBeDeleted);
        $role->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Role deleted successfully!']);
    }
}
