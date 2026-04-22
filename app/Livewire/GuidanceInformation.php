<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class GuidanceInformation extends Component
{
    #[Computed]
    public function getTopics()
    {
        return \App\Models\FAQ::all()->map(function($faq) {
            return [
                "id" => $faq->id,
                "question" => $faq->question,
                "answer" => $faq->answer,
                "category" => $faq->category,
            ];
        })->toArray();
    }

    public function render()
    {
        $categoryMap = [
            "الكل" => null,
            "التسجيل" => "التسجيل",
            "الاختبارات" => "امتحانات",
            "علامات" => "علامات",
            "مالي" => "مالي",
            "متطلبات" => "متطلبات",
            "عام" => "عام",
        ];

        return view('livewire.guidance-information', [
            'topics' => $this->getTopics(),
            'filterTabs' => array_keys($categoryMap),
            'categoryMap' => $categoryMap,
        ]);
    }
}
