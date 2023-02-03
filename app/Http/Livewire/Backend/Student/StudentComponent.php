<?php

namespace App\Http\Livewire\Backend\Student;

use App\Models\User;
use App\Models\Clazz;
use App\Models\Level;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Validator;

class StudentComponent extends Component
{
    use WithFileUploads;

    public $photo;
    public $immunization_card;
    public $birth_certificate;
    public $student;
    public $selectedStudent = null;
    public $selectedClass = null;
    public $selectedLevel = null;
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $promoteData = [];
    public $authUser;
    public $guardians;
    public $classes;
    public $promoteClasses;
    public $levels;
    public $sections;


    public function mount(User $user)
    {
        $this->sections = collect();
        $this->promoteClasses = collect();
        $this->levels = Level::all();
        $this->classes = Clazz::orderBy('name', 'asc')->get();
        $this->guardians = Guardian::all();
        $this->authUser = $user;
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render()
    {
        if ($this->authUser->hasRole('teacher')) {
            $teacher = User::find($this->authUser->id);
            $students = $teacher->students->where('admitted', true);
            return view('livewire.backend.student.student-component', compact('students'))->layout('backend.layouts.app');
        } else {
            $students = Student::with(['guardian', 'class'])
                ->where('admitted', true)
                ->latest()
                ->get();
            return view('livewire.backend.student.student-component', compact('students'))->layout('backend.layouts.app');
        }
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->selectedClass = null;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateSection($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->selectedClass = $value;
        $this->sections = $classRepository->getClassSections($value);
    }

    public function updateClass($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->selectedLevel = $value;
        $this->selectedClass = null;
        $this->promoteClasses = $classRepository->findLevel($value);
    }

    public function store()
    {
        if ($this->photo) {
            $this->state['photo'] = $this->photo;
        }

        if ($this->immunization_card) {
            $this->state['immunization_card'] = $this->immunization_card;
        }

        if ($this->birth_certificate) {
            $this->state['birth_certificate'] = $this->birth_certificate;
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
            "parent_id" => 'nullable|exists:gurad$guardians,id',
            "class_id" => 'required|exists:classes,id',
            "section_id" => 'required|exists:class_sections,id',
            "photo" => 'required|file|mimes:jpg,png,jpeg',
            "birth_certificate" => 'nullable|file|mimes:pdf',
            "immunization_card" => 'nullable|file|mimes:pdf'
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

        $data['admitted'] = true;

        Student::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student created successfully!']);
    }

    public function edit(Student $student)
    {
        $this->student = $student;
        $this->isEditing = true;
        $this->updateSection($student->class->id);
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
            "section_id" => 'required|exists:class_sections,id',
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
        // dd(Student::where('id', '>', $student->id)->min('id'));
        $this->selectedStudent = $student;

        $this->student = $student;

        $this->dispatchBrowserEvent('show-promote');
    }

    public function promote()
    {
        $data = Validator::make($this->promoteData, [
            'new_class_id' => 'required|exists:classes,id',
            'new_section_id' => 'required|exists:class_sections,id',
        ])->validate();

        // $this->student->class_id = $data['new_class_id'];
        // $this->student->section_id = $data['new_section_id'];
        // $this->student->save();

        $settings = App::make(AcademicSetting::class);
        $studentRepository = App::make(StudentRepository::class);

        $current_session = $settings->current_session;
        $data = [];
        $old_yr = explode('-', $current_session);
        $new_year = ++$old_yr[0] . '-' . ++$old_yr[1];
        $student = $studentRepository->getRecord(['class_id' => $this->selectedStudent->class->id, 'section_id' => $this->selectedStudent->section->id])->get()->sortBy('name');
        // dd($student);
        if ($student->count() < 1) {
            $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student Record Not Found!']);
        }


        if ($this->p === 'P') { // Promote
            $data['class_id'] = $this->selectedFromClass;
            $data['section_id'] = $this->selectedToSection;
        }

        //todo add P to the form next

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

        toast('Class Promoted Successfully', 'success');
        return redirect()->route('students.promotion');

        $this->dispatchBrowserEvent('hide-promote', ['message' => 'Student promoted successfully!']);
    }
}
