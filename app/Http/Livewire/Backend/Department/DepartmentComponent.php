<?php

namespace App\Http\Livewire\Backend\Department;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class DepartmentComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Department $department;
    public $selectedDepartment;

    protected $listeners = ['delete' => 'destroy'];


    public function render()
    {
        $departments = Department::all();
        return view('livewire.backend.department.department-component', compact('departments'))->layout('backend.layouts.app');
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
            'name' => 'required|unique:departments,name',
        ])->validate();

        Department::create($data);
        
        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Department created successfully!']);
    }

    public function edit(Department $department)
    {
        $this->department = $department;

        $this->isEditing = true;
        $this->state = $department->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:departments,name,'.$this->department->id,
        ])->validate();

        $this->department->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Department updated successfully!']);
    }

    public function show(Department $department)
    {
        $this->selectedDepartment = $department;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this department?']);
    }

    public function destroy()
    {
        $department = Department::find($this->toBeDeleted);
        $department->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Department deleted successfully!']);
    }
}
