<?php

namespace App\Http\Livewire\Backend\Classroom;

use App\Models\Subject;
use App\Models\User;
use Livewire\Component;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class AssignClassToTeacher extends Component
{
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $classes;
    public $filter;
    public $selectedUser = null;
    public $teachers;
    public $subject;
    public $user;
    public $classIDS = [];

    protected $listeners = ['delete' => 'destroy'];

    public function mount(ClassRepository $classRepository,UserRepository $userRepository)
    {
        $this->classes = $classRepository->all();
        $this->teachers = $userRepository->getUserByRole('teacher');
    }

    public function render(UserRepository $userRepository)
    {
        $users = $userRepository->getUserByRole('teacher');
        return view('livewire.backend.classroom.assign-class-to-teacher', compact('users'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->classIDS = [];
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $data =  Validator::make($this->state, [
            'id' => 'required|exists:users,id',
        ])->validate();

        $user = User::find($data['id']);
        $user->classes()->sync($this->classIDS);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Class Assigned to Teacher successfully!']);
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->isEditing = true;
        $this->classIDS = $user->classes->pluck('id')->toArray();
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'id' => 'required|exists:users,id',
        ])->validate();

        $this->user->classes()->sync($this->classIDS);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Teacher Classes updated successfully!']);
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
        $user->classes()->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Teacher Classes deleted successfully!']);
    }
}
