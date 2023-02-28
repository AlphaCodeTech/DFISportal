<?php

namespace App\Http\Livewire\Backend\Subject;

use App\Models\Clazz;
use App\Models\Subject;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use Illuminate\Support\Facades\Validator;

class SubjectComponent extends Component
{

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $subject;
    public $classes;
    public $filter = false;
    public $class_id;
    public Subject $selectedSubject;

    public $classSections;
    public $allClasses;
    // public $subjects;
    public $teachers;
    public $hideTeacher = false;

    protected $listeners = ['delete' => 'destroy'];

    public function mount(ClassRepository $classRepository, UserRepository $userRepository)
    {
        $this->classes = $classRepository->all();
        $this->classSections = collect();
        $this->allClasses = $classRepository->all();
        // $this->subjects = $classRepository->getAllSubjects();
        $this->teachers = $userRepository->getUserByRole('teacher');
    }

    public function render(ClassRepository $classRepository)
    {
        $subjects = $classRepository->getAllSubjects();
        return view('livewire.backend.subject.subject-component', compact('subjects'))->layout('backend.layouts.app');
    }

    public function updateSection($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $classLevel = $classRepository->find($value)->level;

        if ($classLevel->code == "JS" || $classLevel->code == "SS") {
            $this->hideTeacher = true;
        } else {
            $this->hideTeacher = false;
        }
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
            'name' => 'required|unique:subjects,name',
            'class_id' => 'nullable|exists:classes,id',
            'user_id' => 'nullable|exists:users,id',
            'short_name' => 'required|unique:subjects,short_name',
        ])->validate();

        $data['short_name'] = Str::upper($data['short_name']);

        if ($this->hideTeacher == true) {
            Subject::create($data);
        } else {
            Subject::create([
                'name' => $data['name'],
                'short_name' => $data['short_name'],
            ]);
        }
        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Subject created successfully!']);
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
