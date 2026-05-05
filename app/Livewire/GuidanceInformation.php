<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class GuidanceInformation extends Component
{

    private const CATEGORY_MAP = [
        "الكل" => null,
        "التسجيل" => "التسجيل",
        "الاختبارات" => "امتحانات",
        "علامات" => "علامات",
        "مالي" => "مالي",
        "متطلبات" => "متطلبات",
        "عام" => "عام",
    ];

    #[Computed]
    public function getTopics()
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('published_faqs', function () {
            return \App\Models\FAQ::where('status', 'published')
                ->select('id', 'question', 'answer', 'category')
                ->get()
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.guidance-information', [
            'topics' => $this->getTopics(),
            'filterTabs' => array_keys(self::CATEGORY_MAP),
            'categoryMap' => self::CATEGORY_MAP,
        ]);
    }
}
