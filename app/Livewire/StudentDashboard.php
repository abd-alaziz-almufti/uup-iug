<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class StudentDashboard extends Component
{
    public string $activeSection = 'home';

    // القائمة البيضاء (Whitelist) للأقسام المسموحة لحماية الـ Routing الداخلي
    private const ALLOWED_SECTIONS = [
        'home',
        'academic',
        'inquiries',
        'guidance',
        'department'
    ];

    #[On('changeSection')]
    public function setSection(string $section): void
    {
        // التحقق الأمني: هل القسم المطلوب موجود ضمن القائمة المسموحة؟
        if (in_array($section, self::ALLOWED_SECTIONS, true)) {
            $this->activeSection = $section;
        } else {
            // الرجوع للرئيسية في حال محاولة التلاعب بالـ DOM
            $this->activeSection = 'home';
        }
    }

    public function logout()
    {
        auth()->logout();
        
        // إغلاق الجلسة أمنياً بالكامل (تدمير الـ Session القديمة وتجديد الـ CSRF)
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.student-dashboard')
            ->layout('components.layouts.app');
    }
}
