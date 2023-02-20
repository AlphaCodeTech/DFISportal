<?php

namespace App\Http\Livewire\Backend\Pin;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Repositories\PinRepository;
use Illuminate\Support\Facades\App;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class PinComponent extends Component
{
    public $pin;
    public $user;
    public bool $isEditing = false;
    public $selectedPin;
    public $state = [];

    // public function mount(PinRepository $pinRepository, UserRepository $userRepository)
    // {
    //     $this->pin = $pinRepository;
    //     $this->user = $userRepository;
    // }

    public function render(PinRepository $pinRepository, UserRepository $userRepository)
    {
        $pin_count = $pinRepository->countValid();
        $valid_pins = $pinRepository->getValid();
        $used_pins = $pinRepository->getInValid();

        return view('livewire.backend.pin.pin-component', compact('pin_count', 'valid_pins', 'used_pins'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $pinRepository = App::make(PinRepository::class);

        if ($pinRepository->countValid() > 500) {
            toast(__('msg.pin_max'), 'error');
            return redirect()->route('pins.index');
        }

        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $pinRepository = App::make(PinRepository::class);

        $validatedData =  Validator::make($this->state, [
            'pin_count' => 'required|numeric|min:10|max:500',
        ])->validate();

        $num = $validatedData['pin_count'];
        $data = [];
        for ($i = 0; $i < $num; $i++) {
            $code = Str::random(5) . '-' . Str::random(5) . '-' . Str::random(6);
            $data[] = ['code' => Str::upper($code)];
        }

        $pinRepository->create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => __('msg.pin_create')]);
    }

    public function edit(Role $role)
    {
        $this->role = $role;
        $this->rolePermission = $this->role->permissions()->pluck('id')->toArray();

        $this->isEditing = true;
        $this->state = $role->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        if ($this->rolePermission) {
            $this->role->syncPermissions(array_unique($this->rolePermission));
        }

        $data =  Validator::make($this->state, [
            'name' => 'required|unique:roles,name,' . $this->role->id,
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
