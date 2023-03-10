<?php

namespace App\Http\Livewire\Backend\MailTemplate;

use App\Mail\SendMail;
use Livewire\Component;
use App\Models\EmailMailTemplate;
use Illuminate\Support\Facades\Mail;

class SendMailTemplate extends Component
{
    public $showModal = false;
    public $templateId;
    public $email = "";

    protected $listeners = ['showSendModal'];

    public function submit()
    {
        $mailTemplate = EmailMailTemplate::find($this->templateId);

        Mail::to($this->email)->send(new SendMail($mailTemplate->subject, $mailTemplate->body));
        
        $this->dispatchBrowserEvent('show-confirm', ['success' => 'Check your inbox for test message']);
    }

    public function showSendModal($id)
    {
        $this->templateId = $id;
        $this->dispatchBrowserEvent('show-email');
    }

    public function render()
    {
        return view('livewire.backend.mail-template.send-mail-template')->layout('backend.layouts.app');
    }
}
