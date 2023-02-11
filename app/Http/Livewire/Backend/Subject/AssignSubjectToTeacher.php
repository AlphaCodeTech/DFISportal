<?php

namespace App\Http\Livewire\Backend\Subject;

use App\Models\User;
use Livewire\Component;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class AssignSubjectToTeacher extends Component
{

    public $isEditing = false;
    public $toBeDeleted = null;
    public $toBeDetached = null;
    public $state = [];
    public $subjectTeacher;
    public $allClasses;
    public $filter;
    public $class_id;
    public $selectedClass = null;
    public $selectedUser = null;
    public $classSections;
    public $teachers;
    public $subjects;
    public $subject;
    public $user;
    public $subjectIDS = [];

    protected $listeners = ['delete' => 'destroy','detach' => 'detach'];

    public function mount(ClassRepository $classRepository, UserRepository $userRepository)
    {
        $this->classSections = collect();
        $this->allClasses = $classRepository->all();
        $this->subjects = $classRepository->getAllSubjects();
        $this->teachers = $userRepository->getUserByRole('teacher');
    }

    public function render(UserRepository $userRepository)
    {
        $users = $userRepository->getUserByRole('teacher');
        return view('livewire.backend.subject.assign-subject-to-teacher', compact('users'))->layout('backend.layouts.app');
    }

    public function confirmDetach($id,User $user) 
    { 
        $this->user = $user;
        $this->toBeDetached = $id;
        $this->dispatchBrowserEvent('detach-modal', ['message' => 'Are you sure you want to detach this class from the user?']);
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
            'id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
        ])->validate();

        $user = User::find($data['id']);
        $user->subjects()->syncWithPivotValues($this->subjectIDS, ['class_id' => $data['class_id']], false);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Subject Assigned to Teacher successfully!']);
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->isEditing = true;
        $this->subjectIDS = $user->subjects->pluck('id')->toArray();
        $this->state = $user->toArray();
        $this->state['class_id'] = $user->classes->pluck('id')->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
        ])->validate();

        $this->user->subjects()->syncWithPivotValues($this->subjectIDS, ['class_id' => $data['class_id'][0]], true);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Teacher Subjects updated successfully!']);
    }

    public function show(User $user)
    {
        $this->selectedUser = $user;

        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this data?']);
    }

    public function destroy()
    {
        $user = User::find($this->toBeDeleted);
        $user->subjects()->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Teacher Subjects deleted successfully!']);
    }

    public function detach()
    {
        $this->user->classes()->detach([$this->toBeDetached]);
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'User Subject detached successfully!']);
    }
}
