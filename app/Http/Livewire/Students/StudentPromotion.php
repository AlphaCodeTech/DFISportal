<?php

namespace App\Http\Livewire\Students;

use App\Models\Level;
use App\Models\Student;
use Livewire\Component;

class StudentPromotion extends Component
{
    public $student;
    public $classes;
    public $levels;
    
    public function mount(Student $student)
    {
        $this->student = $student;
        $this->classes = $student->level->classes;
        $this->levels = Level::all();
    }

    public function render()
    {
        return view('livewire.students.student-promotion');
    }

    public function updateLevel($id)
    {
        $level = Level::find($id);
        $this->classes = $level->classes;
        // dd($this->classes);
    }

    public function updateClass()
    {
        
    }
}
