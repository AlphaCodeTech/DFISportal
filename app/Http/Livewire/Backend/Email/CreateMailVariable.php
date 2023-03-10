<?php

namespace App\Http\Livewire\Backend\Email;

use Livewire\Component;
use App\Models\MailVariable;

class CreateMailVariable extends Component
{
    public $key = "";
    public $value = "";
    public $itemId = null;

    protected $listeners = ['showCreateModal', 'showCreateModalForUpdate', 'refreshComponent' => '$refresh'];

    protected function rules()
    {
        return [
            'key' => 'required|regex:/[[A-Za-z]]/|unique:mail_variables,key' . ($this->itemId ? ',' . $this->itemId : '')
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        if (!$this->itemId) {
            $mailVariable = new MailVariable();
        } else {
            $mailVariable = MailVariable::find($this->itemId);
        }

        $mailVariable->key = $this->key;
        $mailVariable->value = $this->value;
        $mailVariable->save();

        $this->dispatchBrowserEvent('hide-email', ['message', 'Variable saved successfully!']);
        $this->emit('refreshComponent');
    }

    public function showCreateModal()
    {
        $this->reset('itemId', 'key', 'value');

        $this->resetErrorBag();

        $this->resetValidation();

        $this->itemId = null;

        $this->dispatchBrowserEvent('show-email');
    }

    public function showCreateModalForUpdate($id)
    {
        $this->reset('itemId', 'key', 'value');

        $this->resetErrorBag();

        $this->resetValidation();

        $this->itemId = $id;

        $mailVariable = MailVariable::find($id);
        $this->key = $mailVariable->key;
        $this->value = $mailVariable->value;

        $this->dispatchBrowserEvent('show-email');
    }


    public function render()
    {
        return view('livewire.backend.email.create-mail-variable')->layout('backend.layouts.app');
    }
}
