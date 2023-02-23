<?php

namespace App\Http\Livewire\Backend\Mark;

use Livewire\Component;

class ShowSheets extends Component
{
    public $subjects;
    public $marks;
    public $exam;
    public $class;
    public $exam_record;
    public $student_record;

    public function mount()
    {
        // dd($this->subjects, $this->marks, $this->exam,$this->exam_records,$this->class,$this->student_record);
    }

    public function render()
    {
        return view('livewire.backend.mark.show-sheets')->layout('backend.layouts.app');
    }
}
