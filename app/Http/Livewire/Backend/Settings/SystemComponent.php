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
    public $state = [];
    public $sum;

    public function mount(SystemSetting $setting)
    {
        $this->state = $setting->toArray();
        $this->sum = ($this->state['first_CA'] + $this->state['second_CA'] + $this->state['exam']);
        $this->state['total'] = $this->sum;
    }

    public function render()
    {
        return view('livewire.backend.settings.system-component')->layout('backend.layouts.app');
    }

    public function updatedStateFirstCA($value)
    {
        $this->state['first_CA'] = intval($value);
        $this->sum = ($this->state['first_CA'] + $this->state['second_CA'] + $this->state['exam']);
        $this->state['total'] = $this->sum;
    }

    public function updatedStateSecondCA($value)
    {
        $this->state['second_CA'] = intval($value);
        $this->sum = ($this->state['first_CA'] + $this->state['second_CA'] + $this->state['exam']);
        $this->state['total'] = $this->sum;
    }

    public function updatedStateExam($value)
    {
        $this->state['exam'] = intval($value);
        $this->sum = ($this->state['first_CA'] + $this->state['second_CA'] + $this->state['exam']);
        $this->state['total'] = $this->sum;
    }

    public function update(SystemSetting $systemSetting)
    {

        $data =  Validator::make($this->state, [
            'name' => 'required',
            'acr' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'first_CA' => 'required|integer',
            'second_CA' => 'required|integer',
            'exam' => 'required|integer',
            'total' => 'required|integer|max:100',
        ], [
            'first_CA.required' => 'the first CA field is required',
            'first_CA.integer' => 'the first CA field must be an integer',
            'first_CA.max' => 'the first CA field must not be greater than ' . $systemSetting->first_CA,

            'second_CA.required' => 'the second CA field is required',
            'second_CA.integer' => 'the second CA field must be an integer',
            'second_CA.max' => 'the second CA field must not be greater than ' . $systemSetting->second_CA,
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
        $systemSetting->first_CA = $data['first_CA'];
        $systemSetting->second_CA = $data['second_CA'];
        $systemSetting->exam = $data['exam'];
        $systemSetting->logo = $data['logo'] ?? $this->state['logo'];

        $systemSetting->save();

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Sytem Setting Updated Successfully!']);
    }
}
