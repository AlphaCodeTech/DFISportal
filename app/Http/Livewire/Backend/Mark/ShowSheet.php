<?php

namespace App\Http\Livewire\Backend\Mark;

use Livewire\Component;

class ShowSheet extends Component
{
    public $subjects;
    public $marks;
    public $exam;
    public $exam_record;

    public function mount()
    {
        // dd($this->subjects, $this->marks, $this->exam,$this->exam_record);
    }

    public function render()
    {
        return view('livewire.backend.mark.show-sheet');
    }
}
