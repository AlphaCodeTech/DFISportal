<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\SystemSetting;
use Illuminate\Support\Facades\Validator;

class SystemComponent extends Component
{
    use WithFileUploads;

    public $logo;
    public $role = [];
    public $state = [];

    public function mount(SystemSetting $setting)
    {
        $this->state = $setting->toArray();
    }

    public function render()
    {
        return view('livewire.backend.settings.system-component')->layout('backend.layouts.app');
    }

    public function update(SystemSetting $systemSetting)
    {

        $data =  Validator::make($this->state, [
            'name' => 'required',
            'acr' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ])->validate();

        if ($this->logo) {
            $this->state['logo'] = $this->logo;

            Validator::make($this->state, [
                'logo' => 'required|image|mimes:jpg,png,gif',
            ])->validate();
            $data['logo'] =  $this->logo->store('setting');
        }

        $systemSetting->name = $data['name'];
        $systemSetting->acr = $data['acr'];
        $systemSetting->email = $data['email'];
        $systemSetting->phone = $data['phone'];
        $systemSetting->address = $data['address'];
        $systemSetting->logo = $data['logo'] ?? $this->state['logo'];

        $systemSetting->save();

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Sytem SettingU pdated Successfully!']);
    }
}
