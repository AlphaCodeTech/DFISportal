<?php

namespace App\Http\Livewire\Backend;

use App\Models\Student;
use Livewire\Component;
use App\Models\Promotion;

class Select extends Component
{
    public $student;
    public $studentId;
    public $promotion;

    protected $listeners = ['validateData'];

    public function mount(Student $student)
    {
        $this->student = $student;
        $studentId = $student->id; // Replace with the actual ID of the student.

        $this->promotion = Promotion::whereHas('student', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->with(['student' => function ($query) use ($studentId) {
            $query->where('id', $studentId)
                ->latest('created_at');
        }])->first();
    }

    public function render()
    {

        return view('livewire.backend.select');
    }

    protected $rules = [
        'promotion.status' => 'required',
    ];

    public function validateData()
    {
        $this->validate();
    }
}
