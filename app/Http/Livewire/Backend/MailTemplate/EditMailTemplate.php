<?php

namespace App\Http\Livewire\Backend\MailTemplate;

use Livewire\Component;
use App\Models\MailVariable;
use App\Models\EmailMailTemplate;

class EditMailTemplate extends Component
{
    use MailTemplateFormTrait;

    public $title = "";
    public $subject = "";
    public $body = "";
    public $key = "";
    public $itemId;

    protected $listeners = ["setBody"];

    public function mount($id)
    {
        $mailTemplate = EmailMailTemplate::find($id);

        $this->fill([
            'itemId' => $id,
            'title' => $mailTemplate->title,
            'subject' => $mailTemplate->subject,
            'body' => $mailTemplate->body,
            'key' => $mailTemplate->key
        ]);
    }
    public function render()
    {
        return view('livewire.backend.mail-template.edit-mail-template', ['mailVariables' => MailVariable::all()])->layout('backend.layouts.app');
    }
}
