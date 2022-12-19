<?php

namespace App\Http\Livewire;

use App\Models\Parents;
use Livewire\Component;

class ParentDropdown extends Component
{
    public $parents;

    public function mount()
    {
        $this->parents = Parents::all();
    }

    public function render()
    {
        return view('livewire.parent-dropdown');
    }
}
