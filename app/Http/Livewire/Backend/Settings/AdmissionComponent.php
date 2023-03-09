<?php

namespace App\Http\Livewire\Backend\Settings;

use App\Models\Session;
use App\Models\Term;
use Livewire\Component;
use App\Settings\AdmissionSetting;
use Illuminate\Support\Facades\Validator;

class AdmissionComponent extends Component
{
    public $state = [];
    public $sections;

    public function mount(AdmissionSetting $setting)
    {
        $this->state = $setting->toArray();
        $this->sections = Session::all();
        
    }

    public function render()
    {
        return view('livewire.backend.settings.admission-component')->layout('backend.layouts.app');
    }

    public function update(AdmissionSetting $admissionSetting)
    {
        $data =  Validator::make($this->state, [
            'form_fee' => 'required',
            'is_active' => 'required',
            'current_session' => 'required',
        ])->validate();

        $admissionSetting->form_fee = $data['form_fee'];
        $admissionSetting->is_active = $data['is_active'];
        $admissionSetting->current_session = $data['current_session'];

        $admissionSetting->save();

        $this->emit('componentRefresh');
        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Admission Setting Updated Successfully!']);
    }
}
