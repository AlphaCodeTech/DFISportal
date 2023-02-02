<?php

namespace App\Http\Livewire\Backend\Student;

use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

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

    public $selectedFromClasses = null;
    public $selectedToClasses = null;
    public $selectedFromSections = null;
    public $selectedToSections = null;
    public $d = [];

    public function mount(AcademicSetting $setting, StudentRepository $studentRepository, ClassRepository $classRepository, $from_class = NULL, $from_section = NULL, $to_class = NULL, $to_section = NULL)
    {
        if ($from_class && $from_section && $to_class && $to_section) {
            $this->selectedFromClasses = $from_class;
            $this->selectedFromSections = $from_section;
            $this->selectedToClasses = $to_class;
            $this->selectedToSections = $to_section;

            $this->selected = true;

            $this->fromText = $classRepository->all()->where('id', $from_class)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $from_section)->first()->name;

            $this->toText = $classRepository->all()->where('id', $to_class)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $to_section)->first()->name;

            $this->students = $studentRepository->getRecord(['class_id' => $from_class, 'section_id' => $from_section])->get();
        }

        $this->fromClasses = $classRepository->all();
        $this->toClasses = $classRepository->all();
        $this->fromSections = collect();
        $this->toSections = collect();

        $this->d['old_year'] = $old_yr = $setting->current_session;
        $old_yr = explode('-', $old_yr);
        $this->d['new_year'] = ++$old_yr[0] . '-' . ++$old_yr[1];
    }

    public function render()
    {
        return view('livewire.backend.student.student-promotion')->layout('backend.layouts.app');
    }

    public function updatedselectedFromClasses($from_class)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->fromSections = $classRepository->getClassSections($from_class);
        $this->selectedFromSections = null;
    }

    public function updatedselectedToClasses($to_class)
    {
        $classRepository = App::make(ClassRepository::class);

        if (!is_null($to_class)) {
            $this->toSections = $classRepository->getClassSections($to_class);
        }
    }

    public function selector()
    {
        $this->validate([
            'selectedFromClasses' => 'required',
            'selectedFromSections' => 'required',
            'selectedToClasses' => 'required',
            'selectedToSections' => 'required',
        ], [
            'selectedFromClasses' => 'the from class field is required',
            'selectedFromSections' => 'the fron section field is required',
            'selectedToClasses' => 'the to class field is required',
            'selectedToSections' => 'the to section field is required',
        ]);

        return redirect()->route('students.promotion', [$this->selectedFromClasses, $this->selectedFromSections, $this->selectedToClasses, $this->selectedToSections]);
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
        // $old_yr = explode('-', $current_session);
        // $new_year = ++$old_yr[0] . '-' . ++$old_yr[1];
        $students = $studentRepository->getRecord(['class_id' => $this->selectedFromClasses, 'section_id' => $this->selectedFromSections])->get()->sortBy('name');

        if ($students->count() < 1) {
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student Record Not Found!']);
        }

        foreach ($students as $student) {

            if ($this->p === 'P') { // Promote
                $data['class_id'] = $this->selectedFromClasses;
                $data['section_id'] = $this->selectedToSections;
            }
            if ($this->p === 'D') { // Don't Promote
                $data['class_id'] = $this->selectedFromClasses;
                $data['section_id'] = $this->selectedToSections;
            }
            if ($this->p === 'G') { // Graduated
                $data['class_id'] = $this->selectedFromClasses;
                $data['section_id'] = $this->selectedToSections;
                $data['graduated'] = 1;
                $data['graduation_date'] = $current_session;
            }

            $studentRepository->updateRecord($student->id, $data);

            //            Insert New Promotion Data
            $promote['from_class'] = $from_class;
            $promote['from_section'] = $from_section;
            $promote['grad'] = ($p === 'G') ? 1 : 0;
            $promote['to_class'] = in_array($p, ['D', 'G']) ? $from_class : $to_class;
            $promote['to_section'] = in_array($p, ['D', 'G']) ? $from_section : $to_section;
            $promote['student_id'] = $student->user_id;
            $promote['from_session'] = $oy;
            $promote['to_session'] = $ny;
            $promote['status'] = $this->p;

            $this->student->createPromotion($promote);
        }
        return redirect()->route('students.promotion')->with('flash_success', __('msg.update_ok'));
    }
}
