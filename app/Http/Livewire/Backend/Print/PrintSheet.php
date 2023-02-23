<?php

namespace App\Http\Livewire\Backend\Print;

use Livewire\Component;

class PrintSheet extends Component
{
    public $student_record;
    public $class;
    public $exam;
    public $subjects;
    public $marks;
    public $tex;
    public $exam_record;

    public function render()
    {
        return view('livewire.backend.print.print-sheet');
    }
}
