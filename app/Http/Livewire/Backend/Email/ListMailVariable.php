<?php

namespace App\Http\Livewire\Backend\Email;

use Livewire\Component;
use App\Models\MailVariable;
use Livewire\WithPagination;

class ListMailVariable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $reload = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function deleteVariable($id)
    {
        MailVariable::find($id)->delete();

        $this->reload = true;
        
        $this->dispatchBrowserEvent('show-confirm', ['message', 'Mail variable deleted with success!']);
    }

    public function render()
    {
        return view('livewire.backend.email.list-mail-variable', ['allVariables' => MailVariable::paginate(10)])->layout('backend.layouts.app');
    }
}
