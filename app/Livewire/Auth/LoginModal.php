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
    public $showForgotPassword = false;
    public $recoveryId = '';
    public $recoveryMethod = 'email';
    public $recoveryStep = 1; // 1: request, 2: verify, 3: reset
    public $generatedCode = ''; // الرمز المولد (مخزن في المكون)
    public $inputCode = ''; // الرمز المدخل
    public $newPassword = '';
    public $newPassword_confirmation = '';

    public function toggleForgotPassword($status = null)
    {
        $this->showForgotPassword = $status ?? !$this->showForgotPassword;
        $this->recoveryStep = 1;
        $this->reset(['recoveryId', 'inputCode', 'newPassword', 'newPassword_confirmation', 'generatedCode']);
        $this->resetErrorBag();
    }

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

    public function verifyRecovery()
    {
        $this->validate([
            'recoveryId' => 'required|string',
            'recoveryMethod' => 'required|in:email,phone',
        ], [
            'recoveryId.required' => 'يرجى إدخال الرقم الجامعي',
        ]);

        // البحث عن المستخدم
        $user = \App\Models\User::where('university_id', $this->recoveryId)->first();

        if (!$user) {
            $this->addError('recoveryId', 'الرقم الجامعي الذي أدخلته غير موجود في سجلاتنا');
            return;
        }

        $this->generatedCode = (string) rand(100000, 999999);

        if ($this->recoveryMethod === 'email') {
            // محاكاة الإرسال عبر البريد
            \Illuminate\Support\Facades\Log::info("Password Reset Code for {$user->email}: {$this->generatedCode}");
            
            $maskedEmail = $this->maskEmail($user->email);
            session()->flash('recovery_success', "تم إرسال رمز التحقق إلى بريدك: {$maskedEmail} (الرمز للتجربة: {$this->generatedCode})");
        } else {
            if (!$user->phone) {
                $this->addError('recoveryId', 'عذراً، رقم هاتفك غير مسجل لدينا.');
                return;
            }

            // محاكاة الإرسال عبر الهاتف
            \Illuminate\Support\Facades\Log::info("SMS Verification Code for {$user->phone}: {$this->generatedCode}");

            $maskedPhone = $this->maskPhone($user->phone);
            session()->flash('recovery_success', "تم إرسال رمز التحقق إلى هاتفك: {$maskedPhone} (الرمز للتجربة: {$this->generatedCode})");
        }

        $this->recoveryStep = 2;
    }

    public function verifyCode()
    {
        if ($this->inputCode === $this->generatedCode) {
            $this->recoveryStep = 3;
            $this->resetErrorBag();
        } else {
            $this->addError('inputCode', 'رمز التحقق غير صحيح، يرجى المحاولة مرة أخرى.');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|string|min:8|confirmed',
        ], [
            'newPassword.required' => 'يرجى إدخال كلمة المرور الجديدة',
            'newPassword.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل',
            'newPassword.confirmed' => 'كلمتا المرور غير متطابقتين',
        ]);

        $user = \App\Models\User::where('university_id', $this->recoveryId)->first();
        if ($user) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($this->newPassword),
            ]);

            session()->flash('message', 'تم تغيير كلمة المرور بنجاح، يمكنك الآن تسجيل الدخول.');
            $this->toggleForgotPassword(false);
        }
    }

    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];
        $maskedName = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 2));
        return $maskedName . '@' . $domain;
    }

    private function maskPhone($phone)
    {
        return substr($phone, 0, 3) . str_repeat('*', 5) . substr($phone, -2);
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
