<?php

namespace App\Http\Livewire\Backend\MailTemplate;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailMailTemplate;

class ListMailTemplate extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $reload = false;

    public function deleteTemplate($id)
    {
        EmailMailTemplate::find($id)->delete();

        $this->reload = true;

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Mail template deleted with success!']);
    }

    public function render()
    {
        return view('livewire.backend.mail-template.list-mail-template', ['allTemplates' => EmailMailTemplate::paginate(10)])->layout('backend.layouts.app');
    }
}
