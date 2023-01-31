<?php

namespace App\Http\Livewire\Backend\Level;

use App\Models\Fee;
use App\Models\Level;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class LevelComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $permission;
    public $fees;
    public $level;
    public $selectedLevel;

    protected $listeners = ['delete' => 'destroy'];

    public function mount()
    {
        $this->fees = Fee::all();
        $this->selectedLevel = Level::first();
    }

    public function render()
    {
        $levels = Level::all();
        return view('livewire.backend.level.level-component', compact('levels'))->layout('backend.layouts.app');
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
            'name' => 'required|unique:levels,name',
            'fee_id' => 'required|exists:fees,id',
        ])->validate();

        $words = explode(" ", $data['name']);
        $initials = null;

        if (count($words) > 1) {;
            foreach ($words as $w) {
                $initials .= $w[0];
            }
        }else{
            $initials = $words[0][0] . '' . $words[0][1];
        }

        $data['code'] = Str::upper($initials);

        Level::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Level created successfully!']);
    }

    public function edit(Level $level)
    {
        $this->level = $level;
        $this->isEditing = true;
        $this->state = $level->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:levels,name,' . $this->level->id,
            'fee_id' => 'required|exists:fees,id',
        ])->validate();

        $words = explode(" ", $data['name']);
        $initials = null;
        
        if (count($words) > 1) {;
            foreach ($words as $w) {
                $initials .= $w[0];
            }
        }else{
            $initials = $words[0][0] . '' . $words[0][1];
        }

        $data['code'] = Str::upper($initials);

        $this->level->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Level created successfully!']);
    }

    public function show(Level $level)
    {
        $this->selectedLevel = $level;
        // dd($this->selectedLevel->roles);
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this level?']);
    }

    public function destroy()
    {
        $permission = Level::find($this->toBeDeleted);
        $permission->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Level deleted successfully!']);
    }
}
