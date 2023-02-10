<?php

namespace App\Http\Livewire\Backend\Subject;

use App\Models\Clazz;
use App\Models\Subject;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class AssignSubjectToTeacher extends Component
{

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $subjectTeacher;
    public $allClasses;
    public $filter;
    public $class_id;
    public $selectedClass = null;
    public $selectedSubject = null;
    public $classSections;
    public $teachers;
    public $subjects;
    public $subject;

    protected $listeners = ['delete' => 'destroy'];

    public function mount(ClassRepository $classRepository,UserRepository $userRepository)
    {
        $this->classSections = collect();
        $this->allClasses = $classRepository->all();
        $this->subjects = $classRepository->getAllSubjects();
        $this->teachers = $userRepository->getUserByRole('teacher');
    }

    public function render(ClassRepository $classRepository)
    {
        $classSubjects = $this->filter ? Clazz::find($this->class_id)->subjects : $classRepository->getAllSubjects();
        return view('livewire.backend.subject.assign-subject-to-teacher', compact('classSubjects'))->layout('backend.layouts.app');
    }

    public function updateSection($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->selectedClass = $value;
        $this->classSections = $classRepository->getClassSections($value);
    }

    public function allClasses()
    {
        $this->filter = false;
    }

    public function reloadInfo($id)
    {
        $this->filter = true;
        $this->class_id = $id;
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $data =  Validator::make($this->state, [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ])->validate();

        $subject = Subject::find($data['subject_id']);
        $subject->teachers()->sync($data['user_id']);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Subject Assigned to Teacher successfully!']);
    }

    public function edit(Subject $subject)
    {
        $this->subject = $subject;
        $this->isEditing = true;
        $this->state = $subject->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:subjects,name,' . $this->subject->id,
            'short_name' => 'required|unique:subjects,short_name',
        ])->validate();

        $data['short_name'] = Str::upper($data['short_name']);

        $this->subject->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Subject updated successfully!']);
    }

    public function show(Subject $subject)
    {
        $this->selectedSubject = $subject;

        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this subject?']);
    }

    public function destroy()
    {
        $subject = Subject::find($this->toBeDeleted);
        $subject->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Subject deleted successfully!']);
    }
}
