<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Nnjeim\World\World;

class GuardianStoreComponent extends Component
{
    public $nationalities;
    public $nationality;
    public $states;
    public $state;
    public $phone;

    protected $rules = [
        'nationality' => 'required|string',
        'state'       => 'required|string',
    ];

    public function mount()
    {
        $this->nationalities = World::countries(['filters' => ['region' => "Africa"]])->data->pluck('name');

        //set nationality to null if not found
        if ($this->nationality != null && !in_array($this->nationality, $this->nationalities->toArray())) {
            $this->nationality = null;
        }
    }

    public function updatedNationality()
    {
        // $this->states = collect(World::where('name.common' , $this->nationality)->first()->hydrateStates()->states->pluck('name'));
        $this->states = collect(World::countries([
            'fields'  => 'states',
            'filters' => [
                'name' => $this->nationality,
            ],
        ])->data->pluck('states')->first());
        if ($this->states->isEmpty()) {
            $this->states = collect([['name' => $this->nationality]]);
        }
        $this->state = $this->states[0]['name'];
    }


    public function render()
    {
        return view('livewire.guardian-store-component');
    }
}
