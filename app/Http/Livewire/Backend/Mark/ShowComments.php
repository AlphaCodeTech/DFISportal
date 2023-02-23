<?php

namespace App\Http\Livewire\Backend\Mark;

use Livewire\Component;

class ShowComments extends Component
{
    public $classLevel;
    public $exam_record;
    
    public function mount()
    {
        $this->classLevel = $this->classLevel.'_fees';
    }
    public function render()
    {
        return view('livewire.backend.mark.show-comments');
    }
}
