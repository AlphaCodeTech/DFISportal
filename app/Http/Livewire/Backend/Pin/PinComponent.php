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

    protected $listeners = ['delete' => 'destroy'];

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


    public function confirmDelete()
    {
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete all the used Pins?']);
    }

    public function destroy()
    {
        $pinRepository = App::make(PinRepository::class);

        $pinRepository->deleteUsed();

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Pins Deleted Successfully']);

        $this->emit('refreshComponent');
    }
}
