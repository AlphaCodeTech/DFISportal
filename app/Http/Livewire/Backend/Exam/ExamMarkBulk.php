<?php

namespace App\Http\Livewire\Backend\Exam;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;

class ExamMarkBulk extends Component
{
    use WithFileUploads;

    public $classes;
    public bool $selected = false;
    public $students;
    public $sections;
    public $selectedClass = null;
    public $selectedSection = null;
    public $data = [];

    public function mount(
        AcademicSetting $setting,
        StudentRepository $studentRepository,
        ClassRepository $classRepository,
        $class = NULL,
        $section = NULL
    ) {
        $this->selected = false;

        if ($class && $section) {
            $this->selectedClass = $class;
            $this->selectedSection = $section;
            $this->sections = $classRepository->getAllSections()->where('class_id', $class);
            $this->students = $students = $studentRepository->getRecord(['class_id' => $class, 'section_id' => $section])->get()->sortBy('user.name');
            
            if ($students->count() < 1) {
                alert('Sorry!', __('msg.srnf'), 'error');
                return redirect()->route('marks.bulk');
            }

            $this->selected = true;
            $data['class_id'] = $class;
            $data['section_id'] = $section;
        }

        $this->classes = $classRepository->all();

        $this->data['old_year'] = $old_yr = $setting->current_session;
        $old_yr = explode('-', $old_yr);
        $this->data['new_year'] = ++$old_yr[0] . '-' . ++$old_yr[1];
    }

    public function render()
    {
        return view('livewire.backend.exam.exam-mark_bulk')->layout('backend.layouts.app');
    }

    public function updatedselectedClass($currentClass)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->sections = $classRepository->getClassSections($currentClass);
        $this->selectedSection = null;
    }

    public function bulk_select()
    {
        $this->validate([
            'selectedClass' => 'required',
            'selectedSection' => 'required',
        ], [
            'selectedClass' => 'the from class field is required',
            'selectedSection' => 'the fron section field is required',
        ]);

        return redirect()->route('marks.bulk', [$this->selectedClass, $this->selectedSection]);
    }

}
