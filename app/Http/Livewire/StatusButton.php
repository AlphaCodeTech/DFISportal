<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class StatusButton extends Component
{
    public $student;

    public function mount(Student $student)
    {
        $this->student = $student;
    }

    public function render()
    {
        return view('livewire.status-button');
    }

    public function changeStatus($id)
    {
        dd($id);
    }
}
