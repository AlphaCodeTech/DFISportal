<?php

namespace App\Http\Livewire\Backend\Permission;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $permission;
    public Permission $selectedPermission;

    protected $listeners = ['delete' => 'destroy'];


    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.backend.permission.permission-component', compact('permissions'))->layout('backend.layouts.app');
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
            'name' => 'required|unique:permissions,name',
        ])->validate();

        $data['name'] = Str::lower($data['name']);

        Permission::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Permission created successfully!']);
    }

    public function edit(Permission $permission)
    {
        $this->permission = $permission;
        $this->isEditing = true;
        $this->state = $permission->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:roles,name,'.$this->permission->id,
        ])->validate();

        $data['name'] = Str::lower($data['name']);


        $this->permission->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Permission updated successfully!']);
    }

    public function show(Permission $permission)
    {
        $this->selectedPermission = $permission;
        // dd($this->selectedPermission->roles);
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this permission?']);
    }

    public function destroy()
    {
        $permission = Permission::find($this->toBeDeleted);
        $permission->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Role deleted successfully!']);
    }
}
