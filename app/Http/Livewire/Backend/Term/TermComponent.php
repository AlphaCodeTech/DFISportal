<?php

namespace App\Http\Livewire\Backend\Term;

use App\Models\Term;
use App\Models\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TermComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Term $term;
    public $selectedTerm;
    public $sessions;

    public function mount()
    {
        $this->sessions = Session::all();
        $this->selectedTerm = Term::first();
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render()
    {
        $terms = Term::all();
        return view('livewire.backend.term.term-component', compact('terms'))->layout('backend.layouts.app');
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
            'session_id' => [
                'required',
                Rule::unique('terms')
                    ->where(
                        fn ($query) => $query
                            ->where([
                                'session_id' => $this->state['session_id'],
                                'type' => $this->state['type']
                            ])
                    )
            ],
            'type' => ['required'],
        ], [
            'session_id.unique' => 'Term is already existing',
        ])->validate();

        Term::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Term created successfully!']);
    }

    public function edit(Term $term)
    {
        $this->term = $term;

        $this->isEditing = true;
        $this->state = $term->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'session_id' => [
                'required',
                Rule::unique('terms')
                    ->where(
                        fn ($query) => $query
                            ->where([
                                'session_id' => $this->state['session_id'],
                                'type' => $this->state['type']
                            ])
                    )->ignore($this->term->id)
            ],
            'type' => ['required'],
        ], [
            'session_id.unique' => 'Term is already existing',
        ])->validate();

        $this->term->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Term updated successfully!']);
    }

    public function show(Term $term)
    {
        $this->selectedTerm = $term;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this term?']);
    }

    public function destroy()
    {
        $term = Term::find($this->toBeDeleted);
        $term->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Term deleted successfully!']);
    }
}
