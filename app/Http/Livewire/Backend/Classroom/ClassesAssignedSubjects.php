<?php

namespace App\Http\Livewire\Backend\Classroom;

use App\Models\Clazz;
use App\Models\Subject;
use Livewire\Component;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class ClassesAssignedSubjects extends Component
{

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $selectedClass = null;
    public $teachers;
    public $subjects;
    public $clazz;
    public $subjectIDS = [];

    protected $listeners = ['delete' => 'destroy'];

    public function mount(ClassRepository $classRepository,UserRepository $userRepository)
    {
        $this->subjects = $classRepository->getAllSubjects();
        $this->teachers = $userRepository->getUserByRole('teacher');
    }

    public function render(ClassRepository $classRepository)
    {
        $classes = $classRepository->all();
        return view('livewire.backend.subject.assign-subject-to-class', compact('classes'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->subjectIDS = [];
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $data =  Validator::make($this->state, [
            'id' => 'required|exists:classes,id',
        ])->validate();

        $class = Clazz::find($data['id']);
        $class->subjects()->sync($this->subjectIDS);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Subjects Assigned to Class successfully!']);
    }

    public function edit(Clazz $clazz)
    {
        $this->clazz = $clazz;
        $this->isEditing = true;
        $this->selectedClass = $clazz;
        $this->subjectIDS = $this->clazz->subjects->pluck('id')->toArray();
        $this->state = $clazz->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'id' => 'required|exists:classes,id',
        ])->validate();


        $this->clazz->subjects()->sync($this->subjectIDS);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Class Subjects updated successfully!']);
    }

    public function show(Clazz $clazz)
    {
        $this->selectedClass = $clazz;

        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this data?']);
    }

    public function destroy()
    {
        $subject = Subject::find($this->toBeDeleted);
        $subject->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Class Subjects deleted successfully!']);
    }
}
