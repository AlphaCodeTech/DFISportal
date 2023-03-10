<?php

namespace App\Http\Livewire\Backend\MailTemplate;

use App\Models\EmailMailTemplate;
use Livewire\Component;

trait MailTemplateFormTrait
{
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function rules()
    {
        return [
            'title' => 'required',
            'subject' => 'required',
            'key' => 'required|unique:email_mail_templates,key' . (isset($this->itemId) ? ',' . $this->itemId : ''),
            'body' => 'required|min:20'
        ];
    }

    public function setBody($data)
    {
        $this->body = $data;
    }

    public function submit()
    {
        $this->validate();

        if (isset($this->itemId) && $this->itemId) {
            $mailTemplate = EmailMailTemplate::find($this->itemId);
        } else {
            $mailTemplate = new EmailMailTemplate();
        }

        $mailTemplate->title = $this->title;
        $mailTemplate->subject = $this->subject;
        $mailTemplate->body = $this->body;
        $mailTemplate->key = $this->key;
        $mailTemplate->save();

        if (isset($this->itemId) && $this->itemId) {
            $this->dispatchBrowserEvent('show-confirm', ['message' => 'Mail template updated with success!']);
        } else {
            $this->dispatchBrowserEvent('show-confirm', ['message' => 'Mail template created with success!']);
        }

        return redirect()->route('email.view.template');
    }
}
