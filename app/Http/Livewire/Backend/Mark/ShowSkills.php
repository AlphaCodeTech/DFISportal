<?php

namespace App\Http\Livewire\Backend\Mark;

use Livewire\Component;

class ShowSkills extends Component
{
    public $skills;
    public $exam_record;

    public function mount()
    {
        // dd($this->skills);
    }
    public function render()
    {
        return view('livewire.backend.mark.show-skills');
    }
}
