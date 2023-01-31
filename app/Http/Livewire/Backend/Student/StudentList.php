<?php

namespace App\Http\Livewire\Backend\Student;

use App\Models\User;
use App\Models\Clazz;
use App\Models\Guardian;
use App\Models\Level;
use App\Models\Student;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class StudentList extends Component
{
    use WithFileUploads;

    public $photo;
    public $immunization_card;
    public $birth_certificate;
    public $student;
    public $selectedStudent;
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $promoteData = [];
    public $guardians;
    public $classes;
    public $levels;
    public $class_id;
    public $class_name;
    public $filter = false;
    public $section_id = null;


    public function mount(Clazz $class)
    {
        $this->class_id = $class->id;
        $this->class_name = $class->name;
        $this->levels = Level::all();
        $this->classes = Clazz::orderBy('name', 'asc')->get();
        $this->guardians = Guardian::all();
        $this->selectedStudent = $class; //!Please this is for error handling
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render(ClassRepository $class,StudentRepository $student)
    {
        $sections = $class->getClassSections($this->class_id);
        $students = $this->filter ? $student->findStudentsBySection($this->section_id) : $student->findStudentsByClass($this->class_id);
           
        return view('livewire.backend.student.student-list', compact('students','sections'))->layout('backend.layouts.app');
    }

    public function allStudent()
    {
        $this->filter = false;
    }

    public function reloadInfo($id)
    {
        $this->filter = true;
        $this->section_id = $id;
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function edit(Student $student)
    {
        $this->student = $student;
        $this->isEditing = true;
        $this->state = $student->toArray();
        unset($this->state['photo']);
        unset($this->state['immunization_card']);
        unset($this->state['birth_certificate']);
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        if ($this->photo) {
            $this->state['photo'] = $this->photo;
        }

        $data =  Validator::make($this->state, [
            "surname" => 'required',
            "middlename" => 'required',
            "lastname" => 'required',
            "gender" => 'required|in:male,female',
            "dob" => 'required|date',
            'admission_date' => 'required|date',
            "blood_group" => 'nullable',
            "genotype" => 'nullable',
            "allergies" => 'nullable',
            "disabilities" => 'nullable',
            "prevSchool" => 'nullable',
            "reason" => 'nullable',
            "introducer" => 'nullable',
            "status" => 'nullable',
            "driver" => 'nullable',
            "guardian_id" => 'nullable|exists:guardians,id',
            "class_id" => 'required|exists:classes,id',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg',
            "birth_certificate" => 'nullable|file|mimes:jpg,png,jpeg,pdf',
            "immunization_card" => 'nullable|file|mimes:jpg,png,jpeg,pdf'
        ])->validate();

        if (array_key_exists('photo', $this->state)) {
            $path = $this->photo->store('student');
            $data['photo'] = $path;
        }

        if (array_key_exists('immunization_card', $this->state)) {
            $card_path = $this->immunization_card->store('student');
            $data['immunization_card'] = $card_path;
        }

        if (array_key_exists('birth_certificate', $this->state)) {
            $birth_path = $this->birth_certificate->store('student');
            $data['birth_certificate'] = $birth_path;
        }

        $this->student->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student created successfully!']);
    }

    public function show(Student $student)
    {
        $this->selectedStudent = $student;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this student?']);
    }

    public function destroy()
    {
        $user = Student::find($this->toBeDeleted);
        $user->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Student deleted successfully!']);
    }

    public function viewImmunizationCard()
    {
        if ($this->selectedStudent->immunization_card == null) {
            $this->dispatchBrowserEvent('not-found', ['message' => 'This student Immunization Card have not been uploaded']);
            return;
        }

        return response()->file(public_path($this->selectedStudent->immunization_card), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; 
            filename="' . $this->selectedStudent->surname . '"'
        ]);
    }

    public function viewBirthCertificate()
    {
        if ($this->selectedStudent->birth_certificate == null) {
            $this->dispatchBrowserEvent('not-found', ['message' => 'This student Birth Certificate have not been uploaded']);
            return;
        }

        return response()->file(public_path($this->selectedStudent->birth_certificate), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; 
            filename="' . $this->selectedStudent->surname . '"'
        ]);
    }

    public function showPromote(Student $student)
    {
        $this->selectedStudent = $student;

        $this->student = $student;

        $this->dispatchBrowserEvent('show-promote');
    }

    public function promote()
    {
        $data = Validator::make($this->promoteData, [
            'new_class_id' => 'required|exists:classes,id',
        ])->validate();

        $this->student->class_id = $data['new_class_id'];
        $this->student->save();

        $this->dispatchBrowserEvent('hide-promote', ['message' => 'Student promoted successfully!']);
    }
}
