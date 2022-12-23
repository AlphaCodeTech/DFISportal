<?php

namespace App\Http\Livewire\Class;

use App\Models\User;
use App\Models\Clazz;
use App\Models\Level;
use Livewire\Component;

class EditClassComponent extends Component
{
    public $levels;
    public $teachers;
    public $class;

    public function mount(Clazz $class)
    {
        $this->class = $class;
        $this->levels = Level::all();
        $this->teachers = User::all();
    }

    public function render()
    {
        return view('livewire.class.edit-class-component');
    }
}
