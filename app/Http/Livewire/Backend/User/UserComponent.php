<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserComponent extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;
    public $role = [];
    public $roles;
    public $userRoles = [];
    public $selectedUser;
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];


    public function mount()
    {
        $this->selectedUser = auth()->user();
        $this->roles = Role::all();
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render()
    {
        $users = User::with('roles')->get();
        return view('livewire.backend.user.user-component', compact('users'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $this->state['photo'] = $this->photo;

        $data =  Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'level_id' => 'nullable|exists:levels,id',
            'role' => 'nullable:exists:roles,id',
            "photo" => 'required|image|mimes:jpg,png,jpeg',
            'status' => 'required|in:1,0',
        ])->validate();

        $data['password'] = Hash::make($data['password']);

        if ($this->state['photo']) {
            $path = $this->photo->store('staff');
            $data['photo'] = $path;
        }

        $user = User::create($data);

        if ($this->role) {
            $user->assignRole(($this->role));
        }

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'User created successfully!']);
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->role = $this->user->roles->pluck('id')->toArray();
        $this->isEditing = true;
        $this->state = $user->toArray();
        unset($this->state['photo']);
        $this->photo = null;
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        if ($this->photo) {
            $this->state['photo'] = $this->photo;
        }

        if ($this->role) {
            $this->user->syncRoles(array_unique($this->role));
        }

        $data =  Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'level_id' => 'nullable|exists:levels,id',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg',
            'status' => 'required|in:1,0',
        ])->validate();

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        if (array_key_exists('photo', $this->state)) {
            $path = $this->photo->store('staff');
            $data['photo'] = $path;
        }

        $this->user->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'User updated successfully!']);
    }

    public function show(User $user)
    {
        $this->selectedUser = $user;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this user?']);
    }

    public function destroy()
    {
        $user = User::find($this->toBeDeleted);
        $user->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'User deleted successfully!']);
    }
}
