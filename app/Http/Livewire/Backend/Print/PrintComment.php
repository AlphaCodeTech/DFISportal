<?php

namespace App\Http\Livewire\Backend\Print;

use Livewire\Component;

class PrintComment extends Component
{
    public $exam_record;
    public $classLevel;

    public function mount()
    {
        $this->classLevel = $this->classLevel . '_fees';
    }
    public function render()
    {
        return view('livewire.backend.print.print-comment');
    }
}
