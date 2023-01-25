<?php

namespace App\Http\Livewire\Backend\Session;

use App\Models\Session;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class SessionComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Session $session;
    public $selectedSession;

    protected $listeners = ['delete' => 'destroy'];

    public function render()
    {
        $sessions = Session::all();
        return view('livewire.backend.session.session-component', compact('sessions'))->layout('backend.layouts.app');
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
            'name' => 'required|unique:sessions,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ])->validate();

        Session::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Academic Session created successfully!']);
    }

    public function edit(Session $session)
    {
        $this->session = $session;

        $this->isEditing = true;
        $this->state = $session->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:sessions,name,' . $this->session->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ])->validate();

        $this->session->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Academic Session updated successfully!']);
    }

    public function show(Session $session)
    {
        $this->selectedSession = $session;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this session?']);
    }

    public function destroy()
    {
        $session = Session::find($this->toBeDeleted);
        $session->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Academic Session deleted successfully!']);
    }
}
