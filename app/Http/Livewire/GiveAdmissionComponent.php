<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class GiveAdmissionComponent extends Component
{
    public $student;

    public function mount(Student $student)
    {
        $this->student = $student;
    }

    public function render()
    {
        return view('livewire.give-admission-component');
    }

    public function promote()
    {
        $this->student->admitted = true;
        $this->student->save();


        return redirect()->back();
    }
}
