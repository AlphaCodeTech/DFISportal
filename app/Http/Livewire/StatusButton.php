<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class StatusButton extends Component
{
    public Model $model;

    public $field;

    public bool $isActive;

    public function mount()
    {
        $this->isActive = (bool) $this->model->getAttribute($this->field);
    }

    public function render()
    {

        return view('livewire.status-button');
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
        // dd($this->model);
    }
}
