<?php

namespace App\Http\Livewire;

use App\Models\Parents;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class PurchaseFormComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $residential_address;
    public $state;
    public $lga;
    public $religion;
    public $nationality;
    public $occupation;
    public $business_address;
    public $relationship;
    public $family_history;
    public $id_card;

    public $enabled = false;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:parents,email',
        'phone' => 'required',
        'residential_address' => 'required',
        'state' => 'required',
        'lga' => 'required',
        'religion' => 'required',
        'nationality' => 'required',
        'occupation' => 'required',
        'business_address' => 'required',
        'relationship' => 'required',
        'family_history' => 'required',
        'id_card' => 'required|file|mimes:pdf,doc',
    ];

    public function render()
    {
        return view('livewire.purchase-form-component');
    }

    public function saveParent()
    {
        $this->validate();

        $path = $this->id_card->store('parent');

        $parent = Parents::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'residential_address' => $this->residential_address,
            'state' => $this->state,
            'lga' => $this->lga,
            'password' => Hash::make($this->phone),
            'religion' => $this->religion,
            'nationality' => $this->nationality,
            'occupation' => $this->occupation,
            'business_address' => $this->business_address,
            'relationship' => $this->relationship,
            'family_history' => $this->family_history,
            'id_card' => $this->id_card,
        ]);
        $this->enabled = true;

        if ($parent) {
            toast('Parent Created Successfully', 'success');
            return redirect()->route('form.purchase',['enabled' => $this->enabled]);
        }
    }
}
