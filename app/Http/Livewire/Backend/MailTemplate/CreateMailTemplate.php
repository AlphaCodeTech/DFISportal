<?php

namespace App\Http\Livewire\Backend\MailTemplate;

use Livewire\Component;
use App\Models\MailVariable;

class CreateMailTemplate extends Component
{
    use MailTemplateFormTrait;

    public $title = "";
    public $subject = "";
    public $body = "";
    public $key = "";

    protected $listeners = ["setBody"];

    public function render()
    {
        return view('livewire.backend.mail-template.create-mail-template',['mailVariables' => MailVariable::all()])->layout('backend.layouts.app');
    }
}
