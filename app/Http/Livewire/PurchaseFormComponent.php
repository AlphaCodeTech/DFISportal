<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class PurchaseFormComponent extends Component
{
    use WithFileUploads;

    public $guardian;
    public $phone;

    public function render()
    {
        return view('livewire.purchase-form-component');
    }
}
