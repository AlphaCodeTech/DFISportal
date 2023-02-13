<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class PublishButton extends Component
{
    public Model $model;

    public $field;

    public bool $isResultPublished;

    public function mount()
    {
        $this->isResultPublished = (bool) $this->model->getAttribute($this->field);
    }

    public function render()
    {

        return view('livewire.backend.publish-button');
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
        // dd($this->model);
    }
}
