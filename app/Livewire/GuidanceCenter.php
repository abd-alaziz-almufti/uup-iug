<?php

namespace App\Livewire;

use Livewire\Component;

class GuidanceCenter extends Component
{
    public $activeFaqCard = null;

    protected $listeners = ['selectFaqCard' => 'handleInfoCardClick'];

    public function handleInfoCardClick($cardId)
    {
        $cards = [
            'guide-new-student' => [
                'id' => 'guide-new-student',
                'title' => 'دليل الطالب الجديد',
                'faqCategory' => 'دليل الطالب الجديد',
            ],
            'guide-registration-steps' => [
                'id' => 'guide-registration-steps',
                'title' => 'خطوات التسجيل',
                'faqCategory' => 'التسجيل',
            ],
            'guide-choose-major' => [
                'id' => 'guide-choose-major',
                'title' => 'اختيار التخصص',
                'faqCategory' => 'اختيار التخصص',
            ],
            'guide-faq' => [
                'id' => 'guide-faq',
                'title' => 'الاسئلة الشائعة',
                'faqCategory' => null,
            ],
            'guide-videos' => [
                'id' => 'guide-videos',
                'title' => 'فيديوهات تعليمية',
                'faqCategory' => 'فيديوهات تعليمية',
            ],
            'guide-info' => [
                'id' => 'guide-info',
                'title' => 'معلومات ارشادية',
                'faqCategory' => 'معلومات ارشادية',
            ],
        ];

        $this->activeFaqCard = $cards[$cardId] ?? null;
    }

    public function handleBack()
    {
        $this->activeFaqCard = null;
    }

    public function render()
    {
        return view('livewire.guidance-center');
    }
}
