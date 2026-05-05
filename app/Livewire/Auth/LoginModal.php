<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class LoginModal extends Component
{
    public $username = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $throttleKey = strtolower($this->username) . '|' . request()->ip();

        // حماية من محاولات التخمين (Rate Limiting) - 5 محاولات في الدقيقة
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('username', "محاولات كثيرة جداً. الرجاء المحاولة بعد {$seconds} ثانية.");
            return;
        }

        // تحديد ما إذا كان المدخل بريد إلكتروني أم رقم جامعي
        $field = filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'university_id';

        if (Auth::attempt([$field => $this->username, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            return redirect()->intended('/dashboard');
        }

        RateLimiter::hit($throttleKey);
        $this->addError('username', 'بيانات الدخول غير صحيحة');
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
