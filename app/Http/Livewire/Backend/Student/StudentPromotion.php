<?php

namespace App\Http\Livewire\Backend\Student;

use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;

class StudentPromotion extends Component
{
    use WithFileUploads;

    public $fromClasses;
    public $toClasses;
    public $fromSections;
    public $toSections;
    public bool $selected = false;
    public $students;
    public $fromText;
    public $toText;
    public $p;

    public $selectedFromClass = null;
    public $selectedToClass = null;
    public $selectedFromSection = null;
    public $selectedToSection = null;
    public $data = [];

    public function mount(AcademicSetting $setting, StudentRepository $studentRepository, ClassRepository $classRepository, $from_class = NULL, $from_section = NULL, $to_class = NULL, $to_section = NULL)
    {
        if ($from_class && $from_section && $to_class && $to_section) {
            $this->selectedFromClass = $from_class;
            $this->selectedFromSection = $from_section;
            $this->selectedToClass = $to_class;
            $this->selectedToSection = $to_section;

            $this->selected = true;

            $this->fromText = $classRepository->all()->where('id', $from_class)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $from_section)->first()->name;

            $this->toText = $classRepository->all()->where('id', $to_class)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $to_section)->first()->name;

            $this->students = $studentRepository->getRecord(['class_id' => $from_class, 'section_id' => $from_section])->get();
            if (count($this->students) < 1) {
                alert('sorry', 'No students found', 'error');
                return redirect()->route('students.promotion');
            }
        }

        $this->fromClasses = $classRepository->all();
        $this->toClasses = $classRepository->all();
        $this->fromSections = collect();
        $this->toSections = collect();

        $this->data['old_year'] = $old_yr = $setting->current_session;
        $old_yr = explode('-', $old_yr);
        $this->data['new_year'] = ++$old_yr[0] . '-' . ++$old_yr[1];
    }

    public function render()
    {
        return view('livewire.backend.student.student-promotion')->layout('backend.layouts.app');
    }

    public function updatedselectedFromClass($from_class)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->fromSections = $classRepository->getClassSections($from_class);
        $this->selectedFromSection = null;
        // dd($this->fromSections);
    }

    public function updatedselectedToClass($to_class)
    {
        $classRepository = App::make(ClassRepository::class);

        if (!is_null($to_class)) {
            $this->toSections = $classRepository->getClassSections($to_class);
        }
    }

    public function selector()
    {
        $this->validate([
            'selectedFromClass' => 'required',
            'selectedFromSection' => 'required',
            'selectedToClass' => 'required',
            'selectedToSection' => 'required',
        ], [
            'selectedFromClass' => 'the from class field is required',
            'selectedFromSection' => 'the fron section field is required',
            'selectedToClass' => 'the to class field is required',
            'selectedToSection' => 'the to section field is required',
        ]);

        return redirect()->route('students.promotion', [$this->selectedFromClass, $this->selectedFromSection, $this->selectedToClass, $this->selectedToSection]);
    }

    public function promote(StudentRepository $studentRepository)
    {
        $this->validate([
            'p' => 'required'
        ], [
            'p' => 'this field is required'
        ]);

        $settings = App::make(AcademicSetting::class);

        $current_session = $settings->current_session;
        $data = [];
        $old_yr = explode('-', $current_session);
        $new_year = ++$old_yr[0] . '-' . ++$old_yr[1];
        $students = $studentRepository->getRecord(['class_id' => $this->selectedFromClass, 'section_id' => $this->selectedFromSection])->get()->sortBy('name');

        if ($students->count() < 1) {
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student Record Not Found!']);
        }

        foreach ($students as $student) {

            if ($this->p === 'P') { // Promote
                $data['class_id'] = $this->selectedFromClass;
                $data['section_id'] = $this->selectedToSection;
            }
            if ($this->p === 'D') { // Don't Promote
                $data['class_id'] = $this->selectedFromClass;
                $data['section_id'] = $this->selectedToSection;
            }
            if ($this->p === 'G') { // Graduated
                $data['class_id'] = $this->selectedFromClass;
                $data['section_id'] = $this->selectedToSection;
                $data['graduated'] = 1;
                $data['graduation_date'] = $current_session;
            }

            $studentRepository->updateRecord($student->id, $data);

            //            Insert New Promotion Data
            $promote['from_class'] = $this->selectedFromClass;
            $promote['from_section'] = $this->selectedFromSection;
            $promote['graduated'] = ($this->p === 'G') ? 1 : 0;
            $promote['to_class'] = in_array($this->p, ['D', 'G']) ? $this->selectedFromClass : $this->selectedToClass;
            $promote['to_section'] = in_array($this->p, ['D', 'G']) ? $this->selectedFromSection : $this->selectedToSection;
            $promote['student_id'] = $student->id;
            $promote['from_session'] = $current_session;
            $promote['to_session'] = $new_year;
            $promote['status'] = $this->p;

            $studentRepository->createPromotion($promote);
        }
        toast('Class Promoted Successfully', 'success');
        return redirect()->route('students.promotion');
    }
}
