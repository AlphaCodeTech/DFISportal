<?php

namespace App\Http\Livewire\Backend\Profile;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;

class ProfileComponent extends Component
{
    use WithFileUploads;

    public $permissions;
    public $photo;
    public User $user;
    public $state = [];
    public $detail = [];
    public $selectedUser;
    public $profile;


    public function mount(User $user)
    {
        $this->profile = $user;
        $this->selectedUser = auth()->user();
        $this->permissions = Permission::all();
    }

    public function render()
    {
        $users = User::find($this->profile->id);
        return view('livewire.backend.profile.profile-component', compact('users'))->layout('backend.layouts.app');
    }


    public function edit(User $user)
    {
        $this->user = $user;
        $this->state = $user->toArray();
        unset($this->state['photo']);
        // $this->photo = null;
        $this->detail = optional($user->detail)->toArray();
        $this->dispatchBrowserEvent('edit-form');
    }

    public function update()
    {
        if ($this->photo) {
            $this->state['photo'] = $this->photo;
        }

        $user =  Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg',
        ])->validate();

        $detail =  Validator::make($this->detail, [
            'phone' => 'required|min:11',
            "gender" => 'required|in:male,female',
            "dob" => 'required|date',
            "bank" => 'required',
            "account_name" => "required",
            "account_number" => 'required|min:10',
            "religion" => 'required',
            "marital_status" => 'required',
            "blood_group" => 'required',
            "nationality" => 'required',
            "qualification" => 'required',
            "address" => 'required',
        ])->validate();

        if (array_key_exists('password', $user)) {
            $user['password'] = Hash::make($user['password']);
        }

        if (array_key_exists('photo', $this->state)) {
            $path = $this->photo->store('staff');
            $user['photo'] = $path;
        }

        $this->user->update($user);

        if ($this->user->detail === null) {
            $userInformation = new UserInformation($detail);
            $this->user->detail()->save($userInformation);
        } else {
            $this->user->detail->update($detail);
        }

        $this->dispatchBrowserEvent('hide-profile', ['message' => 'Profile updated successfully!']);
    }

    public function show(User $user)
    {
        $this->selectedUser = $user;
        // dd($this->selectedUser->getAllPermissions());
        $this->dispatchBrowserEvent('show-view');
    }
}
