<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class GuidanceInformation extends Component
{
    #[Computed]
    public function getTopics()
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('published_faqs', function () {
            return \App\Models\FAQ::select('id', 'question', 'answer', 'category')
                ->where('status', 'published')
                ->get()
                ->toArray();
        });
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
