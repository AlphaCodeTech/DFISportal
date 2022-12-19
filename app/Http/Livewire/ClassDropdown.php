<?php

namespace App\Http\Livewire;

use App\Models\Clazz;
use Livewire\Component;

class ClassDropdown extends Component
{
    public $classes;

    public function mount()
    {
        $this->classes = Clazz::all();
    }
    public function render()
    {
        return view('livewire.class-dropdown');
    }
}
