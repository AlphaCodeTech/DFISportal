<?php

namespace App\Http\Livewire\Backend\Subject;

use App\Models\Clazz;
use App\Models\Subject;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class SubjectComponent extends Component
{

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $subject;
    public $classes;
    public Subject $selectedSubject;

    protected $listeners = ['delete' => 'destroy'];

    public function mount()
    {
        $this->classes = Clazz::all();
    }

    public function render()
    {
        $subjects = Subject::all();
        return view('livewire.backend.subject.subject-component', compact('subjects'))->layout('backend.layouts.app');
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
        ])->validate();

        Subject::create($data);

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
            'name' => 'required|unique:subjects,name,'.$this->subject->id,
        ])->validate();

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
