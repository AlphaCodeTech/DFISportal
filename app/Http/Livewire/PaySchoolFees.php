<?php

namespace App\Http\Livewire;

use App\Models\Parents;
use Livewire\Component;

class PaySchoolFees extends Component
{
    public $parent;

    public function render()
    {
        return view('livewire.pay-school-fees');
    }

    public function fetchDetails($value)
    {
        $this->parent = Parents::where('phone', $value)->first();
    }
}
