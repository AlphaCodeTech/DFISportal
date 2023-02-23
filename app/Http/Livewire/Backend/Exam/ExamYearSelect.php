<?php

namespace App\Http\Livewire\Backend\Exam;

use Livewire\Component;
use Livewire\WithFileUploads;

class ExamYearSelect extends Component
{
    use WithFileUploads;

    public $data;
    public $student_id;
    public $years;

    public function mount()
    {
        $this->student_id = $this->data['student_id'];
        $this->years = $this->data['years'];
    }

    public function render()
    {
        return view('livewire.backend.exam.exam-year-select')->layout('backend.layouts.app');
    }

}
