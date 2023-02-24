<?php

namespace App\Http\Livewire\Backend\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;

class StudentPromotion extends Component
{
    use WithFileUploads;

    public $currentClasses;
    public $nextClasses;
    public $currentSections;
    public $nextSections;
    public bool $selected = false;
    public $students;
    public $fromText;
    public $toText;
    public $P = [];

    public $selectedCurrentClass = null;
    public $selectedNextClass = null;
    public $selectedCurrentSection = null;
    public $selectedNextSection = null;
    public $data = [];

    public function mount(AcademicSetting $setting, StudentRepository $studentRepository, ClassRepository $classRepository, $currentClass = NULL, $currentSection = NULL, $nextClass = NULL, $nextSection = NULL)
    {

        if ($currentClass && $currentSection && $nextClass && $nextSection) {
            $this->selectedCurrentClass = $currentClass;
            $this->selectedCurrentSection = $currentSection;
            $this->selectedNextClass = $nextClass;
            $this->selectedNextSection = $nextSection;

            $this->selected = true;

            $this->fromText = $classRepository->all()->where('id', $currentClass)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $currentSection)->first()->name;

            $this->toText = $classRepository->all()->where('id', $nextClass)->first()->name . ' ' .
                $classRepository->getAllSections()->where('id', $nextSection)->first()->name;

            $this->students = $studentRepository->getRecord(['class_id' => $currentClass, 'section_id' => $currentSection])->get();
            // dd($this->students);
            if (count($this->students) < 1) {
                alert('sorry', 'No students found', 'error');
                return redirect()->route('students.promotion');
            }
            $studentIDS = $this->students->pluck('id')->toArray();

            foreach ($studentIDS as $id) {
                $this->P[$id] = 'P';
            }
        }

        $this->currentClasses = $classRepository->all();
        $this->nextClasses = $classRepository->all();
        $this->currentSections = collect();
        $this->nextSections = collect();

        $this->data['old_year'] = $old_yr = $setting->current_session;
        $old_yr = explode('-', $old_yr);
        $this->data['new_year'] = ++$old_yr[0] . '-' . ++$old_yr[1];
    }

    protected $rules = [
        'P.*' => 'required',
    ];



    public function render()
    {
        return view('livewire.backend.student.student-promotion')->layout('backend.layouts.app');
    }

    public function updatedselectedCurrentClass($currentClass)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->currentSections = $classRepository->getClassSections($currentClass);
        $this->selectedCurrentSection = null;
    }

    public function updatedselectedNextClass($nextClass)
    {
        $classRepository = App::make(ClassRepository::class);

        if (!is_null($nextClass)) {
            $this->nextSections = $classRepository->getClassSections($nextClass);
        }
    }

    public function updateP($promote, $id)
    {
        // dd($promote, $id);
        // $data = array();
        // array_push($data, $promote);
    }

    public function selector()
    {
        $this->validate([
            'selectedCurrentClass' => 'required',
            'selectedCurrentSection' => 'required',
            'selectedNextClass' => 'required',
            'selectedNextSection' => 'required',
        ], [
            'selectedCurrentClass' => 'the from class field is required',
            'selectedCurrentSection' => 'the fron section field is required',
            'selectedNextClass' => 'the to class field is required',
            'selectedNextSection' => 'the to section field is required',
        ]);

        return redirect()->route('students.promotion', [$this->selectedCurrentClass, $this->selectedCurrentSection, $this->selectedNextClass, $this->selectedNextSection]);
    }

    public function promote(StudentRepository $studentRepository)
    {
        $this->validate();
       
        $settings = App::make(AcademicSetting::class);
        $current_session = $settings->current_session;
        $data = [];
        $old_yr = explode('-', $current_session);
        $new_year = ++$old_yr[0] . '-' . ++$old_yr[1];
        $students = $studentRepository->getRecord(['class_id' => $this->selectedCurrentClass, 'section_id' => $this->selectedCurrentSection])->get()->sortBy('name');

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
                $data['class_id'] = $this->selectedCurrentClass;
                $data['section_id'] = $this->selectedCurrentSection;
            }
            if ($p === 'G') { // Graduated
                $data['class_id'] = $this->selectedCurrentClass;
                $data['section_id'] = $this->selectedCurrentSection;
                $data['graduated'] = 1;
                $data['status'] = 0;
                $data['graduation_date'] = $current_session;
            }

            $studentRepository->updateRecord($student->id, $data);

            // Insert New Promotion Data
            $promote['current_class'] = $this->selectedCurrentClass;
            $promote['current_section'] = $this->selectedCurrentSection;
            $promote['graduated'] = ($p === 'G') ? 1 : 0;
            $promote['next_class'] = in_array($p, ['D', 'G']) ? $this->selectedCurrentClass : $this->selectedNextClass;
            $promote['next_section'] = in_array($p, ['D', 'G']) ? $this->selectedCurrentSection : $this->selectedNextSection;
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
