<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class GraduatedButton extends Component
{
    public Model $model;

    public $field;

    public bool $isGraduated;

    public function mount()
    {
        $this->isGraduated = (bool) $this->model->getAttribute($this->field);
    }

    public function render()
    {

        return view('livewire.backend.graduated-button');
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }
}
