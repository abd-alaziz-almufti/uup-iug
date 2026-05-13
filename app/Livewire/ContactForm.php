<?php

namespace App\Livewire;

use App\Models\ContactInquiry;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email',
        'subject' => 'required|string|min:5',
        'message' => 'required|string|min:10',
    ];

    protected $messages = [
        'name.required' => 'يرجى إدخال الاسم',
        'email.required' => 'يرجى إدخال البريد الإلكتروني',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
        'subject.required' => 'يرجى إدخال عنوان الرسالة',
        'message.required' => 'يرجى إدخال نص الرسالة',
        'message.min' => 'يجب أن تكون الرسالة 10 أحرف على الأقل',
    ];

    public function submit()
    {
        $this->validate();

        ContactInquiry::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);

        session()->flash('success', 'تم إرسال رسالتك بنجاح! سنقوم بالرد عليك في أقرب وقت.');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
