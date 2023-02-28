<?php

namespace App\Http\Livewire\Backend\Settings;

use App\Models\TeamSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class TeamComponent extends Component
{
    public $roles;
    public $teams = [];
    public $rolesInTeam = [];
    public $state = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->teams = [
            'TeamSA', //Includes Super-admin/Admin
            'TeamSAT', //Includes Super-admin/Admin/Teacher
            'TeamAccount', //Includes Account bodies
            'TeamAdministrative', //Includes Administrative bodies
        ];
    }

    public function render()
    {
        $settings = TeamSetting::all();

        return view('livewire.backend.settings.team-component', compact('settings'))->layout('backend.layouts.app');
    }

    public function updatedStateName($value)
    {
        $this->rolesInTeam = json_decode(TeamSetting::where('name', $value)->pluck('roles')->first()) ?? [];

    }

    public function update()
    {
        $this->state['roles'] = $this->rolesInTeam;

        $data = Validator::make($this->state, [
            'name' => 'required',
            'roles' => 'required',
        ])->validate();

        $setting = TeamSetting::where('name', $this->state['name'])->first();
        if ($setting) {
            $update = Validator::make($this->state, [
                'roles' => 'required',
            ])->validate();

            $setting->roles = $update['roles'];
            $setting->save();
            Cache::forget($data['name']);

            $this->emit('refreshComponent');
            $this->dispatchBrowserEvent('show-confirm', ['message' => 'Team Updated Successfully']);
        } else {
            TeamSetting::create($data);
            Cache::forget($data['name']);

            $this->emit('refreshComponent');
            $this->dispatchBrowserEvent('show-confirm', ['message' => 'Team Created Successfully']);
        }
    }
}
