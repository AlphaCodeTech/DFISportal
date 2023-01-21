<?php

namespace App\Http\Livewire\Backend\Student;

use App\Models\User;
use App\Models\Clazz;
use App\Models\Parents;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentComponent extends Component
{
    use WithFileUploads;

    public $photo;
    public $immunization_card;
    public $birth_certificate;
    public $user;
    public $selectedStudent;
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public User $authUser;
    public $parents;
    public $classes;


    public function mount(User $user)
    {
        $this->classes = Clazz::all();
        $this->parents = Parents::all();
        $this->authUser = $user;
        $this->selectedStudent = $this->authUser; //Please this is for error handling
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render()
    {
        if ($this->authUser->hasRole('teacher')) {
            $teacher = $this->authUser;
            $students = $teacher->students;
            return view('livewire.backend.student.student-component', compact('students'))->layout('backend.layouts.app');
        } else {
            $students = Student::with(['parent', 'class'])
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
        $this->dispatchBrowserEvent('show-form');
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
            "parent_id" => 'nullable|exists:parents,id',
            "class_id" => 'required|exists:classes,id',
            "photo" => 'nullable|file|mimes:jpg,png,jpeg',
            "birth_certificate" => 'nullable|file|mimes:jpg,png,jpeg,pdf',
            "immunization_card" => 'nullable|file|mimes:jpg,png,jpeg,pdf'
        ])->validate();


        dd($data);

        if (array_key_exists('photo', $this->state)) {
            $path = $this->photo->store('student');
            $data['photo'] = $path;
        }

        if (array_key_exists('immunization_card', $this->state)) {
            $path = $this->immunization_card->store('student');
            $data['immunization_card'] = $path;
        }

        if (array_key_exists('birth_certificate', $this->state)) {
            $path = $this->birth_certificate->store('student');
            $data['birth_certificate'] = $path;
        }

        $student = Student::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Student created successfully!']);
    }

    public function edit(Student $user)
    {
        $this->user = $user;
        $this->role = $this->user->roles->pluck('id')->toArray();
        $this->isEditing = true;
        $this->state = $user->toArray();
        unset($this->state['photo']);
        $this->photo = null;
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        if ($this->photo) {
            $this->state['photo'] = $this->photo;
        }

        if ($this->role) {
            $this->user->syncRoles(array_unique($this->role));
        }


        $data =  Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'level_id' => 'nullable|exists:levels,id',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg',
            'status' => 'required|in:1,0',
        ])->validate();

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        if (array_key_exists('photo', $this->state)) {
            $path = $this->photo->store('staff');
            $data['photo'] = $path;
        }

        $this->user->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'User created successfully!']);
    }

    public function show(Student $user)
    {
        $this->selectedStudent = $user;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this user?']);
    }

    public function destroy()
    {
        $user = Student::find($this->toBeDeleted);
        $user->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'User deleted successfully!']);
    }
}
