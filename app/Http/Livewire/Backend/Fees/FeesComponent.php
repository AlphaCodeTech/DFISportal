<?php

namespace App\Http\Livewire\Backend\Fees;

use App\Models\Fee;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class FeesComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $fee;
    public $selectedFee;

    protected $listeners = ['delete' => 'destroy'];


    public function render()
    {
        $fees = Fee::all();
        return view('livewire.backend.fees.fees-component', compact('fees'))->layout('backend.layouts.app');
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
            'amount' => 'required|numeric',
            'description' => 'required',
            'half_payment' => 'nullable|numeric',
        ])->validate();

        Fee::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Fee created successfully!']);
    }

    public function edit(Fee $fee)
    {
        $this->fee = $fee;
        $this->isEditing = true;
        $this->state = $fee->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
            'half_payment' => 'nullable|numeric',
        ])->validate();

        $this->fee->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Fee Updated successfully!']);
    }

    public function show(Fee $fee)
    {
        $this->selectedFee = $fee;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this fee?']);
    }

    public function destroy()
    {
        $permission = Fee::find($this->toBeDeleted);
        $permission->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Fee deleted successfully!']);
    }
}
