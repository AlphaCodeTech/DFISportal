<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class GiveAdmissionComponent extends Component
{
    public $students;

    public function mount($students)
    {
        $this->students = $students;
    }

    public function render()
    {
        $students = $this->students;
        return view('livewire.give-admission-component',compact('students'));
    }

    public function admit($id)
    {
        $student = Student::find($id);

        $student->admitted = true;
        $student->save();

        $this->dispatchBrowserEvent('admit');
    }
}
