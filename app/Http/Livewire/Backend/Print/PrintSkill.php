<?php

namespace App\Http\Livewire\Backend\Print;

use Livewire\Component;

class PrintSkill extends Component
{
    public $skills;
    public $exam_record;
    
    public function render()
    {
        return view('livewire.backend.print.print-skill');
    }
}
