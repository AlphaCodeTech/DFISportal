<?php

namespace App\Http\Livewire\Backend\Classroom;

use App\Models\Clazz;
use App\Models\Level;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class ClassroomComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $class;
    public $selectedClass;
    public $levels;
    public $teachers;

    protected $listeners = ['delete' => 'destroy'];

    public function mount()
    {
        $this->selectedClass = Clazz::first();
        $this->levels = Level::all();
        $this->teachers = User::role('teacher')->get() ?? User::all();
    }

    public function render()
    {
        $classes = Clazz::all();
        return view('livewire.backend.classroom.class-component', compact('classes'))->layout('backend.layouts.app');
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
            'name' => 'required|unique:classes,name',
            'level_id' => 'required|exists:levels,id',
            'user_id' => 'nullable|exists:users,id',
        ])->validate();

        Clazz::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Classroom created successfully!']);
    }

    public function edit(Clazz $class)
    {
        $this->class = $class;
        $this->isEditing = true;
        $this->state = $class->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:classes,name,'.$this->class->id,
            'level_id' => 'required|exists:levels,id',
            'user_id' => 'required|exists:users,id',
        ])->validate();


        $this->class->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Class updated successfully!']);
    }

    public function show(Clazz $class)
    {
        $this->selectedClass = $class;
        // dd($this->selectedClass->roles);
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this class?']);
    }

    public function destroy()
    {
        $class = Clazz::find($this->toBeDeleted);
        $class->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Classroom deleted successfully!']);
    }
}
