<?php

namespace App\Http\Livewire\Class;

use App\Models\User;
use App\Models\Level;
use Livewire\Component;

class CreateClassComponent extends Component
{
    public $levels;
    public $teachers;

    public function mount()
    {
        $this->levels = Level::all();
        $this->teachers = User::role('teacher')->get();
    }
    
    public function render()
    {
        return view('livewire.class.create-class-component');
    }
}
