<?php

namespace App\Http\Livewire\Backend\Guardian;

use Livewire\Component;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuardianComponent extends Component
{
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $guardian;
    public $selectedGuardian;
    public $selectedStudent;

    protected $listeners = ['delete' => 'destroy'];


    public function mount()
    {
        $this->selectedStudent = collect()->first();
    }

    public function render()
    {
        $guardians = Guardian::all();
        
        return view('livewire.backend.guardian.guardian-component', compact('guardians'))->layout('backend.layouts.app');
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
            'name' => 'required',
            'email' => 'required|email|unique:guardians,email',
            'phone' => 'required|unique:guardians,phone',
            'relationship' => 'required',
            'password' => 'required|min:8'
        ])->validate();

        $data['password'] = Hash::make($data['password']);

        Guardian::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Guardian created successfully!']);
    }

    public function edit(Guardian $guardian)
    {
        $this->guardian = $guardian;
        $this->isEditing = true;
        $this->state = $guardian->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:guardians,email,' . $this->guardian->id,
            'phone' => 'required|unique:guardians,phone,' . $this->guardian->id,
            'relationship' => 'required',
            'password' => 'sometimes|min:8'
        ])->validate();

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        $this->guardian->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Guardian updated successfully!']);
    }

    public function show(Guardian $guardian)
    {
        $this->selectedGuardian = $guardian;

        $this->dispatchBrowserEvent('show-view');
    }

    public function showStudent(Student $student)
    {
        $this->selectedStudent = $student;
        // dd($this->selectedStudent);
        $this->dispatchBrowserEvent('show-student');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this guardian?']);
    }

    public function destroy()
    {
        $guardian = Guardian::find($this->toBeDeleted);
        $guardian->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Guardian deleted successfully!']);
    }

    public function viewIDCard()
    {
        if ($this->selectedGuardian->id_card == null) {
            $this->dispatchBrowserEvent('not-found', ['message' => 'This Guardian ID Card have not been uploaded']);
            return;
        }

        return response()->file(public_path($this->selectedGuardian->id_card), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; 
            filename="' . $this->selectedGuardian->name . '"'
        ]);
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
}
