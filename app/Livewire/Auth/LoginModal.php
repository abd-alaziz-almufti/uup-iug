<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginModal extends Component
{
    public $username = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // نتحقق إذا كان الإدخال عبارة عن إيميل، وإلا نعتبره "email" افتراضياً لتجنب خطأ الداتابيز
        // ملاحظة: إذا أضفت حقل student_id في جدول users لاحقاً عبر migration، يمكنك تغيير الكود ليتعرف عليه
        $field = filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';

        if (Auth::attempt([$field => $this->username, 'password' => $this->password], $this->remember)) {
            
            // Redirect to dashboard on success
            return redirect()->intended('/dashboard');
        }

        $this->addError('username', 'بيانات الدخول غير صحيحة');
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
