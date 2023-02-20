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

    public function promote(StudentRepository $studentRepository)
    {
        $this->validate();

        $settings = App::make(AcademicSetting::class);
        $current_session = $settings->current_session;
        $data = [];
        $old_yr = explode('-', $current_session);
        $new_year = ++$old_yr[0] . '-' . ++$old_yr[1];
        $students = $studentRepository->getRecord(['class_id' => $this->selectedClass, 'section_id' => $this->selectedSection])->get()->sortBy('name');

        if ($students->count() < 1) {
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student Record Not Found!']);
        }

        foreach ($students as $student) {
            $p = $this->P[$student->id];

            if ($p === 'P') { // Promote
                $data['class_id'] = $this->selectedNextClass;
                $data['section_id'] = $this->selectedNextSection;
            }
            if ($p === 'D') { // Don't Promote
                $data['class_id'] = $this->selectedClass;
                $data['section_id'] = $this->selectedSection;
            }
            if ($p === 'G') { // Graduated
                $data['class_id'] = $this->selectedClass;
                $data['section_id'] = $this->selectedSection;
                $data['graduated'] = 1;
                $data['status'] = 0;
                $data['graduation_date'] = $current_session;
            }

            $studentRepository->updateRecord($student->id, $data);

            // Insert New Promotion Data
            $promote['current_class'] = $this->selectedClass;
            $promote['current_section'] = $this->selectedSection;
            $promote['graduated'] = ($p === 'G') ? 1 : 0;
            $promote['next_class'] = in_array($p, ['D', 'G']) ? $this->selectedClass : $this->selectedNextClass;
            $promote['next_section'] = in_array($p, ['D', 'G']) ? $this->selectedSection : $this->selectedNextSection;
            $promote['student_id'] = $student->id;
            $promote['current_session'] = $current_session;
            $promote['next_session'] = $new_year;
            $promote['status'] = $p;

            $studentRepository->createPromotion($promote);
        }
        toast('Class Promoted Successfully', 'success');
        return redirect()->route('students.promotion');
    }
}
